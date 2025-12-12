<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenagakerja;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{

    public function index()
    {
        // 1. Ambil semua data dari tabel Tenagakerja
        // Kamu bisa menggunakan all() atau paginate(10) jika data banyak
        $data = Tenagakerja::paginate(10);

        // 2. Kirim variabel $data ke view 'upload'
        return view('upload', compact('data'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $path = $request->file('file')->getRealPath();

        // Membaca file excel
        $data = Excel::toCollection(null, $path);

        if ($data->isEmpty()) {
            return back()->withErrors(['file' => 'File Excel kosong atau tidak terbaca.']);
        }

        $rows = $data->first();

        // Logika skip header (tergantung struktur excel kamu)
        // Jika baris 1 adalah Judul, dan baris 2 adalah Header Kolom, maka shift 2 kali.
        // Sesuaikan dengan file aslimu.
        $rows->shift();

        foreach ($rows as $row) {
            // Pastikan row memiliki data yang cukup (sesuai index array yang dipanggil)
            if (isset($row[1])) {
                Tenagakerja::updateOrCreate(
                    ['npp' => $row[1]], // Kunci Unik (NPP)
                    [
                        'kode_kantor'     => $row[0] ?? null,
                        'divisi'          => $row[2] ?? null,
                        'nama_perusahaan' => $row[3] ?? null,
                        'tk_aktif'        => (int) ($row[4] ?? 0),
                        'tk_sudah_jmo'    => (int) ($row[5] ?? 0),
                        'tk_belum_jmo'    => (int) ($row[6] ?? 0),
                    ]
                );
            }
        }

        return redirect()->back()->with('success_upload', 'Data berhasil diimport ke database!');
    }
    // ... namespace dan use statement tetap sama ...

    // ... method import tetap sama ...

}
