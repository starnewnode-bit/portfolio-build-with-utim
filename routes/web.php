<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/* ===== Public portfolio ===== */
Route::get('/',                       [PortfolioController::class, 'home'])->name('home');
Route::get('/about',                  [PortfolioController::class, 'about'])->name('about');
Route::get('/projects',               [PortfolioController::class, 'projectsIndex'])->name('projects.index');
Route::get('/projects/{slug}',        [PortfolioController::class, 'showProject'])->name('projects.show');
Route::get('/contact',                [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact',               [PortfolioController::class, 'sendMessage'])->name('contact.send');

/* ===== SEO ===== */
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/* ===== Optional fallback (404 friendly) ===== */
Route::fallback(function () {
    abort(404);
});
