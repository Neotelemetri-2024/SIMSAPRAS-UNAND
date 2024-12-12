<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
       public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idRuangan');
            $table->unsignedBigInteger('idTanggal');
            $table->string('kegiatan');
            $table->unsignedBigInteger('idJadwal');
            $table->string('suratPeminjaman')->nullable();
            $table->string('rundown')->nullable();
            $table->integer('estimasiPeserta')->nullable();
            $table->integer('tarif')->nullable();
            $table->text('feedbackPembatalan')->nullable();
            $table->text('feedbackPenolakan')->nullable();
            $table->enum('status', ['diajukan', 'ditolak', 'diproses', 'disetujui']);
            $table->string('evaluasi')->nullable();
            $table->timestamps();

            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idRuangan')->references('id')->on('ruangan')->onDelete('cascade');
            $table->foreign('idTanggal')->references('id')->on('tanggalPeminjaman')->onDelete('cascade');
            $table->foreign('idJadwal')->references('id')->on('jadwal')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};
