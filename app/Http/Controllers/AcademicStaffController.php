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
        return view('academic_staff.dashboard');
    }

    public function viewTasks()
    {
        $userId = Auth::id();

        $tasks = Task::where('assigned_to_id', $userId)
            ->orWhereHas('group.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['group', 'assignedBy'])
            ->get();

        return view('academic_staff.tasks', compact('tasks'));
    }

    public function viewGroups()
    {
        $userId = Auth::id();

        $groups = Group::whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->withCount('users')
            ->get();

        return view('academic_staff.groups.index', compact('groups'));
    }

    public function showGroup($id)
    {
        $userId = Auth::id();

        $group = Group::whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['users', 'creator'])
            ->findOrFail($id);

        return view('academic_staff.groups.show', compact('group'));
    }
}
