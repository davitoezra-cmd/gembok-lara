@extends('layouts.app')

@section('title', 'Modem List')

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
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Modem</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola dan pantau seluruh stok serta penempatan perangkat modem</p>
                </div>
                <a href="{{ route('admin.network.modems.create') }}" class="bg-cyan-600 text-white px-6 py-3 rounded-lg hover:bg-cyan-700 transition transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Modem
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
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No. Aset Internal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Serial Number (SN)</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Merek</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Pengguna / Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-700 divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($modems as $modem)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-600 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-cyan-600 dark:text-cyan-400">{{ $modem->nomor_aset_internal }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-mono text-gray-600 dark:text-gray-300">{{ $modem->serial_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $modem->merek }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            @if($modem->customer)
                                                <i class="fas fa-user mr-1 text-xs text-gray-400"></i> {{ $modem->customer->name }}
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 italic">Belum terpakai</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($modem->status === 'stok_gudang')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900/50 dark:text-cyan-400">
                                                Stok Gudang
                                            </span>
                                        @elseif($modem->status === 'terpasang')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                                Terpasang
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                                Rusak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.network.modems.show', $modem->id) }}" class="text-cyan-600 hover:text-cyan-800" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.network.modems.edit', $modem->id) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-500" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="delete-modem-{{ $modem->id }}" action="{{ route('admin.network.modems.destroy', $modem->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('delete-modem-{{ $modem->id }}', '{{ $modem->nomor_aset_internal }}')" class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400" title="Hapus">
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
                                        <p>Tidak ada data modem perangkat saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($modems->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700">
                    {{ $modems->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(formId, identifier) {
    if (confirm("Apakah Anda yakin ingin menghapus data modem dengan nomor aset '" + identifier + "'?")) {
        document.getElementById(formId).submit();
    }
}
</script>
@endsection