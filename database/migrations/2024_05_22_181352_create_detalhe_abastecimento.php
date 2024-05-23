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
        Schema::create('detalhe_abastecimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->foreign('header_id')->references('id')->on('header_abastecimentos');
            $table->string('detalhe_tipo_registro');
            $table->integer('numero_sequencial');
            $table->string('data_transacao');
            $table->decimal('valor_transacao');
            $table->string('numero_cartao');
            $table->decimal('qtd_material');
            $table->string('tipo_material');
            $table->string('servico');
            $table->integer('tipo_abastecimento');
            $table->string('placa');
            $table->integer('hodometro');
            $table->string('cnpj_estabelecimento');
            $table->string('nome_estabelecimento');
            $table->string('info1');
            $table->string('info2');
            $table->string('matricula_motorista');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalhe_abastecimentos');
    }
};
