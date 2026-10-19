# Validação do projeto

## Cobertura implementada

A versão atual possui testes de integração para:

- consultas públicas de autores, categorias e livros;
- bloqueio de escrita sem autenticação;
- CRUD de autores e categorias;
- CRUD de livros;
- retorno das relações de autor e categoria nos livros;
- ISBN duplicado;
- validações de campos;
- integridade ao excluir autor/categoria vinculados;
- registro de usuário;
- login válido;
- login inválido retornando HTTP 401;
- bloqueio de cadastro público quando desabilitado por configuração;
- uso de token Sanctum;
- logout e revogação do token;
- execução repetida do seeder básico;
- carga demonstrativa com `CatalogoDemoSeeder`, incluindo relacionamentos e verificação de ausência de duplicatas.

## Integração contínua

O workflow `.github/workflows/tests.yml` é executado em push e pull request.

Ele realiza:

1. instalação das dependências via Composer;
2. geração da chave da aplicação;
3. execução da suíte com SQLite em memória;
4. execução da mesma suíte contra MySQL 8.4;
5. verificação de formatação com Laravel Pint.

A execução com MySQL reduz o risco de uma implementação funcionar apenas no SQLite usado nos testes locais.

## Validação local anterior

Antes das melhorias atuais, a versão inicial havia sido validada com:

- PHP 8.2.12;
- Laravel 12.69.2;
- Sanctum 4.3.3;
- migrations e seeder;
- suíte PHPUnit;
- coleção Postman;
- Laravel Pint.

Como a versão atual recebeu alterações posteriores, o resultado definitivo deve ser considerado o do workflow mais recente do GitHub Actions e, antes da entrega, uma última execução da coleção Postman.

## Situação da entrega

- Código publicado no GitHub: concluído.
- CRUD e relacionamentos: concluído.
- Autenticação Sanctum: concluída.
- Testes automatizados: configurados.
- CI com SQLite + MySQL: configurado.
- Coleção Postman: disponível.
- Catálogo de demonstração: 4 autores, 3 categorias, 7 livros; carga controlada por `SEED_DEMO_CATALOG=true` no Render.
- Docker: build remoto concluído com sucesso no Render em 19/10/2026.
- Serviço web publicado: https://biblioteca-api-dhaniels1.onrender.com — deploy **live** confirmado.
- PostgreSQL: disponível; criação e migrations das tabelas concluídas nos logs do Render.
- Testes HTTP externos específicos de `/api/livros`, `/api/autores` e `/api/categorias`: ainda pendentes de verificação por cliente externo.

O Render confirmou build Docker bem-sucedido, deploy ativo e execução das migrations de `users`, `cache`, `jobs`, `autor`, `categoria`, `livro` e `personal_access_tokens`. A rota raiz `/` respondeu HTTP 200 durante a checagem do Render. A consulta direta das rotas da API por um cliente externo ainda não foi confirmada nesta revisão. O workflow do CI com SQLite e MySQL está configurado, mas seus resultados devem ser conferidos no GitHub Actions.

O guia de publicação encontra-se em [DEPLOY.md](DEPLOY.md).
