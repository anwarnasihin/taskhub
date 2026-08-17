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
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
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

        // 1. Validasi Input
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'due_date'      => 'nullable|date', // Ini akan memperbarui tanggal, otomatis menghilangkan status terlambat jika tanggalnya masa depan
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        // 2. Update Data Dasar
        $task->update([
            'title'    => $validated['title'],
            'due_date' => $validated['due_date'] ?? $task->due_date,
        ]);

        // 3. Proses Upload File (Menambah file baru)
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

    public function downloadAttachment($id)
    {
        // Sesuaikan App\Models\TaskAttachment dengan nama model yang ada di folder app/Models/
        $attachment = \App\Models\TaskAttachment::findOrFail($id);

        $path = storage_path('app/public/' . $attachment->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, $attachment->original_name);
    }

    public function previewAttachment($id)
    {
        $attachment = \App\Models\TaskAttachment::findOrFail($id);
        $path = storage_path('app/public/' . $attachment->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Menampilkan file langsung di browser (inline) alih-alih mendownloadnya
        return response()->file($path);
    }
    }
