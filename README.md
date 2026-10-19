# Biblioteca API

API REST desenvolvida em **Laravel 12 / PHP 8.2+** com **MySQL**, criada para o trabalho de Desenvolvimento Web III do IF Sudeste MG — Campus Muriaé.

A aplicação disponibiliza CRUD de autores, categorias e livros, relacionamentos com Eloquent, respostas JSON e autenticação por tokens com Laravel Sanctum 4.

**Repositório:** https://github.com/Dhaniels1/biblioteca-api

## Estado do projeto

- [x] CRUD de autores.
- [x] CRUD de categorias.
- [x] CRUD de livros.
- [x] Livro retorna autor e categoria relacionados.
- [x] Banco criado por migrations do Laravel.
- [x] Respostas em JSON.
- [x] Autenticação com Laravel Sanctum.
- [x] Validação dos dados recebidos.
- [x] Testes automatizados.
- [x] Coleção Postman.
- [x] CI no GitHub Actions com SQLite e MySQL.
- [x] Código publicado no GitHub.
- [x] Serviço público implantado no Render.
- [x] Interface visual pública do catálogo (consulta, busca, filtros, autores e categorias).

> Acesse o catálogo visual em https://biblioteca-api-dhaniels1.onrender.com e as respostas JSON em https://biblioteca-api-dhaniels1.onrender.com/api/livros. O deploy, banco e migrations foram confirmados no Render.

## Requisitos

- PHP 8.2+
- Composer 2
- MySQL 8+ ou MariaDB 10.6+
- Extensões PHP: ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, PDO, pdo_mysql, session, tokenizer, xml e zip
- Para testes locais com SQLite: pdo_sqlite

Não é necessário Node.js ou npm para executar a API.

## Instalação local

Clone o repositório e entre na pasta:

```bash
git clone https://github.com/Dhaniels1/biblioteca-api.git
cd biblioteca-api
composer install
```

Crie o arquivo de ambiente e a chave da aplicação.

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

No Linux/macOS:

```bash
cp .env.example .env
php artisan key:generate
```

Crie o banco:

```sql
CREATE DATABASE biblioteca_api
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Configure o `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca_api
DB_USERNAME=root
DB_PASSWORD=
```

O usuário `root` sem senha é apenas um exemplo comum em instalações locais do XAMPP. Use as credenciais reais do seu ambiente.

Execute as migrations e, opcionalmente, o seeder:

```bash
php artisan config:clear
php artisan migrate --seed
php artisan serve
```

A API local ficará disponível em:

```text
http://127.0.0.1:8000/api
```

Para iniciar com banco vazio, execute `php artisan migrate` sem `--seed`.

### Catálogo de demonstração

Existe também o seeder independente `CatalogoDemoSeeder`, que adiciona **4 autores, 3 categorias e 7 livros**. Os relacionamentos de autor e categoria são criados automaticamente, e o seeder pode ser executado várias vezes sem duplicar dados (utiliza `firstOrCreate`).

```bash
php artisan db:seed --class=CatalogoDemoSeeder
```

No Render, a carga é habilitada por `SEED_DEMO_CATALOG=true` no ambiente do serviço. A inicialização executa o seeder após as migrations. Retire ou configure `SEED_DEMO_CATALOG=false` se não desejar repovoar dados demonstrativos em futuras reinicializações.

**Os ISBNs gerados para demonstração são fictícios** (exceto o exemplo inicial de Dom Casmurro) e a quantidade de páginas é ilustrativa, sem representar uma edição comercial específica.

## Modelo de dados

Os nomes e comprimentos principais seguem o diagrama fornecido no trabalho.

| Tabela | Campos |
| --- | --- |
| autor | idautor INT (PK), nome VARCHAR(45), nacionalidade VARCHAR(45), nascimento DATE, biografia TEXT |
| categoria | idcategoria INT (PK), nome VARCHAR(45), descricao VARCHAR(255) |
| livro | idlivro INT (PK), titulo VARCHAR(255), isbn VARCHAR(45), anopublicacao INT, descricao VARCHAR(255), paginas INT, idautor INT (FK), idcategoria INT (FK) |

Relacionamentos:

```text
Autor 1 ---- N Livro N ---- 1 Categoria
```

A entidade `users` é utilizada pela autenticação. Os tokens do Sanctum ficam em `personal_access_tokens`.

## Regras adotadas

Para pontos não detalhados explicitamente no enunciado, foram adotadas as seguintes decisões:

- consultas GET são públicas;
- POST, PUT e DELETE exigem autenticação;
- login é público; o cadastro é público apenas em desenvolvimento/testes por padrão e pode ser desabilitado em qualquer ambiente;
- ISBN é único;
- páginas devem ser positivas;
- ano de publicação deve estar entre 1 e 9999;
- nascimento do autor não pode estar no futuro;
- exclusão de autor ou categoria com livros vinculados retorna HTTP 409;
- PUT exige o objeto completo;
- tokens expiram em 7 dias;
- login e registro possuem limite de 10 requisições por minuto por IP.

## Interface visual (leitura pública)

Abra **https://biblioteca-api-dhaniels1.onrender.com** para consultar a biblioteca sem precisar interpretar JSON. A página foi feita com Blade, CSS e JavaScript puro, sem dependências de frontend nem alterações nos endpoints exigidos no exercício.

A interface inclui busca por título, autor ou ISBN, filtro por categoria, ordenação por título ou ano, detalhamento dos livros, listas de autores e categorias e indicadores do acervo. É responsiva para computador, tablet e celular. A interface consulta os endpoints `/api/livros`, `/api/autores` e `/api/categorias`.

**A página é apenas de consulta:** operações de POST, PUT e DELETE continuam restritas a usuários autenticados no Laravel Sanctum. Para demonstrar o CRUD, use a coleção do Postman em ambiente de teste com cadastro habilitado.

## Endpoints

Base local: `http://127.0.0.1:8000/api`.

| Método | Caminho | Acesso | Resultado |
| --- | --- | --- | --- |
| GET | /autores | Público | Lista autores |
| GET | /autores/{id} | Público | Retorna um autor |
| POST | /autores | Token | Cria autor |
| PUT | /autores/{id} | Token | Atualiza autor |
| DELETE | /autores/{id} | Token | Exclui autor |
| GET | /categorias | Público | Lista categorias |
| GET | /categorias/{id} | Público | Retorna uma categoria |
| POST | /categorias | Token | Cria categoria |
| PUT | /categorias/{id} | Token | Atualiza categoria |
| DELETE | /categorias/{id} | Token | Exclui categoria |
| GET | /livros | Público | Lista livros com autor e categoria |
| GET | /livros/{id} | Público | Retorna livro com autor e categoria |
| POST | /livros | Token | Cria livro |
| PUT | /livros/{id} | Token | Atualiza livro |
| DELETE | /livros/{id} | Token | Exclui livro |
| POST | /register | Configurável | Registra usuário e emite token (desabilitado por padrão em produção) |
| POST | /login | Público | Autentica e emite token |
| GET | /user | Token | Retorna o usuário autenticado |
| POST | /logout | Token | Revoga o token atual |

Para rotas protegidas:

```http
Authorization: Bearer TOKEN
Accept: application/json
```

Em requisições com corpo:

```http
Content-Type: application/json
```

## Códigos HTTP principais

| Código | Uso |
| --- | --- |
| 200 | Consulta, atualização ou exclusão bem-sucedida |
| 201 | Cadastro realizado |
| 401 | Token ausente/inválido ou credenciais incorretas |
| 403 | Cadastro público desabilitado |
| 404 | Registro inexistente |
| 409 | Conflito de integridade relacional |
| 422 | Dados de entrada inválidos |
| 429 | Limite de requisições excedido |

## Exemplos de JSON

Registro:

```json
{
  "name": "Aluno",
  "email": "aluno@example.com",
  "password": "SenhaTeste123!",
  "password_confirmation": "SenhaTeste123!"
}
```

Login:

```json
{
  "email": "aluno@example.com",
  "password": "SenhaTeste123!"
}
```

Autor:

```json
{
  "nome": "Machado de Assis",
  "nacionalidade": "Brasileira",
  "nascimento": "1839-06-21",
  "biografia": "Escritor brasileiro."
}
```

Categoria:

```json
{
  "nome": "Romance",
  "descricao": "Narrativas de ficção."
}
```

Livro:

```json
{
  "titulo": "Dom Casmurro",
  "isbn": "9788535914849",
  "anopublicacao": 1899,
  "descricao": "Romance brasileiro.",
  "paginas": 256,
  "idautor": 1,
  "idcategoria": 1
}
```

O GET de livros retorna também os objetos `autor` e `categoria` relacionados.

## Testar no Postman

Importe:

- `postman/Biblioteca.postman_collection.json`
- `postman/Local.postman_environment.json`

Selecione o ambiente **Biblioteca Local** e execute a coleção na ordem definida.

O fluxo cadastra usuário, autentica, cria autor/categoria/livro, consulta os dados, atualiza registros, verifica validações e conflitos, remove os dados criados, realiza logout e verifica a revogação do token. Execute o fluxo completo em ambiente local/de testes, pois o cadastro público fica desabilitado por padrão em produção.

### Verificação segura da API publicada

Para testar a implantação no Render sem modificar o banco nem abrir o cadastro público, importe:

- `postman/Biblioteca-Producao.postman_collection.json`
- `postman/Render.postman_environment.json`

Selecione **Biblioteca - Render (produção)** e execute a coleção de cima para baixo no Collection Runner. São sete requisições que verificam listagens, relações autor/categoria, consulta por ID e as proteções HTTP 401/403. As requisições POST dessa coleção usam acesso anônimo e **devem ser negadas**, sem inserir registros.

O CRUD autenticado completo continua coberto pelos testes Laravel e pela coleção local. Para executá-lo no Render, é necessário configurar uma conta autorizada de modo seguro; não habilite o cadastro público de produção apenas para testes.

## Testes automatizados

Para executar localmente:

```bash
php artisan test
vendor/bin/pint --test
```

Por padrão, a suíte local utiliza SQLite em memória para manter os testes rápidos e isolados.

O GitHub Actions está configurado para executar a suíte duas vezes:

1. SQLite em memória.
2. MySQL 8.4 em um serviço isolado do CI.

Isso permite verificar tanto a lógica da aplicação quanto a compatibilidade com o banco utilizado na entrega.

## Organização

- `app/Models`: Autor, Categoria, Livro e User.
- `app/Http/Controllers`: CRUD e autenticação.
- `app/Http/Requests`: validação dos dados.
- `database/migrations`: estrutura do banco.
- `database/seeders`: seeder básico e `CatalogoDemoSeeder`, com 4 autores, 3 categorias e 7 livros demonstrativos.
- `routes/api.php`: rotas REST públicas e autenticadas.
- `routes/web.php` e `resources/views/catalogo.blade.php`: interface visual independente da API.
- `tests/Feature/BibliotecaTest.php`: testes de integração.
- `postman`: coleção e ambiente para testes manuais.
- `.github/workflows/tests.yml`: integração contínua.

## Publicação externa

O serviço está publicado em **https://biblioteca-api-dhaniels1.onrender.com** no plano gratuito do Render, utilizando Docker e PostgreSQL 16. O build, o deploy, as migrations e a resposta HTTP 200 da rota inicial foram confirmados nos logs do Render em 19/10/2026. Verifique os endpoints em um navegador ou no Postman para completar a conferência externa. Veja [DEPLOY.md](DEPLOY.md) para configuração, segurança, limitações e procedimentos.

Para produção, o servidor deve utilizar PHP 8.2+, Composer e um banco compatível (MySQL/MariaDB ou PostgreSQL). A raiz pública deve apontar exclusivamente para a pasta `public/`.

Fluxo básico:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

Configurações mínimas esperadas no ambiente:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio
API_ALLOW_PUBLIC_REGISTRATION=false
```

**Segurança do cadastro:** em produção o cadastro público fica desabilitado por padrão, para evitar que qualquer visitante obtenha autorização de escrita após criar uma conta. Crie previamente uma conta de confiança diretamente no ambiente da aplicação (por exemplo, pelo Tinker, com senha forte e não versionada). O login permanece disponível. Só ative `API_ALLOW_PUBLIC_REGISTRATION=true` se você aceitar explicitamente que novas contas também possam alterar/excluir o catálogo. Após qualquer alteração no `.env` em produção, atualize o cache com `php artisan config:cache`.

Para completar a verificação funcional, consulte de outra rede:

```text
GET https://biblioteca-api-dhaniels1.onrender.com/api/livros
```

e também o fluxo de registro/login e escrita autenticada.

## Problemas comuns

- **could not find driver**: habilite `pdo_mysql` ou `pdo_sqlite`.
- **ZIP ausente no Composer**: habilite a extensão `zip`.
- **Access denied / Connection refused**: confira MySQL, porta, usuário e senha.
- **No application encryption key**: execute `php artisan key:generate`.
- **401 no login**: confira e-mail e senha.
- **403 em /api/register**: o cadastro público está desabilitado neste ambiente.
- **401 em rota protegida**: faça login e envie o token Bearer.
- **409 ao excluir**: há livros vinculados ao autor ou categoria.
- **422 ao atualizar**: PUT exige todos os campos do recurso.

## Referências

- Laravel 12: https://laravel.com/docs/12.x
- Laravel Sanctum: https://laravel.com/docs/12.x/sanctum
