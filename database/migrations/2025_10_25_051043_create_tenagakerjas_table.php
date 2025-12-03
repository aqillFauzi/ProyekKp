<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenagakerjas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kantor')->nullable();
            $table->string('npp')->unique();
            $table->string('divisi')->nullable();
            $table->string('nama_perusahaan');
            $table->integer('tk_aktif')->nullable();
            $table->integer('tk_sudah_jmo')->nullable();
            $table->integer('tk_belum_jmo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenagakerjas');
    }
};
