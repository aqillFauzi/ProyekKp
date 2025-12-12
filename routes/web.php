<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('/upload', function () {
//     return view('upload');
// })->name('upload');

Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');
// Route::post('/upload/proses', [UploadController::class, 'import'])->name('upload.import');