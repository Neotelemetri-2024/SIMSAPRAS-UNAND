<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facility_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idSarana')->constrained('sarana');
            $table->foreignId('idRuangan')->nullable()->constrained('ruangan');
            $table->date('tanggal');
            $table->integer('jam_terpakai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};