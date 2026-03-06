# Personal Todo – CodeIgniter 4.7 REST API

A simple personal todo management REST API built with [CodeIgniter 4.7](https://codeigniter.com/).

## Requirements

- PHP 8.1+
- Composer
- MySQL / MariaDB

## Installation

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Edit .env to set your database credentials, then run migrations
php spark migrate

# (Optional) Seed the database with sample data
php spark db:seed TodoSeeder
```

## Running the Development Server

```bash
php spark serve
```

The API will be available at `http://localhost:8080`.

## API Endpoints

| Method   | URL              | Description           |
|----------|------------------|-----------------------|
| `GET`    | `/todos`         | List all todos        |
| `POST`   | `/todos`         | Create a new todo     |
| `GET`    | `/todos/{id}`    | Get a specific todo   |
| `PUT`    | `/todos/{id}`    | Update a todo (full)  |
| `PATCH`  | `/todos/{id}`    | Update a todo (partial)|
| `DELETE` | `/todos/{id}`    | Delete a todo         |

### Todo Object

```json
{
  "id": 1,
  "title": "Buy groceries",
  "description": "Milk, eggs, bread, and coffee",
  "status": "pending",
  "created_at": "2024-01-01 00:00:00",
  "updated_at": "2024-01-01 00:00:00"
}
```

### Status Values

| Value       | Meaning            |
|-------------|--------------------|
| `pending`   | Not yet done (default) |
| `completed` | Finished           |

### Example Requests

**Create a todo**
```bash
curl -X POST http://localhost:8080/todos \
  -H "Content-Type: application/json" \
  -d '{"title": "Buy groceries", "description": "Milk and eggs", "status": "pending"}'
```

**List all todos**
```bash
curl http://localhost:8080/todos
```

**Get a specific todo**
```bash
curl http://localhost:8080/todos/1
```

**Update a todo**
```bash
curl -X PUT http://localhost:8080/todos/1 \
  -H "Content-Type: application/json" \
  -d '{"status": "completed"}'
```

**Delete a todo**
```bash
curl -X DELETE http://localhost:8080/todos/1
```

## Running Tests

```bash
composer test
```

## Database Migrations

```bash
# Run all pending migrations
php spark migrate

# Rollback last batch
php spark migrate:rollback

# Reset and re-run all migrations
php spark migrate:refresh
```
