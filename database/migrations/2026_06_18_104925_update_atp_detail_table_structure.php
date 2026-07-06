<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atp_detail', function (Blueprint $table) {

            $table->tinyInteger('semester')
                ->after('id_atp');

            $table->longText('alur_tujuan_pembelajaran')
                ->after('semester');

            $table->string('alokasi_waktu', 9)
                ->after('alur_tujuan_pembelajaran');

            $table->dropColumn('kode_tp');
        });
    }

    public function down(): void
    {
        Schema::table('atp_detail', function (Blueprint $table) {

            $table->string('kode_tp')
                ->after('semester');

            $table->dropColumn([
                'semester',
                'alur_tujuan_pembelajaran',
                'alokasi_waktu'
            ]);
        });
    }
};