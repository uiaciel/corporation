<?php

use Illuminate\Support\Facades\Route;
use Uiaciel\Corporation\Livewire\AnnouncementIndex;

Route::group(['middleware' => config('corporation.middleware', ['web', 'auth']), 'prefix' => config('corporation.route_prefix', 'admin/corporation')], function () {
    Route::get('/announcements', AnnouncementIndex::class)->name('admin.announcement.index');
    Route::get('/announcements/create', \Uiaciel\Corporation\Livewire\AnnouncementCreate::class)->name('admin.announcement.create');
});
