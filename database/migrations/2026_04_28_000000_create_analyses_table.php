<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('campaign_name');
            $table->string('platform');
            $table->integer('impressions');
            $table->integer('clicks');
            $table->integer('conversions');
            $table->decimal('total_spend', 15, 2);
            $table->decimal('ctr', 8, 2);
            $table->decimal('cpc', 15, 2);
            $table->decimal('cpa', 15, 2);
            $table->text('ai_analysis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
