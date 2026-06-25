@extends('layouts.app')

@section('title', 'Edit Backbone - ' . $backbone->kode_backbone)

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
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Kabel Backbone</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Ubah data teknis atau status fungsional jalur backbone</p>
                </div>
                <a href="{{ route('admin.network.backbones.index') }}" class="bg-gray-500 text-white px-5 py-2.5 rounded-lg hover:bg-gray-600 transition shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6 max-w-2xl">
                <form action="{{ route('admin.network.backbones.update', $backbone->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="kode_backbone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kode Backbone</label>
                            <input type="text" name="kode_backbone" id="kode_backbone" value="{{ old('kode_backbone', $backbone->kode_backbone) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('kode_backbone') border-red-500 focus:ring-red-500 @enderror" required>
                            @error('kode_backbone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_jalur" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Jalur / Rute</label>
                            <input type="text" name="nama_jalur" id="nama_jalur" value="{{ old('nama_jalur', $backbone->nama_jalur) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('nama_jalur') border-red-500 focus:ring-red-500 @enderror" required>
                            @error('nama_jalur')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="kapasitas_core" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kapasitas Core</label>
                                <input type="number" name="kapasitas_core" id="kapasitas_core" value="{{ old('kapasitas_core', $backbone->kapasitas_core) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('kapasitas_core') border-red-500 focus:ring-red-500 @enderror" required>
                                @error('kapasitas_core')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="core_terpakai" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Core Terpakai</label>
                                <input type="number" name="core_terpakai" id="core_terpakai" value="{{ old('core_terpakai', $backbone->core_terpakai) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('core_terpakai') border-red-500 focus:ring-red-500 @enderror" required>
                                @error('core_terpakai')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="panjang_kabel" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Panjang Kabel (Meter)</label>
                                <input type="number" step="0.01" name="panjang_kabel" id="panjang_kabel" value="{{ old('panjang_kabel', $backbone->panjang_kabel) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('panjang_kabel') border-red-500 focus:ring-red-500 @enderror" required>
                                @error('panjang_kabel')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tipe_kabel" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Penggelaran Kabel</label>
                                <select name="tipe_kabel" id="tipe_kabel" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                    <option value="aerial" {{ old('tipe_kabel', $backbone->tipe_kabel) == 'aerial' ? 'selected' : '' }}>Aerial (Udara/Tiang)</option>
                                    <option value="underground" {{ old('tipe_kabel', $backbone->tipe_kabel) == 'underground' ? 'selected' : '' }}>Underground (Tanam/Duct)</option>
                                    <option value="submarine" {{ old('tipe_kabel', $backbone->tipe_kabel) == 'submarine' ? 'selected' : '' }}>Submarine (Bawah Air)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Operasional</label>
                            <select name="status" id="status" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                <option value="aktif" {{ old('status', $backbone->status) == 'aktif' ? 'selected' : '' }}>Aktif (Normal)</option>
                                <option value="gangguan" {{ old('status', $backbone->status) == 'gangguan' ? 'selected' : '' }}>Gangguan (Cut/Loss)</option>
                                <option value="maintenance" {{ old('status', $backbone->status) == 'maintenance' ? 'selected' : '' }}>Maintenance (Perbaikan)</option>
                            </select>
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan / Catatan Tambahan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">{{ old('keterangan', $backbone->keterangan) }}</textarea>
                        </div>

                        <div class="pt-4 flex justify-end space-x-2">
                            <a href="{{ route('admin.network.backbones.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-600 dark:text-white rounded-lg transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg shadow-md transition">
                                <i class="fas fa-sync mr-2"></i>Update Backbone
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection