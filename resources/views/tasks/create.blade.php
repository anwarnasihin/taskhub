@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('page-title', 'Tugas Baru')

@section('page-sub', 'Project: ' . $project->name)

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="bg-white dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] rounded-2xl shadow-sm p-8">

        <form action="{{ route('projects.tasks.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Judul Tugas --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Judul Tugas *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Apa yang perlu diselesaikan?"
                       class="w-full px-4 py-3 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Deskripsi (opsional)</label>
                <textarea name="description" rows="4" placeholder="Detail tugas..."
                          class="w-full px-4 py-3 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Prioritas --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Prioritas</label>
                    <select name="priority"
                            class="w-full px-4 py-3 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                {{-- Tanggal Tenggat --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Tenggat Waktu (opsional)</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                           class="w-full px-4 py-3 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">
                </div>
            </div>

            {{-- Lampiran File --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Lampiran <span class="text-gray-400 font-normal">(opsional · jpg, png, pdf, doc, docx · maks 5MB)</span></label>
                <input type="file" name="attachments[]" multiple
                       class="w-full px-4 py-2.5 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-700 dark:text-gray-300 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 dark:file:bg-gray-800 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-200 transition">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-xs uppercase tracking-widest shadow-sm">
                    Simpan Tugas
                </button>
                <a href="{{ route('projects.show', $project) }}"
                   class="px-6 py-3 bg-gray-200 dark:bg-[#2A2A2E] text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-[#3F3F46] transition text-xs uppercase tracking-widest">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
