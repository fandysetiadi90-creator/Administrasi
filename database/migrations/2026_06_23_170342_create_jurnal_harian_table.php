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
        Schema::create('jurnal_harian', function (Blueprint $table) {
            $table->id('id_jurnal_harian');

            $table->unsignedBigInteger('id_administrasi');
            $table->unsignedBigInteger('id_cp_detail');
            $table->unsignedBigInteger('id_atp_detail');

            $table->tinyInteger('minggu');
            $table->date('tanggal');

            $table->string('penilaian', 50)->nullable();

            $table->timestamps();

            $table->foreign('id_administrasi')
                ->references('id_administrasi')
                ->on('administrasi')
                ->onDelete('cascade');

            $table->foreign('id_cp_detail')
                ->references('id_cp_detail')
                ->on('cp_detail')
                ->onDelete('cascade');

            $table->foreign('id_atp_detail')
                ->references('id_atp_detail')
                ->on('atp_detail')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_harian');
    }
};
