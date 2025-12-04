<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

// --- Halaman Statis ---
Route::get('/home', function () { return view('home'); })->name('home');
Route::get('/feature', function () { return view('feature'); })->name('feature');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/about', function () { return view('about'); })->name('about');

// --- Feature Manajemen Data (Excel & Search) ---

// 1. Halaman Admin / Index Data (Melihat semua data & Upload)
// Route::get('/', [ExcelController::class, 'index '])->name('tenagakerja.index');

Route::get('/', function () {
    return view('home');
});

// 2. Proses Import Excel (POST)
Route::post('/import', [ExcelController::class, 'import'])->name('tenagakerja.import');

// 3. Halaman Pencarian Publik (GET - Menampilkan Form Awal)
// Kita arahkan ke method baru 'showSearchPage' agar lebih rapi, atau langsung view juga bisa.
// Tapi karena di search.blade.php kita ada logic upload juga, pakai controller search juga oke.
Route::get('/tenagakerja', [ExcelController::class, 'showSearchPage'])->name('tenagakerja'); 

// 4. Proses Pencarian (GET - Menampilkan Hasil)
Route::post('/search', [ExcelController::class, 'search'])->name('tenagakerja.search');