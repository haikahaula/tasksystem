<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Add this line
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    use HasFactory;

        protected $fillable = [
            'title',
            'description',
            'due_date',
            'document',
            'assigned_to_id',
            'assigned_to_type'
        ];

    public function assignedTo()
    {
        return $this->morphTo();
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
