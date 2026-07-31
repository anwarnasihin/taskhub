{{-- resources/views/tasks/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tugas Baru — '.$project->name)

@section('page-title', 'Tugas Baru')

@section('page-sub', 'Project: '.$project->name)

@section('topbar-actions')
    <a href="{{ route('projects.show', $project) }}"
       class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">
        Batal
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.tasks.store', $project) }}" method="POST"
            enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
        @csrf

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Judul Tugas <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="Apa yang perlu diselesaikan?"
                   class="w-full rounded-xl border border-gray-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 px-3.5 py-2.5 text-sm transition-colors @error('title') border-red-400 bg-red-50 @enderror">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Deskripsi
                <span class="text-gray-400 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="3"
                      placeholder="Detail tugas..."
                      class="w-full rounded-xl border border-gray-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 px-3.5 py-2.5 text-sm transition-colors resize-none">{{ old('description') }}</textarea>
        </div>

        {{-- Prioritas + Tenggat --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Prioritas
                </label>
                <select name="priority" class="w-full rounded-xl border border-gray-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 px-3.5 py-2.5 text-sm transition-colors">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                        Rendah
                    </option>
                    <option value="medium" {{ old('priority','medium') == 'medium' ? 'selected' : '' }}>
                        Sedang
                    </option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                        Tinggi
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Tenggat Waktu
                    <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                       class="w-full rounded-xl border border-gray-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 px-3.5 py-2.5 text-sm transition-colors">
                @error('due_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-3 pt-2">
            {{-- Input Lampiran (PR) --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Lampiran
                <span class="text-gray-400 font-normal">
                    (opsional · jpg, png, pdf, doc, docx · maks 2MB)
                </span>
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
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                Simpan Tugas
            </button>
            <a href="{{ route('projects.show', $project) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
