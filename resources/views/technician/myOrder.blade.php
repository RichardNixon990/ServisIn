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
                    <a href="{{ route('technicianDashboard') }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200 mb-4 group">
                        <i data-feather="arrow-left" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-medium">Kembali ke Dashboard</span>
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Pesanan Saya</h1>
                    <p class="text-gray-600">Kelola pesanan yang sedang Anda kerjakan</p>
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



            <!-- ===== FILTER SECTION ===== -->
            <div class="bg-white rounded-2xl shadow-lg p-4 mb-8 border border-gray-100 animate-fade-in">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center text-gray-700 font-semibold">
                        <i data-feather="filter" class="w-5 h-5 mr-2 text-blue-600"></i>
                        <span class="text-sm">Filter Status:</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="filterStatus('all')"
                            class="status-filter-btn active px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-blue-600 text-white shadow-md"
                            data-status="all">
                            <i data-feather="list" class="w-4 h-4 inline-block mr-1"></i>Semua
                        </button>
                        <button onclick="filterStatus('on_process')"
                            class="status-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-status="on_process">
                            <i data-feather="tool" class="w-4 h-4 inline-block mr-1"></i>Dikerjakan
                        </button>
                        <button onclick="filterStatus('completed')"
                            class="status-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-status="completed">
                            <i data-feather="check-circle" class="w-4 h-4 inline-block mr-1"></i>Selesai
                        </button>
                    </div>
                </div>
            </div>

            <!-- ===== ORDERS GRID ===== -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="ordersContainer">
                @forelse($orders as $order)
                    <div class="order-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-scale-in group"
                        data-status="{{ $order->status }}" style="animation-delay: {{ $loop->index * 0.1 }}s">

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
                                        @if ($order->status === 'on_process')
                                            <span
                                                class="px-3 py-1.5 bg-amber-400 text-amber-900 text-xs font-bold rounded-full shadow-lg">
                                                <i data-feather="tool" class="w-3 h-3 inline-block mr-1"></i>Dikerjakan
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1.5 bg-green-400 text-green-900 text-xs font-bold rounded-full shadow-lg">
                                                <i data-feather="check-circle" class="w-3 h-3 inline-block mr-1"></i>Selesai
                                            </span>
                                        @endif
                                        <span
                                            class="text-blue-100 text-xs font-semibold">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
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

                               <!-- ESTIMATED SPAREPARTS & COST -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="tool" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800">Estimasi Sparepart & Biaya</h4>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-xl border border-blue-200 shadow-sm space-y-3">
                                    <!-- List Spareparts -->
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

                                        <!-- Total Estimasi -->
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

                                        <!-- Info Badge -->
                                        <div
                                            class="flex items-start gap-2 p-2.5 bg-blue-50 rounded-lg border border-blue-200">
                                            <i data-feather="info" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"></i>
                                            <p class="text-xs text-blue-700 leading-relaxed">
                                                <span class="font-semibold">Estimasi awal:</span> Biaya hanya sebatas perkiraan harga menurut AI
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
                                    <a href={{ 'https://wa.me/+62' . ltrim($order->user->phone, 0) }} target="blank"
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
                                        onclick="viewImage('{{ asset('storage/' . $order->photo) }}')">
                                        <img src="{{ asset('storage/' . $order->photo) }}" alt="Foto Kerusakan"
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

                            <!-- COMPLETION INFO (if completed) -->
                            @if ($order->status === 'completed' && $order->completed_at)
                                <div class="space-y-3">
                                    <!-- Completion Time -->
                                    <div class="bg-green-50 p-4 rounded-xl border-2 border-green-200">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center mr-3">
                                                <i data-feather="check-circle" class="w-5 h-5 text-white"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-green-600">DISELESAIKAN PADA</p>
                                                <p class="text-sm font-bold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($order->completed_at)->format('d M Y, H:i') }}
                                                    WIB</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($order->completed_at)->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Final Cost -->
                                    @if ($order->final_cost)
                                        <div
                                            class="bg-gradient-to-br from-yellow-50 to-orange-50 p-4 rounded-xl border-2 border-yellow-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center mr-3">
                                                        <i data-feather="dollar-sign" class="w-5 h-5 text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-semibold text-yellow-700">BIAYA AKHIR</p>
                                                        <p class="text-lg font-black text-gray-800">Rp
                                                            {{ number_format($order->final_cost, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Notes -->
                                    @if ($order->notes)
                                        <div
                                            class="bg-gradient-to-br from-indigo-50 to-purple-50 p-4 rounded-xl border-l-4 border-indigo-400">
                                            <div class="flex items-start">
                                                <div
                                                    class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                                    <i data-feather="file-text" class="w-4 h-4 text-indigo-600"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-xs font-bold text-indigo-700 mb-1">CATATAN TEKNISI</h4>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $order->notes }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="px-6 pb-6 relative">
                            @if ($order->status === 'on_process')
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl blur opacity-30 group-hover:opacity-70 transition-opacity"></div>
                                <button type="button" onclick="openCompleteModal({{ $order->id }})"
                                    class="relative w-full py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center group">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer rounded-xl"></div>
                                    <i data-feather="check-square" class="w-5 h-5 mr-2 group-hover:animate-bounce"></i>
                                    <span class="text-base">Tandai Selesai</span>
                                    <i data-feather="arrow-right" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            @elseif($order->status === 'completed' && $order->payment && $order->payment->payment_status === 'unpaid')
                                <form action={{route('orderconfirmPayment', $order->Payment)}} method="POST" onsubmit="event.preventDefault();
                                    Swal.fire({
                                        title: 'Konfirmasi Pembayaran?',
                                        text: 'Pastikan Anda sudah menerima pembayaran dari pelanggan sebelum melanjutkan!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, Sudah Bayar!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            event.target.submit();
                                        }
                                    });">
                                    @csrf
                                    @method('PUT')
                                    <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-green-700 rounded-xl blur opacity-30 group-hover:opacity-70 transition-opacity"></div>
                                    <button type="submit"
                                        class="relative w-full py-4 bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:from-green-600 hover:via-green-700 hover:to-green-800 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center group">
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer rounded-xl"></div>
                                        <i data-feather="dollar-sign" class="w-5 h-5 mr-2"></i>
                                        <span class="text-base">Konfirmasi Pembayaran</span>
                                    </button>
                                </form>
                            @else
                                <div class="w-full py-4 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 font-bold rounded-xl text-center flex items-center justify-center border-2 border-gray-200 cursor-default">
                                    <i data-feather="check-circle" class="w-5 h-5 mr-2 text-green-500"></i>
                                    Pesanan Selesai & Lunas
                                </div>
                            @endif
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
                                    @if ($order->status === 'on_process')
                                        <div class="w-2 h-2 bg-amber-500 rounded-full mr-2 animate-pulse"></div>
                                        <span class="font-medium">In Progress</span>
                                    @else
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                        <span class="font-medium">Completed</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow-lg p-12 text-center animate-fade-in">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <i data-feather="inbox" class="text-gray-400 w-12 h-12"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Anda belum mengambil pesanan apapun. Ambil pesanan
                            dari dashboard untuk mulai bekerja.</p>
                        <a href="{{ route('technicianDashboard') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i data-feather="arrow-left" class="mr-2 w-5 h-5"></i>Ke Dashboard
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if ($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ===== COMPLETE ORDER MODAL ===== -->
    <div id="completeModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeCompleteModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="check-circle" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Selesaikan Pesanan</h3>
                                <p class="text-green-100 text-sm">Isi informasi penyelesaian order</p>
                            </div>
                        </div>
                        <button onclick="closeCompleteModal()" class="text-white hover:text-green-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="completeOrderForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Order Info -->
                        <div class="bg-blue-50 p-4 rounded-xl border-2 border-blue-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <i data-feather="info" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-blue-600">ORDER ID</p>
                                    <p class="text-sm font-bold text-gray-800" id="modalOrderId">#0000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Final Cost Input -->
                        <div>
                            <label for="final_cost" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="dollar-sign" class="w-4 h-4 text-yellow-600"></i>
                                </div>
                                Biaya Akhir <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="number" id="final_cost" name="final_cost" required min="0"
                                    step="1000" placeholder="Masukkan biaya akhir"
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none text-gray-800 font-semibold">
                            </div>
                            <p class="text-xs text-gray-500 mt-1 ml-1">
                                <i data-feather="alert-circle" class="w-3 h-3 inline-block mr-1"></i>
                                Wajib diisi. Masukkan total biaya perbaikan.
                            </p>
                        </div>

                        <!-- Notes Input -->
                        <div>
                            <label for="notes" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="file-text" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                                Catatan Teknisi <span class="text-gray-400 ml-1 text-xs">(Opsional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                placeholder="Contoh: Sudah diganti LCD original, baterai masih bagus, garansi 7 hari..."
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none text-gray-800 resize-none"></textarea>
                            <p class="text-xs text-gray-500 mt-1 ml-1">
                                <i data-feather="info" class="w-3 h-3 inline-block mr-1"></i>
                                Opsional. Tambahkan catatan perbaikan atau informasi tambahan.
                            </p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 flex gap-3">
                        <button type="button" onclick="closeCompleteModal()"
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                            <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <i data-feather="check-circle" class="w-4 h-4 inline-block mr-2"></i>Konfirmasi Selesai
                        </button>
                    </div>
                </form>
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
        const UPDATE_INTERVAL = 60000; // 60 seconds
        const ANIMATION_DELAY = 80;

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

        // ===== FILTER STATUS FUNCTION =====
        function filterStatus(status) {
            const cards = document.querySelectorAll('.order-card');
            const buttons = document.querySelectorAll('.status-filter-btn');

            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            const activeBtn = document.querySelector(`[data-status="${status}"].status-filter-btn`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
                activeBtn.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md');
            }

            let visibleIndex = 0;
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');

                if (status === 'all' || cardStatus === status) {
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

            featherReplace();
        }

        // ===== OPEN COMPLETE MODAL =====
        function openCompleteModal(orderId) {
            const modal = document.getElementById('completeModal');
            const form = document.getElementById('completeOrderForm');
            const modalOrderId = document.getElementById('modalOrderId');

            if (modal && form && modalOrderId) {
                // Set form action
                form.action = `{{ route('techniciancompletedOrder', ':id') }}`.replace(':id', orderId);

                // Set order ID display
                modalOrderId.textContent = `#${String(orderId).padStart(4, '0')}`;

                // Reset form
                form.reset();

                // Show modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                featherReplace();
            }
        }

        // ===== CLOSE COMPLETE MODAL =====
        function closeCompleteModal() {
            const modal = document.getElementById('completeModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
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

        // ===== HANDLE FORM SUBMIT =====
        document.getElementById('completeOrderForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const finalCost = document.getElementById('final_cost').value;

            if (!finalCost || finalCost <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Biaya Akhir Wajib Diisi!',
                    text: 'Mohon masukkan biaya akhir yang valid.',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                    }
                });
                return;
            }

            // Tutup modal dulu
            closeCompleteModal();

            // Tampilkan loading
            setTimeout(() => {
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menyelesaikan pesanan, mohon tunggu...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                setTimeout(() => {
                    this.submit();
                }, 200);
            }, 200);
        });

        // ===== KEYBOARD EVENT - ESC TO CLOSE MODAL =====
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const imageModal = document.getElementById('imageModal');
                const completeModal = document.getElementById('completeModal');

                if (completeModal && !completeModal.classList.contains('hidden')) {
                    closeCompleteModal();
                } else if (imageModal && !imageModal.classList.contains('hidden')) {
                    closeImageModal();
                }
            }
        });

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
