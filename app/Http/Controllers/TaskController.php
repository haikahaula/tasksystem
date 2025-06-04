<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('assignedTo')->get();
        return view('tasks.index', compact('tasks'));    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $groups = Group::all();
        return view('tasks.create', compact('users', 'groups'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'due_date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,docx,txt,jpg,png|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'due_date']);
        $data['created_by'] = Auth::id(); // academic head or whoever created
        $data['status'] = 'not started';

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        // Determine the assignee type
        if ($request->assigned_user_id) {
            $data['assigned_to_id'] = $request->assigned_user_id;
            $data['assigned_to_type'] = User::class;
        } elseif ($request->assigned_group_id) {
            $data['assigned_to_id'] = $request->assigned_group_id;
            $data['assigned_to_type'] = User::class;
        }

        $task = Task::create($data);

        // Notify the assigned user
        if (isset($data['assigned_to_id']) && $data['assigned_to_type'] === User::class) {
            $user = User::find($data['assigned_to_id']);
            if ($user) {
                $user->notify(new TaskAssigned($task));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task created and notification sent.');
    }
    
    public function show(string $id)
    {

        $task = Task::with(['assignedTo', 'comments.user'])->findOrFail($id);
        return view('tasks.show', compact('task'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();
        $groups = Group::all();
        return view('tasks.edit', compact('task', 'users', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,docx,txt,jpg,png|max:2048',
            'status' => 'nullable|string', // add if you're allowing status update
        ]);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $task->update($data);

        // Notify task creator if status changed
        if ($request->has('status') && $task->created_by) {
            $creator = User::find($task->created_by);
            if ($creator && $task->status !== $task->getOriginal('status')) {
                $creator->notify(new \App\Notifications\TaskStatusChanged($task));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        // Optional: delete the associated file
        if ($task->document) {
            Storage::disk('public')->delete($task->document);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
