<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_name',
        'platform',
        'impressions',
        'clicks',
        'conversions',
        'total_spend',
        'total_revenue',
        'ctr',
        'cpc',
        'cpa',
        'roas',
        'start_date',
        'end_date',
        'ai_analysis',
    ];

    /**
     * Get the user that owns the analysis.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
