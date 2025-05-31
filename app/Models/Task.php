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
            'due_date',
            'document',
            'assigned_to_id',
            'assigned_to_type',
            'created_by'
        ];

    public function assignedTo()
    {
        return $this->morphTo();
    }

        public function assignedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


        public function comments()
    {
        return $this->hasMany(Comment::class);    
    }


        public function users()
    {
            return $this->belongsToMany(User::class);
    }

        public function group()
    {
            return $this->belongsTo(Group::class); // or belongsToMany if multiple groups
    }
}
