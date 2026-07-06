<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('atp');
    }

    public function down(): void
    {
        Schema::create('atp', function ($table) {

            $table->id('id_atp');

            $table->string('status_verifikasi', 15)
                ->default('Menunggu');

            $table->text('catatan_revisi')
                ->nullable();

            $table->timestamps();
        });
    }
};