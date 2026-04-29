<?php

use App\Http\Controllers\AdsAnalysisController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $stats = [
            'total_spend' => $user->analyses()->sum('total_spend'),
            'total_revenue' => $user->analyses()->sum('total_revenue'),
            'avg_roas' => $user->analyses()->avg('roas') ?? 0,
            'total_conversions' => $user->analyses()->sum('conversions'),
            'total_analyses' => $user->analyses()->count(),
            'platform_counts' => [
                'Facebook' => $user->analyses()->where('platform', 'Facebook')->count(),
                'Google' => $user->analyses()->where('platform', 'Google')->count(),
                'TikTok' => $user->analyses()->where('platform', 'TikTok')->count(),
            ],
            'recent_analyses' => $user->analyses()->latest()->take(5)->get(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // Ads Analysis Routes
    Route::prefix('analyses')->name('analyses.')->group(function () {
        Route::get('/', [AdsAnalysisController::class, 'index'])->name('index');
        Route::get('/create', [AdsAnalysisController::class, 'create'])->name('create');
        Route::post('/', [AdsAnalysisController::class, 'store'])->name('store');
        Route::get('/{analysis}', [AdsAnalysisController::class, 'show'])->name('show');
        Route::get('/{analysis}/pdf', [AdsAnalysisController::class, 'exportPdf'])->name('pdf');
    });

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
