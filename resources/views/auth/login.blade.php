<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Supplier Material Borongan</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk toggle password -->
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

<body class="bg-slate-900 text-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md space-y-6">

        <!-- Logo & Title Header -->
        <div class="text-center space-y-2">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 text-white font-bold text-xl shadow-lg shadow-blue-600/30 border border-blue-400/30 mb-2">
                SM
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Portal Masuk Sistem</h1>
            <p class="text-sm text-slate-400">Supplier Material &amp; Penggajian Borongan</p>
        </div>

        <!-- Alert Status / Feedback -->
        @if (session('status'))
            <div
                class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between">
                <span>{{ session('status') }}</span>
                <button type="button" @click="$el.parentElement.remove()"
                    class="text-emerald-400 font-bold">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs space-y-1">
                <span class="font-bold block">Gagal masuk. Periksa kesalahan berikut:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Form Login -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-2xl p-6 sm:p-8 shadow-2xl space-y-6"
            x-data="{ showPassword: false }">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            autofocus
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-slate-900/80 border @error('email') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="nama@domain.com">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                            class="w-full pl-10 pr-10 py-2.5 rounded-lg bg-slate-900/80 border @error('password') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-white">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.907c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.563 3.029m-5.858 5.908a3 3 0 11-4.243-4.243" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Reset Password Link -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-300 hover:text-white">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-800">
                        <span>Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-blue-400 hover:text-blue-300 transition-colors">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-lg shadow-blue-600/30 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                    Masuk Akun
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} Supplier Material Borongan. All rights reserved.
        </p>

    </div>

</body>

</html>
