@extends('layouts.app')

@section('title', 'Edit Modem - ' . $modem->nomor_aset_internal)

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-slate-800 transition-colors duration-300" 
     x-data="{ 
         sidebarOpen: false,
         isDark: localStorage.getItem('theme') === 'dark',
         toggleTheme() {
             this.isDark = !this.isDark;
             localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
             document.documentElement.classList.toggle('dark', this.isDark);
         }
     }">
    @include('admin.partials.sidebar')

    <div class="lg:pl-64">
        @include('admin.partials.topbar')

        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Perangkat Modem</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Ubah informasi spesifikasi atau penempatan modem</p>
                </div>
                <a href="{{ route('admin.network.modems.index') }}" class="bg-gray-500 text-white px-5 py-2.5 rounded-lg hover:bg-gray-600 transition shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6 max-w-2xl">
                <form action="{{ route('admin.network.modems.update', $modem->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="nomor_aset_internal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Aset Internal</label>
                            <input type="text" name="nomor_aset_internal" id="nomor_aset_internal" value="{{ old('nomor_aset_internal', $modem->nomor_aset_internal) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('nomor_aset_internal') border-red-500 focus:ring-red-500 @enderror" required>
                            @error('nomor_aset_internal')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="serial_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Serial Number (SN) Pabrik</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $modem->serial_number) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('serial_number') border-red-500 focus:ring-red-500 @enderror" required>
                            @error('serial_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="merek" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Merek / Manufaktur</label>
                            <input type="text" name="merek" id="merek" value="{{ old('merek', $modem->merek) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('merek') border-red-500 focus:ring-red-500 @enderror" required>
                            @error('merek')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Perangkat</label>
                            <select name="status" id="status" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                <option value="stok_gudang" {{ old('status', $modem->status) == 'stok_gudang' ? 'selected' : '' }}>Stok Gudang</option>
                                <option value="terpasang" {{ old('status', $modem->status) == 'terpasang' ? 'selected' : '' }}>Terpasang (Aktif)</option>
                                <option value="rusak" {{ old('status', $modem->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>

                        <div>
                            <label for="customer_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alokasikan ke Customer</label>
                            <select name="customer_id" id="customer_id" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                <option value="">-- Belum Dialokasikan / Stok Gudang --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $modem->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex justify-end space-x-2">
                            <a href="{{ route('admin.network.modems.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-600 dark:text-white rounded-lg transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg shadow-md transition">
                                <i class="fas fa-sync mr-2"></i>Update Modem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection