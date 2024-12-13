<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('gambar_ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idRuangan')->constrained('ruangan');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gambar_ruangan');
    }
};
