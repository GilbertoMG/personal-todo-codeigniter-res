<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TodoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * Todos REST Controller
 *
 * Handles CRUD operations for Todo items.
 *
 * Routes:
 *   GET    /todos      -> index()   - List all todos
 *   POST   /todos      -> create()  - Create a new todo
 *   GET    /todos/{id} -> show()    - Get a specific todo
 *   PUT    /todos/{id} -> update()  - Update a todo (full)
 *   PATCH  /todos/{id} -> update()  - Update a todo (partial)
 *   DELETE /todos/{id} -> delete()  - Delete a todo
 */
class Todos extends ResourceController
{
    protected $modelName = TodoModel::class;
    protected $format    = 'json';

    /**
     * GET /todos
     *
     * Returns all todo items.
     */
    public function index(): ResponseInterface
    {
        $todos = $this->model->findAll();

        return $this->respond([
            'status' => 'success',
            'data'   => $todos,
        ]);
    }

    /**
     * GET /todos/{id}
     *
     * Returns a single todo item by ID.
     */
    public function show($id = null): ResponseInterface
    {
        $todo = $this->model->find($id);

        if ($todo === null) {
            return $this->failNotFound('Todo not found with ID: ' . $id);
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $todo,
        ]);
    }

    /**
     * POST /todos
     *
     * Creates a new todo item.
     *
     * Request body (JSON):
     *   - title       (string, required) - The todo title
     *   - description (string, optional) - A detailed description
     *   - status      (string, optional) - "pending" (default) or "completed"
     */
    public function create(): ResponseInterface
    {
        $input = $this->request->getJSON(true);

        if (empty($input)) {
            return $this->failValidationErrors('Request body cannot be empty.');
        }

        // Default status to 'pending' if not provided
        if (! isset($input['status'])) {
            $input['status'] = 'pending';
        }

        if (! $this->model->insert($input)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $todo = $this->model->find($this->model->getInsertID());

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Todo created successfully.',
            'data'    => $todo,
        ]);
    }

    /**
     * PUT/PATCH /todos/{id}
     *
     * Updates an existing todo item.
     *
     * Request body (JSON):
     *   - title       (string, optional) - The todo title
     *   - description (string, optional) - A detailed description
     *   - status      (string, optional) - "pending" or "completed"
     */
    public function update($id = null): ResponseInterface
    {
        $todo = $this->model->find($id);

        if ($todo === null) {
            return $this->failNotFound('Todo not found with ID: ' . $id);
        }

        $input = $this->request->getJSON(true);

        if (empty($input)) {
            return $this->failValidationErrors('Request body cannot be empty.');
        }

        if (! $this->model->update($id, $input)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $updated = $this->model->find($id);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Todo updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /todos/{id}
     *
     * Deletes a todo item.
     */
    public function delete($id = null): ResponseInterface
    {
        $todo = $this->model->find($id);

        if ($todo === null) {
            return $this->failNotFound('Todo not found with ID: ' . $id);
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Todo deleted successfully.',
        ]);
    }
}
