<?php

namespace App\Exports;

use App\Models\Tenagakerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BelumJmoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $npp;

    // 1. Terima parameter NPP dari Controller
    public function __construct($npp = null)
    {
        $this->npp = $npp;
    }

    public function collection()
    {
        // Mulai query standar: Ambil yang BELUM JMO
        $query = Tenagakerja::where('status_jmo', 'Belum JMO');

        // 2. Jika ada NPP yang dikirim, filter berdasarkan NPP tersebut
        if ($this->npp) {
            $query->where('npp', 'LIKE', "%{$this->npp}%");
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Kode TK', 'NPP', 'Nama Perusahaan', 'Nama Tenaga Kerja', 'Handphone', 'Segmen', 'Status'];
    }

    public function map($row): array
    {
        return [
            $row->kode_tk,
            $row->npp,
            $row->nama_perusahaan,
            $row->nama_tk,
            $row->handphone,
            $row->kode_segmen,
            $row->status_jmo,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}