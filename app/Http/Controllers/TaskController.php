<?php

namespace App\Http\Controllers;

use App\Models\{Project, Task};
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        // Proteksi kepemilikan project[cite: 2]
        abort_if($project->user_id !== auth()->id(), 403);

        return view('tasks.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'         => 'required|string|min:3|max:255',
            'description'   => 'nullable|string',
            'priority'      => 'required|in:low,medium,high',
            'due_date'      => 'nullable|date|after_or_equal:today',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $task = $project->tasks()->create([
            'user_id'     => auth()->id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority'    => $validated['priority'],
            'due_date'    => $validated['due_date'] ?? null,
        ]);

        // Logic Loop Upload File Lampiran
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $task->attachments()->create([
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getMimeType(),
                    'file_size'     => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Project $project, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        return view('tasks.edit', compact('project', 'task'));
    }

    public function update(Request $request, Project $project, Task $task)
{
    abort_if($task->user_id !== auth()->id(), 403);

    $validated = $request->validate([
        'title'         => 'required|string|min:3|max:255',
        'description'   => 'nullable|string',
        'priority'      => 'required|in:low,medium,high',
        'due_date'      => 'nullable|date',
        'attachments'   => 'nullable|array',
        'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    $task->update([
        'title'       => $validated['title'],
        'description' => $validated['description'] ?? null,
        'priority'    => $validated['priority'],
        'due_date'    => $validated['due_date'] ?? null,
    ]);

    // Logic Loop Upload Lampiran saat Edit
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments', 'public');
            $task->attachments()->create([
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'file_size'     => $file->getSize(),
            ]);
        }
    }

    return redirect()->route('projects.show', $project)
        ->with('success', 'Tugas berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tugas berhasil dihapus!');
    }

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->update(['is_completed' => ! $task->is_completed]);

        $msg = $task->is_completed
            ? 'Tugas ditandai selesai!'
            : 'Tugas dibuka kembali.';

        return back()->with('success', $msg);
    }
}
