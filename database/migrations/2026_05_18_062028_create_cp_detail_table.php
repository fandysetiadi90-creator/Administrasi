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
        Schema::create('cp_detail', function (Blueprint $table) {
            $table->id('id_cp_detail');

            $table->unsignedBigInteger('id_cp');

            $table->string('elemen');

            $table->text('capaian_pembelajaran');
            $table->timestamps();

            $table->foreign('id_cp')
                  ->references('id_cp')
                  ->on('cp')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_detail');
    }
};
