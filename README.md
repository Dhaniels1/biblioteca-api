# Biblioteca API

API REST em Laravel 12 / PHP 8.2+ com MySQL, criada conforme o enunciado `Exerccio.pdf` (Desenvolvimento Web III, IF Sudeste MG — Campus Muriaé). Inclui CRUD de autores, categorias e livros, respostas JSON e autenticação Laravel Sanctum 4.

## Abrir e instalar

1. Extraia o ZIP e abra a pasta `biblioteca-api` no VS Code (ou abra `biblioteca-api.code-workspace`).
2. Instale PHP 8.2+, Composer 2 e MySQL 8+ ou MariaDB 10.6+. No XAMPP, inicie o MySQL. Confira `php -v` e `composer --version` no terminal. Extensões PHP: ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, PDO, pdo_mysql, session, tokenizer, xml e zip. Para testes, habilite também pdo_sqlite.
3. No terminal da pasta do projeto:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

No Linux/macOS, use `cp .env.example .env`. Não é necessário Node.js, npm ou build de frontend.

4. No MySQL (terminal SQL ou aba SQL do phpMyAdmin), crie o banco:

```sql
CREATE DATABASE biblioteca_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Edite `.env` com suas credenciais:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca_api
DB_USERNAME=root
DB_PASSWORD=
```

O usuário root sem senha é apenas um exemplo de instalação local do XAMPP. Use as credenciais reais do seu banco.

6. Crie as tabelas e dados opcionais:

```powershell
php artisan config:clear
php artisan migrate --seed
php artisan serve
```

Abra http://127.0.0.1:8000/api/livros. Para banco vazio, execute `php artisan migrate` sem `--seed`. O seeder pode ser repetido com `php artisan db:seed`; não cria usuário ou senha padrão. Não rode `migrate:fresh` em um banco com dados que deseja preservar.

## Correspondência com o PDF

Os nomes e comprimentos do diagrama foram preservados, incluindo tabelas no singular e chaves explícitas:

| Tabela | Campos |
| --- | --- |
| autor | idautor INT (PK), nome VARCHAR(45), nacionalidade VARCHAR(45), nascimento DATE, biografia TEXT |
| categoria | idcategoria INT (PK), nome VARCHAR(45), descricao VARCHAR(255) |
| livro | idlivro INT (PK), titulo VARCHAR(255), isbn VARCHAR(45), anopublicacao INT, descricao VARCHAR(255), paginas INT, idautor INT (FK), idcategoria INT (FK) |

Autor 1:N Livro; Categoria 1:N Livro. `users` é a entidade de usuários do Laravel, com senha armazenada por hash; `personal_access_tokens` guarda os tokens Sanctum. O PDF menciona usuários, mas não especifica CRUD administrativo ou um diagrama para eles: a implementação fornece registro, login, consulta do próprio usuário e logout.

Decisões para pontos não detalhados no PDF: consultas públicas; escrita permitida a qualquer usuário cadastrado e autenticado, sem papéis de administrador; todos os campos do catálogo obrigatórios; ISBN único (texto de até 45 caracteres, sem impor formato ISBN-10/13); páginas positivas; ano entre 1 e 9999; nascimento não futuro; biografia limitada a 16 mil caracteres. A exclusão de autor/categoria com livros retorna 409 e preserva o catálogo. PUT exige o objeto completo. As tabelas do diagrama não recebem timestamps adicionais.

## Endpoints

Base local: `http://127.0.0.1:8000/api`. Substitua `{id}` pela chave numérica correspondente.

| Método | Caminho | Acesso | Resultado |
| --- | --- | --- | --- |
| GET | /autores | Público | Lista autores |
| GET | /autores/{id} | Público | Autor |
| POST | /autores | Token | Cria autor |
| PUT | /autores/{id} | Token | Atualiza autor |
| DELETE | /autores/{id} | Token | Exclui autor |
| GET | /categorias | Público | Lista categorias |
| GET | /categorias/{id} | Público | Categoria |
| POST | /categorias | Token | Cria categoria |
| PUT | /categorias/{id} | Token | Atualiza categoria |
| DELETE | /categorias/{id} | Token | Exclui categoria |
| GET | /livros | Público | Lista livros com autor e categoria |
| GET | /livros/{id} | Público | Livro com autor e categoria |
| POST | /livros | Token | Cria livro |
| PUT | /livros/{id} | Token | Atualiza livro |
| DELETE | /livros/{id} | Token | Exclui livro |
| POST | /register | Público | Registra usuário e emite token |
| POST | /login | Público | Emite token |
| GET | /user | Token | Consulta usuário autenticado |
| POST | /logout | Token | Revoga o token atual |

Envie `Accept: application/json` e, nos corpos JSON, `Content-Type: application/json`. Rotas `/api/*` retornam erros JSON mesmo sem Accept. Use `Authorization: Bearer TOKEN` para escrita, perfil e logout. Tokens expiram em 7 dias; logout invalida somente o token usado. Login e registro têm limite de 10 requisições por minuto/IP.

Respostas: 200 para consulta, atualização e exclusão (com mensagem JSON); 201 para criação; 401 sem token válido; 404 para registro inexistente; 409 para conflito relacional; 422 para validação; 429 ao exceder o limite. Listas são arrays JSON, sem envelope nem paginação. O acesso HEAD usa a semântica HTTP normal, sem corpo.

### Exemplos de corpos

Registro:
```json
{"name":"Aluno","email":"aluno@example.com","password":"SenhaTeste123!","password_confirmation":"SenhaTeste123!"}
```
Login:
```json
{"email":"aluno@example.com","password":"SenhaTeste123!"}
```
Autor (POST e PUT):
```json
{"nome":"Machado de Assis","nacionalidade":"Brasileira","nascimento":"1839-06-21","biografia":"Escritor brasileiro."}
```
Categoria (POST e PUT):
```json
{"nome":"Romance","descricao":"Narrativas de ficção."}
```
Livro (POST e PUT; use IDs existentes):
```json
{"titulo":"Dom Casmurro","isbn":"9788535914849","anopublicacao":1899,"descricao":"Romance brasileiro.","paginas":256,"idautor":1,"idcategoria":1}
```

GET de livro retorna esses campos, `idlivro` e os objetos `autor` e `categoria` completos. Uma validação inválida retorna `message` e `errors`, sendo `errors` um objeto de campos com listas de mensagens.

## Testar no Postman

1. Importe `postman/Biblioteca.postman_collection.json` e `postman/Local.postman_environment.json`.
2. Selecione o ambiente **Biblioteca Local** e confirme `base_url`.
3. Execute a coleção inteira no Collection Runner, na ordem original, com uma iteração. Ela registra um e-mail único por execução, faz login e salva o token automaticamente.
4. A sequência cria autor, categoria e livro, salva IDs, consulta e atualiza os três, verifica conflitos/validações e exclui somente os registros criados por ela. Por último, revoga o token e verifica 401.
5. Todos os pedidos têm verificações de status. O registro de teste permanece no banco; o catálogo criado pelo Runner é removido no final. Para testes manuais, execute primeiro Registro/Login e respeite a ordem autor/categoria antes de livro.

## Testes automatizados

```powershell
php artisan test
php vendor/bin/pint --test
```

Os testes usam SQLite em memória, isolado do MySQL configurado no `.env`, e recriam as tabelas a cada teste. Cobrem CRUD, relações, campos inválidos, ISBN repetido, impedimento de exclusão vinculada, acesso público, bloqueio de escrita anônima, cadastro/login, token real, logout e seed repetido. A configuração de CI executa a suíte no GitHub Actions.

## Organização

- `app/Models`: Autor, Categoria, Livro e User.
- `app/Http/Controllers`: CRUD e autenticação.
- `app/Http/Requests`: validação de catálogo e autenticação.
- `database/migrations`: estrutura relacional e tabelas Laravel/Sanctum.
- `database/seeders`: catálogo opcional de exemplo.
- `routes/api.php`: 15 endpoints do PDF e 4 de autenticação.
- `tests/Feature/BibliotecaTest.php`: integração da API.
- `postman`: coleção e ambiente importáveis.

## Git e entrega

O código contém `.gitignore`, `.editorconfig`, `composer.lock` e CI. Dependências, `.env`, tokens, bancos locais e logs não devem ir para o Git. Na pasta do projeto:

```powershell
git init
git add .
git commit -m "Implementa API de biblioteca com Laravel e Sanctum"
git branch -M main
git remote add origin URL_DO_SEU_REPOSITORIO
git push -u origin main
```

Crie antes um repositório vazio na sua conta e substitua `URL_DO_SEU_REPOSITORIO`. A entrega do PDF solicita o link do repositório até 30/09/2026. O repositório remoto ainda precisa ser criado/publicado na conta do aluno.

## Disponibilizar para acesso externo

O projeto local e o ZIP não constituem uma publicação. Para cumprir a exigência de acesso externo do PDF, use hospedagem com PHP 8.2+, Composer e MySQL/MariaDB:

1. Envie ou clone o código; execute `composer install --no-dev --optimize-autoloader`.
2. Configure o domínio/HTTPS e a raiz do servidor exclusivamente na pasta `public/`. Apache usa o `.htaccess` incluído; Nginx precisa encaminhar as rotas para `public/index.php`.
3. Configure `.env` com `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://seu-dominio` e as credenciais do banco da hospedagem. Gere `APP_KEY` apenas na primeira instalação e preserve-a nas atualizações.
4. Garanta escrita em `storage/` e `bootstrap/cache/`; execute `php artisan migrate --force`, `php artisan config:cache` e `php artisan route:cache`.
5. Verifique de outra rede `GET https://seu-dominio/api/livros` e o fluxo de autenticação. Defina a URL pública no ambiente do Postman e no README do seu repositório.

`php artisan serve` é para desenvolvimento. A hospedagem e a URL pública não estão provisionadas neste pacote.

## Problemas comuns

- **could not find driver**: habilite `pdo_mysql` (ou `pdo_sqlite` para testes) no PHP usado pelo terminal (`php --ini`).
- **ZIP ausente no Composer**: habilite `extension=zip` no `php.ini` e abra novo terminal.
- **Access denied / Connection refused**: confira MySQL iniciado, porta, usuário e senha; execute `php artisan config:clear` após editar `.env`.
- **No application encryption key**: execute `php artisan key:generate`.
- **401**: faça login novamente e envie o token Bearer.
- **409**: exclua/transfira livros antes de excluir autor ou categoria.
- **422 ao atualizar**: PUT requer todos os campos, inclusive os IDs de relacionamento.

Referências oficiais: [Laravel 12](https://laravel.com/docs/12.x), [Sanctum](https://laravel.com/docs/12.x/sanctum).
