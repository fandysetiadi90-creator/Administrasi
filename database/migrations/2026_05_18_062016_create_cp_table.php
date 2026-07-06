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
        Schema::create('cp', function (Blueprint $table) {
            $table->id('id_cp');
            $table->unsignedBigInteger('id_administrasi');

            $table->string('fase', 10);

            $table->text('deskripsi_umum')->nullable();

            $table->timestamps();

            $table->foreign('id_administrasi')
                ->references('id_administrasi')
                ->on('administrasi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp');
    }
};
