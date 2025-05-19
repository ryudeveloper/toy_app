# Loja de Brinquedos - Projeto Full Stack

Sistema completo em Laravel + HTML/Bootstrap que permite o cadastro e visualização de clientes, vendas e estatísticas com autenticação via token e frontend responsivo.

## Backend (Laravel 12)

### Requisitos
- PHP >= 8.2
- Composer
- MySQL

### Instalação
```bash
cd nome-do-projeto
composer install
cp .env.example .env
php artisan key:generate
```

### Configuração do `.env`
Configure seu banco de dados:
```env
DB_DATABASE=toy_app
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://127.0.0.1:8000
```

### Rodar a aplicação
```bash
php artisan migrate:fresh --seed
php artisan serve
```

### Login
Após rodar o seeder:
- **E-mail:** `admin@example.com`
- **Senha:** `123456`

### Autenticação
O sistema usa Laravel Sanctum para autenticação via token. As rotas da API são protegidas por `auth:sanctum`.

### Funcionalidades da API
- Cadastro, listagem, edição e remoção de clientes
- Registro de vendas por cliente
- Estatísticas:
  - Total de vendas por dia
  - Cliente com maior volume
  - Cliente com maior média
  - Cliente com maior frequência

### Testes
```bash
php artisan test
```

---

##  Frontend (HTML + Bootstrap)

### Funcionalidades
- Login via API
- Cadastro de clientes
- Lista de clientes com:
  - Nome, e-mail, data de nascimento
  - Lista de vendas por cliente
  - Primeira letra do alfabeto que falta no nome
- Destaques de clientes (volume, média, frequência)
- Gráfico de vendas por dia (Chart.js)
- Normalização de JSON desorganizado da API

### Como usar
Abra o arquivo:
```
resources/views/dashboard.blade.php
```
Se estiver usando via Laravel com rota:
```php
Route::get('/', fn() => view('dashboard'));
Route::get('/dashboard', fn() => view('dashboard'));
```

## Estrutura
```
app/
├── DTOs/
├── Http/Controllers/
├── Models/
├── Repositories/
├── Services/
├── Providers/
resources/views/dashboard.blade.php
routes/api.php
routes/web.php
```

---

## Contribuição
Sinta-se livre para clonar, estudar, melhorar ou integrar este projeto em suas próprias ideias.

---

## Desafio Resolvido
Este projeto atende completamente os critérios de:
- Autenticação REST
- Cadastro e manipulação de dados via API
- Tratamento de estrutura de dados desorganizada
- Exibição visual (dashboard)
- Arquitetura com boas práticas (Clean Code, SOLID, Testes, DTOs, Services)
