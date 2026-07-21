<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negara', function (Blueprint $table) {
            $table->id('id_negara');
            $table->unsignedBigInteger('id_sumber')->nullable();
            $table->string('nama_negara');
            $table->string('kode_negara', 2)->comment('ISO 3166-1 alpha-2 untuk GeoChart');
            $table->timestamps();

            $table->foreign('id_sumber')->references('id_sumber')->on('sumber_data')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negara');
    }
};
