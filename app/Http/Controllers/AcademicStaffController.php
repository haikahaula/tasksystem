<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Group;
use App\Models\User;

class AcademicStaffController extends Controller
{
    public function dashboard()
    {
        return view('academic-staff.dashboard');
    }

public function viewTasks()
{
        $user = Auth::user();    
        $userId = $user ? $user->id : null;


    $tasks = Task::where('assigned_to_id', $userId)
        ->orWhereHas('group.users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['group', 'assignedBy'])
        ->get();

    return view('academic_staff.view_tasks', compact('tasks'));
}

    public function viewGroups()
    {
        $groups = Group::all(); // You can filter this later
        return view('academic-staff.view-groups', compact('groups'));
    }
}
