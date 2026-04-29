<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class AdsAnalysisController extends Controller
{
    /**
     * Display a listing of the analyses.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->analyses()->latest();

        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }

        $analyses = $query->get();
        return view('analyses.index', compact('analyses'));
    }

    /**
     * Show the form for creating a new analysis.
     */
    public function create()
    {
        return view('analyses.create');
    }

    /**
     * Store a newly created analysis in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'platform' => 'required|string|in:Facebook,Google,TikTok',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'impressions' => 'required|integer|min:1',
            'clicks' => 'required|integer|min:0',
            'conversions' => 'required|integer|min:0',
            'total_spend' => 'required|numeric|min:0',
            'total_revenue' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $this->processAnalysis($data);

        return redirect()->route('analyses.index')->with('success', 'Analysis created successfully!');
    }

    /**
     * Handle CSV Bulk Upload
     */
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header
        $header = fgetcsv($handle, 1000, ',');
        
        $count = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (count($row) < 8) continue;

            $data = [
                'campaign_name' => $row[0],
                'platform' => $row[1], // Facebook, Google, TikTok
                'impressions' => (int)$row[2],
                'clicks' => (int)$row[3],
                'conversions' => (int)$row[4],
                'total_spend' => (float)$row[5],
                'total_revenue' => (float)$row[6],
                'start_date' => $row[7],
                'end_date' => $row[8] ?? $row[7],
            ];

            $this->processAnalysis($data);
            $count++;
        }

        fclose($handle);

        return redirect()->route('analyses.index')->with('success', "Successfully processed $count campaigns from CSV!");
    }

    /**
     * Common logic to process and save analysis
     */
    private function processAnalysis($data)
    {
        // 1. Calculate Metrics
        $data['ctr'] = $data['impressions'] > 0 ? ($data['clicks'] / $data['impressions']) * 100 : 0;
        $data['cpc'] = $data['clicks'] > 0 ? $data['total_spend'] / $data['clicks'] : 0;
        $data['cpa'] = $data['conversions'] > 0 ? $data['total_spend'] / $data['conversions'] : 0;
        $data['roas'] = $data['total_spend'] > 0 ? $data['total_revenue'] / $data['total_spend'] : 0;

        // 2. Prepare Prompts
        $systemPrompt = "You are an AI Digital Ads Specialist. Analyze advertising campaign metrics and provide sharp technical recommendations to improve ROAS. Report must include: Performance Summary, Underperforming Identification, Optimization Suggestions, and Prioritized Action Items. Use professional English.";
        
        $userPrompt = "Campaign: " . $data['campaign_name'] . " (" . $data['platform'] . ")
  * Metrics: " . number_format($data['impressions']) . " Impr, " . number_format($data['clicks']) . " Clicks, " . number_format($data['conversions']) . " Conv
  * Finance: $" . number_format($data['total_spend'], 2) . " Spend, $" . number_format($data['total_revenue'], 2) . " Revenue
  * Performance: " . number_format($data['ctr'], 2) . "% CTR, $" . number_format($data['cpc'], 2) . " CPC, $" . number_format($data['cpa'], 2) . " CPA, " . number_format($data['roas'], 2) . "x ROAS";

        // 3. Call AI API
        $aiResponse = $this->callAiWithFallback($systemPrompt, $userPrompt);

        // 4. Save to Database
        return Analysis::create([
            'user_id' => Auth::id(),
            'campaign_name' => $data['campaign_name'],
            'platform' => $data['platform'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'impressions' => $data['impressions'],
            'clicks' => $data['clicks'],
            'conversions' => $data['conversions'],
            'total_spend' => $data['total_spend'],
            'total_revenue' => $data['total_revenue'],
            'ctr' => $data['ctr'],
            'cpc' => $data['cpc'],
            'cpa' => $data['cpa'],
            'roas' => $data['roas'],
            'ai_analysis' => $aiResponse,
        ]);
    }

    public function show(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        $parsedown = new \Parsedown();
        $analysis->ai_analysis_html = $parsedown->text($analysis->ai_analysis);

        return view('analyses.show', compact('analysis'));
    }

    public function exportPdf(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            ini_set('memory_limit', '256M');
            $parsedown = new \Parsedown();
            $htmlContent = $parsedown->text($analysis->ai_analysis);
            $pdf = Pdf::loadView('analyses.pdf', compact('analysis', 'htmlContent'));
            $fileName = 'Analysis-' . Str::slug($analysis->campaign_name) . '.pdf';
            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            return "Gagal membuat PDF. Error: " . $e->getMessage();
        }
    }

    private function callAiWithFallback($systemPrompt, $userPrompt)
    {
        $response = $this->callGemini($systemPrompt, $userPrompt);
        if (!str_starts_with($response, 'Error')) return $response;
        
        $response = $this->callHuggingFace($systemPrompt, $userPrompt);
        if (!str_starts_with($response, 'Error')) return $response;
        
        return $this->callGroq($systemPrompt, $userPrompt);
    }

    private function callGemini($systemPrompt, $userPrompt)
    {
        $apiKey = config('services.gemini.key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";
        try {
            $response = Http::post($url, [
                'contents' => [['parts' => [['text' => $systemPrompt . "\n\n" . $userPrompt]]]]
            ]);
            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Error: Gagal parsing.';
        } catch (\Exception $e) { return 'Error: ' . $e->getMessage(); }
    }

    private function callHuggingFace($systemPrompt, $userPrompt)
    {
        $apiKey = config('services.huggingface.key');
        $url = "https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.3";
        try {
            $response = Http::withToken($apiKey)->post($url, [
                'inputs' => $systemPrompt . "\n\n" . $userPrompt,
                'parameters' => ['max_new_tokens' => 1000]
            ]);
            return $response->json()[0]['generated_text'] ?? 'Error: Gagal parsing.';
        } catch (\Exception $e) { return 'Error: ' . $e->getMessage(); }
    }

    private function callGroq($systemPrompt, $userPrompt)
    {
        $apiKey = config('services.groq.key');
        $url = "https://api.groq.com/openai/v1/chat/completions";
        try {
            $response = Http::withToken($apiKey)->post($url, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [['role' => 'system', 'content' => $systemPrompt], ['role' => 'user', 'content' => $userPrompt]],
                'temperature' => 0.7,
            ]);
            return $response->json()['choices'][0]['message']['content'] ?? 'Error: Gagal parsing.';
        } catch (\Exception $e) { return 'Error: ' . $e->getMessage(); }
    }
}
