<?php

namespace Tests\Feature;

use Tests\TestCase;

class CatalogoDemonstracaoTest extends TestCase
{
    public function test_pagina_publica_exibe_roteiro_e_origem_da_api(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('O que você pode explorar aqui?');
        $response->assertSee('Guia técnico');
        $response->assertSee('/api/livros', false);
        $response->assertSee('GUIA_DEMONSTRACAO.md', false);
        $response->assertSee('Esta página é somente para consulta.');
    }
}
