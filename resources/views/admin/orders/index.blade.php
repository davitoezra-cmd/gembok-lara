@extends('layouts.app')

@section('title', 'Kelola Pesanan')

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
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Kelola Pesanan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Daftar pesanan dari landing page</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                            <i class="fas fa-check text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['confirmed'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Dikonfirmasi</p>
                        </div>
                    </div>
                </div>
                <div class="bg-cyan-50 dark:bg-cyan-900/20 rounded-xl p-4 border border-cyan-200 dark:border-cyan-800">
                    <div class="flex items-center">
                        <div class="p-2 bg-cyan-100 dark:bg-cyan-900/50 rounded-lg">
                            <i class="fas fa-tools text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $stats['installing'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemasangan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg">
                            <i class="fas fa-check-double text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['completed'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari order/nama/telepon..."
                        class="px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500 w-64">
                    <select name="status" class="px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="installing" {{ request('status') == 'installing' ? 'selected' : '' }}>Pemasangan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <select name="payment_status" class="px-4 py-2 border border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white rounded-lg focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Pembayaran</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    <button type="submit" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 dark:bg-slate-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-slate-500">Reset</a>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Order</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Paket</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Pembayaran</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($orders as $order)
                            @php 
                                $badge = $order->status_badge;
                                $payBadge = $order->payment_status_badge;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-600">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-cyan-600 hover:underline font-medium">{{ $order->order_number }}</a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->customer_phone }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-900 dark:text-white">{{ $order->package->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ strtoupper($order->connection_type) }}</p>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $payBadge['color'] }}-100 text-{{ $payBadge['color'] }}-800">{{ $payBadge['label'] }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $badge['color'] }}-100 text-{{ $badge['color'] }}-800">{{ $badge['label'] }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-cyan-600 hover:text-cyan-800" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($order->payment_status === 'pending')
                                        <button onclick="confirmPayment({{ $order->id }})" class="text-green-600 hover:text-green-800" title="Konfirmasi Bayar">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300 dark:text-slate-500"></i>
                                    <p>Belum ada pesanan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-slate-600 dark:bg-slate-700">{{ $orders->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmPayment(orderId) {
    Swal.fire({
        title: 'Konfirmasi Pembayaran?',
        text: 'Apakah Anda yakin ingin mengkonfirmasi pembayaran pesanan ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0891b2',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Konfirmasi!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading('Memproses...');
            fetch(`/admin/orders/${orderId}/confirm-payment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => location.reload());
                } else {
                    showError(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(err => {
                Swal.close();
                showError('Terjadi kesalahan jaringan');
            });
        }
    });
}
</script>
@endpush
@endsection