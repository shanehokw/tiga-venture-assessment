<?php

namespace App\Services;

use App\Models\Task;

class TaskService {
    public function getTasks($userId)
    {
        return Task::where("user_id", $userId)->get();
    }
}
