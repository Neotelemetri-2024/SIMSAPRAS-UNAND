<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('gambar_sarana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idSarana')
                  ->constrained('sarana')
                  ->onDelete('cascade');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gambar_sarana');
    }
};