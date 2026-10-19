# Publicação da Biblioteca API

Este documento descreve uma opção de publicação da aplicação com **Docker + Render**. O código do repositório já contém `Dockerfile`, `.dockerignore` e `docker/start.sh`; criar esses arquivos **não** significa que o serviço está publicado.

## Como a imagem funciona

A imagem utiliza PHP 8.3 e Apache, com DocumentRoot apontando exclusivamente para `public/`. Inclui as extensões `pdo_mysql` e `pdo_pgsql`, permitindo MySQL ou PostgreSQL. O Apache escuta a porta 10000.

Durante a inicialização o contêiner:

1. exige que `APP_KEY` esteja configurada;
2. executa `php artisan config:cache`;
3. executa `php artisan route:cache`;
4. aplica as migrations pendentes com `php artisan migrate --force`;
5. inicia o Apache.

A imagem **não** contém senha, token ou arquivo `.env` real.

## Publicar no Render

Documentação oficial: https://render.com/docs/deploy-php-laravel-docker

1. Crie um banco relacional acessível à aplicação. Laravel aceita MySQL e PostgreSQL; o enunciado permite ambos.
2. No Render, crie um **Web Service**, conecte o repositório `Dhaniels1/biblioteca-api`, escolha a branch `main` e runtime **Docker**.
3. Aponte para o `Dockerfile` da raiz e utilize a região do serviço de banco, se possível.
4. Configure as variáveis sensíveis no painel do Render, nunca no GitHub.

Exemplo de variáveis gerais:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://URL-REAL-DO-SEU-SERVICO.onrender.com
APP_KEY=base64:CHAVE_GERADA_FORA_DO_REPOSITORIO
API_ALLOW_PUBLIC_REGISTRATION=false
```

**Não copie o valor de APP_KEY acima literalmente.** Gere uma chave real em um ambiente confiável com `php artisan key:generate --show` e salve-a como segredo no Render. Preserve a mesma chave em atualizações.

Exemplo usando PostgreSQL:

```dotenv
DB_CONNECTION=pgsql
DB_URL=postgresql://USUARIO:SENHA@HOST:5432/BANCO
```

Também é possível configurar `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` separadamente. Use apenas credenciais do banco configurado no serviço.

5. Configure a rota `/up` como health check, se desejar.
6. Aguarde o build e o deploy do serviço. Se houver erro, verifique os logs do deploy.
7. Verifique `GET https://URL-REAL-DO-SEU-SERVICO.onrender.com/api/livros` em uma rede externa e confirme que o resultado é JSON.

## Segurança

O cadastro público é desabilitado por padrão quando `APP_ENV=production`. Assim, uma pessoa desconhecida não pode cadastrar uma conta para obter autorização de escrita no catálogo.

Crie contas de confiança por um processo administrativo seguro (por exemplo, via `php artisan tinker` em uma hospedagem que disponibilize shell). Não adicione senhas ao Git nem exponha tokens de autenticação em documentação.

Para demonstrações locais, o cadastro permanece habilitado por padrão; nesse ambiente é possível executar a coleção Postman completa. Habilitar `API_ALLOW_PUBLIC_REGISTRATION=true` em produção permite que qualquer pessoa obtenha acesso de escrita depois do cadastro — **não é recomendado** em uma API aberta.

## Limitações do plano Free do Render

- O Render não oferece runtime PHP nativo; por isso, utiliza-se Docker.
- Serviços web gratuitos não oferecem acesso SSH/Shell, o que dificulta provisionar uma conta inicial de confiança por linha de comando.
- Se optar pelo PostgreSQL gratuito do próprio Render, o banco expira **30 dias após a criação** segundo a documentação do provedor.
- A aplicação precisa de um banco persistente; gravar o catálogo apenas no sistema de arquivos efêmero do contêiner não é adequado.

Antes de criar recursos, confirme os limites e custos atuais do plano escolhido. Para uma publicação duradoura, considere uma hospedagem com banco persistente e acesso administrativo.

## Comandos locais úteis

```bash
php artisan route:list --path=api
php artisan test
vendor/bin/pint --test
```

Para verificar migrations pendentes sem alterar o banco:

```bash
php artisan migrate:status
```

## Estado

Os arquivos de Docker estão versionados no GitHub. O **build da imagem, o deploy remoto e o teste de ponta a ponta em um servidor público** ainda devem ser confirmados. Atualize este documento e o README com a URL real somente depois que a publicação funcionar.
