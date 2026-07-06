<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atp_detail', function (Blueprint $table) {

            // Tambah kolom baru
            $table->unsignedBigInteger('id_cp_detail')
                ->after('id_atp_detail');
        });

        Schema::table('atp_detail', function (Blueprint $table) {

            $table->foreign('id_cp_detail')
                ->references('id_cp_detail')
                ->on('cp_detail')
                ->onDelete('cascade');
        });

        // Hapus FK id_atp jika ada
        try {
            DB::statement(
                'ALTER TABLE atp_detail DROP FOREIGN KEY atp_detail_id_atp_foreign'
            );
        } catch (\Exception $e) {
        }

        Schema::table('atp_detail', function (Blueprint $table) {

            if (Schema::hasColumn('atp_detail', 'id_atp')) {
                $table->dropColumn('id_atp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('atp_detail', function (Blueprint $table) {

            $table->unsignedBigInteger('id_atp')
                ->after('id_atp_detail');

            $table->foreign('id_atp')
                ->references('id_atp')
                ->on('atp')
                ->onDelete('cascade');

            $table->dropForeign(['id_cp_detail']);

            $table->dropColumn('id_cp_detail');
        });
    }
};