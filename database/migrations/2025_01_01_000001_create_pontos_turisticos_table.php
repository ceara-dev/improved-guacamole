<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pontos_turisticos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->text('descricao_curta')->nullable();
            $table->string('imagem')->nullable();
            $table->string('video_url')->nullable();
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('categoria');
            $table->decimal('avaliacao', 2, 1)->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('horario_funcionamento')->nullable();
            $table->decimal('preco_entrada', 10, 2)->nullable();
            $table->json('tags')->nullable();
            $table->integer('visualizacoes')->default(0);
            $table->integer('curtidas')->default(0);
            $table->timestamp('publicado_em')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pontos_turisticos');
    }
};
