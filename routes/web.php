<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/upload', function () {
//     return view('upload');
// })->name('upload');


// route untuk dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// route untuk upload data
Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');
// route Proses Upload
Route::post('/upload/proses', [UploadController::class, 'import'])->name('upload.import');