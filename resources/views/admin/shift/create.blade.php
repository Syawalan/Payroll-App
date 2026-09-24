@extends('layouts.admin')

@section('title', 'Tambah Shift Kerja')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6" x-data="{ tab: 'batch' }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Atur Shift Kerja</h1>
                <p class="text-sm text-slate-400 mt-1">Buat jadwal kerja harian atau jadwal berulang untuk karyawan.</p>
            </div>
            <a href="{{ route('admin.shifts.index') }}"
                class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-sm font-medium border border-slate-700">
                &larr; Kembali
            </a>
        </div>

        <!-- Mode Selector Tabs -->
        <div class="flex p-1 bg-slate-800 border border-slate-700/60 rounded-xl">
            <button type="button" @click="tab = 'batch'"
                :class="tab === 'batch' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all text-center">
                📅 Generate Shift Berulang (Batch)
            </button>
            <button type="button" @click="tab = 'single'"
                :class="tab === 'single' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all text-center">
                ✍️ Input 1 Tanggal Saja
            </button>
        </div>

        <!-- FORM 1: GENERATE SHIFT BERULANG (BATCH) -->
        <div x-show="tab === 'batch'" class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.shifts.store-batch') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Karyawan -->
                <div>
                    <label for="user_id_batch" class="block text-sm font-medium text-slate-300 mb-2">Pilih Karyawan</label>
                    <select name="user_id" id="user_id_batch" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach ($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}" {{ old('user_id') == $karyawan->id ? 'selected' : '' }}>
                                {{ $karyawan->name }} ({{ ucfirst($karyawan->kontrak_gaji) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Hari Kerja -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Pilih Hari Kerja Berulang</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        @php
                            $days = [
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                                'Sunday' => 'Minggu',
                            ];
                        @endphp
                        @foreach ($days as $key => $label)
                            <label
                                class="flex items-center gap-2.5 p-3 rounded-lg bg-slate-900 border border-slate-700 hover:border-slate-600 cursor-pointer text-xs font-semibold text-slate-300">
                                <input type="checkbox" name="hari[]" value="{{ $key }}"
                                    class="rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-blue-500">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-300 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', date('Y-m-01')) }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-300 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', date('Y-m-t')) }}"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <!-- Jam Kerja -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai_batch" class="block text-sm font-medium text-slate-300 mb-2">Jam Mulai
                            (Masuk)</label>
                        <input type="time" name="jam_mulai" id="jam_mulai_batch" value="{{ old('jam_mulai', '08:00') }}"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label for="jam_selesai_batch" class="block text-sm font-medium text-slate-300 mb-2">Jam Selesai
                            (Pulang)</label>
                        <input type="time" name="jam_selesai" id="jam_selesai_batch"
                            value="{{ old('jam_selesai', '12:00') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-lg shadow-blue-600/30 transition-all">
                    Generate Shift Harian
                </button>
            </form>
        </div>

        <!-- FORM 2: INPUT SINGLE SHIFT -->
        <div x-show="tab === 'single'" style="display: none;"
            class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.shifts.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="user_id_single" class="block text-sm font-medium text-slate-300 mb-2">Pilih Karyawan</label>
                    <select name="user_id" id="user_id_single" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach ($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Shift</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-slate-300 mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="08:00" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-slate-300 mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" value="17:00" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-lg shadow-blue-600/30 transition-all">
                    Simpan Single Shift
                </button>
            </form>
        </div>
    </div>
@endsection
