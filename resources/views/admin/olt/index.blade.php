@extends('layouts.app')

@section('title', 'OLT Management')

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
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">OLT Management</h1>
                    <p class="text-gray-600 dark:text-gray-400">Monitor dan kelola perangkat OLT & ONU</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.olt.onu.index') }}" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition">
                        <i class="fas fa-list mr-2"></i>Semua ONU
                    </a>
                    <a href="{{ route('admin.olt.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah OLT
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                @php
                    $statsCards = [
                        ['label' => 'OLTs', 'value' => $stats['total_olts'], 'icon' => 'fa-server', 'color' => 'blue'],
                        ['label' => 'Online', 'value' => $stats['online_onus'], 'icon' => 'fa-check-circle', 'color' => 'green'],
                        ['label' => 'DyingGasp', 'value' => $stats['dyinggasp_onus'], 'icon' => 'fa-bolt', 'color' => 'orange'],
                        ['label' => 'LOS', 'value' => $stats['los_onus'], 'icon' => 'fa-times-circle', 'color' => 'red'],
                        ['label' => 'Offline', 'value' => $stats['offline_onus'], 'icon' => 'fa-power-off', 'color' => 'gray']
                    ];
                @endphp
                
                @foreach($statsCards as $card)
                <div class="bg-white dark:bg-slate-700 rounded-xl shadow-sm p-4 border border-gray-100 dark:border-slate-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $card['value'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @foreach($olts as $olt)
            <div class="bg-white dark:bg-slate-700 rounded-xl shadow-sm border border-gray-100 dark:border-slate-600 overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-server text-white text-2xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $olt->name }}</h3>
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $olt->status == 'online' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($olt->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $olt->brand }} {{ $olt->model }}</p>
                                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-clock mr-1"></i>{{ $olt->uptime ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($olt->temperature)
                            <div class="text-right mr-4">
                                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $olt->temperature }}°C</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Temperature</p>
                            </div>
                            @endif
                            <a href="{{ route('admin.olt.show', $olt) }}" class="p-2 text-gray-500 hover:text-cyan-600 dark:text-gray-400 dark:hover:text-cyan-400 rounded-lg">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.olt.edit', $olt) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 rounded-lg">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mt-6">
                        @php
                            $onuStats = [
                                ['label' => 'Total Port', 'val' => $olt->total_pon_ports, 'bg' => 'gray'],
                                ['label' => 'Total ONU', 'val' => $olt->total_onus, 'bg' => 'gray'],
                                ['label' => 'Online', 'val' => $olt->online_onus, 'bg' => 'green'],
                                ['label' => 'LOS', 'val' => $olt->los_onus, 'bg' => 'red'],
                                ['label' => 'DyingGasp', 'val' => $olt->dyinggasp_onus, 'bg' => 'orange'],
                                ['label' => 'Offline', 'val' => $olt->offline_onus, 'bg' => 'gray'],
                            ];
                        @endphp
                        @foreach($onuStats as $stat)
                        <div class="text-center p-3 bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stat['val'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection