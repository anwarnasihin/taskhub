@extends('layouts.app')

@section('page-title', 'Tambah Project Baru')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="POST" action="{{ route('projects.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">Nama Project</label>
                    <input id="name" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Aplikasi Keuangan" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="color" class="block font-medium text-sm text-gray-700">Warna Label</label>
                    <input id="color" class="block mt-1 w-full h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-1 cursor-pointer" type="color" name="color" value="{{ old('color', '#3B82F6') }}" required />
                    @error('color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 mr-3">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-[#FF6B4A] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#e65a3d] transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Project
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
