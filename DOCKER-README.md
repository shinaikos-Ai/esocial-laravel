# Docker — eSocial Extrator

## Executar (PowerShell)

```powershell
docker compose up -d --build
docker compose logs -f app
```

Abra http://localhost:8000

O banco SQLite e o diretório storage são persistidos em volumes Docker.
Na primeira inicialização, as migrações são executadas automaticamente.

## Criar usuários de demonstração (somente desenvolvimento)

```powershell
docker compose exec app php artisan db:seed --force
```

Contas de exemplo: admin@esocial.local / admin1234 e operador@esocial.local / operador1234.
Troque essas senhas imediatamente. NÃO execute o seed em produção.

## Comandos úteis

```powershell
docker compose ps
docker compose logs --tail=100 app
docker compose exec app php artisan migrate:status
docker compose down
```

**Não execute `docker compose down -v`** se quiser preservar os dados.

## Observações

- Configuração voltada para desenvolvimento local, não publicação direta na internet.
- O ZIP original estava incompleto; foram incluídos arquivos de inicialização essenciais do Laravel 11 e configuração básica de Vite.
- O projeto original não possui composer.lock; a versão exata das dependências pode variar durante o build.
- A inicialização real não foi validada em Docker neste ambiente.
- Para produção: configure HTTPS, segredos, backup dos volumes, APP_DEBUG=false, política de senhas e autenticação.
