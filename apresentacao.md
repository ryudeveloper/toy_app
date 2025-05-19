---
marp: true
theme: default
paginate: true
---

# 🧭 Projeto Loja de Brinquedos - Apresentação Técnica

---

## 🎯 Objetivo do Projeto

- Criar uma aplicação Full Stack completa
- Backend Laravel 12 com API REST
- Frontend HTML + Bootstrap + JS
- Autenticação, CRUD, estatísticas e visualização

---

## 🧱 Stack Utilizada

### 🔧 Backend
- Laravel 12
- Sanctum (auth via token)
- MySQL
- PHPUnit (testes)
- Design Patterns: DTO, Repository, Service
- Clean Code & SOLID

### 💻 Frontend
- HTML5
- Bootstrap 5
- JavaScript (Fetch API)
- Chart.js (gráficos)

---

## ⚙️ Arquitetura Backend

- Controller → Service → Repository
- DTO para transporte seguro de dados
- Repository desacopla acesso ao banco
- Service centraliza lógica de negócio
- Controllers apenas orquestram

---

## 🔐 Autenticação

- Laravel Sanctum
- Token via login `/api/login`
- Rotas protegidas com `auth:sanctum`

---

## 📊 Funcionalidades do Backend

- Cadastro, edição, remoção de clientes
- Filtros por nome e e-mail
- Registro de vendas
- Estatísticas por cliente:
  - Maior volume
  - Maior média
  - Maior frequência
- Estatísticas por dia (para gráficos)

---

## 🧪 Testes Automatizados

- `php artisan test`
- Testes de criação, edição, estatísticas
- Factories para clientes, vendas e usuários
- Seeders para popular rapidamente

---

## 📈 Frontend Funcional

- Tela de login
- Formulário de cadastro de cliente
- Listagem dinâmica com dados da API
- Gráfico de vendas (Chart.js)
- Destaques visuais (maior volume, média, frequência)
- Letra ausente no nome

---

## 🧹 Normalização de JSON

- API retorna estrutura aninhada e redundante
- Função JS extrai apenas os dados úteis
- Ignora campos duplicados ou inúteis (`duplicado`, `redundante`, etc.)

---

## 🚀 Execução

```bash
php artisan migrate:fresh --seed
php artisan serve
```
- Login: `admin@example.com`
- Senha: `123456`

---

## ✅ Conclusão

- API RESTful com autenticação e boas práticas
- Frontend funcional, simples e visual
- Arquitetura modular e testável
- Pronto para produção ou extensão
