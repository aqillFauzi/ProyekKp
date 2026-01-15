<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenagakerja extends Model
{
    use HasFactory;

    protected $table = 'tenagakerjas';

    protected $fillable = [
        'kode_tk',
        'npp',
        'nama_perusahaan',
        'nama_tk',
        'kode_kantor',
        'nama_pembina',
        'handphone',
        'status_jmo',
    ];
}