<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autor', function (Blueprint $table) {
            $table->increments('idautor');
            $table->string('nome', 45);
            $table->string('nacionalidade', 45);
            $table->date('nascimento');
            $table->text('biografia');
        });
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('idcategoria');
            $table->string('nome', 45);
            $table->string('descricao', 255);
        });
        Schema::create('livro', function (Blueprint $table) {
            $table->increments('idlivro');
            $table->string('titulo', 255);
            $table->string('isbn', 45)->unique();
            $table->integer('anopublicacao');
            $table->string('descricao', 255);
            $table->integer('paginas');
            $table->unsignedInteger('idautor');
            $table->unsignedInteger('idcategoria');
            $table->foreign('idautor')->references('idautor')->on('autor')->restrictOnDelete();
            $table->foreign('idcategoria')->references('idcategoria')->on('categoria')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro');
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('autor');
    }
};
