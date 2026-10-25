<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('announcements.index');

Route::resource('announcements', AnnouncementController::class)->only(['show']);
