<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/robots.txt', function () {
    $siteUrl = rtrim((string) config('app.url'), '/');

    return response(
        "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: {$siteUrl}/sitemap.xml\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8'],
    );
})->name('robots');
Route::get('/sitemap.xml', function () {
    return response()->view('seo.sitemap', [
        'homepage' => rtrim((string) config('app.url'), '/').'/',
    ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
})->name('sitemap');

Route::post('/contact', [PortfolioController::class, 'contact'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])
        ->middleware('throttle:admin-login')
        ->name('admin.login.store');
});

Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])
    ->middleware(['auth', 'can:access-admin'])
    ->name('admin.logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'can:access-admin'])
    ->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    });
