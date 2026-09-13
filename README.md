# Monolito Modular PHP

Arquitetura modular monolito com Hexagonal leve, Eloquent ORM e router organizado.

## Estrutura

```
src/
  Core/                Kernel, Router, Database
  Modules/{Nome}/      Domain, Application, Infrastructure, Interface
  Shared/              View Renderer, Eloquent base
public/index.php
config/database.php
database.sqlite
```

## Instalação

```bash
composer install
```

## Criar módulo

```bash
./scripts/create-module.sh NomeDoModulo
```

Gera Domain, Application, Infrastructure Eloquent, Controller e rotas.

## Rotas

Router auto-descobre módulos em `src/Modules/*` e carrega `Interface/Routes/routes.php`.

Exemplo Users:
- `GET /users/view` → lista HTML
- `GET /users/create` → formulário
- `POST /users` → cria
- `GET /users/{id}` → JSON

## Views

Use `App\Shared\Infrastructure\View\Renderer::render($template, $data)`

Templates em `Modules/{Nome}/Interface/Views`

## Migrations

Crie arquivos em `Modules/{Nome}/Infrastructure/Migrations` e execute via `scripts/migrate.php` ou direto no SQLite.

## Desenvolvimento

Servir:
```bash
php -S localhost:8000 -t public
```

Arquitetura detalhada em `doc/arquitetura.txt`
