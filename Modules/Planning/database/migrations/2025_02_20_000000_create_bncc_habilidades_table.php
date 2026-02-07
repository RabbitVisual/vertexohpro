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
        Schema::create('bncc_habilidades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->index();
            $table->text('descricao');
            $table->string('componente')->nullable(); // Matemática, Língua Portuguesa
            $table->string('componente_curricular')->nullable();
            $table->string('ano_faixa'); // 1º Ano, EF15
            $table->string('unidade_tematica')->nullable();
            $table->string('objeto_conhecimento')->nullable();
            $table->json('objetos_conhecimento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bncc_habilidades');
    }
};
