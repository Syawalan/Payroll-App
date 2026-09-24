@extends('layouts.admin')

@section('title', 'Edit Jadwal Shift')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.shifts.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Edit Jadwal Shift</h1>
                <p class="text-sm text-slate-400">Perbarui tanggal atau jam kerja karyawan.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Pilih Karyawan -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-slate-300 mb-2">Pilih Karyawan</label>
                    <select name="user_id" id="user_id" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('user_id') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $shift->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Shift -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Kerja</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $shift->tanggal) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('tanggal') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Mulai & Jam Selesai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-slate-300 mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i')) }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('jam_mulai') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('jam_mulai')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-slate-300 mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i')) }}"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('jam_selesai') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('jam_selesai')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/60">
                    <a href="{{ route('admin.shifts.index') }}"
                        class="px-4 py-2.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
