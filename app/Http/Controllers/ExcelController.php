<?php

namespace App\Http\Controllers;

use App\Models\Tenagakerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class ExcelController extends Controller
{
    // Halaman Index (Biasanya untuk Admin/Upload nanti)
    public function index()
    {
        $tenagakerjas = Tenagakerja::all();
        // Ini tetap ke excel.index (sesuai request kamu nanti mau dipisah)
        return view('home', compact('tenagakerjas'));
    }

    // Halaman Search (Halaman Publik yang baru kita buat UI-nya)
    public function showSearchPage()
    {
        // Menampilkan halaman search.blade.php kosong (tanpa hasil pencarian)
        return view('search');
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

    public function search(Request $request)
    {
        $npp = $request->input('npp'); // Pakai input() untuk POST

        // Cari data
        $tenagakerja = Tenagakerja::where('npp', $npp)->first();

        if ($tenagakerja) {
            // Jika ketemu, redirect balik sambil bawa data 'tenagakerja' ke session
            return redirect()->route('tenagakerja')->with('tenagakerja', $tenagakerja);
        } else {
            // Jika tidak ketemu, redirect balik sambil bawa pesan error
            return redirect()->route('tenagakerja')->with('error', 'Data NPP tidak ditemukan.');
        }
    }
}
