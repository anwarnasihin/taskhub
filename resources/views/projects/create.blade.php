@extends('layouts.app')

@section('page-title', 'Tambah Project Baru')

@section('content')
<div class="max-w-4xl mx-auto py-8 sm:px-6 lg:px-8">

    <!-- Bagian Judul -->
    <div class="mb-8 pl-2">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Project Baru</h2>
        <p class="mt-2 text-md text-gray-500">Isi detail project yang akan kamu kerjakan</p>
    </div>

    <!-- Kartu Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 max-w-2xl">
        <div class="p-8">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                <!-- Nama Project -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-800 mb-2">
                        Nama Project <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Contoh: Website Redesign">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold text-gray-800 mb-2">
                        Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Deskripsi singkat project ini...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Warna Label -->
                <div class="mb-10">
                    <label class="block text-sm font-bold text-gray-800 mb-4">
                        Warna Label
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @php
                            $colors = [
                                '#3B82F6', // Biru
                                '#10B981', // Hijau
                                '#F59E0B', // Kuning
                                '#EF4444', // Merah
                                '#8B5CF6', // Ungu
                                '#EC4899', // Pink
                                '#F97316', // Oranye
                            ];
                        @endphp

                        @foreach($colors as $index => $color)
                            <label class="cursor-pointer relative flex items-center justify-center">
                                <input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ old('color') == $color || ($index == 0 && !old('color')) ? 'checked' : '' }}>
                                <span class="block w-10 h-10 rounded-full peer-checked:ring-4 peer-checked:ring-offset-2 peer-checked:ring-blue-400 transition-all duration-200"
                                      style="background-color: {{ $color }};">
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center gap-2 pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl shadow-sm hover:bg-blue-700 hover:shadow focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                        Simpan Project
                    </button>
                    <a href="{{ route('projects.index') }}"
                        class="px-6 py-2.5 text-gray-500 font-medium rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
