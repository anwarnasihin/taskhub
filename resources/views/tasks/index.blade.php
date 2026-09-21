<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    @if($filter === 'completed')
                        Tugas Selesai
                    @elseif($filter === 'overdue')
                        Tugas Terlambat
                    @else
                        Semua Tugas
                    @endif
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if($filter === 'completed')
                        Daftar tugas yang sudah diselesaikan.
                    @elseif($filter === 'overdue')
                        Daftar tugas yang sudah melewati deadline.
                    @else
                        Daftar seluruh tugas Anda.
                    @endif
                </p>
            </div>

            {{-- Tombol Filter --}}
            <div class="flex flex-wrap gap-2 mb-6">

                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold
                   {{ $filter === 'all'
                       ? 'bg-indigo-600 text-white'
                       : 'bg-gray-100 text-gray-700 dark:bg-[#27272A] dark:text-gray-300' }}">
                    Semua
                </a>

                <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold
                   {{ $filter === 'completed'
                       ? 'bg-green-600 text-white'
                       : 'bg-gray-100 text-gray-700 dark:bg-[#27272A] dark:text-gray-300' }}">
                    Selesai
                </a>

                <a href="{{ route('tasks.index', ['filter' => 'overdue']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold
                   {{ $filter === 'overdue'
                       ? 'bg-red-600 text-white'
                       : 'bg-gray-100 text-gray-700 dark:bg-[#27272A] dark:text-gray-300' }}">
                    Terlambat
                </a>

            </div>

            {{-- Daftar Tugas --}}
            <div class="bg-white dark:bg-[#18181B] rounded-2xl border border-gray-200 dark:border-[#27272A] overflow-hidden">

                @forelse($tasks as $task)

                    <div class="p-5 border-b border-gray-200 dark:border-[#27272A] last:border-b-0">

                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white">
                                    {{ $task->title }}
                                </h3>

                                @if($task->project)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Project:
                                        <a href="{{ route('projects.show', $task->project) }}"
                                           class="text-indigo-600 hover:underline">
                                            {{ $task->project->name }}
                                        </a>
                                    </p>
                                @endif

                                @if($task->due_date)
                                    <p class="text-sm mt-2
                                        {{ !$task->is_completed && $task->isOverdue()
                                            ? 'text-red-600 font-semibold'
                                            : 'text-gray-500 dark:text-gray-400' }}">

                                        Deadline:
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}

                                        @if(!$task->is_completed && $task->isOverdue())
                                            — Terlambat
                                        @endif

                                    </p>
                                @endif
                            </div>

                            {{-- Status --}}
                            @if($task->is_completed)

                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Selesai
                                </span>

                            @elseif($task->due_date && $task->isOverdue())

                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    Terlambat
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                    Berjalan
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        @if($filter === 'overdue')

                            <div class="text-4xl mb-3">🎉</div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Tidak Ada Tugas Terlambat
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Semua tugas saat ini masih sesuai dengan deadline.
                            </p>

                        @elseif($filter === 'completed')

                            <div class="text-4xl mb-3">📋</div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Belum Ada Tugas Selesai
                            </h3>

                        @else

                            <div class="text-4xl mb-3">📋</div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Belum Ada Tugas
                            </h3>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>
