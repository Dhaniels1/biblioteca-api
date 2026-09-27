<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BibliotecaTest extends TestCase
{
    use RefreshDatabase;

    private function autor(): array
    {
        return ['nome' => 'Machado de Assis', 'nacionalidade' => 'Brasileira', 'nascimento' => '1839-06-21', 'biografia' => 'Escritor brasileiro.'];
    }

    private function livro(): array
    {
        return ['titulo' => 'Dom Casmurro', 'isbn' => '9788535914849', 'anopublicacao' => 1899, 'descricao' => 'Romance.', 'paginas' => 256,
            'idautor' => Autor::create($this->autor())->idautor,
            'idcategoria' => Categoria::create(['nome' => 'Romance', 'descricao' => 'Ficção.'])->idcategoria];
    }

    public function test_consultas_publicas_e_escritas_protegidas(): void
    {
        foreach (['autores', 'categorias', 'livros'] as $uri) {
            $this->get('/api/'.$uri)->assertOk()->assertExactJson([]);
            $this->postJson('/api/'.$uri, [])->assertUnauthorized();
            $this->putJson('/api/'.$uri.'/1', [])->assertUnauthorized();
            $this->deleteJson('/api/'.$uri.'/1')->assertUnauthorized();
            $this->get('/api/'.$uri.'/999')->assertNotFound()->assertHeader('Content-Type', 'application/json');
        }
    }

    public function test_crud_autor_e_categoria(): void
    {
        Sanctum::actingAs(User::factory()->create());
        foreach ([['autores', 'autor', 'idautor', $this->autor()], ['categorias', 'categoria', 'idcategoria', ['nome' => 'Romance', 'descricao' => 'Ficção.']]] as [$uri, $table, $key, $payload]) {
            $id = $this->postJson('/api/'.$uri, $payload)->assertCreated()->json($key);
            $this->getJson('/api/'.$uri.'/'.$id)->assertOk()->assertJsonFragment($payload);
            $this->getJson('/api/'.$uri)->assertOk()->assertJsonCount(1);
            $payload['nome'] = 'Atualizado';
            $this->putJson('/api/'.$uri.'/'.$id, $payload)->assertOk()->assertJsonPath('nome', 'Atualizado');
            $this->deleteJson('/api/'.$uri.'/'.$id)->assertOk();
            $this->assertDatabaseMissing($table, [$key => $id]);
        }
    }

    public function test_crud_livro_relacionamentos_e_integridade(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $payload = $this->livro();
        $id = $this->postJson('/api/livros', $payload)->assertCreated()->assertJsonPath('autor.nome', 'Machado de Assis')->json('idlivro');
        $this->getJson('/api/livros/'.$id)->assertOk()->assertJsonPath('categoria.nome', 'Romance');
        $this->getJson('/api/livros')->assertOk()->assertJsonPath('0.autor.idautor', $payload['idautor']);
        $this->postJson('/api/livros', $payload)->assertUnprocessable()->assertJsonValidationErrors('isbn');
        $payload['titulo'] = 'Título atualizado';
        $this->putJson('/api/livros/'.$id, $payload)->assertOk()->assertJsonPath('titulo', 'Título atualizado');
        $this->deleteJson('/api/autores/'.$payload['idautor'])->assertStatus(409);
        $this->deleteJson('/api/categorias/'.$payload['idcategoria'])->assertStatus(409);
        $this->deleteJson('/api/livros/'.$id)->assertOk();
        $this->assertDatabaseMissing('livro', ['idlivro' => $id]);
        $this->deleteJson('/api/autores/'.$payload['idautor'])->assertOk();
        $this->deleteJson('/api/categorias/'.$payload['idcategoria'])->assertOk();
    }

    public function test_validacoes_e_rollback_de_atualizacao_invalida(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $this->postJson('/api/autores', array_replace($this->autor(), ['nome' => str_repeat('x', 46), 'nascimento' => '2050-01-01']))->assertUnprocessable()->assertJsonValidationErrors(['nome', 'nascimento']);
        $this->postJson('/api/categorias', ['nome' => 'a', 'descricao' => str_repeat('x', 256)])->assertUnprocessable();
        $payload = $this->livro();
        $id = $this->postJson('/api/livros', $payload)->assertCreated()->json('idlivro');
        $invalid = array_replace($payload, ['paginas' => 0, 'idautor' => 9999, 'idcategoria' => 9999]);
        $this->putJson('/api/livros/'.$id, $invalid)->assertUnprocessable()->assertJsonValidationErrors(['paginas', 'idautor', 'idcategoria']);
        $this->assertDatabaseHas('livro', ['idlivro' => $id, 'paginas' => 256]);
        $this->putJson('/api/livros/'.$id, ['titulo' => 'Incompleto'])->assertUnprocessable();
    }

    public function test_registro_login_token_real_e_revogacao(): void
    {
        $payload = ['name' => 'Aluno', 'email' => 'aluno@example.com', 'password' => 'SenhaTeste123!', 'password_confirmation' => 'SenhaTeste123!'];
        $token = $this->postJson('/api/register', $payload)->assertCreated()->assertJsonMissingPath('user.password')->json('token');
        $this->assertDatabaseCount('users', 1);
        $this->postJson('/api/register', $payload)->assertUnprocessable();
        $this->postJson('/api/login', ['email' => $payload['email'], 'password' => 'errada'])->assertUnprocessable();
        $this->postJson('/api/login', $payload)->assertOk()->assertJsonStructure(['token', 'user']);
        $headers = ['Authorization' => 'Bearer '.$token];
        $this->getJson('/api/user', $headers)->assertOk()->assertJsonPath('email', $payload['email']);
        $this->app['auth']->forgetGuards();
        $this->postJson('/api/autores', $this->autor(), $headers)->assertCreated();
        $this->app['auth']->forgetGuards();
        $this->postJson('/api/logout', [], $headers)->assertOk();
        $this->app['auth']->forgetGuards();
        $this->getJson('/api/user', $headers)->assertUnauthorized();
    }

    public function test_seed_pode_ser_repetido(): void
    {
        $this->seed();
        $this->seed();
        $this->assertDatabaseCount('autor', 1);
        $this->assertDatabaseCount('categoria', 1);
        $this->assertDatabaseCount('livro', 1);
    }
}
