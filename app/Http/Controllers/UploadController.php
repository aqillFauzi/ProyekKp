<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenagakerja;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BelumJmoExport;
use Illuminate\Support\Facades\DB;


class UploadController extends Controller
{
    /**
     * Menampilkan Dashboard & Data
     */
    public function index(Request $request)
    {
        // 1. Pagination 
        $perPage = $request->input('per_page', 10);

        // Mulai Query
        $query = Tenagakerja::query();

        // A. Filter Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_tk', 'LIKE', "%{$search}%")
                  ->orWhere('npp', 'LIKE', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('kode_tk', 'LIKE', "%{$search}%");
            });
        }

        // B. Filter Status (LOGIKA BARU DISINI)
        if ($request->filled('filter_status')) {
            // Akan mengambil data yang status_jmo nya sesuai pilihan dropdown
            $query->where('status_jmo', $request->filter_status);
        }

        // Eksekusi Query dengan Pagination
        // withQueryString() berguna agar saat pindah page, search & filter tetap nempel
        $data = $query->latest()->paginate($perPage)->withQueryString();

        // C. Hitung Statistik (Tetap sama)
        $total_perusahaan = Tenagakerja::distinct('npp')->count('npp');
        $total_tk_aktif   = Tenagakerja::count();
        $total_sudah_jmo  = Tenagakerja::where('status_jmo', 'Sudah JMO')->count();
        $total_belum_jmo  = Tenagakerja::where('status_jmo', 'Belum JMO')->count();

        return view('upload', compact(
            'data', 
            'total_perusahaan', 
            'total_tk_aktif', 
            'total_sudah_jmo', 
            'total_belum_jmo'
        ));
    }

    /**
     * Proses Import Excel
     */
    public function import(Request $request)
    {
        // 1. Setting agar tidak timeout
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $path = $request->file('file')->getRealPath();
            // Baca data tanpa memformat header dulu agar lebih ringan
            $data = Excel::toCollection(null, $path);

            if ($data->isEmpty()) {
                return back()->withErrors(['file' => 'File Excel kosong.']);
            }

            $rows = $data->first();
            $rows->shift(); // Buang Header (Baris 1)

            // 2. TAMPUNG DATA KE ARRAY DULU (JANGAN LANGSUNG KE DB)
            $insertData = [];
            $now = now(); // Untuk created_at dan updated_at

            foreach ($rows as $row) {
                // Pastikan kolom penting ada (NPP & Kode TK)
                if (!isset($row[2]) || !isset($row[4])) continue;

                // Logika Status
                $flagJmo = isset($row[12]) ? trim($row[12]) : 'T';
                $status  = ($flagJmo == 'Y') ? 'Sudah JMO' : 'Belum JMO';

                // Masukkan ke array penampung
                $insertData[] = [
                    'kode_tk'         => $row[4], // Kunci Unik
                    'kode_kantor'     => $row[1] ?? null,
                    'npp'             => $row[2] ?? null,
                    'nama_perusahaan' => $row[3] ?? null,
                    'nama_tk'         => $row[5] ?? null,
                    'handphone'       => $row[6] ?? null,
                    'kode_segmen'     => $row[8] ?? null,
                    'status_jmo'      => $status,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            // 3. EKSEKUSI KE DATABASE PER 1000 BARIS (CHUNK)
            // Ini kuncinya supaya tidak "mutar-mutar"
            $chunks = array_chunk($insertData, 1000);

            foreach ($chunks as $chunk) {
                // Upsert: Jika Kode TK sudah ada -> Update, Jika belum -> Insert
                Tenagakerja::upsert(
                    $chunk, 
                    ['kode_tk'], // Kolom acuan unik (Primary Key)
                    ['kode_kantor', 'npp', 'nama_perusahaan', 'nama_tk', 'handphone', 'kode_segmen', 'status_jmo', 'updated_at'] // Kolom yang diupdate jika data sudah ada
                );
            }

            return redirect()->route('upload.index')->with('success_upload', 'Data berhasil diimport dengan Cepat!');

        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal: ' . $e->getMessage()]);
        }
    }
    public function exportBelumJmo(Request $request)
    {
        // Ambil kata kunci dari kolom pencarian (jika ada)
        $npp = $request->input('search');

        // Kirim $npp ke dalam Class Export
        return Excel::download(new BelumJmoExport($npp), 'data-belum-jmo.xlsx');
    }
}