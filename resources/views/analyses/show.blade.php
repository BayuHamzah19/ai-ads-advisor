@extends('layouts.app')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <nav class="flex text-sm text-gray-500 mb-4 gap-2">
                <a href="{{ route('analyses.index') }}" class="hover:text-sky-400">History</a>
                <span>/</span>
                <span class="text-gray-300">Analysis Result</span>
            </nav>
            <h1 class="text-4xl font-bold mb-2">{{ $analysis->campaign_name }}</h1>
            <div class="flex gap-4 items-center">
                <span class="px-3 py-1 bg-sky-500/20 text-sky-400 border border-sky-500/30 rounded-full text-xs font-bold uppercase tracking-wider">{{ $analysis->platform }}</span>
                <span class="text-gray-400 text-sm font-medium">{{ \Carbon\Carbon::parse($analysis->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($analysis->end_date)->format('M d, Y') }}</span>
                <span class="text-gray-600">|</span>
                <span class="text-gray-500 text-sm italic">Analyzed {{ $analysis->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        <a href="{{ route('analyses.pdf', $analysis->id) }}" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/5 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Save as PDF
        </a>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-2xl">
            <p class="text-gray-500 text-sm mb-1">CTR</p>
            <p class="text-2xl font-bold text-sky-400">{{ number_format($analysis->ctr, 2) }}%</p>
        </div>
        <div class="glass p-6 rounded-2xl">
            <p class="text-gray-500 text-sm mb-1">Avg. CPC</p>
            <p class="text-2xl font-bold text-sky-400">${{ number_format($analysis->cpc, 2) }}</p>
        </div>
        <div class="glass p-6 rounded-2xl">
            <p class="text-gray-500 text-sm mb-1">Avg. CPA</p>
            <p class="text-2xl font-bold text-sky-400">${{ number_format($analysis->cpa, 2) }}</p>
        </div>
        <div class="glass p-6 rounded-2xl">
            <p class="text-gray-500 text-sm mb-1">Total Spend</p>
            <p class="text-2xl font-bold text-sky-400">${{ number_format($analysis->total_spend, 2) }}</p>
        </div>
        <div class="glass p-6 rounded-2xl border-emerald-500/30">
            <p class="text-emerald-500 text-sm mb-1">ROAS</p>
            <p class="text-2xl font-bold text-emerald-400">{{ number_format($analysis->roas, 2) }}x</p>
        </div>
    </div>

    <!-- AI Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-6">
            <div class="glass p-8 rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                </div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center text-sm">🤖</span>
                    AI Deep Analysis
                </h2>
                <div class="prose prose-invert max-w-none prose-p:text-gray-300 prose-headings:text-white prose-strong:text-sky-400">
                    {!! $analysis->ai_analysis_html !!}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass p-6 rounded-3xl border-sky-500/30">
                <h3 class="text-lg font-bold mb-4 text-sky-400">Quick Context</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Impressions</span>
                        <span>{{ number_format($analysis->impressions) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Clicks</span>
                        <span>{{ number_format($analysis->clicks) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Conversions</span>
                        <span>{{ number_format($analysis->conversions) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Revenue</span>
                        <span class="text-emerald-400 font-bold">${{ number_format($analysis->total_revenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-sky-600/20 to-indigo-600/20 p-6 rounded-3xl border border-sky-500/30">
                <h3 class="text-lg font-bold mb-2">Need Help?</h3>
                <p class="text-sm text-gray-400 mb-4">Our team of specialists is ready to help you execute the recommendations above.</p>
                <a href="{{ route('contact') }}" class="block text-center py-2 bg-sky-500 hover:bg-sky-400 rounded-xl text-sm font-bold transition">Contact Consultant</a>
            </div>
        </div>
    </div>
</div>
@endsection
