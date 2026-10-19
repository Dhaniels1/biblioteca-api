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
- execução repetida do seeder.

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
- Arquivos de Docker para deploy: configurados, ainda sem build remoto verificado.
- Publicação da API em URL externa: pendente.

A publicação externa é a principal etapa que ainda precisa ser concluída para atender integralmente ao enunciado. O workflow do CI foi configurado, mas seu resultado na versão mais recente ainda precisa ser conferido no GitHub Actions. O Dockerfile também precisa de um primeiro build antes de ser considerado validado.

O guia de publicação encontra-se em [DEPLOY.md](DEPLOY.md).
