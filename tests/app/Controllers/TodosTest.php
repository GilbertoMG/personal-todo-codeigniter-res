<?php

declare(strict_types=1);

namespace Tests\app\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class TodosTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    protected $seed = 'App\Database\Seeds\TodoSeeder';

    public function testIndexReturnsAllTodos(): void
    {
        $result = $this->get('todos');

        $result->assertStatus(200);
        $result->assertHeader('Content-Type', 'application/json; charset=UTF-8');

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('success', $json['status']);
        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);
    }

    public function testCreateReturnsCreatedTodo(): void
    {
        $data = [
            'title'       => 'Test Todo',
            'description' => 'This is a test todo item',
            'status'      => 'pending',
        ];

        $result = $this->withBodyFormat('json')
            ->post('todos', $data);

        $result->assertStatus(201);

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('success', $json['status']);
        $this->assertSame('Todo created successfully.', $json['message']);
        $this->assertSame('Test Todo', $json['data']['title']);
        $this->assertSame('pending', $json['data']['status']);
    }

    public function testCreateDefaultsStatusToPending(): void
    {
        $data = [
            'title' => 'No Status Todo',
        ];

        $result = $this->withBodyFormat('json')
            ->post('todos', $data);

        $result->assertStatus(201);

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('pending', $json['data']['status']);
    }

    public function testCreateFailsWithoutTitle(): void
    {
        $data = [
            'description' => 'No title provided',
        ];

        $result = $this->withBodyFormat('json')
            ->post('todos', $data);

        $result->assertStatus(400);
    }

    public function testShowReturnsExistingTodo(): void
    {
        // Seed creates 5 todos, get the first one
        $result = $this->get('todos/1');

        $result->assertStatus(200);

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('success', $json['status']);
        $this->assertArrayHasKey('data', $json);
    }

    public function testShowReturns404ForMissingTodo(): void
    {
        $result = $this->get('todos/9999');

        $result->assertStatus(404);
    }

    public function testUpdateModifiesTodo(): void
    {
        $data = [
            'status' => 'completed',
        ];

        $result = $this->withBodyFormat('json')
            ->put('todos/1', $data);

        $result->assertStatus(200);

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('success', $json['status']);
        $this->assertSame('completed', $json['data']['status']);
    }

    public function testUpdateReturns404ForMissingTodo(): void
    {
        $data = [
            'status' => 'completed',
        ];

        $result = $this->withBodyFormat('json')
            ->put('todos/9999', $data);

        $result->assertStatus(404);
    }

    public function testDeleteRemovesTodo(): void
    {
        $result = $this->delete('todos/1');

        $result->assertStatus(200);

        $json = json_decode($result->getJSON(), true);
        $this->assertSame('success', $json['status']);
        $this->assertSame('Todo deleted successfully.', $json['message']);

        // Verify it is gone
        $checkResult = $this->get('todos/1');
        $checkResult->assertStatus(404);
    }

    public function testDeleteReturns404ForMissingTodo(): void
    {
        $result = $this->delete('todos/9999');

        $result->assertStatus(404);
    }
}
