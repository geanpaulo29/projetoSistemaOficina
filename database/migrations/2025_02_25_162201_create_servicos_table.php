<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
            $table->text('descricao');
            $table->decimal('valor_mao_de_obra', 10, 2); // Renomeado de 'valor' para ficar claro
            $table->json('itens')->nullable(); // Armazena peças em formato JSON
            $table->decimal('valor_total', 10, 2); // Soma de itens + mão de obra
            $table->date('data_servico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
