<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karyawan Dashboard') - Supplier Material</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        primaryHover: '#1d4ed8',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-900 text-slate-100 font-sans antialiased min-h-screen flex flex-col" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden" style="display: none;"></div>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Karyawan -->
        @include('layouts.partials.karyawan-sidebar')

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            @include('layouts.partials.navbar')

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button type="button" @click="$el.parentElement.remove()"
                            class="text-emerald-400 font-bold">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 flex justify-between items-center">
                        <span>{{ session('error') }}</span>
                        <button type="button" @click="$el.parentElement.remove()"
                            class="text-rose-400 font-bold">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

</body>

</html>
