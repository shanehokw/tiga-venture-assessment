<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request, TaskService $taskService)
    {
        $tasks = $taskService->getTasks(auth()->id());
        return Inertia::render('Tasks/Index', [
            "tasks" => $tasks
        ]);
    }

    public function store() {}

    public function show() {}

    public function update() {}

    public function destroy() {}
}
