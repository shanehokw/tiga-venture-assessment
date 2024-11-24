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

        if ($dueDate->isPast()) {
            return 'Overdue';
        } elseif ($dueDate->diffInDays($today) <= 7) {
            return 'Due soon';
        } else {
            return 'Not urgent';
        }
    }
}
