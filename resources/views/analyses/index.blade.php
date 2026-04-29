@extends('layouts.app')

@section('content')
<div class="space-y-10 relative">
    <!-- Decorative Curves -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-sky-500/5 blur-[120px] rounded-full"></div>
    <div class="absolute top-1/2 -left-40 w-80 h-80 bg-indigo-500/5 blur-[120px] rounded-full"></div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
        <div>
            <h1 class="text-4xl font-bold">Analysis <span class="gradient-text">History</span></h1>
            <p class="text-gray-500">
                @if(request('platform'))
                    Showing all your <b>{{ request('platform') }}</b> campaigns.
                @else
                    Manage and review all your campaign analyses.
                @endif
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            @if(request('platform'))
                <a href="{{ route('analyses.index') }}" class="glass px-4 py-2 rounded-xl text-sm text-gray-400 hover:text-white transition flex items-center gap-2">
                    <span>Clear Filter</span>
                    <span class="bg-white/10 px-1.5 py-0.5 rounded text-[10px]">&times;</span>
                </a>
            @endif
            <a href="{{ route('analyses.create') }}" class="btn-primary px-8 py-3 rounded-xl font-bold transition">New Analysis</a>
        </div>
    </div>

    @if(request('platform'))
    <!-- Platform Specific Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
        <div class="glass p-6 rounded-2xl border-white/5">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total</p>
            <p class="text-xl font-bold">{{ $analyses->count() }} <span class="text-sm font-normal text-gray-500">Reports</span></p>
        </div>
        <div class="glass p-6 rounded-2xl border-white/5">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total Spend</p>
            <p class="text-xl font-bold text-sky-400">${{ number_format($analyses->sum('total_spend'), 2) }}</p>
        </div>
        <div class="glass p-6 rounded-2xl border-white/5">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Avg. ROAS</p>
            <p class="text-xl font-bold text-emerald-400">{{ number_format($analyses->avg('roas'), 2) }}x</p>
        </div>
        <div class="glass p-6 rounded-2xl border-white/5">
            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Top Platform</p>
            <p class="text-xl font-bold text-indigo-400">{{ request('platform') }}</p>
        </div>
    </div>
    @endif

    <div class="glass rounded-3xl overflow-hidden relative z-10">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-white/10 bg-white/5">
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400">Date</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400">Campaign Name</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400">Platform</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 text-center">CTR</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 text-center">CPA</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($analyses as $analysis)
                <tr class="hover:bg-white/5 transition group">
                    <td class="px-6 py-4 text-sm text-gray-400">
                        {{ $analysis->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 font-semibold group-hover:text-sky-400 transition">
                        {{ $analysis->campaign_name }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold px-2 py-1 bg-slate-800 rounded border border-white/10">{{ $analysis->platform }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ number_format($analysis->ctr, 2) }}%
                    </td>
                    <td class="px-6 py-4 text-center">
                        ${{ number_format($analysis->cpa, 2) }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('analyses.show', $analysis->id) }}" class="text-sky-400 hover:underline font-bold">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="text-gray-500 mb-4">No analysis history yet.</div>
                        <a href="{{ route('analyses.create') }}" class="text-sky-400 font-bold hover:underline">Start Your First Analysis</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
