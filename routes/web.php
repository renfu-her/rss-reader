<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssReaderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rss', [RssReaderController::class, 'index'])->name('rss.index');
Route::get('/rss/{feedName}', [RssReaderController::class, 'show'])->name('rss.show');
