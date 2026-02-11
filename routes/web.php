<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiolinkController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BiolinkAdminController;
use App\Http\Controllers\Admin\BioItemController;
use App\Http\Controllers\SitemapController;

// Public Biolink Display (domain-based)
Route::get('/', [BiolinkController::class, 'show']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Admin Biolinks Management
Route::get('/admin/biolinks', [BiolinkAdminController::class, 'index'])->name('admin.biolinks.index');
Route::get('/admin/biolinks/create', [BiolinkAdminController::class, 'create'])->name('admin.biolinks.create');
Route::post('/admin/biolinks', [BiolinkAdminController::class, 'store'])->name('admin.biolinks.store');
Route::get('/admin/biolinks/{id}/edit', [BiolinkAdminController::class, 'edit'])->name('admin.biolinks.edit');
Route::put('/admin/biolinks/{id}', [BiolinkAdminController::class, 'update'])->name('admin.biolinks.update');
Route::delete('/admin/biolinks/{id}', [BiolinkAdminController::class, 'destroy'])->name('admin.biolinks.destroy');

// Bio Items Management (AJAX for autosave)
Route::post('/admin/biolinks/{biolinkId}/items', [BioItemController::class, 'store'])->name('admin.bioitems.store');
Route::put('/admin/biolinks/{biolinkId}/items/{id}', [BioItemController::class, 'update'])->name('admin.bioitems.update');
Route::delete('/admin/biolinks/{biolinkId}/items/{id}', [BioItemController::class, 'destroy'])->name('admin.bioitems.destroy');
Route::post('/admin/biolinks/{biolinkId}/items/reorder', [BioItemController::class, 'reorder'])->name('admin.bioitems.reorder');

// File Upload (AJAX for autosave)
Route::post('/admin/biolinks/{id}/upload-avatar', [BiolinkAdminController::class, 'uploadAvatar'])->name('admin.biolinks.upload.avatar');
Route::post('/admin/biolinks/{id}/upload-banner', [BiolinkAdminController::class, 'uploadBanner'])->name('admin.biolinks.upload.banner');
Route::post('/admin/bioitems/{id}/upload-icon', [BioItemController::class, 'uploadIcon'])->name('admin.bioitems.upload.icon');