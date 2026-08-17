@extends('layouts.app')

@section('title', $project->name)

@section('page-title', $project->name)

@section('page-sub', $project->description ?: 'Tidak ada deskripsi')

@section('topbar-actions')
    <!-- Tombol Cetak PDF -->
    <a href="{{ route('projects.pdf', $project) }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition gap-2">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
        Cetak PDF
    </a>

    <!-- Tombol Tugas Baru -->
    <a href="{{ route('projects.tasks.create', $project) }}"
       class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
        + Tugas Baru
    </a>

    <!-- Tombol Edit Project -->
    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-800 border border-transparent rounded-xl font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-700 transition">
        Edit Project
    </a>

    <!-- Tombol Hapus Project -->
    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?');" class="inline">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
            Hapus Project
        </button>
    </form>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6"
     x-data="{
         deleteTaskModal: false,
         taskDeleteUrl: '',
         deleteAttachmentModal: false,
         attachmentDeleteUrl: ''
     }">

    <!-- Kartu Informasi Tanggal & Warna Project -->
    <div class="bg-white dark:bg-[#18181B] overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-[#27272A] border-t-4 p-6" style="border-top-color: {{ $project->color }}">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat pada: {{ $project->created_at->format('d F Y') }}</p>
            </div>
            <span class="px-4 py-1 text-sm rounded-full text-white font-medium shadow-sm" style="background-color: {{ $project->color }}">
                {{ $project->color }}
            </span>
        </div>
    </div>

    <!-- Container Daftar Tugas -->
    <div class="bg-white dark:bg-[#18181B] rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-[#27272A]">
        <h2 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Daftar Tugas</h2>

        <!-- Form Pencarian Tugas -->
        <div class="mb-6">
            <form action="{{ route('projects.show', $project) }}" method="GET" class="flex items-center gap-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama tugas..."
                       class="w-full px-4 py-2.5 bg-white dark:bg-[#202023] border border-gray-300 dark:border-[#27272A] text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition">

                <button type="submit" class="px-5 py-2.5 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-white transition text-sm">
                    CARI
                </button>

                <!-- Tombol Reset -->
                @if(request('search'))
                    <a href="{{ route('projects.show', $project) }}" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition text-sm">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        @forelse($project->tasks as $task)

            @php
                $borderColor = $task->is_completed
                    ? '#15803D'
                    : ($task->isOverdue() ? '#EF4444' : $project->color);
            @endphp

            <div class="flex items-center gap-3
                        bg-white dark:bg-[#202023] border border-gray-200 dark:border-[#27272A]
                        rounded-xl px-4 py-3 mb-3
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
                                       : 'border-gray-300 dark:border-gray-600 hover:border-green-600 text-transparent' }}">
                        ✓
                    </button>
                </form>

                {{-- Konten task --}}
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold
                                {{ $task->is_completed
                                    ? 'line-through text-gray-400 dark:text-gray-500'
                                    : 'text-gray-900 dark:text-white' }}">
                        {{ $task->title }}
                    </div>

                    <div class="flex items-center gap-2 flex-wrap mt-1">
                        @php
                            $pColors = [
                                'high'   => 'bg-red-50 dark:bg-red-950/50 text-red-500 dark:text-red-400',
                                'medium' => 'bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400',
                                'low'    => 'bg-green-50 dark:bg-green-950/50 text-green-600 dark:text-green-400',
                            ];
                            $pLabels = ['high'=>'Tinggi','medium'=>'Sedang','low'=>'Rendah'];
                        @endphp
                        <span class="text-xs font-semibold font-mono px-2 py-0.5 rounded-full {{ $pColors[$task->priority] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                            {{ $pLabels[$task->priority] ?? 'Sedang' }}
                        </span>

                        {{-- Daftar Lampiran Task --}}
                        @if($task->attachments->count() > 0)
                            <div class="mt-3 space-y-1.5 w-full">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Lampiran:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($task->attachments as $att)
                                        <div class="flex items-center gap-2 bg-gray-50 dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] rounded-lg px-2.5 py-1.5 text-xs">
                                            <span class="font-medium text-gray-700 dark:text-gray-300 truncate max-w-[150px]">{{ $att->original_name }}</span>

                                            {{-- Tombol Lihat (Pratinjau / Modal) --}}
                                            @php
                                                $ext = strtolower(pathinfo($att->original_name, PATHINFO_EXTENSION));
                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                                            @endphp

                                            @if($isImage)
                                                <button type="button" onclick="openModal('{{ route('attachments.preview', $att->id) }}', '{{ $att->original_name }}')" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                                                    Lihat
                                                </button>
                                            @else
                                                <a href="{{ route('attachments.preview', $att->id) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                                                    Buka
                                                </a>
                                            @endif

                                            <a href="{{ route('attachments.download', $att->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                                                Unduh
                                            </a>

                                            <!-- Tombol Hapus Lampiran -->
                                            <button type="button"
                                                    @click="attachmentDeleteUrl = '{{ route('attachments.destroy', $att) }}'; deleteAttachmentModal = true"
                                                    class="text-red-500 hover:text-red-700 font-bold ml-1">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($task->due_date)
                            <span class="text-xs flex items-center gap-1
                                   {{ $task->isOverdue()
                                       ? 'text-red-500 font-semibold'
                                       : 'text-gray-400 dark:text-gray-500' }}">
                                {{ $task->due_date->format('d M Y') }}
                                @if($task->isOverdue())
                                    <span class="font-bold">— Terlambat!</span>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Aksi Tugas (Ikon Pensil & Tempat Sampah) --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Tombol Edit (Ikon Pensil) -->
                    <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                       title="Edit Tugas"
                       class="text-gray-400 hover:text-amber-600 transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>

                    <!-- Tombol Hapus (Ikon Tempat Sampah - Terhubung ke Modal) -->
                    <button type="button"
                            @click="taskDeleteUrl = '{{ route('projects.tasks.destroy', [$project, $task]) }}'; deleteTaskModal = true"
                            title="Hapus Tugas"
                            class="text-gray-400 hover:text-red-600 transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

            </div>

        @empty
            <div class="text-center py-12 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-xl">
                <div class="text-4xl mb-3 opacity-20">✅</div>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">
                    Belum ada tugas di project ini.
                </p>
                <a href="{{ route('projects.tasks.create', $project) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                    + Tambah Tugas Pertama
                </a>
            </div>
        @endforelse

    </div>

    <!-- Modal Konfirmasi Hapus Tugas -->
    <div x-show="deleteTaskModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">
        <div class="bg-white dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] p-6 rounded-2xl shadow-xl w-96 transform transition-all">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Konfirmasi Hapus Tugas</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Yakin ingin menghapus tugas ini dari project?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="deleteTaskModal = false" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition">Batal</button>
                <form :action="taskDeleteUrl" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Lampiran -->
    <div x-show="deleteAttachmentModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">
        <div class="bg-white dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] p-6 rounded-2xl shadow-xl w-96 transform transition-all">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Konfirmasi Hapus Lampiran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Yakin ingin menghapus file lampiran ini?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="deleteAttachmentModal = false" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition">Batal</button>
                <form :action="attachmentDeleteUrl" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Modal Popup Pratinjau Gambar -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white dark:bg-[#18181B] border border-gray-200 dark:border-[#27272A] rounded-2xl max-w-3xl w-full p-4 relative shadow-2xl mx-4">
        <div class="flex justify-between items-center mb-3 border-b border-gray-200 dark:border-gray-800 pb-2">
            <h3 id="modalTitle" class="text-sm font-bold text-gray-900 dark:text-white truncate">Pratinjau Lampiran</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-bold text-lg px-2">×</button>
        </div>
        <div class="flex justify-center items-center bg-gray-100 dark:bg-[#202023] rounded-xl overflow-hidden p-2 max-h-[75vh]">
            <img id="modalImage" src="" alt="Preview" class="max-h-[70vh] object-contain rounded-lg">
        </div>
        <div class="flex justify-end mt-3">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(url, title) {
        document.getElementById('modalImage').src = url;
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('modalImage').src = '';
    }
</script>
@endsection
