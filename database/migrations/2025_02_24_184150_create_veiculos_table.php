<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('cor');
            $table->integer('ano');
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('cascade'); // Exclui veículo se cliente for excluído
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};