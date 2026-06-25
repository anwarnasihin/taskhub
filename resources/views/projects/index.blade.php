@extends('layouts.app')

@section('page-title', 'Daftar Project')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" x-data="{ confirmDelete: false, deleteUrl: '' }">

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Semua Project</h2>
        <a href="{{ route('projects.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-xl hover:bg-gray-700 transition font-semibold text-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Baru
        </a>
    </div>

    @if($projects->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-sm text-center text-gray-500">
            Belum ada project.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 transition-transform hover:scale-[1.02]" style="border-color: {{ $project->color }}">
                    <h3 class="text-lg font-bold text-gray-800">{{ $project->name }}</h3>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('projects.show', $project) }}" class="text-gray-500 hover:text-[#FF6B4A]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>
                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-500 hover:text-[#FF6B4A]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-14 1l4-4 3 3 8-8"></path></svg></a>

                        <button @click.prevent="confirmDelete = true; deleteUrl = '{{ route('projects.destroy', $project) }}'"
                                class="text-gray-500 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div x-show="confirmDelete" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
            <h2 class="text-lg font-bold">Konfirmasi Hapus</h2>
            <p class="text-gray-600 mt-2">Yakin ingin menghapus project ini?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="confirmDelete = false" class="text-gray-500">Batal</button>
                <form :action="deleteUrl" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
