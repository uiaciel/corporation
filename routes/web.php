<?php

use Illuminate\Support\Facades\Route;
use Uiaciel\Corporation\Livewire\AnnouncementIndex;
use Uiaciel\Corporation\Livewire\AnnouncementCreate;
use Uiaciel\Corporation\Livewire\ReportIndex;
use Uiaciel\Corporation\Livewire\ReportCreate;

use Uiaciel\Corporation\Http\Controllers\CorporationController;

Route::group(['middleware' => config('corporation.middleware', ['web', 'auth']), 'prefix' => config('corporation.route_prefix', 'admin/corporation')], function () {
    Route::get('/announcements', AnnouncementIndex::class)->name('admin.announcement.index');
    Route::get('/announcements/create', AnnouncementCreate::class)->name('admin.announcement.create');

    Route::get('/reports', ReportIndex::class)->name('admin.report.index');
    Route::get('reports/create', ReportCreate::class)->name('admin.report.create');
});

Route::get('/financial-reports', [CorporationController::class, 'financial'])->name('frontend.financial');
Route::get('/audit-committee-charter', [CorporationController::class, 'acc'])->name('frontend.acc');
Route::get('/share-price', [CorporationController::class, 'share'])->name('frontend.share');
Route::get('/announcement/{slug}', [CorporationController::class, 'announcement'])->name('announcement.show');
Route::get('/report/{slug}', [CorporationController::class, 'report'])->name('frontend.reportya');
