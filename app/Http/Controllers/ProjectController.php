<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menangkap input pencarian dari form
        $search = $request->input('search');

        // Mengambil data project HANYA milik user yang sedang login
        $projects = Project::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->get();

        return view('projects.index', compact('projects', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Membuat project baru melalui relasi user
        $user->projects()->create($validated);

        return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Project $project)
    {
        // Memastikan user hanya bisa melihat project miliknya sendiri
        abort_if($project->user_id !== auth()->id(), 403);

        // Menangkap kata kunci pencarian tugas
        $search = $request->input('search');

        // Mengambil daftar tugas milik project ini, lalu di-filter jika ada pencarian
        $tasks = $project->tasks()
            ->when($search, function ($query, $search) {
                // Catatan: Ubah 'name' menjadi 'title' jika nama kolom di database Anda menggunakan 'title'
                return $query->where('name', 'like', "%{$search}%");
            })->get();

        // Mengirim data project, tugas yang sudah difilter, dan kata kunci ke view
        return view('projects.show', compact('project', 'tasks', 'search'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus!');
    }

    public function exportPdf(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        $project->load('tasks');

        $pdf = Pdf::loadView('projects.pdf', compact('project'));

        return $pdf->stream('Laporan-Daftar-Tugas-' . str_replace(' ', '-', $project->name) . '.pdf');
    }

    public function dashboard()
    {
        $userId = Auth::id();

        // Mengambil data project milik user yang sedang login beserta task-nya
        $projects = \App\Models\Project::where('user_id', $userId)->with('tasks')->get();

        // Hitung Statistik
        $totalProjects = $projects->count();
        $totalTasks = $projects->sum(fn($p) => $p->tasks->count());
        $completedTasks = $projects->sum(fn($p) => $p->tasks->where('is_completed', true)->count());

        // Hitung persentase keseluruhan
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Hitung tugas terlambat (overdue) dan yang akan datang
        $overdueTasks = collect();
        $upcomingTasks = collect();

        foreach ($projects as $project) {
            foreach ($project->tasks as $task) {
                if (!$task->is_completed) {
                    if ($task->due_date && $task->isOverdue()) {
                        $overdueTasks->push($task);
                    } else {
                        $upcomingTasks->push($task);
                    }
                }
            }
        }

        return view('dashboard', compact(
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'completionPercentage',
            'overdueTasks',
            'upcomingTasks',
            'projects'
        ));
    }
}
