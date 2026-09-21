@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-6">

    <!-- Header Selamat Datang -->
    <div class="bg-white dark:bg-[#18181B] rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Berikut adalah ringkasan aktivitas project dan tugas Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-xl text-xs uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                + Project Baru
            </a>
        </div>
    </div>

    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Project -->
        <a href="{{ route('projects.index') }}"
        class="bg-white dark:bg-[#18181B] p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] flex items-center justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-200 cursor-pointer">

            <div>
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    Total Project
                </p>

                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">
                    {{ $totalProjects ?? 0 }}
                </h3>
            </div>

            <div class="p-3 bg-blue-50 dark:bg-blue-950/50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                    </path>
                </svg>
            </div>

        </a>

        <!-- Total Tugas -->
        <a href="{{ route('tasks.index') }}"
        class="bg-white dark:bg-[#18181B] p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] flex items-center justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-200 cursor-pointer">

            <div>
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    Total Tugas
                </p>

                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">
                    {{ $totalTasks ?? 0 }}
                </h3>
            </div>

            <div class="p-3 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>

        </a>

        <!-- Tugas Selesai -->
        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
        class="bg-white dark:bg-[#18181B] p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] flex items-center justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-200 cursor-pointer">

            <div>
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    Tugas Selesai
                </p>

                <h3 class="text-2xl font-extrabold text-green-600 mt-1">
                    {{ $completedTasks ?? 0 }}
                </h3>
            </div>

            <div class="p-3 bg-green-50 dark:bg-green-950/50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7">
                    </path>
                </svg>
            </div>

        </a>

        <!-- Tugas Terlambat -->
        <a href="{{ $overdueTasks && $overdueTasks->count() > 0
            ? route('tasks.index', ['filter' => 'overdue'])
            : 'javascript:void(0)' }}"
        @if(!$overdueTasks || $overdueTasks->count() === 0)
            onclick="showNoOverdueAlert(event)"
        @endif
        class="bg-white dark:bg-[#18181B] p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] flex items-center justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-200 cursor-pointer">

            <div>
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    Terlambat
                </p>

                <h3 class="text-2xl font-extrabold text-red-600 mt-1">
                    {{ isset($overdueTasks) ? $overdueTasks->count() : 0 }}
                </h3>
            </div>

            <div class="p-3 bg-red-50 dark:bg-red-950/50 text-red-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>

        </a>
    </div>

    <!-- Grafik Persentase Penyelesaian Keseluruhan -->
    <div class="bg-white dark:bg-[#18181B] rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] p-6">
        <div class="flex justify-between items-center mb-2">
            {{-- Tambahkan text-gray-900 dark:text-white agar jelas --}}
            <span class="text-sm font-bold text-gray-900 dark:text-white">Progress Penyelesaian Keseluruhan Tugas</span>
            <span class="text-sm font-extrabold text-blue-600 dark:text-blue-400">{{ $completionPercentage ?? 0 }}%</span>
        </div>

        {{-- Bingkai luar dengan border biru/abu dan padding tipis ala gambar --}}
        <div style="width: 100%; background-color: #f3f4f6; border: 2px solid #38bdf8; border-radius: 9999px; height: 20px; padding: 2px; box-sizing: border-box; overflow: hidden;" class="dark:bg-[#202023] dark:border-blue-500">
            <div style="width: {{ $completionPercentage ?? 0 }}%; background-color: #0284c7; height: 100%; border-radius: 9999px; transition: width 0.5s ease;"></div>
        </div>
    </div>

    <!-- Bagian Daftar Tugas Terlambat & Peringatan -->
    @if(isset($overdueTasks) && $overdueTasks->count() > 0)
    <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 rounded-2xl p-6">
        <h3 class="text-sm font-bold text-red-800 dark:text-red-400 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Perhatian: Tugas yang Melewati Batas Waktu (Overdue)
        </h3>
        <div class="space-y-2">
            @foreach($overdueTasks as $task)
                <div class="bg-white dark:bg-[#18181B] border border-red-200 dark:border-red-900/50 rounded-xl p-3 flex justify-between items-center text-xs">
                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $task->title }}</span>
                        <span class="text-gray-400 ml-2">({{ $task->project->name ?? 'Project' }})</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-red-600 font-bold">{{ $task->due_date->format('d M Y') }} — Terlambat!</span>
                        <a href="{{ route('projects.show', $task->project_id) }}" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Daftar Project Aktif dengan Persentase Per Project -->
    <div class="bg-white dark:bg-[#18181B] rounded-2xl shadow-sm border border-gray-200 dark:border-[#27272A] p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Project Anda</h3>
            <a href="{{ route('projects.index') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-semibold">Lihat Semua →</a>
        </div>

        @if(isset($projects) && $projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($projects->take(6) as $project)
                    @php
                        $pTotal = $project->tasks->count();
                        $pDone = $project->tasks->where('is_completed', true)->count();
                        $pPercent = $pTotal > 0 ? round(($pDone / $pTotal) * 100) : 0;
                    @endphp
                    <div class="bg-gray-50 dark:bg-[#202023] border border-gray-200 dark:border-[#27272A] p-4 rounded-xl border-t-4 hover:shadow-sm transition" style="border-color: {{ $project->color }}">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800 dark:text-white text-sm truncate max-w-[180px]">{{ $project->name }}</h4>
                            <span class="text-xs font-mono font-semibold text-gray-500 dark:text-gray-400">{{ $pPercent }}%</span>
                        </div>

                        {{-- Progress Bar Per Project --}}
                        <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden mb-3">
                            <div class="h-full rounded-full transition-all duration-300" style="width: {{ $pPercent }}%; background-color: {{ $project->color }};"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            @php
    $pPending = $pTotal - $pDone;
@endphp

<p class="text-xs text-gray-500 dark:text-gray-400">
    @if($pPending > 0)
        {{ $pPending }} Tugas Pending / Belum Selesai
    @else
        Semua Tugas Selesai 🎉
    @endif
</p>
                            <a href="{{ route('projects.show', $project) }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Kelola →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400 text-sm">
                Belum ada project yang dibuat. <a href="{{ route('projects.create') }}" class="text-blue-600 underline">Buat sekarang</a>
            </div>
        @endif
    </div>

</div>
@endsection

<script>
function showNoOverdueAlert(event) {
    event.preventDefault();

    alert(
        "🎉 Tidak Ada Tugas Terlambat!\n\n" +
        "Semua tugas saat ini masih sesuai dengan deadline."
    );
}
</script>
