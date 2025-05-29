<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $tasks = Task::with('assignedTo')->get(); // eager load relationship
        return view('tasks.index', compact('tasks'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Or use specific filtering if needed
        return view('tasks.create', compact('users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    Task::create($data);

    return redirect()->route('tasks.index')->with('success', 'Task created.');
    }
    /**
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
        return view('tasks.edit', compact('task', 'users'));
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
