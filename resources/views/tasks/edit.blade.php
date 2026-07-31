{{-- resources/views/tasks/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit — '.$task->title)

@section('page-title', 'Edit Tugas')

@section('page-sub', $task->title)

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.tasks.update', [$project, $task]) }}"
      method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
    @csrf
    @method('PUT')

    {{-- (Bagian title, description, priority, due_date tetap seperti sebelumnya) --}}

    {{-- Tambahan Input Lampiran saat Edit --}}
    <div>
        <label class="block text-sm font-semibold text-gray-900 mb-1.5">
            Tambah Lampiran Baru
            <span class="text-gray-400 font-normal">(opsional · jpg, png, pdf, doc, docx · maks 2MB)</span>
        </label>
        <input type="file" name="attachments[]" multiple
               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
               class="w-full text-sm text-gray-500
                      file:mr-3 file:py-2 file:px-4
                      file:rounded-xl file:border-0
                      file:text-sm file:font-semibold
                      file:bg-indigo-50 file:text-indigo-600
                      hover:file:bg-indigo-100
                      transition-colors cursor-pointer border border-gray-200 rounded-xl p-1">
        @error('attachments.*')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tombol Simpan --}}
    <div class="flex gap-3 pt-2">
        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
            Simpan Perubahan
        </button>
        <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">
            Batal
        </a>
    </div>
</form>
</div>
@endsection
