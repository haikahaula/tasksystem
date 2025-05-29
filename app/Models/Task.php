<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Add this line
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'assigned_to_id', 'due_date', 'document'];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');    
    }

        public function comments()
    {
        return $this->hasMany(Comment::class);    
    }

}
