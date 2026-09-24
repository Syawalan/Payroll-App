<header
    class="h-16 bg-slate-800/80 backdrop-blur border-b border-slate-700/60 px-4 md:px-6 flex items-center justify-between sticky top-0 z-30">
    <!-- Toggle Button Mobile -->
    <button @click="sidebarOpen = !sidebarOpen"
        class="lg:hidden text-slate-300 hover:text-white focus:outline-none p-2 rounded-lg bg-slate-700/50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Page Header / Breadcrumb Minimalis -->
    <div class="hidden sm:block">
        <span class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Sistem Penggajian Borongan</span>
    </div>

    <!-- Right Profile Menu Dropdown -->
    <div class="flex items-center gap-4" x-data="{ dropdownOpen: false }">
        <div class="relative">
            <button @click="dropdownOpen = !dropdownOpen"
                class="flex items-center gap-2 text-slate-300 hover:text-white focus:outline-none">
                <span class="text-sm font-medium hidden md:inline-block">{{ auth()->user()->name ?? 'User' }}</span>
                <div
                    class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl border border-slate-700 py-1 z-50"
                style="display: none;">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-rose-400 hover:bg-slate-700/50 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout / Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
