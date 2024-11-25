<?php

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function() {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('testing123')
    ]);
});

test('task list is empty', function () {
    $this->actingAs($this->user)
        ->get('/task')
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Tasks/Index')
            ->has('tasks.data', 0)
        );
});

test('task list is paginated', function () {
    $this->actingAs($this->user)
        ->get('/task')
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Tasks/Index')
            ->has('tasks.data', 0)
            ->has('tasks.links')
        );
});

test('task list can be searched', function () {
    Task::factory()->create([
        'name' => 'Important Task',
        'user_id' => $this->user->id,
    ]);

    Task::factory()->create([
        'name' => 'Unrelated Task',
        'user_id' => $this->user->id,
    ]);

    $this->actingAs($this->user)
        ->get('/task?search=Important')
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Tasks/Index')
            ->has('tasks.data', 1)
            ->where('tasks.data.0.name', 'Important Task')
        );
});

test('task list can be ordered', function () {
    Task::factory()->createMany([
        [
            'name' => 'Task A', 
            'user_id' => $this->user->id,
            "due_date" => '01-12-2024'
        ], [
            'name' => 'Task B', 
            'user_id' => $this->user->id,
            "due_date" => '20-12-2024'
        ]
    ]);

    $this->actingAs($this->user)
        ->get('/task?orderBy=due_date&orderDirection=desc')
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Tasks/Index')
            ->where('tasks.data.0.name', 'Task B')
            ->where('tasks.data.1.name', 'Task A')
        );
});

test('task can be created', function () {
    $data = [
        'name' => 'New Task',
        'description' => 'Task description',
        'due_date' => now()->addDays(7)->format('d/m/Y'),
    ];

    $this->actingAs($this->user)
        ->post('/task', $data)
        ->assertRedirect('/task')
        ->assertSessionHas('success', 'Task created.');

    $this->assertDatabaseHas('tasks', [
        'name' => 'New Task',
        'description' => 'Task description',
        'user_id' => $this->user->id,
    ]);
});

test('task edit page renders correctly', function () {
    $task = Task::factory()->create([
        'name'=> 'This page should render correctly',
        'due_date' => now()->addDays(7)->format('d/m/Y'),
        'user_id' => $this->user->id
    ]);

    $this->actingAs($this->user)
        ->get("/task/{$task->id}/edit")
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Tasks/Edit')
            ->where('task.id', $task->id)
            ->where('task.name', $task->name)
        );
});

test('task can be updated', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $data = [
        'name' => 'Updated Task',
        'description' => 'Updated description',
        'due_date' => now()->addDays(10)->format('d/m/Y'),
    ];

    $this->actingAs($this->user)
        ->put("/task/{$task->id}", $data)
        ->assertRedirect('/task')
        ->assertSessionHas('success', 'Task updated.');

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => 'Updated Task',
        'description' => 'Updated description',
    ]);
});

test('task creation fails with validation errors', function () {
    $this->actingAs($this->user)
        ->post('/task', [])
        ->assertSessionHasErrors(['name', 'due_date']);
});

test('user cannot access tasks they do not own', function () {
    $otherUser = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($this->user)
        ->get("/task/{$task->id}/edit")
        ->assertForbidden();
});

test('task status is Overdue when due_date is in the past', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now()->subDay(), // 1 day in the past
    ]);

    expect($task->status)->toBe('Overdue');
});

test('task status is Due soon when due_date is within the next 7 days', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now()->addDays(5), // 5 days in the future
    ]);

    expect($task->status)->toBe('Due soon');
});

test('task status is Not urgent when due_date is more than 7 days in the future', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now()->addDays(10), // 10 days in the future
    ]);

    expect($task->status)->toBe('Not urgent');
});

test('task status is Overdue for a task due exactly yesterday', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => Carbon::yesterday(), // Yesterday's date
    ]);

    expect($task->status)->toBe('Overdue');
});

test('task status is Due soon for a task due exactly today', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now(), // Today's date
    ]);

    expect($task->status)->toBe('Due soon');
});

test('task status is Due soon for a task due exactly 7 days from today', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now()->addDays(7), // Exactly 7 days from today
    ]);

    expect($task->status)->toBe('Due soon');
});

test('task status is Not urgent for a task due exactly 8 days from today', function () {
    $task = Task::factory()->create([
        'name' => 'Task Name',
        'user_id' => $this->user->id,
        'due_date' => now()->addDays(8), // Exactly 8 days from today
    ]);

    expect($task->status)->toBe('Not urgent');
});
