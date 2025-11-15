@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
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
            <div class="mt-4 md:mt-0 flex gap-3">
                <div class="bg-white px-4 py-2 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center text-gray-600">
                        <i data-feather="clock" class="w-4 h-4 mr-2 text-blue-600"></i>
                        <span class="text-sm font-medium" id="currentTime"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <!-- Active Orders -->
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Sedang Dikerjakan</p>
                        <h3 class="text-4xl font-bold">{{ $orders->where('status', 'on_process')->count() }}</h3>
                        <p class="text-xs opacity-75 mt-1">Pesanan aktif</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i data-feather="tool" class="w-7 h-7"></i>
                    </div>
                </div>
            </div>

            <!-- Completed Today -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Selesai Hari Ini</p>
                        <h3 class="text-4xl font-bold">
                            {{ $orders->where('status', 'completed')->filter(function($order) {
                                return \Carbon\Carbon::parse($order->updated_at)->isToday();
                            })->count() }}
                        </h3>
                        <p class="text-xs opacity-75 mt-1">Total completed</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i data-feather="check-circle" class="w-7 h-7"></i>
                    </div>
                </div>
            </div>

            <!-- Total Completed -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Diselesaikan</p>
                        <h3 class="text-4xl font-bold">{{ $orders->where('status', 'completed')->count() }}</h3>
                        <p class="text-xs opacity-75 mt-1">All time</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i data-feather="award" class="w-7 h-7"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 border border-gray-100">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center text-gray-700 font-semibold">
                    <i data-feather="filter" class="w-5 h-5 mr-2 text-blue-600"></i>
                    <span class="text-sm">Status:</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterStatus('all')"
                            class="status-filter-btn active px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-blue-600 text-white shadow-md"
                            data-status="all">
                        <i data-feather="list" class="w-4 h-4 inline-block mr-1"></i>Semua
                    </button>
                    <button onclick="filterStatus('on_process')"
                            class="status-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-amber-100 hover:text-amber-800"
                            data-status="on_process">
                        <i data-feather="tool" class="w-4 h-4 inline-block mr-1"></i>Dikerjakan
                    </button>
                    <button onclick="filterStatus('completed')"
                            class="status-filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-green-100 hover:text-green-800"
                            data-status="completed">
                        <i data-feather="check-circle" class="w-4 h-4 inline-block mr-1"></i>Selesai
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="ordersContainer">
            @forelse($orders as $order)
                <div class="order-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 animate-scale-in"
                     data-status="{{ $order->status }}">

                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                                    @php
                                        $deviceIcons = ['hp' => 'smartphone', 'tablet' => 'tablet', 'laptop' => 'monitor'];
                                        $iconName = $deviceIcons[$order->device_type] ?? 'smartphone';
                                    @endphp
                                    <i data-feather="{{ $iconName }}" class="text-white w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg capitalize">{{ $order->device_type }}</h3>
                                    <p class="text-blue-100 text-sm">{{ $order->brand }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                @if($order->status === 'on_process')
                                    <span class="px-3 py-1 bg-amber-400 text-amber-900 text-xs font-bold rounded-full">
                                        <i data-feather="tool" class="w-3 h-3 inline-block mr-1"></i>Dikerjakan
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-400 text-green-900 text-xs font-bold rounded-full">
                                        <i data-feather="check-circle" class="w-3 h-3 inline-block mr-1"></i>Selesai
                                    </span>
                                @endif
                                <span class="text-blue-100 text-xs">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 space-y-4">
                        <!-- Issue Description -->
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="alert-circle" class="w-4 h-4 text-red-600"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">Deskripsi Kerusakan</h4>
                            </div>
                            <div class="bg-red-50 p-4 rounded-xl border-l-4 border-red-400">
                                <p class="text-sm text-gray-700">{{ $order->issue_description }}</p>
                            </div>
                        </div>

                        <!-- Schedule & Customer Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <i data-feather="calendar" class="w-4 h-4 text-blue-600 mr-2"></i>
                                    <p class="text-xs font-semibold text-blue-600">Jadwal</p>
                                </div>
                                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($order->schedule_date)->format('d M Y') }}</p>
                            </div>

                            <div class="bg-purple-50 p-4 rounded-xl border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <i data-feather="user" class="w-4 h-4 text-purple-600 mr-2"></i>
                                    <p class="text-xs font-semibold text-purple-600">Customer</p>
                                </div>
                                <p class="text-sm font-bold text-gray-800">{{ $order->user->name }}</p>
                            </div>
                        </div>

                        <!-- Contact & Address -->
                        <div class="space-y-3">
                            <a href="tel:{{ $order->user->phone }}"
                               class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors border border-green-200">
                                <div class="flex items-center">
                                    <i data-feather="phone" class="w-4 h-4 text-green-600 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">{{ $order->user->phone }}</span>
                                </div>
                                <i data-feather="external-link" class="w-4 h-4 text-gray-400"></i>
                            </a>

                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-start">
                                    <i data-feather="map-pin" class="w-4 h-4 text-gray-600 mr-2 mt-0.5"></i>
                                    <p class="text-sm text-gray-700 flex-1">{{ $order->address }}</p>
                                    <a href="https://maps.google.com/?q={{ urlencode($order->address) }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center text-xs font-semibold text-green-700 hover:text-green-800 bg-white px-3 py-2 rounded-lg hover:shadow-md transition-all">
                                        <i data-feather="navigation" class="w-3 h-3 mr-1.5"></i>
                                        Buka di Google Maps
                                        <i data-feather="external-link" class="w-3 h-3 ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Photo if exists -->
                        @if($order->photo)
                            <div>
                                <div class="flex items-center mb-2">
                                    <i data-feather="image" class="w-4 h-4 text-indigo-600 mr-2"></i>
                                    <h4 class="text-sm font-bold text-gray-800">Foto Kerusakan</h4>
                                </div>
                                <div class="relative group cursor-pointer overflow-hidden rounded-xl border-2 border-gray-200 hover:border-indigo-400 transition-all"
                                     onclick="viewImage('{{ asset('storage/' . $order->photo) }}')">
                                    <img src="{{ asset('storage/' . $order->photo) }}" alt="Foto" class="w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                        <i data-feather="zoom-in" class="w-10 h-10 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 pb-6 flex gap-3">
                        @if($order->status === 'on_process')
                            <form action="" method="POST" class="flex-1">
                                {{-- @csrf
                                @method('PUT') --}}
                                <button type="submit"
                                        onclick="return confirm('Tandai pesanan ini sebagai selesai?')"
                                        class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center">
                                    <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                                    Tandai Selesai
                                </button>
                            </form>
                        @else
                            <div class="flex-1 py-3 bg-gray-100 text-gray-500 font-bold rounded-xl text-center flex items-center justify-center">
                                <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                                Pesanan Selesai
                            </div>
                        @endif

                        <button onclick="viewDetail({{ $order->id }})"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all">
                            <i data-feather="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i data-feather="inbox" class="text-gray-400 w-12 h-12"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-8">Anda belum mengambil pesanan apapun. Ambil pesanan dari dashboard untuk mulai bekerja.</p>
                    <a href="{{ route('technician.dashboard') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all">
                        <i data-feather="arrow-left" class="mr-2 w-5 h-5"></i>
                        Ke Dashboard
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black/95 backdrop-blur-sm">
    <div class="relative w-full h-full flex items-center justify-center p-4">
        <button onclick="closeImageModal()"
                class="absolute top-6 right-6 text-white hover:text-gray-300 bg-white/10 hover:bg-white/20 rounded-full p-3">
            <i data-feather="x" class="w-6 h-6"></i>
        </button>
        <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl">
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
    .animate-scale-in { animation: scaleIn 0.5s ease-out; }
</style>

<script>
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' };
        const formatted = new Intl.DateTimeFormat('id-ID', options).format(now);
        document.getElementById('currentTime').textContent = `${formatted} WIB`;
    }
    updateTime();
    setInterval(updateTime, 60000);

    function filterStatus(status) {
        const cards = document.querySelectorAll('.order-card');
        const buttons = document.querySelectorAll('.status-filter-btn');

        buttons.forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });

        const activeBtn = document.querySelector(`[data-status="${status}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
            activeBtn.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md');
        }

        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            if (status === 'all' || cardStatus === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        feather.replace();
    }

    function viewImage(src) {
        document.getElementById('previewImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        feather.replace();
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function viewDetail(orderId) {
        alert(`Detail order #${orderId} akan segera hadir!`);
    }

    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeImageModal();
    });
</script>

@endsection
