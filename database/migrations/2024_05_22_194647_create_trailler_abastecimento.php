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
        Schema::create('trailler_abastecimento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->foreign('header_id')->references('id')->on('header_abastecimentos');
            $table->string('id_tipo_registro');
            $table->integer('qtd_registro');
            $table->integer('total_material');
            $table->integer('total_valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailler_abastecimento');
    }
};
