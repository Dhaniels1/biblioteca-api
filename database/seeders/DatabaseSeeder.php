<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $autor = Autor::firstOrCreate(['nome' => 'Machado de Assis'], ['nacionalidade' => 'Brasileira', 'nascimento' => '1839-06-21', 'biografia' => 'Escritor brasileiro e fundador da Academia Brasileira de Letras.']);
        $categoria = Categoria::firstOrCreate(['nome' => 'Romance'], ['descricao' => 'Narrativas literárias de ficção.']);
        Livro::firstOrCreate(['isbn' => '9788535914849'], ['titulo' => 'Dom Casmurro', 'anopublicacao' => 1899, 'descricao' => 'Romance narrado por Bento Santiago.', 'paginas' => 256, 'idautor' => $autor->idautor, 'idcategoria' => $categoria->idcategoria]);
    }
}
