<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLimboStatusToTasks extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('tasks', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['todo', 'doing', 'done', 'limbo'],
                'default' => 'todo',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('tasks', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['todo', 'doing', 'done'],
                'default' => 'todo',
            ],
        ]);
    }
}
