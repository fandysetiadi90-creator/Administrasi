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
        Schema::create('prota', function (Blueprint $table) {
            $table->id('id_prota');

            $table->foreignId('id_administrasi')
                ->references('id_administrasi')
                ->on('administrasi')
                ->cascadeOnDelete();

            // hasil hitung dari detail
            $table->integer('total_jp')->default(0);              // SUM semua JP
            $table->integer('alokasi_per_minggu')->default(0);    // biasanya 6

            $table->string('status_verifikasi', 15)->default('Menunggu');
            $table->text('catatan_revisi')->nullable('');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prota');
    }
};
