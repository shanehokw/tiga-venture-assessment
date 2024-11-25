<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request, TaskService $taskService): Response
    {
        $tasks = $taskService->getTasks(auth()->id(), [
            "search" => $request['search'] ?? '',
            "orderBy" => $request['orderBy'] ?? '',
            "orderDirection" => $request['orderDirection'] ?? 'asc',
        ]);
        return Inertia::render('Tasks/Index', [
            "tasks" => $tasks
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(StoreTaskRequest $request, TaskService $taskService) 
    {
        try {
            $taskService->createTask($request->validated(), auth()->id());
            return Redirect::route('task.index')->with('success', 'Task created.');
        } catch (\Throwable $th) {
            abort(500, $th->getMessage());
        }
    }

    public function edit(Task $task, TaskService $taskService): Response
    {
        return Inertia::render('Tasks/Edit', [
            "task" => [
                'id' => $task->id,
                'name'=> $task->name,
                'description'=> $task->description,
                'due_date'=> $task->due_date->format('d/m/Y'),
                'created_at'=> $task->created_at->format('d/m/Y'),
                'status'=> $task->status,
            ]
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task, TaskService $taskService) {
        try {
            $taskService->updateTask($request->validated(), $task->id, auth()->id());
            return Redirect::route('task.index')->with('success', 'Task updated.');
        } catch (\Throwable $th) {
            abort(500, $th->getMessage());
        }
    }
}
