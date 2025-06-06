<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('cor');
            $table->integer('ano');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Chave estrangeira para cliente
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}