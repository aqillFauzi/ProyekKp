<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenagakerja; // Pastikan memanggil Model

class DashboardController extends Controller
{
    public function index()
    {
        // LOGIKA STATISTIK (Menggunakan Count, bukan Sum)
        
        // 1. Total Perusahaan
        $total_perusahaan = Tenagakerja::distinct('npp')->count('npp');

        // 2. Total Tenaga Kerja Aktif
        $total_tk_aktif   = Tenagakerja::count();

        // 3. Status JMO
        $total_sudah_jmo  = Tenagakerja::where('status_jmo', 'Sudah JMO')->count();
        $total_belum_jmo  = Tenagakerja::where('status_jmo', 'Belum JMO')->count();

        // Pastikan Anda punya file view bernama 'dashboard.blade.php'
        return view('dashboard', compact(
            'total_perusahaan', 
            'total_tk_aktif', 
            'total_sudah_jmo', 
            'total_belum_jmo'
        ));
    }
}