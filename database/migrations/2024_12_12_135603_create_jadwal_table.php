<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('shift');
            $table->timestamp('mulai');
            $table->timestamp('selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
