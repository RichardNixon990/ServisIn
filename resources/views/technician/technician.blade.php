@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/technician/technician.css') }}">

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 animate-fade-in">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Dashboard Teknisi</h1>
                    <p class="text-gray-600">Pesanan menunggu untuk diambil dan dikerjakan</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white px-4 py-2 rounded-xl shadow-md border border-gray-100">
                        <div class="flex items-center text-gray-600">
                            <i data-feather="clock" class="w-4 h-4 mr-2 text-blue-600"></i>
                            <span class="text-sm font-medium" id="currentTime"></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <div
                    class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-slide-up relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <i data-feather="inbox" class="w-7 h-7"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-blue-400 bg-opacity-30 rounded-full text-xs font-bold backdrop-blur-sm">Live</span>
                        </div>
                        <p class="text-sm opacity-90 mb-1 font-medium">Pesanan Tersedia</p>
                        <h3 class="text-4xl font-black mb-1">{{ $stats['available'] ?? 8 }}</h3>
                        <p class="text-xs opacity-75">Menunggu diambil</p>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-slide-up relative overflow-hidden group"
                    style="animation-delay: 0.1s">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <i data-feather="tool" class="w-7 h-7"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-amber-400 bg-opacity-30 rounded-full text-xs font-bold backdrop-blur-sm">Active</span>
                        </div>
                        <p class="text-sm opacity-90 mb-1 font-medium">Sedang Dikerjakan</p>
                        <h3 class="text-4xl font-black mb-1">{{ $stats['active'] ?? 5 }}</h3>
                        <p class="text-xs opacity-75">Pesanan aktif</p>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-slide-up relative overflow-hidden group"
                    style="animation-delay: 0.2s">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <i data-feather="check-circle" class="w-7 h-7"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-green-400 bg-opacity-30 rounded-full text-xs font-bold backdrop-blur-sm">Today</span>
                        </div>
                        <p class="text-sm opacity-90 mb-1 font-medium">Selesai Hari Ini</p>
                        <h3 class="text-4xl font-black mb-1">{{ $stats['completed'] ?? 12 }}</h3>
                        <p class="text-xs opacity-75">Total completed</p>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-slide-up relative overflow-hidden group"
                    style="animation-delay: 0.2s">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <i data-feather="award" class="w-7 h-7"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-blue-400 bg-opacity-30 rounded-full text-xs font-bold backdrop-blur-sm">Total</span>
                        </div>
                        <p class="text-sm opacity-90 mb-1 font-medium">Total Diselesaikan</p>
                        <h3 class="text-4xl font-black mb-1">{{ $stats['total_completed'] }}</h3>
                        <p class="text-xs opacity-75">Sepanjang waktu</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 border border-gray-100 animate-fade-in">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center text-gray-700 font-semibold">
                        <i data-feather="filter" class="w-5 h-5 mr-2 text-blue-600"></i>
                        <span class="text-sm">Filter Perangkat:</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="filterDevice('all')"
                            class="device-filter-btn active px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-blue-600 text-white shadow-md"
                            data-device="all">
                            <i data-feather="list" class="w-4 h-4 inline-block mr-1"></i>Semua
                        </button>
                        <button onclick="filterDevice('hp')"
                            class="device-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-device="hp">
                            <i data-feather="smartphone" class="w-4 h-4 inline-block mr-1"></i>HP
                        </button>
                        <button onclick="filterDevice('tablet')"
                            class="device-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-device="tablet">
                            <i data-feather="tablet" class="w-4 h-4 inline-block mr-1"></i>Tablet
                        </button>
                        <button onclick="filterDevice('laptop')"
                            class="device-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-device="laptop">
                            <i data-feather="monitor" class="w-4 h-4 inline-block mr-1"></i>Laptop
                        </button>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8" id="ordersContainer">
                @foreach ($orders as $order)
                    <div class="order-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-scale-in group"
                        data-device="{{ $order->device_type }}" style="animation-delay: {{ $loop->index * 0.1 }}s">

                        
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div
                                            class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm border-2 border-white/30 group-hover:scale-110 transition-transform duration-300">
                                            @php
                                                $deviceIcons = [
                                                    'hp' => 'smartphone',
                                                    'tablet' => 'tablet',
                                                    'laptop' => 'monitor',
                                                ];
                                                $iconName = $deviceIcons[$order->device_type] ?? 'smartphone';
                                            @endphp
                                            <i data-feather="{{ $iconName }}" class="text-white w-7 h-7"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-bold text-lg capitalize">
                                                {{ $order->device_type }}
                                            </h3>
                                            <p class="text-blue-100 text-sm font-medium">{{ $order->brand }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <span
                                            class="px-3 py-1.5 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full shadow-lg animate-pulse">
                                            <i data-feather="clock" class="w-3 h-3 inline-block mr-1"></i>Menunggu
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="p-6 space-y-4">
                            
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="alert-circle" class="w-4 h-4 text-red-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Deskripsi Kerusakan</h4>
                                </div>
                                <div
                                    class="bg-gradient-to-br from-red-50 to-orange-50 p-4 rounded-xl border-l-4 border-red-400 shadow-sm">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $order->issue_description }}
                                    </p>
                                </div>
                            </div>

                            
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="tool" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Estimasi Sparepart & Biaya</h4>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-xl border border-blue-200 shadow-sm space-y-3">
                                    
                                    @if ($order->listKerusakan && $order->listKerusakan->count() > 0)
                                        <div class="space-y-2">
                                            @foreach ($order->listKerusakan as $item)
                                                <div
                                                    class="flex items-center justify-between p-2.5 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                                                    <div class="flex items-center flex-1 min-w-0">
                                                        <div
                                                            class="w-2 h-2 bg-blue-500 rounded-full mr-2.5 flex-shrink-0">
                                                        </div>
                                                        <span
                                                            class="text-sm font-medium text-gray-700 truncate">{{ $item->nama_barang }}</span>
                                                    </div>
                                                    <span class="text-sm font-bold text-blue-700 ml-3 flex-shrink-0">
                                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>

                                        
                                        <div class="pt-2 border-t-2 border-blue-200">
                                            <div
                                                class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg">
                                                <span class="text-sm font-bold text-white flex items-center">
                                                    <i data-feather="calculator" class="w-4 h-4 mr-2"></i>
                                                    Total Estimasi
                                                </span>
                                                <span class="text-base font-black text-white">
                                                    Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>

                                        
                                        <div
                                            class="flex items-start gap-2 p-2.5 bg-blue-50 rounded-lg border border-blue-200">
                                            <i data-feather="info" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"></i>
                                            <p class="text-xs text-blue-700 leading-relaxed">
                                                <span class="font-semibold">Estimasi awal:</span> Biaya dapat berubah
                                                setelah pemeriksaan detail
                                            </p>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center p-4 bg-white rounded-lg">
                                            <i data-feather="alert-circle" class="w-4 h-4 text-gray-400 mr-2"></i>
                                            <span class="text-sm text-gray-500 italic">Estimasi sparepart belum
                                                tersedia</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-200 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                        <i data-feather="calendar" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-blue-600 mb-0.5">Jadwal Servis</p>
                                        <p class="text-sm font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($order->schedule_date)->isoFormat('dddd, D MMMM Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs font-bold whitespace-nowrap ml-2">
                                    {{ \Carbon\Carbon::parse($order->schedule_date)->diffForHumans() }}
                                </div>
                            </div>

                            
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="user" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Informasi Konsumen</h4>
                                </div>
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200 shadow-sm space-y-3">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                            <span
                                                class="text-white text-sm font-bold">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800">{{ $order->user->name }}</p>
                                    </div>
                                    <a href="{{ 'https://wa.me/+62' . ltrim($order->user->phone, 0) }}" target="blank"
                                        class="flex items-center justify-between p-3 bg-white rounded-lg hover:bg-purple-100 transition-colors group">
                                        <div class="flex items-center">
                                            <i data-feather="phone" class="w-4 h-4 text-purple-600 mr-2"></i>
                                            <span
                                                class="text-sm font-semibold text-gray-700">{{ $order->user->phone }}</span>
                                        </div>
                                        <i data-feather="external-link"
                                            class="w-4 h-4 text-gray-400 group-hover:text-purple-600 transition-colors"></i>
                                    </a>
                                </div>
                            </div>

                            
                            <div>
                                <div class="flex items-start mb-2">
                                    <div
                                        class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                        <i data-feather="map-pin" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Alamat Lengkap</h4>
                                </div>
                                <div
                                    class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200 shadow-sm">
                                    <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ $order->address }}</p>
                                    <a href="https://maps.google.com/?q={{ urlencode($order->address) }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center text-xs font-semibold text-green-700 hover:text-green-800 bg-white px-3 py-2 rounded-lg hover:shadow-md transition-all">
                                        <i data-feather="navigation" class="w-3 h-3 mr-1.5"></i>
                                        Buka di Google Maps
                                        <i data-feather="external-link" class="w-3 h-3 ml-1"></i>
                                    </a>
                                </div>
                            </div>

                            
                            @if ($order->photo)
                                <div>
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                            <i data-feather="image" class="w-4 h-4 text-indigo-600"></i>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-800">Foto Kerusakan</h4>
                                    </div>
                                    <div class="relative group cursor-pointer overflow-hidden rounded-xl border-2 border-gray-200 hover:border-indigo-400 transition-all"
                                        onclick="viewImage('{{ asset('storage/' . $order->photo) }}')">
                                        <img src="{{ asset('storage/' . $order->photo) }}" alt="Foto Kerusakan"
                                            class="w-full h-56 object-cover">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                            <div
                                                class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center">
                                                <i data-feather="zoom-in" class="w-8 h-8 mb-2"></i>
                                                <span class="text-sm font-semibold">Klik untuk memperbesar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        
                        <div class="px-6 pb-6 relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl blur opacity-30 group-hover:opacity-70 transition-opacity">
                            </div>

                            
                            @if ($technicianStatus === 'online')
                            <form action="{{ route('techniciantakeorder', $order->id) }}" method="POST"
                                style="display: inline-block; width: 100%;">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="handleTakeOrder(event, {{ $order->id }})"
                                    class="relative w-full py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center group">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer rounded-xl">
                                    </div>
                                    <i data-feather="check-square" class="w-5 h-5 mr-2 group-hover:animate-bounce"></i>
                                    <span class="text-base">Ambil Pesanan Ini</span>
                                    <i data-feather="arrow-right"
                                        class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </form>
                            @else
    <div class="space-y-3">
        <button disabled
            class="relative w-full py-4 bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold rounded-xl shadow-lg cursor-not-allowed flex items-center justify-center group">
            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mr-3 backdrop-blur-sm">
                <i data-feather="power" class="w-5 h-5"></i>
            </div>
            <div class="text-left">
                <div class="text-sm font-bold">Status Offline</div>
                <div class="text-xs opacity-90">Aktifkan untuk mengambil pesanan</div>
            </div>
        </button>
    </div>
                            @endif
                        </div>

                        
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                        <i data-feather="hash" class="w-3 h-3 text-blue-600"></i>
                                    </div>
                                    <span class="font-semibold">Order
                                        #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                    <span class="font-medium">Available Now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-fade-in">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-gray-900">{{ $orders->firstItem() ?? 0 }}</span>
                        sampai <span class="font-semibold text-gray-900">{{ $orders->lastItem() ?? 0 }}</span>
                        dari <span class="font-semibold text-gray-900">{{ $orders->total() }}</span> pesanan
                    </div>

                    
                    <div class="flex items-center gap-2">
                        
                        @if ($orders->onFirstPage())
                            <span
                                class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg font-medium text-sm cursor-not-allowed">
                                <i data-feather="chevron-left" class="w-4 h-4 inline-block"></i>
                                Previous
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                <i data-feather="chevron-left" class="w-4 h-4 inline-block"></i>
                                Previous
                            </a>
                        @endif

                        
                        <div class="hidden sm:flex items-center gap-1">
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if ($page == $orders->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold text-sm shadow-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium text-sm hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        
                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                Next
                                <i data-feather="chevron-right" class="w-4 h-4 inline-block"></i>
                            </a>
                        @else
                            <span
                                class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg font-medium text-sm cursor-not-allowed">
                                Next
                                <i data-feather="chevron-right" class="w-4 h-4 inline-block"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="imageModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeImageModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <button onclick="closeImageModal()"
                class="absolute top-6 right-6 z-10 text-white hover:text-gray-300 transition-all bg-white/10 backdrop-blur-md hover:bg-white/20 rounded-full p-3 group">
                <i data-feather="x" class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
            <div class="relative max-w-6xl max-h-[90vh] animate-scale-in">
                <img id="previewImage" src="" alt="Preview"
                    class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl object-contain"
                    onclick="event.stopPropagation()">
                <div
                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 backdrop-blur-md text-white px-6 py-3 rounded-full text-sm flex items-center gap-2 animate-slide-up">
                    <i data-feather="info" class="w-4 h-4"></i>
                    <span>Klik di luar gambar atau tombol X untuk menutup</span>
                </div>
            </div>
        </div>
    </div>

    
    @if ($message = Session::get('success'))
        <div
            class="fixed top-6 right-6 z-50 bg-green-50 border border-green-200 rounded-xl p-4 shadow-lg animate-fade-in max-w-sm">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-feather="check-circle" class="h-5 w-5 text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0">
                    <i data-feather="x" class="h-5 w-5 text-green-600 hover:text-green-700"></i>
                </button>
            </div>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div
            class="fixed top-6 right-6 z-50 bg-red-50 border border-red-200 rounded-xl p-4 shadow-lg animate-fade-in max-w-sm">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-feather="alert-circle" class="h-5 w-5 text-red-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-800">{{ $message }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0">
                    <i data-feather="x" class="h-5 w-5 text-red-600 hover:text-red-700"></i>
                </button>
            </div>
        </div>
    @endif
@endsection

@push('script')
    
    

    <script src="{{ asset('js/technician/technician.js') }}" defer></script>
@endpush

