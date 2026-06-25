@extends('layouts.app')

@section('title', 'Detail Modem - ' . $modem->nomor_aset_internal)

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
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Perangkat Modem</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap spesifikasi dan penempatan unit aset</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.network.modems.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="{{ route('admin.network.modems.edit', $modem->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md overflow-hidden max-w-3xl">
                <div class="p-6 bg-gray-50 dark:bg-slate-600/50 border-b border-gray-100 dark:border-slate-600 flex items-center justify-between">
                    <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $modem->nomor_aset_internal }}</span>
                    
                    <div>
                        @if($modem->status === 'stok_gudang')
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900/50 dark:text-cyan-400">
                                Stok Gudang
                            </span>
                        @elseif($modem->status === 'terpasang')
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                Terpasang
                            </span>
                        @else
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                Rusak
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Serial Number (SN)</span>
                        <span class="text-base font-mono font-medium text-gray-900 dark:text-white mt-1 block">{{ $modem->serial_number }}</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider">Merek Perangkat</span>
                        <span class="text-base font-medium text-gray-900 dark:text-white mt-1 block">{{ $modem->merek }}</span>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-600 pt-4">
                        <span class="block text-xs font-semibold uppercase text-gray-400 tracking-wider mb-2">Informasi Alokasi Pengguna</span>
                        @if($modem->customer)
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-800 border dark:border-slate-600 flex items-start space-x-3">
                                <div class="bg-cyan-100 dark:bg-cyan-900/30 p-2.5 rounded-md text-cyan-600 dark:text-cyan-400">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $modem->customer->name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">ID Customer: #{{ $modem->customer->id }}</p>
                                </div>
                            </div>
                        @else
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-800 border dark:border-slate-600 border-dashed text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-warehouse text-2xl mb-2 text-gray-300 dark:text-slate-600"></i>
                                <p class="text-xs italic">Modem ini saat ini idle dan tersimpan di dalam stok gudang utama.</p>
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-600 pt-4 grid grid-cols-2 gap-4 text-xs text-gray-400">
                        <div>
                            <span>Didaftarkan Pada:</span>
                            <span class="block font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $modem->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div>
                            <span>Terakhir Diperbarui:</span>
                            <span class="block font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $modem->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection