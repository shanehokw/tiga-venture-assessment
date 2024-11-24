<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

    public function store() {}

    public function show() {}

    public function update() {}

    public function destroy() {}
}
