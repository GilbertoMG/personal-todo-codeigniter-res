<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class TodoModel extends Model
{
    protected $table            = 'todos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'title',
        'description',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title'       => 'required|min_length[1]|max_length[255]',
        'description' => 'permit_empty|string|max_length[1000]',
        'status'      => 'permit_empty|in_list[pending,completed]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'The title field is required.',
            'min_length' => 'The title must be at least 1 character long.',
            'max_length' => 'The title cannot exceed 255 characters.',
        ],
        'description' => [
            'max_length' => 'The description cannot exceed 1000 characters.',
        ],
        'status' => [
            'in_list' => 'Status must be either "pending" or "completed".',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
