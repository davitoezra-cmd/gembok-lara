@extends('layouts.app')

@section('title', 'Detail Data Tiang')

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
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <a href="{{ route('admin.network.tiangs.index') }}" class="text-cyan-600 dark:text-cyan-400 hover:underline text-sm font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke List
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Detail Tiang: {{ $tiang->nomor_tiang }}</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.network.tiangs.edit', $tiang) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.network.tiangs.destroy', $tiang) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow transition">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6 max-w-2xl space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200 dark:border-slate-600">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Nomor / Kode Tiang</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $tiang->nomor_tiang }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Status Tiang</h3>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-2
                            {{ $tiang->status === 'baik' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                            {{ $tiang->status === 'miring' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                            {{ $tiang->status === 'rusak' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                            {{ ucfirst($tiang->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200 dark:border-slate-600">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Latitude</h3>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $tiang->latitude ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Longitude</h3>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $tiang->longitude ?? '-' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Lokasi Spesifik / Patokan</h3>
                    <p class="text-gray-900 dark:text-white mt-1 whitespace-pre-line">{{ $tiang->lokasi_spesifik }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection