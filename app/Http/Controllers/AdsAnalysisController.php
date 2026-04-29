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

        // 1. Calculate Metrics
        $data['ctr'] = $data['impressions'] > 0 ? ($data['clicks'] / $data['impressions']) * 100 : 0;
        $data['cpc'] = $data['clicks'] > 0 ? $data['total_spend'] / $data['clicks'] : 0;
        $data['cpa'] = $data['conversions'] > 0 ? $data['total_spend'] / $data['conversions'] : 0;
        $data['roas'] = $data['total_spend'] > 0 ? $data['total_revenue'] / $data['total_spend'] : 0;

        // 2. Prepare Prompts
        $systemPrompt = "You are an AI Digital Ads Specialist. Your task is to analyze advertising campaign metrics (Facebook, Google, TikTok) and provide sharp technical recommendations to improve ROAS. You must be able to identify campaigns that are wasting budget and provide concrete steps for optimizing creatives, audiences, and budget allocation.";

        $userPrompt = "Analyze the following campaign:
  * Campaign Name: " . $data['campaign_name'] . "
  * Platform: " . $data['platform'] . "
  * Impressions: " . number_format($data['impressions']) . "
  * Clicks: " . number_format($data['clicks']) . "
  * Conversions: " . number_format($data['conversions']) . "
  * Total Spend: $" . number_format($data['total_spend'], 2) . "
  * Total Revenue: $" . number_format($data['total_revenue'], 2) . "
  * CTR: " . number_format($data['ctr'], 2) . "%
  * CPC: $" . number_format($data['cpc'], 2) . "
  * CPA: $" . number_format($data['cpa'], 2) . "
  * ROAS: " . number_format($data['roas'], 2) . "x
  * Date Range: " . $data['start_date'] . " to " . $data['end_date'] . "

### Output Instructions (Must be Structured):
Based on the data above, provide a report covering:
1. Performance Summary: A brief summary of campaign performance.
2. Underperforming Identification: Is this campaign healthy or failing? Why?
3. Optimization Suggestions:
   - Budget Reallocation (should it be increased, decreased, or stopped).
   - Audience targeting and creative improvements (images/videos/copywriting).
4. Prioritized Action Items: Create a list of action points that the advertiser must take immediately.

Use professional and objective English language.";

        // 3. Call AI API (With Multi-Level Fallback)
        $aiResponse = $this->callAiWithFallback($systemPrompt, $userPrompt);

        // 4. Save to Database
        $analysis = Analysis::create([
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

        return redirect()->route('analyses.show', $analysis->id);
    }

    /**
     * Display the specified analysis.
     */
    public function show(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        $parsedown = new \Parsedown();
        $analysis->ai_analysis_html = $parsedown->text($analysis->ai_analysis);

        return view('analyses.show', compact('analysis'));
    }

    /**
     * Export the specified analysis to PDF.
     */
    public function exportPdf(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan memory limit cukup untuk PDF
        ini_set('memory_limit', '256M');

        $parsedown = new \Parsedown();
        $htmlContent = $parsedown->text($analysis->ai_analysis);

        $pdf = Pdf::loadView('analyses.pdf', compact('analysis', 'htmlContent'));

        // Gunakan Str::slug agar nama file aman dari karakter aneh
        $fileName = 'Analysis-' . Str::slug($analysis->campaign_name) . '.pdf';

        return $pdf->download($fileName);
    }


    /**
     * Multi-level fallback AI call logic.
     */
    private function callAiWithFallback($systemPrompt, $userPrompt)
    {
        // Level 1: Gemini (Primary)
        $response = $this->callGemini($systemPrompt, $userPrompt);
        if (!str_starts_with($response, 'Error')) {
            return $response;
        }
        Log::warning('Gemini Failed: ' . $response . '. Switching to Hugging Face...');

        // Level 2: Hugging Face (Fallback 1)
        $response = $this->callHuggingFace($systemPrompt, $userPrompt);
        if (!str_starts_with($response, 'Error')) {
            return $response;
        }
        Log::warning('Hugging Face Failed: ' . $response . '. Switching to Groq...');

        // Level 3: Groq (Fallback 2 - The Reliability King)
        return $this->callGroq($systemPrompt, $userPrompt);
    }

    private function callGemini($systemPrompt, $userPrompt)
    {
        $apiKey = config('services.gemini.key');
        // Mencoba versi v1beta dengan penamaan terbaru
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";

        try {
            $response = Http::post($url, [
                'contents' => [['parts' => [['text' => $systemPrompt . "\n\n" . $userPrompt]]]]
            ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Error: Gagal parsing data.';
            }
            return 'Error ' . $response->status() . ': ' . $response->body();
        } catch (\Exception $e) {
            return 'Error Connection: ' . $e->getMessage();
        }
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

            if ($response->successful()) {
                return $response->json()[0]['generated_text'] ?? 'Error: Gagal parsing HF.';
            }
            return 'Error ' . $response->status() . ': ' . $response->body();
        } catch (\Exception $e) {
            return 'Error HF Connection: ' . $e->getMessage();
        }
    }

    private function callGroq($systemPrompt, $userPrompt)
    {
        $apiKey = config('services.groq.key');
        $url = "https://api.groq.com/openai/v1/chat/completions";

        try {
            $response = Http::withToken($apiKey)->post($url, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'] ?? 'Error: Gagal parsing Groq.';
            }
            return 'Error ' . $response->status() . ': ' . ($response->json()['error']['message'] ?? $response->body());
        } catch (\Exception $e) {
            return 'Error Groq Connection: ' . $e->getMessage();
        }
    }
}
