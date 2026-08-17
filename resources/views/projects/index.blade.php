@extends('layouts.app')

@section('title', 'Daftar Project')

@section('page-title', 'Daftar Project')

@section('topbar-actions')
    <!-- Tombol Tambah Project Baru -->
    <a href="{{ route('projects.create') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
        + Tambah Baru
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Kotak Utama Daftar Project -->
    <div class="bg-white dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] rounded-2xl shadow-sm p-6">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Semua Project</h3>
        </div>

        <!-- Form Pencarian Project -->
        <div class="mb-6">
            <form action="{{ route('projects.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama project atau deskripsi..."
                       class="w-full px-4 py-2.5 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">

                <button type="submit" class="px-5 py-2.5 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-white transition text-sm">
                    CARI
                </button>

                @if(request('search'))
                    <a href="{{ route('projects.index') }}" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition text-sm">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Grid Kartu Project -->
        @if(isset($projects) && $projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    {{-- Tambahkan kelas relative dan pastikan padding atasnya pas --}}
                    <div class="bg-white dark:bg-[#202023] border border-gray-200 dark:border-[#27272A] rounded-2xl border-t-4 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden" style="border-top-color: {{ $project->color }}">

                        {{-- Berikan padding p-6 agar ada jarak longgar dari garis atas --}}
                        <div class="p-6 pb-2">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base mb-1.5">{{ $project->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ $project->description ?: 'Tidak ada deskripsi' }}</p>
                        </div>

                        <!-- Tombol Aksi di Kartu dengan padding bawah yang pas -->
                        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800 mt-2">
                            <span class="text-xs text-gray-400 font-mono font-medium">{{ $project->tasks->count() }} Tugas</span>

                            <div class="flex items-center gap-2">
                                <!-- Lihat -->
                                <a href="{{ route('projects.show', $project) }}" class="p-1.5 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <!-- Edit -->
                                <a href="{{ route('projects.edit', $project) }}" class="p-1.5 text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <!-- Hapus -->
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
        @endforeach
            </div>
        @else
            <div class="text-center py-12 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-xl">
                <div class="text-4xl mb-3 opacity-20">📂</div>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">Belum ada project yang ditemukan.</p>
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-xl text-xs uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                    + Buat Project Baru
                </a>
            </div>
        @endif

    </div>

</div>
@endsection
