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
        Schema::create('prosem_detail', function (Blueprint $table) {

            $table->id('id_prosem_detail');

            $table->unsignedBigInteger('id_prosem');

            $table->unsignedBigInteger('id_prota_detail');

            $table->tinyInteger('alokasi_waktu')->nullable();
                
            $table->tinyInteger('jp')->nullable();

            $table->string('bulan', 20);

            $table->tinyInteger('minggu_ke');

            $table->string('tanggal', 20)->nullable();

            $table->timestamps();

            $table->foreign('id_prosem')
                ->references('id_prosem')
                ->on('prosem')
                ->onDelete('cascade');

            $table->foreign('id_prota_detail')
                ->references('id_prota_detail')
                ->on('prota_detail')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosem_detail');
    }
};