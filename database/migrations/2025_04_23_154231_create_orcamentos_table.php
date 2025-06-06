<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('cascade'); // Exclui orçamento se cliente for excluído
            
            $table->foreignId('veiculo_id')
                  ->constrained('veiculos')
                  ->onDelete('cascade'); // Exclui orçamento se veículo for excluído
            
            $table->text('descricao');
            $table->decimal('valor_mao_de_obra', 10, 2);
            $table->json('itens');
            $table->decimal('valor_total', 10, 2);
            $table->date('validade')->nullable();
            $table->boolean('aprovado')->default(false);
            $table->timestamp('aprovado_em')->nullable();
            $table->foreignId('aprovado_por')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); // Define como nulo se usuário for excluído
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};