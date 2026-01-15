<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenagakerja;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BelumJmoExport;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Tenagakerja::query();

        // A. Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tk', 'LIKE', "%{$search}%")
                    ->orWhere('npp', 'LIKE', "%{$search}%")
                    ->orWhere('nama_perusahaan', 'LIKE', "%{$search}%")
                    ->orWhere('nama_pembina', 'LIKE', "%{$search}%") // Tambahkan pencarian pembina
                    ->orWhere('kode_tk', 'LIKE', "%{$search}%");
            });
        }

        // B. Filter Status
        if ($request->filled('filter_status')) {
            $query->where('status_jmo', $request->filter_status);
        }

        $data = $query->latest()->paginate($perPage)->withQueryString();

        // C. Statistik
        $total_perusahaan = Tenagakerja::distinct('npp')->count('npp');
        $total_tk_aktif   = Tenagakerja::count();
        $total_sudah_jmo  = Tenagakerja::where('status_jmo', 'Sudah JMO')->count();
        $total_belum_jmo  = Tenagakerja::where('status_jmo', 'Belum JMO')->count();

        return view('upload', compact( // <--- KEMBALIKAN KE 'upload'
            'data',
            'total_perusahaan',
            'total_tk_aktif',
            'total_sudah_jmo',
            'total_belum_jmo'
        ));
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $path = $request->file('file')->getRealPath();
            $data = Excel::toCollection(null, $path);

            if ($data->isEmpty()) {
                return back()->withErrors(['file' => 'File Excel kosong.']);
            }

            $rows = $data->first();
            $rows->shift(); // Buang Header

            $insertData = [];
            $now = now();

            foreach ($rows as $row) {
                
                // Pastikan kolom penting ada
                if (!isset($row[2]) || !isset($row[4])) continue;

                // Logika Status
                // Cek kolom ke-12 (M) di Excel Anda, sesuaikan jika bergeser
                $flagJmo = isset($row[12]) ? trim($row[12]) : 'T';
                $status  = ($flagJmo == 'Y') ? 'Sudah JMO' : 'Belum JMO';

                $insertData[] = [
                    'kode_tk'         => $row[4],
                    'kode_kantor'     => $row[1] ?? null,
                    'npp'             => $row[2] ?? null,
                    'nama_perusahaan' => $row[3] ?? null,
                    'nama_tk'         => $row[5] ?? null,
                    'handphone'       => $row[6] ?? null,
                    'kode_segmen'     => $row[8] ?? null,
                    'nama_pembina'    => $row[7] ?? null,
                    // ------------------------

                    'status_jmo'      => $status,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            $chunks = array_chunk($insertData, 1000);

            foreach ($chunks as $chunk) {
                Tenagakerja::upsert(
                    $chunk,
                    ['kode_tk'],
                    // Pastikan 'nama_pembina' dimasukkan disini agar ter-update
                    ['kode_kantor', 'npp', 'nama_perusahaan', 'nama_tk', 'handphone', 'kode_segmen', 'nama_pembina', 'status_jmo', 'updated_at']
                );
            }

            return redirect()->route('upload.index')->with('success_upload', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    // ... (Fungsi Export tetap sama) ...
    public function exportBelumJmo(Request $request)
    {
        $npp = $request->input('search');
        return Excel::download(new BelumJmoExport($npp), 'data-belum-jmo.xlsx');
    }

    public function destroy($id)
    {
        $data = Tenagakerja::findOrFail($id);
        $data->delete();
        return back()->with('success_upload', 'Data Tenaga Kerja berhasil dihapus!');
    }

    /**
     * FITUR BARU: HAPUS SEMUA DATA (RESET)
     * Tambahkan route baru untuk mengakses ini jika perlu
     */
    public function truncate()
    {
        // Menghapus SEMUA data di tabel secara cepat
        Tenagakerja::truncate();

        return back()->with('success_upload', 'Semua data berhasil dibersihkan! Silakan upload Excel baru.');
    }
}
