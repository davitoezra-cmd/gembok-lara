<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Collector Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300"
      x-data="{
          sidebarOpen: false,
          isDark: localStorage.getItem('theme') === 'dark',
          toggleTheme() {
              this.isDark = !this.isDark;
              localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
              document.documentElement.classList.toggle('dark', this.isDark);
          }
      }">

    <div x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden"
        @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-50 w-64 h-screen bg-gradient-to-b from-slate-900 to-slate-800 dark:from-slate-950 dark:to-slate-900 transition-transform lg:translate-x-0">
        <div class="flex items-center justify-center h-16 border-b border-slate-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hand-holding-dollar text-white"></i>
                </div>
                <span class="text-xl font-bold text-white">Collector</span>
            </div>
        </div>

        <div class="p-4">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-4 text-white">
                <p class="text-blue-100 text-sm">Terkumpul Hari Ini</p>
                <p class="text-2xl font-bold">Rp {{ number_format($todayTotal ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('collector.dashboard') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('collector.dashboard') ? 'bg-slate-700 text-white' : '' }}">
                <i class="fas fa-home w-5 mr-3"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('collector.invoices') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('collector.invoices*') ? 'bg-slate-700 text-white' : '' }}">
                <i class="fas fa-file-invoice-dollar w-5 mr-3"></i><span>Tagihan</span>
            </a>
            <a href="{{ route('collector.collect') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('collector.collect*') ? 'bg-slate-700 text-white' : '' }}">
                <i class="fas fa-money-bill-wave w-5 mr-3"></i><span>Terima Pembayaran</span>
            </a>
            <a href="{{ route('collector.history') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('collector.history*') ? 'bg-slate-700 text-white' : '' }}">
                <i class="fas fa-history w-5 mr-3"></i><span>Riwayat</span>
            </a>
            <a href="{{ route('collector.profile') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('collector.profile*') ? 'bg-slate-700 text-white' : '' }}">
                <i class="fas fa-user-cog w-5 mr-3"></i><span>Profil</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
            <form action="{{ route('collector.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition">
                    <i class="fas fa-sign-out-alt w-5 mr-3"></i><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:ml-64">
        <header class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-200 dark:border-slate-700 sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center justify-between px-4 py-3">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center space-x-4">
                    @include('partials.theme-toggle')
                    <span class="text-gray-600 dark:text-gray-300">{{ Auth::user()->name ?? 'Collector' }}</span>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-dollar text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 lg:p-6">
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>