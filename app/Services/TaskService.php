<?php

namespace App\Services;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use DB;
use Log;

class TaskService {
    public function getTasks(int $userId)
    {
        return Task::where("user_id", $userId)->get();
    }

    public function createTask(array $taskData, int $userId)
    {
        DB::beginTransaction();

        try {
            $task = new Task();

            $task->user_id = $userId;
            $task->name = $taskData['name'];
            $task->description = $taskData['description'] ?? null;
            $task->due_date = $taskData['due_date'] ?? null;

            $task->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
