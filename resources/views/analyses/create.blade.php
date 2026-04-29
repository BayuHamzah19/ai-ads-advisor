@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-bold mb-4">Start New <span class="gradient-text">Analysis</span></h1>
        <p class="text-gray-400">Enter your campaign data and let our AI provide sharp recommendations to boost your ROAS.</p>
    </div>

    <div class="glass p-8 rounded-3xl">
        <form action="{{ route('analyses.store') }}" method="POST" class="space-y-6">
            <!-- Existing Form Content -->
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Campaign Name</label>
                    <input type="text" name="campaign_name" placeholder="Example: Ramadhan Promo 2026" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Platform</label>
                    <select name="platform" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                        <option value="Facebook">Facebook Ads</option>
                        <option value="Google">Google Ads</option>
                        <option value="TikTok">TikTok Ads</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Start Date</label>
                    <input type="date" name="start_date" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">End Date</label>
                    <input type="date" name="end_date" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Impressions</label>
                    <input type="number" name="impressions" placeholder="0" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Clicks</label>
                    <input type="number" name="clicks" placeholder="0" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Conversions</label>
                    <input type="number" name="conversions" placeholder="0" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Total Spend (USD)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">$</span>
                        <input type="number" step="0.01" name="total_spend" placeholder="0.00" class="w-full bg-slate-800/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Total Revenue (USD)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">$</span>
                        <input type="number" step="0.01" name="total_revenue" placeholder="0.00" class="w-full bg-slate-800/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary py-4 rounded-xl font-bold text-lg mt-4">
                Analyze Now
            </button>
        </form>

        <div class="mt-10 pt-10 border-t border-white/10">
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Bulk Upload via CSV
            </h3>
            <p class="text-sm text-gray-500 mb-6">Process multiple campaigns at once. Format: <span class="text-gray-300">CampaignName, Platform, Impr, Clicks, Conv, Spend, Revenue, StartDate, EndDate</span></p>
            
            <form action="{{ route('analyses.upload-csv') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                @csrf
                <input type="file" name="csv_file" accept=".csv" class="flex-1 bg-slate-800/50 border border-white/10 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition" required>
                <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-bold transition">
                    Upload
                </button>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
