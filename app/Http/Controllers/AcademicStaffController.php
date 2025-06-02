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

        $task = Task::with(['users', 'group', 'comments'])
            ->where(function ($q) use ($userId) {
                $q->whereHas('users', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('group.users', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->find($id);

        if (!$task) {
            abort(403, 'You are not authorized to view this task.');
        }

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

    public function update(Request $request, $id)   
    {
    $userId = Auth::id();

    // Validate status input
    $validated = $request->validate([
        'status' => 'required|in:pending,in progress,finished',
    ]);

    // Check if user is allowed to update this task
    $task = Task::where(function ($q) use ($userId) {
            $q->whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->orWhereHas('group.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        })
        ->findOrFail($id);

    $task->status = $validated['status'];
    $task->save();

    return redirect()->route('academic-staff.tasks.index')->with('success', 'Task status updated.');
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
