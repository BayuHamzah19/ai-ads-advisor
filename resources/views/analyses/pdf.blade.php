<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analysis Result - {{ $analysis->campaign_name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .header { border-bottom: 2px solid #0ea5e9; padding-bottom: 20px; margin-bottom: 30px; }
        .campaign-name { font-size: 24px; font-weight: bold; margin: 0; color: #111; }
        .meta { color: #666; font-size: 12px; margin-top: 5px; }
        .platform { display: inline-block; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .metrics { display: table; width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .metric-box { display: table-cell; width: 25%; padding: 15px; border: 1px solid #eee; text-align: center; }
        .metric-label { font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 5px; }
        .metric-value { font-size: 18px; font-weight: bold; color: #0ea5e9; }
        .section-title { font-size: 18px; font-weight: bold; margin-top: 30px; margin-bottom: 15px; color: #111; border-left: 4px solid #0ea5e9; padding-left: 10px; }
        .analysis-content { font-size: 13px; text-align: justify; }
        .footer { margin-top: 50px; font-size: 10px; color: #999; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
        h1, h2, h3 { color: #0369a1; }
        hr { border: 0; border-top: 1px solid #eee; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <p class="platform">{{ $analysis->platform }}</p>
        <h1 class="campaign-name">{{ $analysis->campaign_name }}</h1>
        <p class="meta">Period: {{ \Carbon\Carbon::parse($analysis->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($analysis->end_date)->format('M d, Y') }} | AI Analysis performed on {{ $analysis->created_at->format('M d, Y') }}</p>
    </div>

    <div class="metrics">
        <div class="metric-box">
            <div class="metric-label">CTR</div>
            <div class="metric-value">{{ number_format($analysis->ctr, 2) }}%</div>
        </div>
        <div class="metric-box">
            <div class="metric-label">Avg. CPA</div>
            <div class="metric-value">${{ number_format($analysis->cpa, 2) }}</div>
        </div>
        <div class="metric-box">
            <div class="metric-label">Total Spend</div>
            <div class="metric-value">${{ number_format($analysis->total_spend, 2) }}</div>
        </div>
        <div class="metric-box">
            <div class="metric-label">ROAS</div>
            <div class="metric-value">{{ number_format($analysis->roas, 2) }}x</div>
        </div>
    </div>

    <div class="section-title">AI Deep Analysis</div>
    <div class="analysis-content">
        {!! $htmlContent !!}
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} AdVise AI - Digital Ads Optimization Advisor. Built for Performance.
    </div>
</body>
</html>
