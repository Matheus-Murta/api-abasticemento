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
        Schema::create('header_abastecimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('tipo_registro');
            $table->string('cnpj');
            $table->string('identificador_emissor');
            $table->string('data_primeiro_registro');
            $table->string('data_ultimo_registro');
            $table->string('hora_primeiro_registro');
            $table->string('hora_ultimo_registro');
            $table->timestamp('data_geracao');
            $table->string('periodo');
            $table->enum('status', ['Pendente', 'Enviado']);
            $table->timestamp('data_envio_rm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_abastecimentos');
    }
};
