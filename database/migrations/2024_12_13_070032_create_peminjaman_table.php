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
            $table->enum('statusPeminjam', ['unit', 'ormawa', 'umum']);
            $table->integer('totalTarif')->default(0)->nullable();
            $table->text('feedbackPenolakan')->nullable();
            $table->string('evaluasi')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->foreignId( 'ditolak_oleh')->nullable()->constrained('users');
            $table->foreignId('dibatalkan_oleh')->nullable()->constrained('users');
            $table->foreignId('diproses_oleh')->nullable()->constrained('users');
            $table->enum('status', ['diajukan', 'ditolak', 'diproses', 'disetujui', 'dibatalkan', 'diajukanbatal', 'selesai']);
            $table->enum('statusPembayaran', ['lunas', 'tidak'])->nullable();
            $table->enum('statusPengembalian', ['sudah', 'belum'])->nullable();
            $table->string('buktiPembayaran')->nullable();
            $table->string('buktiRefund')->nullable();
            $table->string('suratDisposisi')->nullable();
            $table->text('feedbackPembatalan')->nullable();
            $table->text('alasanPembatalan')->nullable();
            $table->text('alasanTolakBatal')->nullable();
            $table->string('statusSebelumBatal')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamp('diproses_at')->nullable();
            $table->timestamp('ditolak_at')->nullable();
            $table->timestamp('dibatalkan_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};