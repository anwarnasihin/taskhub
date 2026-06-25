{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- @yield('title') diisi dari setiap halaman anak --}}
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>

    {{-- Load Tailwind CSS + Alpine.js via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style> [x-cloak] { display: none !important; } </style>
</head>

{{-- x-data di <body> agar sidebar & overlay bisa saling komunikasi --}}
<body class="bg-[#FAFAF8] text-gray-900 antialiased"
    style="font-family:'Inter',system-ui,sans-serif;"
    x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar ada di sini (Langkah 3) --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-[248px] bg-white border-r border-[#ECECE9]
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
                              ? 'bg-[#1C1C1E] text-white'
                              : 'text-[#8A8A8E] hover:bg-[#FAFAF8] hover:text-[#1C1C1E]' }}">
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
                              ? 'bg-[#1C1C1E] text-white'
                              : 'text-[#8A8A8E] hover:bg-[#FAFAF8] hover:text-[#1C1C1E]' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                          stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                    </svg>
                    Projects
                    {{-- Badge counter — muncul hanya kalau ada project --}}
                    @php $pc = auth()->user()->projects()->count() @endphp
                    @if($pc > 0)
                        <span class="ml-auto text-[11px] font-semibold px-[7px] py-[1px] rounded-full
                                     {{ request()->routeIs('projects.*')
                                         ? 'bg-white/20 text-white'
                                         : 'bg-[#FFE8E1] text-[#FF6B4A]' }}"
                              style="font-family:'JetBrains Mono',monospace;">
                            {{ $pc }}
                        </span>
                    @endif
                </a>

                {{-- Semua Tugas — menu ini aktif setelah P5 --}}
                @if(Route::has('tasks.index'))
                <a href="{{ route('tasks.index') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('tasks.index')
                              ? 'bg-[#1C1C1E] text-white'
                              : 'text-[#8A8A8E] hover:bg-[#FAFAF8] hover:text-[#1C1C1E]' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none"
                          stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                    </svg>
                    Semua Tugas
                </a>
                @endif

                {{-- Tags — menu ini aktif setelah P6 --}}
                @if(Route::has('tags.index'))
                <a href="{{ route('tags.index') }}"
                   class="flex items-center gap-[11px] px-3 py-[9px] rounded-[10px]
                          text-[13.5px] font-medium mb-[2px] transition-all
                          {{ request()->routeIs('tags.*')
                              ? 'bg-[#1C1C1E] text-white'
                              : 'text-[#8A8A8E] hover:bg-[#FAFAF8] hover:text-[#1C1C1E]' }}">
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
                    <p class="text-[11px] font-semibold text-[#B8B8B5] uppercase
                              tracking-[.06em] px-3 pt-5 pb-2">
                        Project Saya
                    </p>
                    @foreach($sidebarProjects as $sp)
                        <a href="{{ route('projects.show', $sp) }}"
                           class="flex items-center gap-[10px] px-3 py-2 rounded-[10px]
                                  text-[13.5px] font-medium mb-[1px] transition-all
                                  {{ request()->is('projects/'.$sp->id) || request()->is('projects/'.$sp->id.'/*')
                                     ? 'bg-[#FAFAF8] text-[#1C1C1E] font-semibold'
                                     : 'text-[#8A8A8E] hover:bg-[#FAFAF8] hover:text-[#1C1C1E]' }}">
                            <span class="w-[9px] h-[9px] rounded-full shrink-0"
                                  style="background-color:{{ $sp->color ?? '#3B82F6' }}"></span>
                            <span class="truncate flex-1">{{ Str::limit($sp->name, 22) }}</span>
                            <span class="text-[11px] text-[#B8B8B5] shrink-0"
                                  style="font-family:'JetBrains Mono',monospace;">
                                {{ $sp->tasks_count }}
                            </span>
                        </a>
                    @endforeach
                @endif

            </nav>

            {{-- User info + tombol logout di bawah sidebar --}}
            <div class="flex items-center gap-[10px] px-6 py-4 border-t border-[#ECECE9] mt-auto">
                <div class="w-[34px] h-[34px] rounded-full bg-[#E8EFFD] text-[#5B8DEF]
                            flex items-center justify-center font-bold text-[13px] shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[11.5px] text-[#8A8A8E] truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-[#B8B8B5] hover:text-[#F87171] hover:bg-[#FEEAEA] p-[6px] rounded-lg transition-all"
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
            <header class="sticky top-0 z-30 bg-white border-b border-[#ECECE9] flex items-center gap-4 px-9 py-5">

                {{-- Tombol hamburger — mobile --}}
                <button class="lg:hidden text-[#8A8A8E] hover:text-[#1C1C1E] p-[6px] rounded-lg hover:bg-[#FAFAF8] transition-colors"
                        @click="sidebarOpen = true">
                    <svg class="w-[18px] h-[18px]" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                <div class="flex-1 min-w-0">
                    <h1 class="font-bold text-[22px] tracking-tight text-[#1C1C1E]"
                        style="font-family:'Outfit',system-ui,sans-serif;">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    @hasSection('page-sub')
                        <p class="text-[13px] text-[#8A8A8E] mt-[3px]">
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
                     class="flex items-center gap-[10px] mx-9 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-[13.5px] font-medium">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-[10px] mx-9 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-[13.5px] font-medium">
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
