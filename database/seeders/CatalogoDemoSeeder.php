<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Não altera registros existentes nem duplica itens em novos deploys.
        DB::transaction(function (): void {
            $autores = [
                'Machado de Assis' => [
                    'nacionalidade' => 'Brasileira',
                    'nascimento' => '1839-06-21',
                    'biografia' => 'Escritor brasileiro e fundador da Academia Brasileira de Letras.',
                ],
                'José de Alencar' => [
                    'nacionalidade' => 'Brasileira',
                    'nascimento' => '1829-05-01',
                    'biografia' => 'Romancista brasileiro associado ao romantismo.',
                ],
                'Clarice Lispector' => [
                    'nacionalidade' => 'Brasileira',
                    'nascimento' => '1920-12-10',
                    'biografia' => 'Escritora brasileira de romances, contos e crônicas.',
                ],
                'Graciliano Ramos' => [
                    'nacionalidade' => 'Brasileira',
                    'nascimento' => '1892-10-27',
                    'biografia' => 'Escritor brasileiro associado ao romance regionalista.',
                ],
            ];

            $autoresIds = [];
            foreach ($autores as $nome => $atributos) {
                $autor = Autor::firstOrCreate(['nome' => $nome], $atributos);
                $autoresIds[$nome] = $autor->idautor;
            }

            $categorias = [
                'Romance' => 'Narrativas literárias de ficção em prosa.',
                'Novela' => 'Narrativas literárias de extensão intermediária.',
                'Regionalismo' => 'Obras ambientadas em contextos regionais brasileiros.',
            ];

            $categoriasIds = [];
            foreach ($categorias as $nome => $descricao) {
                $categoria = Categoria::firstOrCreate(
                    ['nome' => $nome],
                    ['descricao' => $descricao]
                );
                $categoriasIds[$nome] = $categoria->idcategoria;
            }

            // ISBNs com prefixo 97800000010 são fictícios, destinados somente à demonstração.
            // A quantidade de páginas é ilustrativa e depende da edição do livro.
            $livros = [
                [
                    'titulo' => 'Dom Casmurro',
                    'isbn' => '9788535914849',
                    'anopublicacao' => 1899,
                    'descricao' => 'Um narrador revisita memórias de juventude.',
                    'paginas' => 256,
                    'autor' => 'Machado de Assis',
                    'categoria' => 'Romance',
                ],
                [
                    'titulo' => 'Memórias Póstumas de Brás Cubas',
                    'isbn' => '9780000001016',
                    'anopublicacao' => 1881,
                    'descricao' => 'Narrativa irônica apresentada por um narrador defunto.',
                    'paginas' => 208,
                    'autor' => 'Machado de Assis',
                    'categoria' => 'Romance',
                ],
                [
                    'titulo' => 'O Alienista',
                    'isbn' => '9780000001023',
                    'anopublicacao' => 1882,
                    'descricao' => 'Um médico investiga os limites entre razão e loucura.',
                    'paginas' => 96,
                    'autor' => 'Machado de Assis',
                    'categoria' => 'Novela',
                ],
                [
                    'titulo' => 'Iracema',
                    'isbn' => '9780000001030',
                    'anopublicacao' => 1865,
                    'descricao' => 'Narrativa ambientada no Ceará colonial.',
                    'paginas' => 144,
                    'autor' => 'José de Alencar',
                    'categoria' => 'Romance',
                ],
                [
                    'titulo' => 'O Guarani',
                    'isbn' => '9780000001047',
                    'anopublicacao' => 1857,
                    'descricao' => 'Romance indianista brasileiro do século XIX.',
                    'paginas' => 352,
                    'autor' => 'José de Alencar',
                    'categoria' => 'Romance',
                ],
                [
                    'titulo' => 'A Hora da Estrela',
                    'isbn' => '9780000001054',
                    'anopublicacao' => 1977,
                    'descricao' => 'A história de Macabéa, narrada por Rodrigo S. M.',
                    'paginas' => 96,
                    'autor' => 'Clarice Lispector',
                    'categoria' => 'Novela',
                ],
                [
                    'titulo' => 'Vidas Secas',
                    'isbn' => '9780000001061',
                    'anopublicacao' => 1938,
                    'descricao' => 'Família enfrenta a seca e a pobreza no sertão.',
                    'paginas' => 176,
                    'autor' => 'Graciliano Ramos',
                    'categoria' => 'Regionalismo',
                ],
            ];

            foreach ($livros as $dados) {
                Livro::firstOrCreate(
                    ['isbn' => $dados['isbn']],
                    [
                        'titulo' => $dados['titulo'],
                        'anopublicacao' => $dados['anopublicacao'],
                        'descricao' => $dados['descricao'],
                        'paginas' => $dados['paginas'],
                        'idautor' => $autoresIds[$dados['autor']],
                        'idcategoria' => $categoriasIds[$dados['categoria']],
                    ]
                );
            }
        });
    }
}
