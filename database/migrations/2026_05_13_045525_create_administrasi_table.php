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
        Schema::create('administrasi', function (Blueprint $table) {

            $table->id('id_administrasi');

            $table->unsignedBigInteger('id_pengguna');

            $table->unsignedBigInteger('id_kelas');

            $table->unsignedBigInteger('id_mapel');

            $table->unsignedBigInteger('id_periode');

            $table->string('status', 30)
                  ->default('Draft');

            $table->timestamps();

             $table->foreign('id_pengguna')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');

             $table->foreign('id_kelas')
                  ->references('id_kelas')
                  ->on('kelas')
                  ->onDelete('cascade');

             $table->foreign('id_mapel')
                  ->references('id_mapel')
                  ->on('mapel')
                  ->onDelete('cascade');

             $table->foreign('id_periode')
                  ->references('id_periode')
                  ->on('periode')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasi');
    }
};
