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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');

            $table->unsignedBigInteger('id_kelas');

            $table->string('nama', 60);
            $table->string('nis', 30)->unique();

            $table->string('tempat_lahir', 25);
            $table->date('tgl_lahir');

            $table->string('nik', 25)->unique();

            $table->string('agama', 12);

            $table->text('alamat');

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_kelas')
                ->references('id_kelas')
                ->on('kelas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
