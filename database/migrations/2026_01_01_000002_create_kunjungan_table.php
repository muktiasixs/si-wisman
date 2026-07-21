<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id('id_kunjungan');
            $table->unsignedBigInteger('id_negara_asal');
            $table->unsignedBigInteger('id_negara_tujuan')->nullable()->comment('Bisa null jika selalu Indonesia');
            $table->string('bulan'); // Menyimpan 'Januari', 'Februari', dll
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('id_negara_asal')->references('id_negara')->on('negara')->onDelete('cascade');
            $table->foreign('id_negara_tujuan')->references('id_negara')->on('negara')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
