<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <div class="flex flex-col h-full">
        
        <!-- Logo -->
        <div class="flex items-center justify-center h-20 border-b border-slate-700">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-tr from-cyan-500 via-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">ShopAdmin</h1>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="p-4 border-b border-slate-700">
            <button id="profileBtn" class="w-full flex items-center space-x-3 p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-200">
                <div class="relative">
                    <img class="h-12 w-12 rounded-full border-2 border-cyan-500" 
                         src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=06b6d4&color=fff" 
                         alt="Profile">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-slate-900"></div>
                </div>
                <div class="flex-1 text-left">
                    <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-slate-400">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                </div>
                <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform" id="profileIcon"></i>
            </button>

            <!-- Profile Dropdown -->
            <div id="profileMenu" class="hidden mt-2 space-y-1 bg-slate-800/30 rounded-xl p-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-cyan-500/20 hover:text-cyan-400 rounded-lg transition-all">
                    <i class="fas fa-user w-4"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-cyan-500/20 hover:text-cyan-400 rounded-lg transition-all">
                    <i class="fas fa-cog w-4"></i>
                    <span>Pengaturan</span>
                </a>
                <div class="border-t border-slate-700 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/20 rounded-lg transition-all">
                        <i class="fas fa-sign-out-alt w-4"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-6">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-cyan-500/20 hover:to-blue-500/20 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-400' : '' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-cyan-500/20 transition-all">
                    <i class="fas fa-home"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Produk Section -->
            <div>
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Manajemen</p>

                <a href="{{ route('admin.products.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-purple-500/20 hover:to-pink-500/20 transition-all">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-purple-500/20 transition-all">
                        <i class="fas fa-box"></i>
                    </div>
                    <span class="font-medium">Produk</span>
                </a>
            </div>

            <!-- Pesanan Section -->
            <div>
                <button class="menu-btn group w-full flex items-center justify-between px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-orange-500/20 hover:to-red-500/20 transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-orange-500/20 transition-all">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="font-medium">Pesanan</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform submenu-icon"></i>
                </button>

                <div class="submenu hidden ml-4 mt-2 space-y-1 pl-10">
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-slate-400 hover:text-orange-400 hover:bg-orange-500/10 rounded-lg transition-all">
                        <i class="fas fa-circle text-xs"></i>
                        <span>Semua Pesanan</span>
                    </a>
                    <a href="{{ route('admin.orders.pending') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-slate-400 hover:text-orange-400 hover:bg-orange-500/10 rounded-lg transition-all">
                        <i class="fas fa-circle text-xs"></i>
                        <span>Pesanan Pending</span>
                    </a>
                </div>
            </div>

            <!-- Pelanggan Section -->
            <div>
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Data</p>
                <a href="{{ route('admin.customers.index') }}" class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-green-500/20 hover:to-emerald-500/20 transition-all">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-green-500/20 transition-all">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="font-medium">Pelanggan</span>
                </a>
            </div>

            <!-- Laporan Section -->
            <div>
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Laporan</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.reports.sales') }}" class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-indigo-500/20 transition-all">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-blue-500/20 transition-all">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="font-medium">Penjualan</span>
                    </a>
                    <a href="{{ route('admin.reports.inventory') }}" class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-yellow-500/20 hover:to-amber-500/20 transition-all">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-yellow-500/20 transition-all">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <span class="font-medium">Stok</span>
                    </a>
                </div>
            </div>

            <!-- Sistem Section -->
            <div>
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Sistem</p>
                <a href="{{ route('admin.settings') }}" class="group flex items-center space-x-3 px-4 py-3 text-slate-300 rounded-xl hover:bg-gradient-to-r hover:from-slate-600/20 hover:to-slate-500/20 transition-all">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 group-hover:bg-slate-600/20 transition-all">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </div>
        </nav>

        <!-- Footer Tips -->
        <div class="p-4 border-t border-slate-700">
            <div class="relative overflow-hidden bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 rounded-xl p-4 text-white">
                <div class="relative z-10">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-lightbulb text-yellow-300"></i>
                        <p class="text-sm font-bold">Tips Hari Ini</p>
                    </div>
                    <p class="text-xs opacity-90">Gunakan shortcut keyboard untuk navigasi lebih cepat!</p>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
            </div>
        </div>
    </div>
</aside>

<script>
// Profile Dropdown Toggle
document.getElementById('profileBtn')?.addEventListener('click', function() {
    const menu = document.getElementById('profileMenu');
    const icon = document.getElementById('profileIcon');
    menu?.classList.toggle('hidden');
    icon?.classList.toggle('rotate-180');
});

// Submenu Toggle
document.querySelectorAll('.menu-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const submenu = this.nextElementSibling;
        const icon = this.querySelector('.submenu-icon');
        
        document.querySelectorAll('.submenu').forEach(menu => {
            if (menu !== submenu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                const otherIcon = menu.previousElementSibling?.querySelector('.submenu-icon');
                if (otherIcon) otherIcon.classList.remove('rotate-180');
            }
        });
        
        submenu?.classList.toggle('hidden');
        icon?.classList.toggle('rotate-180');
    });
});

// Close sidebar on mobile when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (window.innerWidth < 1024 && sidebar && sidebarToggle) {
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    }
});
</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}

.submenu {
    transition: all 0.3s ease;
}

/* Custom Scrollbar */
#sidebar::-webkit-scrollbar {
    width: 6px;
}

#sidebar::-webkit-scrollbar-track {
    background: #1e293b;
}

#sidebar::-webkit-scrollbar-thumb {
    background: #475569;
    border-radius: 3px;
}

#sidebar::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
</style>