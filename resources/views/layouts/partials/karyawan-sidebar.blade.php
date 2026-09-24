<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 border-r border-slate-700/60 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col justify-between"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div>
        <div class="h-16 flex items-center justify-between px-6 bg-slate-800/80 border-b border-slate-700/60">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-600 rounded-lg text-white font-bold">
                    KM
                </div>
                <span class="font-bold text-white text-lg tracking-wide">PORTAL KARYAWAN</span>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="px-4 py-6 space-y-1">
            <a href="{{ route('karyawan.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('karyawan.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard Saya
            </a>

            <a href="{{ route('karyawan.borongan.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('karyawan.borongan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Borongan Saya
            </a>

            <a href="{{ route('karyawan.shifts.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('karyawan.shifts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Jadwal Shift
            </a>

            <a href="{{ route('karyawan.penggajian.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('karyawan.penggajian.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Slip Gaji & Bukti
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-700/60 bg-slate-800/40">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Karyawan' }}</p>
                <p class="text-xs text-slate-400 capitalize">Role: Karyawan</p>
            </div>
        </div>
    </div>
</aside>
