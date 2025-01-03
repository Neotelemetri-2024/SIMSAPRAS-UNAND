<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idSarana')
                  ->constrained('sarana')
                  ->onDelete('cascade');
            $table->string('nama');
            $table->string('gambar');
            $table->text('deskripsi');
            $table->integer('kapasitas');
            $table->string('fasilitas');
            $table->integer('tariformawa');
            $table->integer('tarifunit');
            $table->integer('tarifumum');
            $table->boolean('kelas');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangan');
    }
};