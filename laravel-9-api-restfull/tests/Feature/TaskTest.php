<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Task;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_task_list()
    {
        $response = $this->getJson(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_new_task()
    {
        $response = $this->postJson(route('tasks.store'), [
            'name' => 'New Task',
            'done' => false,
            'due_date' => '2023-01-01'
        ]);
        $response->assertStatus(201);
    }

    public function test_cannot_create_new_task_without_name()
    {
        $response = $this->postJson(route('tasks.store'), [
            'done' => false,
            'due_date' => '2023-01-01'
        ]);
        $response->assertStatus(422);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'New Task',
            'done' => false,
            'due_date' => '2023-01-01'
        ]);

        $response->assertStatus(200);
    }

    public function test_cannot_update_task()
    {
        $response = $this->putJson(route('tasks.update', 2323232), [
            'name' => 'New Task',
            'done' => false,
            'due_date' => '2023-01-01'
        ]);
        $response->assertStatus(404);
    }

    public function test_can_show_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.show', $task->id));
        $response->assertStatus(200);
    }

    public function test_cannot_show_task()
    {
        $response = $this->getJson(route('tasks.show', 23929382));
        $response->assertStatus(404);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.delete', $task->id));
        $response->assertStatus(200);
    }

    public function test_cannot_delete_task()
    {
        $response = $this->deleteJson(route('tasks.delete', 232932983));
        $response->assertStatus(404);
    }
}
