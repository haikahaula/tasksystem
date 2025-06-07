<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Group;
use App\Models\Comment;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to_id',
        'due_date',
        'document',
        'group_id',
        'status',
        'created_by',
    ];

    // Many users assigned to this task (pivot table task_user)
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    // Assigned to a specific group
    public function assignedGroup()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // Shortcut if you still want an alias for the same relation
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // Who created the task
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
