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
        Schema::table('cp', function (Blueprint $table) {

            $table->string('status_verifikasi', 20)
                  ->default('Menunggu');

            $table->text('catatan_revisi')
                  ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cp', function (Blueprint $table) {

            $table->dropColumn([
                'status_verifikasi',
                'catatan_revisi'
            ]);

        });
    }
};