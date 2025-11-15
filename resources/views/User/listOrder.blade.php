@extends('layout.main')
@section('content')

   <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Pesanan Saya</h1>
                    <p class="text-gray-600">Lihat dan pantau status permintaan perbaikan Anda</p>
                </div>
                <a href="{{ route('ordercreate') }}"
                    class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <i data-feather="plus-circle" class="mr-2 w-5 h-5"></i>
                    Buat Pesanan Baru
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Total Pesanan</p>
                            <h3 class="text-3xl font-bold">{{ $orders->total() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-amber-500 to-amber-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Sedang Berjalan</p>
                            <h3 class="text-3xl font-bold">{{ $orders->where('status', 'on_process')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="clock" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Selesai</p>
                            <h3 class="text-3xl font-bold">{{ $orders->where('status', 'completed')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="check-circle" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-red-500 to-red-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Dibatalkan</p>
                            <h3 class="text-3xl font-bold">{{ $orders->where('status', 'cancelled')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="x-circle" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 border border-gray-100">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center text-gray-700 font-semibold">
                        <i data-feather="filter" class="w-5 h-5 mr-2 text-blue-600"></i>
                        <span class="text-sm">Filter Status:</span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button onclick="filterOrders('all')"
                            class="filter-btn active px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-blue-600 text-white shadow-md"
                            data-filter="all">
                            <i data-feather="list" class="w-4 h-4 inline-block mr-1"></i>
                            Semua
                        </button>

                        <button onclick="filterOrders('pending')"
                            class="filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-yellow-100 hover:text-yellow-800"
                            data-filter="pending">
                            <i data-feather="clock" class="w-4 h-4 inline-block mr-1"></i>
                            Menunggu
                        </button>

                        <button onclick="filterOrders('on_process')"
                            class="filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-800"
                            data-filter="on_process">
                            <i data-feather="tool" class="w-4 h-4 inline-block mr-1"></i>
                            Dikerjakan
                        </button>

                        <button onclick="filterOrders('completed')"
                            class="filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-green-100 hover:text-green-800"
                            data-filter="completed">
                            <i data-feather="check-circle" class="w-4 h-4 inline-block mr-1"></i>
                            Selesai
                        </button>

                        <button onclick="filterOrders('cancelled')"
                            class="filter-btn px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-800"
                            data-filter="cancelled">
                            <i data-feather="x-circle" class="w-4 h-4 inline-block mr-1"></i>
                            Dibatalkan
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Orders List -->
            @if ($orders->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Perangkat
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Merek
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Masalah
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Teknisi
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Jadwal
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-blue-50 transition-colors order-row" data-status="{{ $order->status }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                    @if ($order->device_type === 'hp')
                                                        <i data-feather="smartphone" class="text-blue-600 w-5 h-5"></i>
                                                    @elseif ($order->device_type === 'laptop')
                                                        <i data-feather="monitor" class="text-blue-600 w-5 h-5"></i>
                                                    @else
                                                        <i data-feather="tablet" class="text-blue-600 w-5 h-5"></i>
                                                    @endif
                                                </div>
                                                <span
                                                    class="font-medium text-gray-900 capitalize">{{ $order->device_type }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-gray-900 font-medium">{{ $order->brand }}</span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="max-w-xs">
                                                <p class="text-gray-900 truncate" title="{{ $order->issue_description }}">
                                                    {{ Str::limit($order->issue_description, 20) }}
                                                </p>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($order->technician)
                                                    <div
                                                        class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-2">
                                                        <span class="text-white text-sm font-bold">
                                                            {{ strtoupper(substr($order->technician->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <span class="text-gray-900">{{ $order->technician->name }}</span>
                                                @else
                                                    <span class="text-gray-500 italic">Belum Ditugaskan</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-gray-900">
                                                <i data-feather="calendar" class="w-4 h-4 mr-2 text-gray-400"></i>
                                                {{ date('d F Y', strtotime($order->schedule_date)) }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($order->status === 'pending')
                                                <span
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    Menunggu
                                                </span>
                                            @elseif ($order->status === 'on_process')
                                                <span
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                    Dikerjakan
                                                </span>
                                            @elseif ($order->status === 'completed')
                                                <span
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                    Selesai
                                                </span>
                                            @elseif ($order->status === 'cancelled')
                                                <span
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                                    {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                                    title="Lihat Detail">
                                                    <i data-feather="eye" class="w-4 h-4"></i>
                                                </button>

                                                @if ($order->status === 'completed')
                                                    @if ($order->rating)
                                                        <button
                                                            class="p-2 text-yellow-600 bg-yellow-50 rounded-lg cursor-default"
                                                            title="Sudah di-rating">
                                                            <i data-feather="star" class="w-4 h-4 fill-current"></i>
                                                        </button>
                                                    @else
                                                        <button
                                                            onclick="openRatingModal({{ $order->id }}, '{{ $order->device_type }}', '{{ $order->brand }}')"
                                                            class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors"
                                                            title="Beri Rating">
                                                            <i data-feather="star" class="w-4 h-4"></i>
                                                        </button>
                                                    @endif
                                                @endif

                                                @if ($order->status === 'pending')
                                                    <form action={{ route('ordercancel', $order->id) }} method="POST">
                                                        @csrf
                                                        <button
                                                            class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                                            title="Hapus">
                                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden order-card" data-status="{{ $order->status }}">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                            @if ($order->device_type === 'hp')
                                                <i data-feather="smartphone" class="text-blue-600 w-6 h-6"></i>
                                            @elseif ($order->device_type === 'laptop')
                                                <i data-feather="monitor" class="text-blue-600 w-6 h-6"></i>
                                            @else
                                                <i data-feather="tablet" class="text-blue-600 w-6 h-6"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 capitalize">{{ $order->device_type }}</h4>
                                            <p class="text-sm text-gray-600">{{ $order->brand }}</p>
                                        </div>
                                    </div>
                                    @if ($order->status === 'pending')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif ($order->status === 'on_process')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Dikerjakan
                                        </span>
                                    @elseif ($order->status === 'completed')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @elseif ($order->status === 'cancelled')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>

                                <!-- Issue Description -->
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($order->issue_description, 80) }}</p>

                                <!-- Info Grid -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Teknisi</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $order->technician?->name ?? 'Belum Ditugaskan' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Jadwal</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ date('d M Y', strtotime($order->schedule_date)) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">

                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Lihat Detail">
                                        <i data-feather="eye" class="w-5 h-5"></i>
                                    </button>


                                    @if ($order->status === 'completed')
                                        <button
                                            onclick="openRatingModal({{ $order->id }}, '{{ $order->device_type }}', '{{ $order->brand }}')"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                                            title="Beri Rating">
                                            <i data-feather="star" class="w-5 h-5"></i>
                                        </button>
                                    @endif


                                    @if ($order->status === 'pending')
                                        <form action="{{ route('ordercancel', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            <button
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Batalkan Pesanan">
                                                <i data-feather="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Mobile Pagination -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i data-feather="package" class="text-gray-400 w-12 h-12"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Anda belum memiliki pesanan perbaikan. Mulai dengan membuat pesanan pertama Anda sekarang!
                    </p>
                    <a href="{{ route('ordercreate') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                        <i data-feather="plus-circle" class="mr-2 w-5 h-5"></i>
                        Buat Pesanan Baru
                    </a>
                </div>
            @endif
        </div>
    </div>


    {{-- MODAL --}}
    <!-- Modal Rating -->
    <div id="ratingModal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all animate-scale-in">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 rounded-t-2xl relative">
                <button onclick="closeRatingModal()"
                    class="absolute top-3 right-3 text-white/80 hover:text-white hover:bg-white/20 rounded-lg p-1.5 transition-all">
                    <i data-feather="x" class="w-4 h-4"></i>
                </button>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                        <i data-feather="star" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Beri Rating</h2>
                        <p class="text-blue-100 text-xs">Bagaimana pengalaman Anda?</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="ratingForm" action="{{ route('ratingstore') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="order_id" id="orderId">
                <input type="hidden" name="rating" id="ratingValue">

                <!-- Device Info -->
                <div class="bg-blue-50 rounded-xl p-3 mb-5 border border-blue-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i data-feather="smartphone" class="text-white w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 font-semibold">DETAIL PESANAN</p>
                            <p id="modalDeviceInfo" class="text-sm font-bold text-gray-800">Perangkat: -</p>
                        </div>
                    </div>
                </div>

                <!-- Rating Stars -->
                <div class="mb-5">
                    <p class="text-center text-xs font-semibold text-gray-600 mb-3 flex items-center justify-center">
                        <i data-feather="award" class="w-3 h-3 mr-1.5 text-blue-600"></i>
                        Berikan Penilaian Anda
                    </p>
                    <div class="flex justify-center gap-2 mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})"
                                id="star{{ $i }}"
                                class="transform hover:scale-110 active:scale-95 transition-all duration-200 focus:outline-none">
                                <i data-feather="star"
                                    class="w-9 h-9 text-gray-300 hover:text-yellow-400 transition-colors"></i>
                            </button>
                        @endfor
                    </div>
                    <p id="ratingText" class="text-center text-xs text-gray-500">Pilih bintang untuk rating</p>
                </div>

                <!-- Comment -->
                <div class="mb-5">
                    <label class="flex items-center text-xs font-semibold text-gray-700 mb-2">
                        <i data-feather="message-circle" class="w-3 h-3 mr-1.5 text-blue-600"></i>
                        Komentar
                        <span class="ml-1 text-xs font-normal text-gray-500">(Opsional)</span>
                    </label>
                    <textarea name="comment" id="comment" rows="3" placeholder="Ceritakan pengalaman Anda..."
                        class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none text-sm placeholder-gray-400"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="button" onclick="closeRatingModal()"
                        class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-400 active:scale-95 transition-all duration-200 text-sm">
                        <i data-feather="x-circle" class="w-3.5 h-3.5 inline-block mr-1.5"></i>
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-lg shadow-lg hover:shadow-xl active:scale-95 transition-all duration-200 text-sm">
                        <i data-feather="send" class="w-3.5 h-3.5 inline-block mr-1.5"></i>
                        Kirim Rating
                    </button>
                </div>
            </form>
        </div>
    </div>
