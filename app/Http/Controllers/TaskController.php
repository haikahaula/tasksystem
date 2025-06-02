<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;

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

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }    /**
     * Display the specified resource.
     */
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
    ]);

    if ($request->hasFile('document')) {
        $data['document'] = $request->file('document')->store('documents', 'public');
    }

    $task->update($data);

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
