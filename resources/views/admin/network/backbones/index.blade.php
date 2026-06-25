@extends('layouts.app')

@section('title', 'Backbone List')

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
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Kabel Backbone</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola jalur kabel utama, kapasitas core, dan status jaringan backbone</p>
                </div>
                <a href="{{ route('admin.network.backbones.create') }}" class="bg-cyan-600 text-white px-6 py-3 rounded-lg hover:bg-cyan-700 transition transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Backbone
                </a>
            </div>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-r-lg">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                        <thead class="bg-gray-50 dark:bg-slate-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Kode Backbone</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nama Jalur</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Penggunaan Core</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Panjang / Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-700 divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($backbones as $backbone)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-600 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-cyan-600 dark:text-cyan-400">{{ $backbone->kode_backbone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $backbone->nama_jalur }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $backbone->core_terpakai }}</span> / {{ $backbone->kapasitas_core }} Core
                                            <span class="text-xs text-gray-400 dark:text-gray-500 block">(Sisa: {{ $backbone->core_tersedia }} Core)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $backbone->panjang_kabel }} m</div>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 capitalize">{{ $backbone->tipe_kabel }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($backbone->status === 'aktif')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                                Aktif
                                            </span>
                                        @elseif($backbone->status === 'gangguan')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                                Gangguan
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">
                                                Maintenance
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.network.backbones.show', $backbone->id) }}" class="text-cyan-600 hover:text-cyan-800" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.network.backbones.edit', $backbone->id) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-500" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="delete-backbone-{{ $backbone->id }}" action="{{ route('admin.network.backbones.destroy', $backbone->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('delete-backbone-{{ $backbone->id }}', '{{ $backbone->kode_backbone }}')" class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-exclamation-circle text-4xl mb-4 text-gray-300 dark:text-slate-500"></i>
                                        <p>Tidak ada data jalur backbone saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($backbones->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700">
                    {{ $backbones->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(formId, identifier) {
    if (confirm("Apakah Anda yakin ingin menghapus data backbone dengan kode '" + identifier + "'?")) {
        document.getElementById(formId).submit();
    }
}
</script>
@endsection