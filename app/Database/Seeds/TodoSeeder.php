<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title'       => 'Buy groceries',
                'description' => 'Milk, eggs, bread, and coffee',
                'status'      => 'pending',
            ],
            [
                'title'       => 'Read a book',
                'description' => 'Finish reading "Clean Code" by Robert C. Martin',
                'status'      => 'pending',
            ],
            [
                'title'       => 'Exercise',
                'description' => '30-minute morning jog',
                'status'      => 'completed',
            ],
            [
                'title'       => 'Update project documentation',
                'description' => 'Add API endpoints description to the README',
                'status'      => 'pending',
            ],
            [
                'title'       => 'Review pull requests',
                'description' => null,
                'status'      => 'completed',
            ],
        ];

        $this->db->table('todos')->insertBatch($data);
    }
}
