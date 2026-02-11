<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBiolinkController;
use App\Http\Controllers\Admin\BioItemController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\BiolinkController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AmpController;
use App\Http\Controllers\ClickTrackerController;

// Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin Biolinks Management
Route::get('/admin/biolinks', [AdminBiolinkController::class, 'index'])->name('admin.biolinks.index');
Route::get('/admin/biolinks/create', [AdminBiolinkController::class, 'create'])->name('admin.biolinks.create');
Route::post('/admin/biolinks', [AdminBiolinkController::class, 'store'])->name('admin.biolinks.store');
Route::get('/admin/biolinks/{id}/edit', [AdminBiolinkController::class, 'edit'])->name('admin.biolinks.edit');
Route::put('/admin/biolinks/{id}', [AdminBiolinkController::class, 'update'])->name('admin.biolinks.update');
Route::delete('/admin/biolinks/{id}', [AdminBiolinkController::class, 'destroy'])->name('admin.biolinks.destroy');
Route::post('/admin/biolinks/{id}/upload-avatar', [AdminBiolinkController::class, 'uploadAvatar']);
Route::post('/admin/biolinks/{id}/upload-banner', [AdminBiolinkController::class, 'uploadBanner']);
Route::get('/admin/biolinks/{id}/preview', [AdminBiolinkController::class, 'preview'])->name('admin.biolinks.preview');

// Bio Items Management
Route::post('/admin/biolinks/{biolinkId}/items', [BioItemController::class, 'store']);
Route::put('/admin/biolinks/{biolinkId}/items/{itemId}', [BioItemController::class, 'update']);
Route::delete('/admin/biolinks/{biolinkId}/items/{itemId}', [BioItemController::class, 'destroy']);
Route::post('/admin/biolinks/{biolinkId}/items/reorder', [BioItemController::class, 'reorder']);
Route::post('/admin/bioitems/{itemId}/upload-icon', [BioItemController::class, 'uploadIcon']);

// Analytics
Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');

// Click Tracking
Route::get('/track/click/{itemId}', [ClickTrackerController::class, 'track'])->name('track.click');

// AMP Pages
Route::get('/ampproject/{domain}', [AmpController::class, 'show'])->name('amp.show');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Public Biolink Display (catch-all route, must be last)
Route::get('/{any?}', [BiolinkController::class, 'show'])->where('any', '.*');