{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- @yield('title') diisi dari setiap halaman anak --}}
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=4">

    {{-- Skrip Inline Pencegah Kedip Putih (Flash) Saat Load Halaman --}}
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    {{-- BAGIAN YANG DIEDIT: Mengganti @vite dengan CDN Tailwind + Config + Alpine.js --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class' // Memaksa Tailwind membaca class "dark" dari tombol Alpine.js
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- AKHIR BAGIAN YANG DIEDIT --}}

    @stack('styles')
    <style> [x-cloak] { display: none !important; } </style>
</head>

{{-- x-data di <body> agar sidebar & overlay bisa saling komunikasi --}}
<body class="bg-[#FAFAF8] dark:bg-[#121214] text-gray-900 dark:text-gray-100 antialiased transition-colors duration-200"
    style="font-family:'Inter',system-ui,sans-serif;"
    x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-[248px] bg-white dark:bg-[#18181B] border-r border-[#ECECE9] dark:border-[#27272A]
                flex flex-col fixed top-0 left-0 h-screen z-50
                lg:translate-x-0 transition-transform duration-300">

            {{-- Brand: logo "T" + nama TaskHub --}}
            <div class="flex items-center gap-[10px] px-6 py-6">
                <div class="w-[34px] h-[34px] rounded-[10px] flex items-center
                    justify-center text-white font-black text-[17px] shrink-0"
                    style="background:linear-gradient(135deg,#FF6B4A,#FF8F73);">
                    T
                </div>
                <span class="font-bold text-[18px] tracking-tight">TaskHub</span>
            </div>

            {{-- Menu navigasi utama --}}
            <nav class="px-4 flex-1 overflow-y-auto">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('dashboard')
                              ? 'bg-[#1C1C1E] dark:bg-[#27272A] text-white'
                              : 'text-[#8A8A8E] dark:text-[#A1A1AA] hover:bg-[#FAFAF8] dark:hover:bg-[#202023] hover:text-[#1C1C1E] dark:hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3"  y="3"  width="7" height="7" rx="1"/>
                        <rect x="14" y="3"  width="7" height="7" rx="1"/>
                        <rect x="3"  y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Projects --}}
                <a href="{{ route('projects.index') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('projects.*')
                              ? 'bg-[#1C1C1E] dark:bg-[#27272A] text-white'
                              : 'text-[#8A8A8E] dark:text-[#A1A1AA] hover:bg-[#FAFAF8] dark:hover:bg-[#202023] hover:text-[#1C1C1E] dark:hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                    </svg>
                    Projects
                    {{-- Badge counter --}}
                    @php $pc = auth()->user()->projects()->count() @endphp
                    @if($pc > 0)
                        <span class="ml-auto text-[11px] font-semibold px-[7px] py-[1px] rounded-full
                                     {{ request()->routeIs('projects.*')
                                         ? 'bg-white/20 text-white'
                                         : 'bg-[#FFE8E1] dark:bg-[#3F201C] text-[#FF6B4A]' }}"
                              style="font-family:'JetBrains Mono',monospace;">
                            {{ $pc }}
                        </span>
                    @endif
                </a>

                {{-- Semua Tugas --}}
                @if(Route::has('tasks.index'))
                <a href="{{ route('tasks.index') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('tasks.index')
                              ? 'bg-[#1C1C1E] dark:bg-[#27272A] text-white'
                              : 'text-[#8A8A8E] dark:text-[#A1A1AA] hover:bg-[#FAFAF8] dark:hover:bg-[#202023] hover:text-[#1C1C1E] dark:hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                    </svg>
                    Semua Tugas
                </a>
                @endif

                {{-- Tags --}}
                @if(Route::has('tags.index'))
                <a href="{{ route('tags.index') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('tags.*')
                              ? 'bg-[#1C1C1E] dark:bg-[#27272A] text-white'
                              : 'text-[#8A8A8E] dark:text-[#A1A1AA] hover:bg-[#FAFAF8] dark:hover:bg-[#202023] hover:text-[#1C1C1E] dark:hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                    Tags
                </a>
                @endif

                {{-- Daftar project milik user di sidebar --}}
                @php
                    $sidebarProjects = auth()->user()
                        ->projects()
                        ->withCount('tasks')
                        ->latest()
                        ->take(8)
                        ->get();
                @endphp

                @if($sidebarProjects->isNotEmpty())
                    <p class="text-[11px] font-semibold text-[#B8B8B5] dark:text-[#71717A] uppercase
                            tracking-[.06em] px-3 pt-5 pb-2">
                        Project Saya
                    </p>
                    @foreach($sidebarProjects as $sp)
                        <a href="{{ route('projects.show', $sp) }}"
                           class="flex items-center gap-[10px] px-3 py-2 rounded-[10px]
                                  text-[13.5px] font-medium mb-[1px] transition-all
                                  {{ request()->is('projects/'.$sp->id) || request()->is('projects/'.$sp->id.'/*')
                                      ? 'bg-[#FAFAF8] dark:bg-[#202023] text-[#1C1C1E] dark:text-white font-semibold'
                                      : 'text-[#8A8A8E] dark:text-[#A1A1AA] hover:bg-[#FAFAF8] dark:hover:bg-[#202023] hover:text-[#1C1C1E] dark:hover:text-white' }}">
                            <span class="w-[9px] h-[9px] rounded-full shrink-0"
                                  style="background-color:{{ $sp->color ?? '#3B82F6' }}"></span>
                            <span class="truncate flex-1">{{ Str::limit($sp->name, 22) }}</span>
                            <span class="text-[11px] text-[#B8B8B5] dark:text-[#71717A] shrink-0"
                                  style="font-family:'JetBrains Mono',monospace;">
                                {{ $sp->tasks_count }}
                            </span>
                        </a>
                    @endforeach
                @endif

            </nav>

            {{-- Tombol Dark / Light Mode Toggle --}}
            <div class="px-4 py-2 border-t border-[#ECECE9] dark:border-[#27272A] flex items-center justify-between">
                <span class="text-[12px] font-medium text-[#8A8A8E] dark:text-[#A1A1AA]">Mode Tampilan</span>
                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-xl bg-gray-100 dark:bg-[#202023] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#27272A] transition"
                        :title="darkMode ? 'Ubah ke Mode Terang' : 'Ubah ke Mode Gelap'">
                    {{-- Ikon Matahari (Muncul saat Dark Mode aktif) --}}
                    <svg x-show="darkMode" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    {{-- Ikon Bulan (Muncul saat Light Mode aktif) --}}
                    <svg x-show="!darkMode" class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </div>

            {{-- User info + tombol logout di bawah sidebar --}}
            <div class="flex items-center gap-[10px] px-6 py-4 border-t border-[#ECECE9] dark:border-[#27272A] mt-auto">
                <div class="w-[34px] h-[34px] rounded-full bg-[#E8EFFD] dark:bg-[#1E293B] text-[#5B8DEF]
                          flex items-center justify-center font-bold text-[13px] shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[11.5px] text-[#8A8A8E] dark:text-[#A1A1AA] truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-[#B8B8B5] dark:text-[#71717A] hover:text-[#F87171] hover:bg-[#FEEAEA] dark:hover:bg-[#3F201C] p-[6px] rounded-lg transition-all"
                            title="Logout">
                        <svg class="w-[15px] h-[15px]" fill="none"
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            </div>

        </aside>

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-40 lg:hidden"
            style="display:none;">
        </div>

        {{-- Main content + Topbar --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-[248px]">
            <header class="sticky top-0 z-30 bg-white dark:bg-[#18181B] border-b border-[#ECECE9] dark:border-[#27272A] flex items-center gap-4 px-9 py-5">

                {{-- Tombol hamburger — mobile --}}
                <button class="lg:hidden text-[#8A8A8E] dark:text-[#A1A1AA] hover:text-[#1C1C1E] dark:hover:text-white p-[6px] rounded-lg hover:bg-[#FAFAF8] dark:hover:bg-[#202023] transition-colors"
                        @click="sidebarOpen = true">
                    <svg class="w-[18px] h-[18px]" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                <div class="flex-1 min-w-0">
                    <h1 class="font-bold text-[22px] tracking-tight text-[#1C1C1E] dark:text-white"
                        style="font-family:'Outfit',system-ui,sans-serif;">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    @hasSection('page-sub')
                        <p class="text-[13px] text-[#8A8A8E] dark:text-[#A1A1AA] mt-[3px]">
                            @yield('page-sub')
                        </p>
                    @endif
                </div>

                <div class="flex items-center gap-[10px] shrink-0">
                    @yield('topbar-actions')
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-end="opacity-0"
                     class="flex items-center gap-[10px] mx-9 mt-4 px-4 py-3 bg-green-50 dark:bg-[#143322] border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-xl text-[13.5px] font-medium">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-[10px] mx-9 mt-4 px-4 py-3 bg-red-50 dark:bg-[#3F201C] border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-xl text-[13.5px] font-medium">
                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9"  y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Konten utama --}}
            <main class="flex-1 p-9">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
