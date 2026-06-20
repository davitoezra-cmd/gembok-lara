@extends('layouts.app')

@section('title', 'Edit OLT - ' . $olt->name)

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
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit OLT</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ $olt->name }}</p>
                    </div>
                    <a href="{{ route('admin.olt.show', $olt) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-700 rounded-xl shadow-sm border border-gray-100 dark:border-slate-600 p-6">
                    <form action="{{ route('admin.olt.update', $olt) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama OLT</label>
                                <input type="text" name="name" value="{{ old('name', $olt->name) }}" required
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                                <select name="brand" required class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                                    @foreach(['ZTE', 'Huawei', 'FiberHome', 'Nokia', 'BDCOM', 'V-SOL', 'Other'] as $brand)
                                    <option value="{{ $brand }}" {{ old('brand', $olt->brand) == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Model</label>
                                <input type="text" name="model" value="{{ old('model', $olt->model) }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IP Address</label>
                                <input type="text" name="ip_address" value="{{ old('ip_address', $olt->ip_address) }}" required
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                                    <option value="online" {{ $olt->status == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="offline" {{ $olt->status == 'offline' ? 'selected' : '' }}>Offline</option>
                                    <option value="maintenance" {{ $olt->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>

                            <div class="col-span-2 border-t pt-4 mt-2 dark:border-slate-600">
                                <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-4">SNMP Configuration</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SNMP Community</label>
                                <input type="text" name="snmp_community" value="{{ old('snmp_community', $olt->snmp_community) }}" required
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SNMP Port</label>
                                <input type="number" name="snmp_port" value="{{ old('snmp_port', $olt->snmp_port) }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div class="col-span-2 border-t pt-4 mt-2 dark:border-slate-600">
                                <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-4">Telnet Configuration</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telnet Username</label>
                                <input type="text" name="telnet_username" value="{{ old('telnet_username', $olt->telnet_username) }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telnet Password</label>
                                <input type="password" name="telnet_password" placeholder="Kosongkan jika tidak diubah"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi</label>
                                <input type="text" name="location" value="{{ old('location', $olt->location) }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                                <textarea name="description" rows="2"
                                    class="w-full rounded-lg border-gray-300 dark:border-slate-500 dark:bg-slate-600 dark:text-white shadow-sm focus:ring-cyan-500 focus:border-cyan-500">{{ old('description', $olt->description) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t dark:border-slate-600">
                            <a href="{{ route('admin.olt.show', $olt) }}" class="px-4 py-2 border border-gray-300 dark:border-slate-500 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition">
                                <i class="fas fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-600">
                        <form action="{{ route('admin.olt.destroy', $olt) }}" method="POST" onsubmit="return confirm('Yakin hapus OLT ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-medium">
                                <i class="fas fa-trash mr-1"></i>Hapus Perangkat OLT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection