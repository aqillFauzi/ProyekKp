<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tenagakerjas', function (Blueprint $table) { // sesuaikan nama tabel
            $table->string('nama_pembina')->nullable()->after('nama_perusahaan');
        });
    }

    public function down()
    {
        Schema::table('tenagakerjas', function (Blueprint $table) {
            $table->dropColumn('nama_pembina');
        });
    }
};
