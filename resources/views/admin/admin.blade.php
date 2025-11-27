<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Include Sidebar -->
        @include('admin.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64 transition-all duration-300">
            
            <!-- Top Header -->
            <header class="bg-white/80 backdrop-blur-lg shadow-sm z-10 border-b border-slate-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="text-slate-600 hover:text-slate-900 focus:outline-none lg:hidden mr-4">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">Dashboard</h1>
                            <p class="text-sm text-slate-500">Selamat datang kembali! ✨</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-lg">3</span>
                        </button>
                        
                        <div class="relative">
                            <img class="h-11 w-11 rounded-xl border-2 border-cyan-500 shadow-md" 
                                 src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=06b6d4&color=fff" 
                                 alt="Admin">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-800 mb-2">Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
                    <p class="text-slate-600">Berikut adalah ringkasan performa bisnis Anda</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    <!-- Card 1 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl p-6 transform hover:-translate-y-1 transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-box text-white text-2xl"></i>
                                </div>
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">+12%</span>
                            </div>
                            <p class="text-slate-500 text-sm mb-1">Total Produk</p>
                            <h3 class="text-3xl font-bold text-slate-800">2,215</h3>
                            <div class="mt-4 flex items-center text-xs text-green-600">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>Meningkat dari bulan lalu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl p-6 transform hover:-translate-y-1 transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-dollar-sign text-white text-2xl"></i>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">+8%</span>
                            </div>
                            <p class="text-slate-500 text-sm mb-1">Total Penjualan</p>
                            <h3 class="text-3xl font-bold text-slate-800">Rp 70M</h3>
                            <div class="mt-4 flex items-center text-xs text-green-600">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>Meningkat dari bulan lalu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl p-6 transform hover:-translate-y-1 transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                                </div>
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">-3%</span>
                            </div>
                            <p class="text-slate-500 text-sm mb-1">Pesanan Baru</p>
                            <h3 class="text-3xl font-bold text-slate-800">123</h3>
                            <div class="mt-4 flex items-center text-xs text-red-600">
                                <i class="fas fa-arrow-down mr-1"></i>
                                <span>Menurun dari bulan lalu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl p-6 transform hover:-translate-y-1 transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">+15%</span>
                            </div>
                            <p class="text-slate-500 text-sm mb-1">Pelanggan</p>
                            <h3 class="text-3xl font-bold text-slate-800">912</h3>
                            <div class="mt-4 flex items-center text-xs text-green-600">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>Meningkat dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Recent Orders -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Sales Chart -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">Grafik Penjualan</h3>
                                <p class="text-sm text-slate-500">Performa 6 bulan terakhir</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 text-sm bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl font-semibold shadow-md">Bulan</button>
                                <button class="px-4 py-2 text-sm bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors">Tahun</button>
                            </div>
                        </div>
                        <div style="position: relative; height: 300px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-800">Pesanan Terbaru</h3>
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100 hover:shadow-md transition-all">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">#ORD-001</p>
                                        <p class="text-xs text-slate-500">Nur Hidayatulloh</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-green-500 text-white shadow-sm">Selesai</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border border-yellow-100 hover:shadow-md transition-all">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">#ORD-002</p>
                                        <p class="text-xs text-slate-500">Nabilal Karom</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-yellow-500 text-white shadow-sm">Proses</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100 hover:shadow-md transition-all">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">#ORD-003</p>
                                        <p class="text-xs text-slate-500">Ahmad Mustafa</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-500 text-white shadow-sm">Dikirim</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-100 hover:shadow-md transition-all">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-gradient-to-br from-red-400 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">#ORD-004</p>
                                        <p class="text-xs text-slate-500">Saka Alief</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-red-500 text-white shadow-sm">Pending</span>
                            </div>
                        </div>

                        <button class="w-full mt-5 py-3 text-sm bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-bold hover:from-cyan-600 hover:to-blue-600 rounded-xl shadow-md transition-all">
                            Lihat Semua Pesanan →
                        </button>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        const ctx = document.getElementById('salesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Penjualan (Juta)',
                        data: [12, 19, 15, 25, 22, 30],
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 6,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>