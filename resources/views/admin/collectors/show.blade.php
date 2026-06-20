@extends('layouts.app')

@section('title', 'Collector Details')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-slate-800 transition-colors duration-300" 
     x-data="{ 
         sidebarOpen: false, 
         isDark: localStorage.getItem('theme') === 'dark' 
     }">
    @include('admin.partials.sidebar')

    <div class="lg:pl-64">
        @include('admin.partials.topbar')

        <div class="p-6">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.collectors.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $collector->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Collector Details</p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.collectors.edit', $collector) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition shadow-md">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Collector Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $collector->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $collector->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $collector->email ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Commission Rate</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $collector->commission_rate ?? 0 }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                <span class="px-3 py-1 text-sm rounded-full {{ $collector->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($collector->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Area Coverage</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $collector->area_coverage ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-md p-6 text-white">
                        <h3 class="text-lg font-semibold mb-4">Collection Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Total Collected</span>
                                <span class="font-bold">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span>This Month</span>
                                <span class="font-bold">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Commission Earned</span>
                                <span class="font-bold">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-slate-700 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Collections</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Invoice</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Commission</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($collector->payments ?? [] as $payment)
                            <tr>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $payment->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $payment->invoice->customer->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $payment->invoice->invoice_number ?? '-' }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-green-600 dark:text-green-400">Rp {{ number_format($payment->commission ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No collections yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection