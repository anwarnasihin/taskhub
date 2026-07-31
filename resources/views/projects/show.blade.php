@extends('layouts.app')

@section('title', $project->name)

@section('page-title', $project->name)

@section('page-sub', $project->description ?: 'Tidak ada deskripsi')

@section('topbar-actions')
    <a href="{{ route('projects.tasks.create', $project) }}"
       class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
        + Tugas Baru
    </a>
    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">
        Edit Project
    </a>
    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?');" class="inline">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
            Hapus Project
        </button>
    </form>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border-t-4 p-6" style="border-color: {{ $project->color }}">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Dibuat pada: {{ $project->created_at->format('d F Y') }}</p>
            </div>
            <span class="px-4 py-1 text-sm rounded-full text-white font-medium" style="background-color: {{ $project->color }}">
                {{ $project->color }}
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
        <h2 class="text-[15px] font-semibold text-gray-900 mb-5">Daftar Tugas</h2>

        @forelse($project->tasks as $task)

            @php
                $borderColor = $task->is_completed
                    ? '#15803D'
                    : ($task->isOverdue() ? '#EF4444' : $project->color);
            @endphp

            <div class="flex items-center gap-3
                        bg-white border border-gray-200
                        rounded-xl px-4 py-3 mb-2
                        border-l-4 transition-all hover:shadow-sm
                        {{ $task->is_completed ? 'opacity-60' : '' }}"
                 style="border-left-color: {{ $borderColor }}">

                {{-- Checkbox toggle --}}
                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="w-5 h-5 rounded-md border-2 flex items-center justify-center text-xs font-bold transition-all
                                   {{ $task->is_completed
                                       ? 'bg-green-600 border-green-600 text-white'
                                       : 'border-gray-300 hover:border-green-600 text-transparent' }}">
                        ✓
                    </button>
                </form>

                {{-- Konten task --}}
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold
                                {{ $task->is_completed
                                    ? 'line-through text-gray-400'
                                    : 'text-gray-900' }}">
                        {{ $task->title }}
                    </div>

                    <div class="flex items-center gap-2 flex-wrap mt-1">
                        @php
                            $pColors = [
                                'high'   => 'bg-red-50 text-red-500',
                                'medium' => 'bg-amber-50 text-amber-700',
                                'low'    => 'bg-green-50 text-green-600',
                            ];
                            $pLabels = ['high'=>'Tinggi','medium'=>'Sedang','low'=>'Rendah'];
                        @endphp
                        <span class="text-xs font-semibold font-mono px-2 py-0.5 rounded-full {{ $pColors[$task->priority] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $pLabels[$task->priority] ?? 'Sedang' }}
                        </span>

                        {{-- Daftar Lampiran Task --}}
                    @if($task->attachments->count() > 0)
                        <div class="mt-3 space-y-1.5">
                            <p class="text-xs font-semibold text-gray-500">Lampiran:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($task->attachments as $att)
                                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-1.5 text-xs">
                                        <span class="font-medium text-gray-700 truncate max-w-[150px]">{{ $att->original_name }}</span>
                                        <a href="{{ Storage::url($att->file_path) }}" target="_blank" class="text-indigo-600 hover:underline font-semibold">
                                            Unduh
                                        </a>
                                        <form action="{{ route('attachments.destroy', $att) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lampiran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold ml-1">×</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                        @if($task->due_date)
                            <span class="text-xs flex items-center gap-1
                                         {{ $task->isOverdue()
                                             ? 'text-red-500 font-semibold'
                                             : 'text-gray-400' }}">
                                {{ $task->due_date->format('d M Y') }}
                                @if($task->isOverdue())
                                    <span class="font-bold">— Terlambat!</span>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                       class="text-xs text-gray-400 hover:text-blue-600 px-2.5 py-1 rounded-lg transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                          method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs text-gray-400 hover:text-red-500 px-2.5 py-1 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>

        @empty
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">
                <div class="text-4xl mb-3 opacity-20">✅</div>
                <p class="text-sm text-gray-400 mb-4">
                    Belum ada tugas di project ini.
                </p>
                <a href="{{ route('projects.tasks.create', $project) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                    + Tambah Tugas Pertama
                </a>
            </div>
        @endforelse

    </div>
</div>
@endsection
