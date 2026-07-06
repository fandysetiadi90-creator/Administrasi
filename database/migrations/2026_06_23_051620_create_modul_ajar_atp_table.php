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
        Schema::create('modul_ajar_atp', function (Blueprint $table) {

            $table->id('id_modul_ajar_atp');

            $table->foreignId('id_modul_ajar')
                ->constrained('modul_ajar', 'id_modul_ajar')
                ->cascadeOnDelete();

            $table->foreignId('id_atp_detail')
                ->constrained('atp_detail', 'id_atp_detail')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_ajar_atp');
    }
};
