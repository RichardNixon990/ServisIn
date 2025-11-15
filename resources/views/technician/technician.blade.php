@extends('layout.main')
@section('content')
    <style>
        /* ===== KEYFRAME ANIMATIONS ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* ===== ANIMATION UTILITIES ===== */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out;
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3b82f6, #1e40af);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #2563eb, #1e3a8a);
        }
    </style>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            <!-- ===== HEADER SECTION ===== -->
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

            <!-- ===== STATS CARDS ===== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- CARD 1: Available Orders -->
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

                <!-- CARD 2: Active Orders -->
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
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black">{{ $stats['active'] ?? 5 }}</h3>
                            <span class="text-sm opacity-75">/ 5 limit</span>
                        </div>
                        <div class="mt-2 bg-white bg-opacity-20 rounded-full h-2">
                            <div class="bg-white rounded-full h-2 transition-all duration-500"
                                style="width: {{ (($stats['active'] ?? 5) / 5) * 100 }}%"></div>
                        </div>
                        <p class="text-xs opacity-75 mt-1">
                            {{ ($stats['active'] ?? 5) >= 5 ? 'Kapasitas penuh' : 'Masih tersedia' }}</p>
                    </div>
                </div>

                <!-- CARD 3: Completed Today -->
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

                <!-- CARD 4: Rating -->
                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-slide-up relative overflow-hidden group"
                    style="animation-delay: 0.3s">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <i data-feather="star" class="w-7 h-7"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-purple-400 bg-opacity-30 rounded-full text-xs font-bold backdrop-blur-sm">Rating</span>
                        </div>
                        <p class="text-sm opacity-90 mb-1 font-medium">Rating Rata-rata</p>
                        <h3 class="text-4xl font-black mb-1">{{ $stats['rating'] ?? 4.8 }}</h3>
                        <p class="text-xs opacity-75">Dari {{ $stats['reviews'] ?? 127 }} ulasan</p>
                    </div>
                </div>
            </div>

            <!-- ===== FILTER SECTION ===== -->
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

            <!-- ===== ORDERS GRID ===== -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="ordersContainer">
                @foreach ($orders as $order)
                    <div class="order-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-scale-in group"
                        data-device="{{ $order->device_type }}" style="animation-delay: {{ $loop->index * 0.1 }}s">

                        <!-- CARD HEADER -->
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
                                            <h3 class="text-white font-bold text-lg capitalize">{{ $order->device_type }}
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

                        <!-- CARD BODY -->
                        <div class="p-6 space-y-4">
                            <!-- ISSUE DESCRIPTION -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="alert-circle" class="w-4 h-4 text-red-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Deskripsi Kerusakan</h4>
                                </div>
                                <div
                                    class="bg-gradient-to-br from-red-50 to-orange-50 p-4 rounded-xl border-l-4 border-red-400 shadow-sm">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $order->issue_description }}</p>
                                </div>
                            </div>

                            <!-- SCHEDULE DATE -->
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

                            <!-- CUSTOMER INFO -->
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
                                    <a href="tel:{{ $order->user->phone }}"
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

                            <!-- CUSTOMER ADDRESS -->
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

                            <!-- DAMAGE PHOTO -->
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
                                        onclick="viewImage('{{ $order->photo }}')">
                                        <img src="{{ $order->photo }}" alt="Foto Kerusakan"
                                            class="w-full h-56 object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                            <div class="text-center">
                                                <i data-feather="zoom-in"
                                                    class="w-10 h-10 text-white mb-2 mx-auto group-hover:scale-110 transition-transform"></i>
                                                <p class="text-white font-semibold text-sm">Klik untuk memperbesar</p>
                                            </div>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <span
                                                class="px-3 py-1 bg-white rounded-full text-xs font-bold text-gray-700 shadow-lg backdrop-blur-sm">
                                                <i data-feather="camera" class="w-3 h-3 inline-block mr-1"></i>Photo
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- ACTION BUTTON - AMBIL PESANAN -->
                        <div class="px-6 pb-6 relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl blur opacity-30 group-hover:opacity-70 transition-opacity">
                            </div>

                            <!-- FORM AMBIL PESANAN -->
                            <form action="{{ route('ordertakeorder', $order->id) }}" method="POST"
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
                        </div>

                        <!-- CARD FOOTER -->
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
        </div>
    </div>

    <!-- ===== IMAGE PREVIEW MODAL ===== -->
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

    <!-- ===== FLASH MESSAGE ALERTS ===== -->
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ===== CONSTANTS =====
        const MAX_ORDERS = 5;
        const ANIMATION_DELAY = 80;
        const UPDATE_INTERVAL = 60000;

        // ===== UPDATE TIME FUNCTION =====
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Jakarta'
            };

            const formatter = new Intl.DateTimeFormat('id-ID', options);
            const formatted = formatter.format(now);
            const timeString = `${formatted} WIB`;

            const element = document.getElementById('currentTime');
            if (element) {
                element.textContent = timeString;
            }
        }

        updateTime();
        setInterval(updateTime, UPDATE_INTERVAL);

        // ===== FILTER DEVICES FUNCTION =====
        function filterDevice(deviceType) {
            const cards = document.querySelectorAll('.order-card');
            const buttons = document.querySelectorAll('.device-filter-btn');

            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            const activeBtn = document.querySelector(`[data-device="${deviceType}"].device-filter-btn`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
                activeBtn.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md');
            }

            let visibleIndex = 0;
            cards.forEach(card => {
                const cardDevice = card.getAttribute('data-device');

                if (deviceType === 'all' || cardDevice === deviceType) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1) translateY(0)';
                    }, visibleIndex * ANIMATION_DELAY);
                    visibleIndex++;
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9) translateY(10px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            setTimeout(() => {
                const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
                if (visibleCards.length === 0 && deviceType !== 'all') {
                    showEmptyState(deviceType);
                } else {
                    hideEmptyState();
                }
            }, 400);
        }

        // ===== VIEW IMAGE MODAL =====
        function viewImage(imageSrc) {
            const modal = document.getElementById('imageModal');
            const previewImage = document.getElementById('previewImage');

            if (modal && previewImage) {
                previewImage.src = imageSrc;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                featherReplace();
            }
        }

        // ===== CLOSE IMAGE MODAL =====
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // ===== KEYBOARD EVENT - ESC TO CLOSE MODAL =====
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('imageModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeImageModal();
                }
            }
        });

        // ===== HANDLE TAKE ORDER - MAIN FUNCTION =====
        function handleTakeOrder(event, orderId) {
            event.preventDefault();

            const form = event.target.closest('form');

            Swal.fire({
                title: 'Konfirmasi Pengambilan Pesanan',
                html: `
                <div class="text-left space-y-3">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="font-semibold text-gray-800 mb-2">
                            <i class="w-4 h-4 inline-block mr-2"></i>
                            Order #${String(orderId).padStart(4, '0')}
                        </p>
                        <p class="text-sm text-gray-600">Setelah diambil, pesanan ini akan menjadi tanggung jawab Anda.</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                        <p class="text-sm text-amber-800">
                            <i class="w-4 h-4 inline-block mr-2"></i>
                            <strong>Perhatian:</strong> Pastikan Anda dapat menyelesaikan pesanan sesuai jadwal yang ditentukan.
                        </p>
                    </div>
                </div>
            `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Ambil Pesanan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-lg',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'Sedang mengambil pesanan, mohon tunggu...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form after 500ms delay
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });
        }

        // ===== SHOW EMPTY STATE =====
        function showEmptyState(deviceType) {
            const container = document.getElementById('ordersContainer');
            const existingEmpty = document.getElementById('emptyState');

            if (existingEmpty || !container) return;

            const deviceNames = {
                'hp': 'HP',
                'tablet': 'Tablet',
                'laptop': 'Laptop'
            };

            const emptyState = document.createElement('div');
            emptyState.id = 'emptyState';
            emptyState.className = 'col-span-full bg-white rounded-2xl shadow-lg p-12 text-center animate-fade-in';
            emptyState.innerHTML = `
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i data-feather="search" class="text-gray-400 w-12 h-12"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Pesanan ${deviceNames[deviceType] || deviceType}</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Saat ini tidak ada pesanan yang tersedia. Coba filter lain atau cek kembali nanti.</p>
            <button onclick="filterDevice('all')" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <i data-feather="list" class="mr-2 w-5 h-5"></i>Tampilkan Semua
            </button>
        `;

            container.appendChild(emptyState);
            featherReplace();
        }

        // ===== HIDE EMPTY STATE =====
        function hideEmptyState() {
            const emptyState = document.getElementById('emptyState');
            if (emptyState) {
                emptyState.remove();
            }
        }

        // ===== FEATHER ICONS REPLACE =====
        function featherReplace() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // ===== INITIALIZE SCROLL TOP BUTTON =====
        function initScrollTopButton() {
            const scrollBtn = document.createElement('button');
            scrollBtn.innerHTML = '<i data-feather="arrow-up" class="w-5 h-5"></i>';
            scrollBtn.className =
                'fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 z-40 hidden';
            scrollBtn.id = 'scrollTopBtn';
            scrollBtn.onclick = () => window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            document.body.appendChild(scrollBtn);

            window.addEventListener('scroll', () => {
                const isHidden = scrollBtn.classList.contains('hidden');
                if (window.scrollY > 300 && isHidden) {
                    scrollBtn.classList.remove('hidden');
                } else if (window.scrollY <= 300 && !isHidden) {
                    scrollBtn.classList.add('hidden');
                }
            });

            featherReplace();
        }

        // ===== PAGE LOAD INITIALIZATION =====
        document.addEventListener('DOMContentLoaded', () => {
            featherReplace();
            initScrollTopButton();
        });

        // ===== PAGE UNLOAD ANIMATION =====
        window.addEventListener('beforeunload', () => {
            document.body.style.opacity = '0.7';
            document.body.style.transition = 'opacity 0.3s';
        });
    </script>
@endpush
