@extends('layouts.app')

@section('page-title', 'Detail Project')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4" style="border-color: {{ $project->color }}">
        <div class="p-6 text-gray-900">

            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $project->name }}</h2>
                    <p class="text-sm text-gray-500 mt-2">Dibuat pada: {{ $project->created_at->format('d F Y') }}</p>
                </div>
                <span class="px-4 py-1 text-sm rounded-full text-white font-medium" style="background-color: {{ $project->color }}">
                    {{ $project->color }}
                </span>
            </div>

            <div class="mt-8 flex space-x-3 border-t pt-6">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                    Kembali
                </a>
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit Project
                </a>

                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permanen?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                        Hapus Project
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
