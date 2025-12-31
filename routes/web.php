<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DashboardController;

// 1. Halaman Dashboard (Halaman Utama)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Halaman Upload & Lihat Data
Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');

// 3. Proses Import Excel
Route::post('/upload/proses', [UploadController::class, 'import'])->name('upload.import');

// Tambahkan baris ini di bawah route import yang sudah ada
Route::get('/upload/export-belum-jmo', [UploadController::class, 'exportBelumJmo'])->name('upload.export.belumjmo');