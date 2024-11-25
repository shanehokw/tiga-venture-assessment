<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['status'];

    protected function casts(): array
    {
        return [
            'due_date' => 'date:Y-m-d',
            'created_at' => 'date:Y-m-d'
        ];
    }

    protected function getStatusAttribute(): string{
        $dueDate = Carbon::parse($this->due_date); // Parse the due_date as Carbon instance
        $today = Carbon::now();
        $oneWeekAfter = Carbon::now()->addDays(7);

        if ($dueDate->isSameDay($oneWeekAfter) || // due exactly 7 days from now
            $dueDate->isSameDay($today) || // due today
            ($dueDate->isAfter($today) && $dueDate->isBefore($oneWeekAfter)) // between today and 7 days from now
        ) {
            return 'Due soon';
        } 

        if ($dueDate->isAfter($oneWeekAfter)) {
            return 'Not urgent';
        }

        return 'Overdue';
    }
}
