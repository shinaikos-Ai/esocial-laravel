# eSocial Extrator — Laravel

Sistema web com login para extração e filtragem de XMLs do eSocial por empresa, período e CPF.

## Requisitos

- PHP **8.2** ou superior
- Composer
- SQLite **ou** MySQL/PostgreSQL

---

## Instalação

```bash
# 1. Instalar dependências PHP
composer install

# 2. Copiar e configurar o .env
cp .env.example .env
php artisan key:generate

# 3a. SQLite (mais simples, padrão)
touch database/database.sqlite
#   → no .env: DB_CONNECTION=sqlite

# 3b. MySQL (alternativa)
#   → edite DB_* no .env e crie o banco antes

# 4. Rodar migrations
php artisan migrate

# 5. Popular com usuários iniciais
php artisan db:seed

# 6. Subir o servidor de desenvolvimento
php artisan serve
```

Acesse: **http://localhost:8000**

---

## Usuários padrão (após seed)

| E-mail                    | Senha          | Papel         |
|---------------------------|----------------|---------------|
| admin@esocial.local       | admin1234      | Administrador |
| operador@esocial.local    | operador1234   | Operador      |

> ⚠️ **Troque as senhas imediatamente após o primeiro login.**

---

## Papéis

| Papel       | O que pode fazer                                              |
|-------------|---------------------------------------------------------------|
| **Admin**   | Tudo: gerenciar usuários, acessar o extrator                  |
| **Operador**| Somente acessar o extrator com sua empresa vinculada          |

---

## Como funciona

1. Cada usuário tem um campo **Nº Inscrição** (CNPJ-raiz ou CNPJ completo, só dígitos).
2. Ao acessar o extrator, esse valor é injetado automaticamente no JavaScript — sem precisar editar código.
3. O extrator aceita:
   - **ZIP** com XMLs do eSocial
   - **CSV** com lista de CPFs (um por linha, aceita com ou sem formatação)
   - **Período** no formato `AAAAMM` (ex: `202608`)
4. Gera ZIPs separados por tipo de evento:
   - `S-5001` — Bases e Tributos por Trabalhador
   - `S-5011` — Bases e Tributos Consolidados
   - `S-5003` — Totalizador por Trabalhador
   - `S-5013` — Totalizador Consolidado

> Os eventos **5011** e **5013** são totalizadores da empresa — filtrados apenas por período (sem CPF).

---

## Estrutura relevante

```
app/
  Http/
    Controllers/
      Auth/AuthenticatedSessionController.php   ← Login/Logout
      UserController.php                        ← CRUD de usuários
      ExtratorController.php                    ← Injeta nrInsc na view
    Middleware/
      AdminMiddleware.php                       ← Protege rotas de gestão
    Requests/
      StoreUserRequest.php
      UpdateUserRequest.php
  Models/
    User.php                                    ← campo nr_insc + accessor
database/
  migrations/0001_create_users_table.php
  seeders/DatabaseSeeder.php
  factories/UserFactory.php
resources/views/
  auth/login.blade.php
  layouts/app.blade.php
  extrator/index.blade.php                      ← Extrator com JS embutido
  users/
    index.blade.php
    create.blade.php
    edit.blade.php
    _form.blade.php                             ← Partial compartilhado
routes/
  web.php
  auth.php
```

---

## Produção

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

Configure o web server (Apache/Nginx) para apontar para a pasta `public/`.

---

## Licença

MIT
