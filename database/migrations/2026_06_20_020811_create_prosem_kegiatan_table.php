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
        Schema::create('prosem_kegiatan', function (Blueprint $table) {

            $table->id('id_kegiatan');

            $table->unsignedBigInteger('id_prosem');

            $table->string('nama_kegiatan');

            $table->string('bulan', 20);

            $table->tinyInteger('minggu_ke');

            $table->string('warna',30)->nullable();

            $table->timestamps();

            $table->foreign('id_prosem')
                ->references('id_prosem')
                ->on('prosem')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosem_kegiatan');
    }
};