<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
// 1. TAMBAHKAN INI (Supaya Laravel kenal controllernya)
use App\Http\Controllers\ForgotPasswordController; 
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- A. ROUTE PUBLIC / TAMU ---

// Login & Logout
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. TAMBAHKAN GROUP INI (Khusus Fitur Lupa Password)
// Kita pakai middleware 'guest' agar orang yang sudah login tidak bisa buka halaman ini
Route::middleware('guest')->group(function () {
    // Form Masukkan Email
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    // Proses Kirim Link ke Email
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    
    // Form Ganti Password (Saat link di email diklik)
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    // Proses Simpan Password Baru
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});


// --- B. ROUTE YANG DILINDUNGI (Harus Login) ---
Route::middleware(['auth'])->group(function () {

    // Halaman Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Upload & Lihat Data
    Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');

    // Proses Import Excel
    Route::post('/upload/proses', [UploadController::class, 'import'])->name('upload.import');

    // Export Data
    Route::get('/upload/export-belum-jmo', [UploadController::class, 'exportBelumJmo'])->name('upload.export.belumjmo');

    // Hapus Data 
    Route::delete('/monitoring/hapus/{id}', [UploadController::class, 'destroy'])->name('upload.destroy');

    // Tambahkan baris ini
    Route::post('/upload/truncate', [App\Http\Controllers\UploadController::class, 'truncate'])->name('upload.truncate');

});