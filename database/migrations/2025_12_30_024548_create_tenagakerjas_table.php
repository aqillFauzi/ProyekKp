<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenagakerjas', function (Blueprint $table) {
            $table->id();
            // Data Utama
            $table->string('kode_tk')->unique(); // Kunci Unik (Agar satu orang tidak dobel)
            $table->string('npp');
            $table->string('nama_perusahaan');
            $table->string('nama_tk');
            
            // Data Pendukung
            $table->string('kode_kantor')->nullable();
            $table->string('kode_segmen')->nullable(); // PU/BPU
            $table->string('handphone')->nullable();
            
            // Status Penting
            $table->string('status_jmo'); // Akan diisi 'Sudah JMO' atau 'Belum JMO'
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenagakerjas');
    }
};  