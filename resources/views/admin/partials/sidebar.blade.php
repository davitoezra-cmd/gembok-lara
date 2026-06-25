<div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-blue-900 to-cyan-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <div class="flex items-center justify-center h-16 bg-black bg-opacity-30 border-b border-cyan-500/20">
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                <i class="fas fa-network-wired text-white"></i>
            </div>
            <span class="text-white font-bold text-xl tracking-wide">{{ companyName() }}</span>
        </div>
    </div>

    <nav class="mt-4 px-4 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 180px);">
        
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2 mt-2">Main Menu</p>
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-home w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        
        <div x-data="{ openCustomers: {{ request()->routeIs('admin.customers.*') ? 'true' : 'false' }} }">
            <button @click="openCustomers = !openCustomers" 
                class="flex items-center w-full px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.customers.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                <i class="fas fa-users w-5 mr-3"></i>
                <span>Customers</span>
                <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="openCustomers ? 'rotate-180' : ''"></i>
            </button>
            
            <div x-show="openCustomers" x-cloak class="mt-1 ml-4 pl-4 border-l border-cyan-500/30 space-y-1">
                <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg">All Customers</a>
                <a href="{{ route('admin.customers.index', ['status' => 'active']) }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg">Active</a>
                <a href="{{ route('admin.customers.index', ['status' => 'inactive']) }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg">Inactive</a>
                <a href="{{ route('admin.customers.index', ['status' => 'suspended']) }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg">Suspended</a>
            </div>
        </div>
        
        <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.packages.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-box w-5 mr-3"></i>
            <span>Packages</span>
        </a>
        
        <a href="{{ route('admin.invoices.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.invoices.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-file-invoice w-5 mr-3"></i>
            <span>Invoices</span>
        </a>
        
        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-shopping-cart w-5 mr-3"></i>
            <span>Orders</span>
            @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count() ?? 0; @endphp
            @if($pendingOrders > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
            @endif
        </a>

        <a href="{{ route('admin.expenses.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.expenses.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-wallet w-5 mr-3"></i>
            <span>Expenses</span>
        </a>

        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Staff</p>
        
        <a href="{{ route('admin.technicians.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.technicians.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-tools w-5 mr-3"></i>
            <span>Technicians</span>
        </a>
        
        <a href="{{ route('admin.collectors.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.collectors.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-hand-holding-usd w-5 mr-3"></i>
            <span>Collectors</span>
        </a>
        
        <a href="{{ route('admin.agents.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.agents.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-user-tie w-5 mr-3"></i>
            <span>Agents</span>
        </a>
        
        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Network</p>
        
        <a href="{{ route('admin.olt.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.olt.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-broadcast-tower w-5 mr-3"></i>
            <span>OLT Management</span>
        </a>
        
        <a href="{{ route('admin.vouchers.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.vouchers.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-ticket-alt w-5 mr-3"></i>
            <span>Vouchers</span>
        </a>
        
        <a href="{{ route('admin.network.odps.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.network.odps.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-project-diagram w-5 mr-3"></i>
            <span>ODP Management</span>
        </a>
        
        <a href="{{ route('admin.network.map') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.network.map') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-map-marked-alt w-5 mr-3"></i>
            <span>Network Map</span>
        </a>

        <a href="{{ route('admin.network.tiangs.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.network.tiangs.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-heading w-5 mr-3"></i>
            <span>Tiang Management</span>
        </a>

        <a href="{{ route('admin.network.modems.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.network.modems.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-hdd w-5 mr-3"></i>
            <span>Modem Management</span>
        </a>

        <a href="{{ route('admin.network.backbones.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.network.backbones.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-route w-5 mr-3"></i>
            <span>Backbone Management</span>
        </a>
        
        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Services</p>
        
        <a href="{{ route('admin.mikrotik.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.mikrotik.index') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-server w-5 mr-3"></i>
            <span>Mikrotik</span>
        </a>
        
        <a href="{{ route('admin.mikrotik.sync.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.mikrotik.sync.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-sync-alt w-5 mr-3"></i>
            <span>Mikrotik Sync</span>
        </a>
        
        <a href="{{ route('admin.radius.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.radius.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-shield-alt w-5 mr-3"></i>
            <span>RADIUS</span>
        </a>
        
        <a href="{{ route('admin.cpe.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.cpe.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-wifi w-5 mr-3"></i>
            <span>CPE / ONU</span>
        </a>
        
        <a href="{{ route('admin.snmp.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.snmp.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-chart-line w-5 mr-3"></i>
            <span>SNMP Monitor</span>
        </a>
        
        <a href="{{ route('admin.ip-monitor.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.ip-monitor.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-network-wired w-5 mr-3"></i>
            <span>IP Monitor</span>
            @php $downIps = \App\Models\IpMonitor::active()->down()->count() ?? 0; @endphp
            @if($downIps > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $downIps }}</span>
            @endif
        </a>
        
        <a href="{{ route('admin.whatsapp.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.whatsapp.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fab fa-whatsapp w-5 mr-3"></i>
            <span>WhatsApp</span>
        </a>
        
        <a href="{{ route('admin.payment.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.payment.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-credit-card w-5 mr-3"></i>
            <span>Payment Gateway</span>
        </a>

        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Reports</p>
        
        <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.reports.index') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-chart-bar w-5 mr-3"></i>
            <span>Overview</span>
        </a>
        
        <a href="{{ route('admin.reports.daily') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.reports.daily') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-calendar-day w-5 mr-3"></i>
            <span>Daily Report</span>
        </a>
        
        <a href="{{ route('admin.reports.monthly') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.reports.monthly') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-calendar-alt w-5 mr-3"></i>
            <span>Monthly Report</span>
        </a>
        
        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Support</p>

        <div x-data="{ openTickets: {{ request()->routeIs('admin.ticket_gangguan.*') || request()->routeIs('admin.tickets.*') ? 'true' : 'false' }} }">
            <button @click="openTickets = !openTickets" 
                class="flex items-center w-full px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.ticket_gangguan.*') || request()->routeIs('admin.tickets.*') ? 'true font-semibold' : '' }}">
                <i class="fas fa-headset w-5 mr-3 flex-shrink-0"></i>
                <span class="truncate text-left flex-1 text-sm">Ticket Management</span>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 ml-2 flex-shrink-0" :class="openTickets ? 'rotate-180' : ''"></i>
            </button>
            
            <div x-show="openTickets" x-cloak class="mt-1 ml-4 pl-4 border-l border-cyan-500/30 space-y-1">
                <a href="{{ route('admin.ticket_gangguan.index') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg {{ request()->routeIs('admin.ticket_gangguan.*') ? 'text-white font-semibold' : '' }}">Tiket Gangguan</a>
                <a href="{{ route('admin.tickets.index') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg {{ request()->routeIs('admin.tickets.*') ? 'text-white font-semibold' : '' }}">Tiket Umum</a>
            </div>
        </div>

        <div class="border-t border-cyan-500/20 my-3"></div>
        <p class="px-4 text-xs text-cyan-300/60 uppercase tracking-wider mb-2">Settings</p>
        
        <a href="{{ route('admin.settings.integrations') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.settings.integrations') || request()->routeIs('admin.settings.mikrotik*') || request()->routeIs('admin.settings.radius*') || request()->routeIs('admin.settings.genieacs*') || request()->routeIs('admin.settings.whatsapp*') || request()->routeIs('admin.settings.midtrans*') || request()->routeIs('admin.settings.xendit*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-plug w-5 mr-3"></i>
            <span>Integrasi</span>
        </a>
        
        <a href="{{ route('admin.api-docs') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.api-docs') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-code w-5 mr-3"></i>
            <span>API Docs</span>
        </a>
        
        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition {{ request()->routeIs('admin.settings') && !request()->is('admin/settings/*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
            <i class="fas fa-cog w-5 mr-3"></i>
            <span>General</span>
        </a>
    </nav>

    <div class="absolute bottom-0 w-full p-4 bg-gradient-to-t from-slate-900 to-transparent">
        <div class="flex space-x-2">
            <a href="{{ route('admin.change-password') }}" class="flex-1 flex items-center justify-center px-3 py-2 text-gray-300 hover:bg-white hover:bg-opacity-10 rounded-lg transition text-sm">
                <i class="fas fa-key mr-2"></i>Password
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition text-sm">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>