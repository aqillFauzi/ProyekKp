<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenagakerja extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode_kantor',
        'npp',
        'divisi',
        'nama_perusahaan',
        'tk_aktif',
        'tk_sudah_jmo',
        'tk_belum_jmo',
    ];
}
