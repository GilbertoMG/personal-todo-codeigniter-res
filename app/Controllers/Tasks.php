<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TaskModel;

class Tasks extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\TaskModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $tasks = $this->model->orderBy('id', 'DESC')->findAll();
        return $this->respond($tasks);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $task = $this->model->find($id);

        if ($task) {
            return $this->respond($task);
        }

        return $this->failNotFound('Tarefa não encontrada com ID ' . $id);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getPost();

        // If data is JSON
        if (empty($data) && $this->request->getJSON()) {
            $data = (array) $this->request->getJSON();
        }

        if ($this->model->insert($data)) {
            $task = $this->model->find($this->model->getInsertID());
            return $this->respondCreated($task, 'Tarefa criada com sucesso.');
        }

        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $task = $this->model->find($id);

        if (!$task) {
            return $this->failNotFound('Tarefa não encontrada com ID ' . $id);
        }

        $data = $this->request->getJSON(true);

        if (empty($data)) {
            $data = $this->request->getRawInput();
        }

        // Merge original title if it's a partial update (like drag & drop)
        if (!isset($data['title'])) {
            $data['title'] = $task['title'];
        }

        if ($this->model->update($id, $data)) {
            $task = $this->model->find($id);
            return $this->respond($task, 200, 'Tarefa atualizada com sucesso.');
        }

        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $task = $this->model->find($id);

        if ($task) {
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id], 'Tarefa removida com sucesso.');
        }

        return $this->failNotFound('Tarefa não encontrada com ID ' . $id);
    }
}
