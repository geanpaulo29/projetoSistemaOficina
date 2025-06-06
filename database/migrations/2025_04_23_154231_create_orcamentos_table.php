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
    // database/migrations/xxxx_create_orcamentos_table.php
    Schema::create('orcamentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained();
        $table->foreignId('veiculo_id')->constrained();
        $table->text('descricao');
        $table->decimal('valor_mao_de_obra', 10, 2);
        $table->json('itens');
        $table->decimal('valor_total', 10, 2);
        $table->date('validade')->nullable();
        $table->boolean('aprovado')->default(false);
        $table->timestamp('aprovado_em')->nullable();
        $table->foreignId('aprovado_por')->nullable()->constrained('users');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
