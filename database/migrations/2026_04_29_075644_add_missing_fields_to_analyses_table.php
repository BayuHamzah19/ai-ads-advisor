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
        Schema::table('analyses', function (Blueprint $table) {
            $table->decimal('total_revenue', 15, 2)->after('total_spend')->default(0);
            $table->decimal('roas', 10, 2)->after('cpa')->default(0);
            $table->date('start_date')->nullable()->after('platform');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->dropColumn(['total_revenue', 'roas', 'start_date', 'end_date']);
        });
    }
};
