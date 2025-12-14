<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenagakerja; // Pastikan Model di-import

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data Statistik
        $total_perusahaan = Tenagakerja::count();
        $total_tk_aktif   = Tenagakerja::sum('tk_aktif');
        $total_sudah_jmo  = Tenagakerja::sum('tk_sudah_jmo');
        $total_belum_jmo  = Tenagakerja::sum('tk_belum_jmo');

        // 2. Kirim ke View 'dashboard'
        return view('dashboard', compact(
            'total_perusahaan', 
            'total_tk_aktif', 
            'total_sudah_jmo', 
            'total_belum_jmo'
        ));
    }
}