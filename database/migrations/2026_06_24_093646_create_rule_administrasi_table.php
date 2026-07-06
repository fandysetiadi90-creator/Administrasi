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
        Schema::create('rule_administrasi', function (Blueprint $table) {
            $table->id('id_rule');

            $table->string('komponen');

            $table->enum('status', [
                'Wajib',
                'Tidak Wajib'
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_administrasi');
    }
};
