# 📌 CodeIgniter 4 Kanban ToDo List

Um aplicativo de gerenciamento de tarefas em formato Kanban (arrastar e soltar), desenvolvido focado em separação de responsabilidades (Backend RESTful API + Frontend Vanilla JS consumindo os dados). Construído sobre o framework **CodeIgniter 4**.

![Kanban Preview](https://img.shields.io/badge/Status-Completed-success)
![PHP 8.0+](https://img.shields.io/badge/PHP-8.0%2B-blue)
![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EE4323?logo=codeigniter)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap)
![Vanilla JS](https://img.shields.io/badge/JavaScript-Vanilla-F7DF1E?logo=javascript)

---

## 🚀 Funcionalidades

- **Layout Kanban Responsivo:** 4 colunas dinâmicas (🔴 Limbo, 🔵 Para Fazer, 🟡 Fazendo, 🟢 Feito).
- **Drag and Drop (Arrastar e Soltar):** Movimente as tarefas entre as colunas fluidamente utilizando a API HTML5 nativa.
- **RESTful API:** Toda a comunicação de dados é feita via requisições HTTP (`GET`, `POST`, `PUT`, `DELETE`).
- **Segurança Reforçada:** Implementação rigorosa do **CSRF Token** nativo do CI4 injetado silenciosamente nas requisições do frontend.
- **Soft Deletes:** Tarefas excluídas não quebram o banco de forma definitiva.
- **Micro-interações:** Feedbacks visuais amigáveis usando [SweetAlert2](https://sweetalert2.github.io/).
- **Validação de Servidor:** Regras estritas no Model impedindo inserção de lixo na base de dados.

---

## 🏗️ Arquitetura

O sistema adota uma abordagem moderna:
* **Backend (`/api/app/Controllers/Tasks.php`):** Foca estritamente na regra de negócios, operando um *Resource Controller* que responde apenas JSON.
* **Frontend (`/api/app/Views/kanban.php`):** Uma SPA (Single Page Application) leve renderizada apenas uma vez. Toda a montagem das colunas e ações de CRUD são feitas pelo JavaScript manipulando a DOM.
* **Banco de Dados (MySQL):** A estrutura de tarefas (id, title, description, status, timestamps) é gerenciada e construída de forma automatizada usando **Migrations** do CodeIgniter.

---

## ⚙️ Rotas da API (`/tasks`)

| Método | Endpoint         | Descrição | Relatório Esperado |
|--------|------------------|-----------|--------------------|
| `GET`  | `/tasks`       | Lista todas as tarefas não deletadas | `[ { id: 1, title: '...', status: 'todo' } ]` |
| `POST` | `/tasks`       | Retorna e cadastra uma nova tarefa | `201 Created` |
| `PUT`  | `/tasks/:id`   | Atualiza informações ou o `status` (arrastar) | `200 OK` |
| `DELETE`| `/tasks/:id`  | Aplica um *Soft Delete* na tarefa | `200 OK` (Message: deleted) |

*Nota: Todas as requisições (exceto GET) exigem o header `X-CSRF-TOKEN` fornecido como uma meta tag no frontend.*

---

## 🛠️ Instalação e Configuração Local

Siga as instruções abaixo para rodar o projeto perfeitamente em sua máquina:

### 1. Pré-requisitos
- PHP 8.0 ou superior (com as extensões `intl`, `mbstring`, `json`, `mysqlnd` habilitadas).
- Composer
- Servidor MySQL ativo

### 2. Clonando o Repositório
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio/api
```

### 3. Instalando as Dependências
```bash
composer install
```

### 4. Configurando o Ambiente
Copie ou renomeie o arquivo de ambiente original `env` para `.env`:
```bash
cp env .env
```
Abra o `.env` e ajuste para o seu banco local e ambiente:
```ini
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = todo_list
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
```

### 5. Executando as Migrations (Banco de Dados)
Dentro da pasta do projeto (`/api`), rode a action para constuir a tabela `tasks`:
```bash
php spark migrate
```

### 6. Iniciando o Servidor de Desenvolvimento
Inicie a aplicação utilizando o emulador embutido do PHP:
```bash
php spark serve --port 8080
```
> A aplicação estará disponível em: `http://localhost:8080`

---

## 👨‍💻 Stack Tecnológica
* **PHP Base:** CodeIgniter 4 (AppStarter)
* **Design System / CSS:** Bootstrap 5.3 (via CDN)
* **Feedback Gráfico:** SweetAlert2
* **Ícones:** FontAwesome (Opcional, ou fallback para SVG)

---
*Criado com as melhores práticas de Engenharia de Software focada na simplicidade e escalabilidade.*
