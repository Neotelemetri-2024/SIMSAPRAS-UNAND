<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::create('sarana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdKategori')
                  ->constrained('kategori_sarana')
                  ->onDelete('cascade');
            $table->string('gambar');
            $table->text('deskripsi');
            $table->string('nama');
            $table->integer('kapasitas')->nullable();
            $table->string('fasilitas')->nullable();
            $table->integer('tarifunand')->nullable();
            $table->integer('tarifumum')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sarana');
    }
};