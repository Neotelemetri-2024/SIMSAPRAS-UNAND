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
            $table->integer('tarifunand')->nullable();
            $table->integer('tarifumum')->nullable();
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