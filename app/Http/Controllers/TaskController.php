<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request, TaskService $taskService): Response
    {
        $tasks = $taskService->getTasks(auth()->id());
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
            error_log($th->getMessage());
            abort(500, $th->getMessage());
        }
    }

    public function show() {}

    public function update() {}

    public function destroy() {}
}
