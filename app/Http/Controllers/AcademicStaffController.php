<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Group;

class AcademicStaffController extends Controller
{
    public function dashboard()
    {
        return view('academic_staff.dashboard');
    }

    // ---------------- Tasks ----------------

    public function viewTasks()
    {
        $userId = Auth::id();

        $tasks = Task::whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('group.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['users', 'group', 'comments']) // eager-load if needed
            ->get();

        return view('academic_staff.tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $userId = Auth::id();

        $task = Task::whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('group.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['users', 'group', 'comments'])
            ->findOrFail($id);

        return view('academic_staff.tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $userId = Auth::id();

        $task = Task::whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('group.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['users', 'group'])
            ->findOrFail($id);

        return view('academic_staff.tasks.edit', compact('task'));
    }

    // ---------------- Groups ----------------

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
            ->with(['users', 'creator', 'tasks']) // if you want to show tasks as well
            ->findOrFail($id);

        return view('academic_staff.groups.show', compact('group'));
    }
}
