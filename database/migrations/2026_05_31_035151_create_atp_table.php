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
        Schema::create('atp', function (Blueprint $table) {
            $table->id('id_atp');

            $table->unsignedBigInteger('id_administrasi');
            $table->unsignedBigInteger('id_cp');

            $table->string('unit', 20);

            $table->string('status_verifikasi', 15)
                ->default('Menunggu');

            $table->text('catatan_revisi')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atp');
    }
};
