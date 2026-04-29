@extends('layouts.app')

@section('content')
<div class="space-y-10">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-3xl border-sky-500/20">
            <div class="flex justify-between items-start mb-2">
                <p class="text-gray-500 text-sm">Total Analyses</p>
                <span class="text-2xl font-bold text-white">{{ number_format($stats['total_analyses']) }}</span>
            </div>
            <div class="flex gap-2 mt-4">
                <a href="{{ route('analyses.index', ['platform' => 'Facebook']) }}" class="flex-1 bg-blue-500/10 p-2 rounded-xl text-center hover:bg-blue-500/20 transition group">
                    <p class="text-[10px] text-blue-400 font-bold uppercase group-hover:text-blue-300">FB</p>
                    <p class="text-lg font-bold text-white">{{ $stats['platform_counts']['Facebook'] }}</p>
                </a>
                <a href="{{ route('analyses.index', ['platform' => 'Google']) }}" class="flex-1 bg-red-500/10 p-2 rounded-xl text-center hover:bg-red-500/20 transition group">
                    <p class="text-[10px] text-red-400 font-bold uppercase group-hover:text-red-300">GG</p>
                    <p class="text-lg font-bold text-white">{{ $stats['platform_counts']['Google'] }}</p>
                </a>
                <a href="{{ route('analyses.index', ['platform' => 'TikTok']) }}" class="flex-1 bg-pink-500/10 p-2 rounded-xl text-center hover:bg-pink-500/20 transition group">
                    <p class="text-[10px] text-pink-400 font-bold uppercase group-hover:text-pink-300">TT</p>
                    <p class="text-lg font-bold text-white">{{ $stats['platform_counts']['TikTok'] }}</p>
                </a>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border-sky-500/20">
            <p class="text-gray-500 text-sm mb-1">Total Spend</p>
            <p class="text-3xl font-bold text-sky-400">${{ number_format($stats['total_spend'], 2) }}</p>
        </div>
        <div class="glass p-6 rounded-3xl border-emerald-500/20">
            <p class="text-gray-500 text-sm mb-1">Total Revenue</p>
            <p class="text-3xl font-bold text-emerald-400">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="glass p-6 rounded-3xl border-indigo-500/20">
            <p class="text-gray-500 text-sm mb-1">Avg. ROAS</p>
            <p class="text-3xl font-bold text-indigo-400">{{ number_format($stats['avg_roas'], 2) }}x</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 relative">
        <!-- Decorative Glow -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-sky-500/10 blur-[100px] rounded-full"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full"></div>

        <!-- Chart Section -->
        <div class="lg:col-span-2 glass p-8 rounded-[2.5rem] relative z-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-xl font-bold">Performance Trends</h2>
                    <p class="text-xs text-gray-500 mt-1">Comparison of Spend vs Revenue in curves</p>
                </div>
                <a href="{{ route('analyses.create') }}" class="btn-primary px-6 py-2 rounded-xl text-sm font-bold">New +</a>
            </div>
            <div class="h-[350px]">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Recent History -->
        <div class="glass p-8 rounded-[2.5rem] relative z-10">
            <h2 class="text-xl font-bold mb-6">Recent Analyses</h2>
            <div class="space-y-4">
                @forelse($stats['recent_analyses'] as $analysis)
                <a href="{{ route('analyses.show', $analysis->id) }}" class="block p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/5 transition">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-400">{{ $analysis->platform }}</span>
                        <span class="text-[10px] text-gray-500">{{ $analysis->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="font-bold text-sm truncate mb-2">{{ $analysis->campaign_name }}</p>
                    <div class="flex gap-4 text-[10px]">
                        <span class="text-gray-400">ROAS: <b class="text-white">{{ number_format($analysis->roas, 2) }}x</b></span>
                        <span class="text-gray-400">CPA: <b class="text-white">${{ number_format($analysis->cpa, 2) }}</b></span>
                    </div>
                </a>
                @empty
                <div class="text-center py-10">
                    <p class="text-gray-500 text-sm italic">No analysis data yet.</p>
                </div>
                @endforelse
            </div>
            @if($stats['total_analyses'] > 5)
            <a href="{{ route('analyses.index') }}" class="block text-center mt-6 text-sm text-sky-400 hover:underline">View All History →</a>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const chartData = {
        labels: {!! json_encode($stats['recent_analyses']->pluck('campaign_name')->reverse()->values()) !!},
        datasets: [
            {
                label: 'Spend ($)',
                data: {!! json_encode($stats['recent_analyses']->pluck('total_spend')->reverse()->values()) !!},
                backgroundColor: 'rgba(14, 165, 233, 0.2)',
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2,
                borderRadius: 8,
                tension: 0.4
            },
            {
                label: 'Revenue ($)',
                data: {!! json_encode($stats['recent_analyses']->pluck('total_revenue')->reverse()->values()) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                borderRadius: 8,
                tension: 0.4
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                line: {
                    fill: true,
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(14, 165, 233, 0)');
                        gradient.addColorStop(1, 'rgba(14, 165, 233, 0.1)');
                        return gradient;
                    }
                },
                point: { radius: 4, hoverRadius: 6 }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#64748b' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b' }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { color: '#94a3b8', usePointStyle: true, padding: 20 }
                }
            }
        }
    });
</script>
@endsection
