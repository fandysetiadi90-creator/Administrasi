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
        Schema::create('prosem', function (Blueprint $table) {

            $table->id('id_prosem');

            $table->unsignedBigInteger('id_prota');
            
            $table->tinyInteger('semester');

            $table->string('status_verifikasi',10)->default('Menunggu');

            $table->text('catatan_revisi')->nullable();   

            $table->timestamps();

            $table->foreign('id_prota')
                ->references('id_prota')
                ->on('prota')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosem');
    }
};