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
        Schema::create('prota_detail', function (Blueprint $table) {
            $table->id('id_prota_detail');

            $table->foreignId('id_prota')
                ->references('id_prota')
                ->on('prota')
                ->cascadeOnDelete();        

            $table->foreignId('id_atp_detail')
                ->references('id_atp_detail')
                ->on('atp_detail')
                ->cascadeOnDelete();    

            // snapshot wajib
            $table->longText('alur_tujuan_pembelajaran');
            $table->tinyInteger('semester');

            // editable
            $table->integer('alokasi_waktu');   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prota_detail');
    }
};
