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
        Schema::create('modul_ajar', function (Blueprint $table) {
            $table->id('id_modul_ajar');

            $table->unsignedBigInteger('id_cp_detail');

            $table->unsignedBigInteger('id_administrasi');

            // data modul
            $table->string('judul_modul');

            $table->longText('identifikasi')->nullable();
            $table->longText('desain_pembelajaran')->nullable();
            $table->longText('pengalaman_belajar')->nullable();
            $table->longText('asesmen')->nullable();

            $table->string('status_verifikasi', 15)->default('draft');
            $table->text('catatan_revisi')->nullable();

            $table->timestamps();

            // FK: cp_detail
            $table->foreign('id_cp_detail')
                ->references('id_cp_detail')
                ->on('cp_detail')
                ->onDelete('cascade');

            // FK: administrasi
            $table->foreign('id_administrasi')
                ->references('id_administrasi')
                ->on('administrasi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_ajar');
    }
};
