<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('penjaga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idSarana')
                  ->constrained('sarana')
                  ->onDelete('cascade');
            $table->string('kontak');
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjaga');
    }
};