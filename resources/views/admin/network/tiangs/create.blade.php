@extends('layouts.app')

@section('title', 'Tambah Aset Tiang Baru')

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
            <div class="mb-6">
                <a href="{{ route('admin.network.tiangs.index') }}" class="text-cyan-600 dark:text-cyan-400 hover:underline text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke List
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Tambah Aset Tiang</h1>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6 max-w-2xl">
                <form action="{{ route('admin.network.tiangs.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor / Kode Tiang *</label>
                        <input type="text" name="nomor_tiang" value="{{ old('nomor_tiang') }}" required placeholder="Contoh: TNG-MRA-01" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('nomor_tiang') border-red-500 @enderror">
                        @error('nomor_tiang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Fisik Tiang *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="baik" {{ old('status') == 'baik' ? 'selected' : '' }}>Baik / Tegak</option>
                            <option value="miring" {{ old('status') == 'miring' ? 'selected' : '' }}>Miring</option>
                            <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak / Keropos</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Latitude</label>
                            <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="Contoh: -7.812345" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('latitude') border-red-500 @enderror">
                            @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Longitude</label>
                            <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="Contoh: 112.012345" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('longitude') border-red-500 @enderror">
                            @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi Spesifik / Patokan *</label>
                        <textarea name="lokasi_spesifik" rows="4" required placeholder="Contoh: Depan gang makam, sebelah tiang PLN..." class="w-full px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('lokasi_spesifik') border-red-500 @enderror">{{ old('lokasi_spesifik') }}</textarea>
                        @error('lokasi_spesifik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-slate-600">
                        <a href="{{ route('admin.network.tiangs.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-slate-500 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600 transition text-sm font-medium">Batal</a>
                        <button type="submit" class="bg-cyan-600 text-white px-6 py-2.5 rounded-lg hover:bg-cyan-700 transition shadow-lg text-sm font-medium">Simpan Aset Tiang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection