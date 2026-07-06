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
        Schema::create('atp_detail', function (Blueprint $table) {
            $table->id('id_atp_detail');

            $table->unsignedBigInteger('id_atp');

            $table->unsignedBigInteger('id_cp_detail');

            $table->string('kode_tp', 10);

            $table->longText('tujuan_pembelajaran');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atp_detail');
    }
};
