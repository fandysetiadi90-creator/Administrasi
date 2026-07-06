<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atp', function (Blueprint $table) {

            $table->dropColumn([
                'id_administrasi',
                'id_cp',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('atp', function (Blueprint $table) {

            $table->unsignedBigInteger('id_administrasi')->nullable();
            $table->unsignedBigInteger('id_cp')->nullable();

        });
    }
};
