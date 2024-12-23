<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
    {
        Schema::create('tanggalPeminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPeminjaman')->constrained('peminjaman');
            $table->foreignId('idJadwal')->constrained('jadwal');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tanggalPeminjaman');
    }
};
