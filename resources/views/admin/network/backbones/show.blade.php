@extends('layouts.app')

@section('title', 'Detail Backbone - ' . $backbone->kode_backbone)

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
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Kabel Backbone</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Spesifikasi komprehensif alokasi core rute optik</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.network.backbones.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="{{ route('admin.network.backbones.edit', $backbone->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md overflow-hidden max-w-3xl">
                <div class="p-6 bg-gray-50 dark:bg-slate-600/50 border-b border-gray-100 dark:border-slate-600 flex items-center justify-between">
                    <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $backbone->kode_backbone }}</span>
                    
                    <div>
                        @if($backbone->status === 'aktif')
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                Aktif / Normal
                            </span>
                        @elseif($backbone->status === 'gangguan')
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                Gangguan (Cut)
                            </span>
                        @else
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">
                                Maintenance
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Nama Jalur / Rute</span>
                        <span class="text-lg font-medium text-gray-900 dark:text-white mt-1 block">{{ $backbone->nama_jalur }}</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Panjang Penggelaran</span>
                        <span class="text-base font-medium text-gray-900 dark:text-white mt-1 block">{{ $backbone->panjang_kabel }} Meter</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Tipe Kabel</span>
                        <span class="text-base font-medium text-gray-900 dark:text-white mt-1 block capitalize">{{ $backbone->tipe_kabel }}</span>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-600 pt-4">
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider mb-3">Statistik Penggunaan Core</span>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-800 border dark:border-slate-600 text-center">
                                <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">{{ $backbone->kapasitas_core }}</span>
                                <span class="text-xs text-gray-400 mt-0.5 block">Total Core</span>
                            </div>
                            <div class="p-4 rounded-lg bg-cyan-50 dark:bg-cyan-950/30 border border-cyan-100 dark:border-cyan-900/50 text-center">
                                <span class="block text-sm font-bold text-cyan-600 dark:text-cyan-400">{{ $backbone->core_terpakai }}</span>
                                <span class="text-xs text-cyan-500/80 mt-0.5 block">Terpakai</span>
                            </div>
                            <div class="p-4 rounded-lg bg-green-50 dark:bg-green-950/30 border border-green-100 dark:border-green-900/50 text-center">
                                <span class="block text-sm font-bold text-green-600 dark:text-green-400">{{ $backbone->core_tersedia }}</span>
                                <span class="text-xs text-green-500/80 mt-0.5 block">Tersedia</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-600 pt-4">
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Catatan Ruang / Keterangan Lapangan</span>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-800 border dark:border-slate-600 mt-2 text-sm text-gray-700 dark:text-gray-300">
                            @if($backbone->keterangan)
                                {{ $backbone->keterangan }}
                            @else
                                <span class="text-gray-400 italic">Tidak ada catatan lapangan tertulis untuk rute ini.</span>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-600 pt-4 grid grid-cols-2 gap-4 text-xs text-gray-400">
                        <div>
                            <span>Didaftarkan Pada:</span>
                            <span class="block font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $backbone->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div>
                            <span>Terakhir Diperbarui:</span>
                            <span class="block font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $backbone->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection