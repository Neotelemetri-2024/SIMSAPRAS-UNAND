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
            $table->foreignId('idUser')->constrained('users');
            $table->foreignId('idRuangan')->nullable()->constrained('ruangan');
            $table->foreignId('idSarana')->constrained('sarana');
            $table->string('kegiatan');
            $table->string('suratPeminjaman')->nullable();
            $table->string('rundown')->nullable();
            $table->string('instansi');
            $table->integer('estimasiPeserta')->nullable();
            $table->boolean('isUnand')->default(true);
            $table->integer('totalTarif')->default(0)->after('isUnand')->nullable();
            $table->text('feedbackPenolakan')->nullable();
            $table->string('evaluasi')->nullable();
            $table->enum('status', ['diajukan', 'ditolak', 'diproses', 'disetujui', 'dibatalkan', 'diajukanbatal']);
            $table->enum('statusPembayaran', ['lunas', 'tidak'])->nullable();
            $table->enum('statusPengembalian', ['sudah', 'belum'])->nullable();
            $table->string('buktiPembayaran')->nullable();
            $table->text('feedbackPembatalan')->nullable();
            $table->text('alasanPembatalan')->nullable();
            $table->text('alasanTolakBatal')->nullable();
            $table->string('statusSebelumBatal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};