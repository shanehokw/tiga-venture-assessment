<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use DB;

class TaskService {
    public function getTasksWithPagination(int $userId, array $options)
    {
        $query = Task::where("user_id", $userId);

        if ($options['search']) {
            $query->where('name', 'ILIKE', "%".$options['search']."%" );
        }

        if ($options['orderBy']) {
            $query->orderBy($options['orderBy'], $options['orderDirection']);
        }

        return $query->paginate(10, ['*'], 'page', $options['pageNo'])
            ->appends($options["paginationQueryString"]);
    }

    public function createTask(array $taskData, int $userId)
    {
        DB::beginTransaction();

        try {
            $task = new Task();

            $task->user_id = $userId;
            $task->name = $taskData['name'];
            $task->description = $taskData['description'] ?? null;
            $task->due_date = $taskData['due_date'];

            $task->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function updateTask(array $taskData, int $taskId, int $userId)
    {
        $task = Task::where('id', $taskId)->where('user_id', $userId)->first();
        if (!$task) {
            throw new \Exception('Could not find task with id ' . $taskId);
        }

        DB::beginTransaction();

        try {
            $task->name = $taskData['name'];
            $task->description = $taskData['description'] ?? null;
            $task->due_date = Carbon::createFromFormat('d/m/Y', $taskData['due_date']);

            $task->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
