@extends('layout.main')
@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                        Pesanan Teknisi: {{ $technician->user->name }}
                    </h1>
                    <p class="text-gray-600">Daftar pesanan yang ditangani oleh teknisi ini</p>
                </div>
                <a href="{{ route('adminDashboard') }}"
                    class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <i data-feather="arrow-left" class="mr-2 w-5 h-5"></i>
                    Kembali
                </a>
            </div>

            <!-- Technician Info Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center mr-4">
                            <span
                                class="text-blue-800 text-3xl font-bold">{{ strtoupper(substr($technician->user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">{{ $technician->user->name }}</h3>
                            <p class="text-blue-100 text-sm">{{ $technician->user->email }}</p>
                            <p class="text-blue-100 text-sm">{{ $technician->user->phone }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="text-center">
                            <p class="text-white text-xs mb-1">Total Pesanan</p>
                            <p class="text-3xl font-bold">{{ $orders->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-gradient-to-br from-amber-500 to-amber-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Menunggu</p>
                            <h3 class="text-3xl font-bold">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="clock" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Dikerjakan</p>
                            <h3 class="text-3xl font-bold">{{ $orders->where('status', 'on_process')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i data-feather="tool" class="w-6 h-6"></i>
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
                                        Pelanggan
                                    </th>
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
                                    <tr class="hover:bg-blue-50 transition-colors order-row"
                                        data-status="{{ $order->status }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-purple-600 font-bold text-sm">
                                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $order->user->phone }}</p>
                                                </div>
                                            </div>
                                        </td>

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
                                                <p class="text-gray-900 truncate"
                                                    title="{{ $order->issue_description }}">
                                                    {{ Str::limit($order->issue_description, 30) }}
                                                </p>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-gray-900">
                                                <i data-feather="calendar" class="w-4 h-4 mr-2 text-gray-400"></i>
                                                {{ date('d M Y', strtotime($order->schedule_date)) }}
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
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button
                                                onclick="openDetailModal({{ json_encode([
                                                    'customer_name' => $order->user->name,
                                                    'customer_phone' => $order->user->phone,
                                                    'customer_email' => $order->user->email,
                                                    'device_type' => $order->device_type,
                                                    'brand' => $order->brand,
                                                    'issue_description' => $order->issue_description,
                                                    'address' => $order->address,
                                                    'schedule_date_formatted' => date('d F Y', strtotime($order->schedule_date)),
                                                    'estimated_cost' => $order->estimated_cost,
                                                    'final_cost' => $order->final_cost,
                                                    'status' => $order->status,
                                                    'notes' => $order->notes,
                                                    'photo' => $order->photo ? asset('storage/' . $order->photo) : null,
                                                    'created_at' => optional(\Carbon\Carbon::make($order->created_at))->format('d F Y H:i'),
                                                    'completed_at' => optional(\Carbon\Carbon::make($order->completed_at))->format('d F Y H:i'),
                                                ]) }})"
                                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                                title="Lihat Detail">
                                                <i data-feather="eye" class="w-4 h-4"></i>
                                            </button>
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
                        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden order-card"
                            data-status="{{ $order->status }}">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-purple-600 font-bold">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $order->user->name }}</h4>
                                            <p class="text-xs text-gray-600">{{ $order->user->phone }}</p>
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
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>

                                <!-- Device Info -->
                                <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                    <div class="flex items-center">
                                        @if ($order->device_type === 'hp')
                                            <i data-feather="smartphone" class="text-blue-600 w-5 h-5 mr-2"></i>
                                        @elseif ($order->device_type === 'laptop')
                                            <i data-feather="monitor" class="text-blue-600 w-5 h-5 mr-2"></i>
                                        @else
                                            <i data-feather="tablet" class="text-blue-600 w-5 h-5 mr-2"></i>
                                        @endif
                                        <span
                                            class="font-semibold text-gray-900 capitalize">{{ $order->device_type }}</span>
                                        <span class="mx-2 text-blue-400">•</span>
                                        <span class="text-gray-700">{{ $order->brand }}</span>
                                    </div>
                                </div>

                                <!-- Issue Description -->
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($order->issue_description, 80) }}</p>

                                <!-- Schedule -->
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                    {{ date('d M Y', strtotime($order->schedule_date)) }}
                                </div>

                                <!-- Action -->
                                <button
                                    onclick="openDetailModal({{ json_encode([
                                        'customer_name' => $order->user->name,
                                        'customer_phone' => $order->user->phone,
                                        'customer_email' => $order->user->email,
                                        'device_type' => $order->device_type,
                                        'brand' => $order->brand,
                                        'issue_description' => $order->issue_description,
                                        'address' => $order->address,
                                        'schedule_date_formatted' => date('d F Y', strtotime($order->schedule_date)),
                                        'estimated_cost' => $order->estimated_cost,
                                        'final_cost' => $order->final_cost,
                                        'status' => $order->status,
                                        'notes' => $order->notes,
                                        'photo' => $order->photo ? asset('storage/' . $order->photo) : null,
                                        'created_at' => optional(\Carbon\Carbon::make($order->created_at))->format('d F Y H:i'),
                                        'completed_at' => optional(\Carbon\Carbon::make($order->completed_at))->format('d F Y H:i'),
                                    ]) }})"
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                    <i data-feather="eye" class="w-4 h-4 inline-block mr-2"></i>
                                    Lihat Detail
                                </button>
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
                        Teknisi ini belum memiliki pesanan yang ditangani.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="detailModal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all animate-scale-in my-8">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl relative sticky top-0 z-10">
                <button onclick="closeDetailModal()"
                    class="absolute top-4 right-4 text-white/80 hover:text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <i data-feather="file-text" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Detail Pesanan</h2>
                        <p class="text-white/80 text-sm">Informasi lengkap pesanan teknisi</p>

                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <!-- Customer Info -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border-2 border-purple-200">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="user" class="w-5 h-5 text-white"></i>
                        </div>
                        INFORMASI PELANGGAN
                    </label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i data-feather="user" class="w-4 h-4 mr-2 text-purple-600"></i>
                            <span id="detailCustomerName" class="font-semibold text-gray-900">-</span>
                        </div>
                        <div class="flex items-center">
                            <i data-feather="phone" class="w-4 h-4 mr-2 text-purple-600"></i>
                            <span id="detailCustomerPhone" class="text-gray-700">-</span>
                        </div>
                        <div class="flex items-center">
                            <i data-feather="mail" class="w-4 h-4 mr-2 text-purple-600"></i>
                            <span id="detailCustomerEmail" class="text-gray-700">-</span>
                        </div>
                    </div>
                </div>

                <!-- Device & Brand Section -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-5 border-2 border-blue-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start">
                            <div
                                class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i id="detailDeviceIcon" data-feather="smartphone" class="text-white w-7 h-7"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 font-semibold mb-1">PERANGKAT</p>
                                <h3 id="detailDevice" class="text-2xl font-bold text-gray-900 capitalize">-</h3>
                                <p id="detailBrand" class="text-sm text-gray-700 mt-1 font-medium">Merek: -</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-600 font-semibold mb-2">STATUS</p>
                            <span id="detailStatus"
                                class="px-4 py-2 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 shadow-sm">-</span>
                        </div>
                    </div>
                </div>

                <!-- Issue Description -->
                <div class="bg-gradient-to-br from-red-50 to-orange-50 p-5 rounded-xl border-l-4 border-red-400">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="alert-circle" class="w-5 h-5 text-white"></i>
                        </div>
                        DESKRIPSI MASALAH
                    </label>
                    <div id="detailIssue" class="text-sm text-gray-700 leading-relaxed">-</div>
                </div>

                <!-- Schedule & Timeline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                        <label class="flex items-center text-xs font-bold text-green-700 mb-3">
                            <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                            JADWAL PERBAIKAN
                        </label>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-feather="clock" class="w-6 h-6 text-white"></i>
                            </div>
                            <p id="detailSchedule" class="font-bold text-gray-900 text-sm">-</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-5 rounded-xl border-2 border-indigo-200">
                        <label class="flex items-center text-xs font-bold text-indigo-700 mb-3">
                            <i data-feather="clock" class="w-4 h-4 mr-2"></i>
                            DIBUAT PADA
                        </label>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-feather="calendar" class="w-6 h-6 text-white"></i>
                            </div>
                            <p id="detailCreatedAt" class="font-bold text-gray-900 text-sm">-</p>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 p-5 rounded-xl border-2 border-cyan-200">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-cyan-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="map-pin" class="w-5 h-5 text-white"></i>
                        </div>
                        ALAMAT LAYANAN
                    </label>
                    <p id="detailAddress" class="text-sm text-gray-700 leading-relaxed">-</p>
                </div>

                <!-- Cost Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-xl border-2 border-amber-200">
                        <label class="flex items-center text-xs font-bold text-amber-700 mb-3">
                            <i data-feather="calculator" class="w-4 h-4 mr-2"></i>
                            ESTIMASI BIAYA
                        </label>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center mr-3">
                                <i data-feather="dollar-sign" class="w-5 h-5 text-white"></i>
                            </div>
                            <p id="detailEstimatedCost" class="font-black text-xl text-amber-700">-</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                        <label class="flex items-center text-xs font-bold text-green-700 mb-3">
                            <i data-feather="credit-card" class="w-4 h-4 mr-2"></i>
                            BIAYA AKHIR
                        </label>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                                <i data-feather="check-circle" class="w-5 h-5 text-white"></i>
                            </div>
                            <p id="detailFinalCost" class="font-black text-xl text-green-700">-</p>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div id="notesSection"
                    class="hidden bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-xl border-l-4 border-blue-400">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="file-text" class="w-5 h-5 text-white"></i>
                        </div>
                        CATATAN TEKNISI
                    </label>
                    <p id="detailNotes" class="text-sm text-gray-700 leading-relaxed">-</p>
                </div>

                <!-- Photo Section -->
                <div id="photoSection"
                    class="hidden bg-gradient-to-br from-gray-50 to-slate-50 p-5 rounded-xl border-2 border-gray-200">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="image" class="w-5 h-5 text-white"></i>
                        </div>
                        FOTO KERUSAKAN
                    </label>
                    <div id="detailPhotoContainer" class="relative group cursor-pointer overflow-hidden rounded-xl">
                        <!-- Photo will be inserted here -->
                    </div>
                </div>

                <!-- Completion Date (if completed) -->
                <div id="completedSection"
                    class="hidden bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                    <label class="flex items-center text-sm font-bold text-gray-800 mb-3">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                            <i data-feather="check-square" class="w-5 h-5 text-white"></i>
                        </div>
                        DISELESAIKAN PADA
                    </label>
                    <p id="detailCompletedAt" class="text-sm font-semibold text-gray-900">-</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 sticky bottom-0">
                <button type="button" onclick="closeDetailModal()"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i data-feather="x-circle" class="w-4 h-4 inline-block mr-2"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Filter Orders Function
        function filterOrders(status) {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const orderRows = document.querySelectorAll('.order-row');
            const orderCards = document.querySelectorAll('.order-card');

            filterButtons.forEach(btn => {
                if (btn.getAttribute('data-filter') === status) {
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'active');
                } else {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'active');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                }
            });

            orderRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            orderCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all' || cardStatus === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Format Rupiah
        function formatRupiah(value) {
            if (!value || value === null || value === '' || value == 0) return 'Belum ditentukan';
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        }

        // Get Device Icon
        function getDeviceIcon(deviceType) {
            const icons = {
                'hp': 'smartphone',
                'laptop': 'monitor',
                'tablet': 'tablet'
            };
            return icons[deviceType] || 'smartphone';
        }

        // Open Detail Modal
        function openDetailModal(orderData) {
            // Customer Info
            document.getElementById('detailCustomerName').textContent = orderData.customer_name;
            document.getElementById('detailCustomerPhone').textContent = orderData.customer_phone;
            document.getElementById('detailCustomerEmail').textContent = orderData.customer_email;

            // Device & Brand
            document.getElementById('detailDevice').textContent = orderData.device_type.toUpperCase();
            document.getElementById('detailBrand').textContent = `Merek: ${orderData.brand}`;
            document.getElementById('detailDeviceIcon').setAttribute('data-feather', getDeviceIcon(orderData.device_type));

            // Issue Description
            document.getElementById('detailIssue').textContent = orderData.issue_description;

            // Address
            document.getElementById('detailAddress').textContent = orderData.address;

            // Schedule
            document.getElementById('detailSchedule').textContent = orderData.schedule_date_formatted;

            // Created At
            document.getElementById('detailCreatedAt').textContent = orderData.created_at;

            // Cost
            document.getElementById('detailEstimatedCost').textContent = formatRupiah(orderData.estimated_cost);
            document.getElementById('detailFinalCost').textContent = formatRupiah(orderData.final_cost);

            // Status
            const statusMap = {
                'pending': {
                    text: 'Menunggu',
                    class: 'bg-yellow-100 text-yellow-800'
                },
                'on_process': {
                    text: 'Dikerjakan',
                    class: 'bg-blue-100 text-blue-800'
                },
                'completed': {
                    text: 'Selesai',
                    class: 'bg-green-100 text-green-800'
                },
                'cancelled': {
                    text: 'Dibatalkan',
                    class: 'bg-red-100 text-red-800'
                }
            };
            const status = statusMap[orderData.status] || {
                text: orderData.status,
                class: 'bg-gray-100 text-gray-800'
            };
            const statusEl = document.getElementById('detailStatus');
            statusEl.textContent = status.text;
            statusEl.className = `px-4 py-2 text-xs font-bold rounded-full ${status.class} shadow-sm`;

            // Notes
            if (orderData.notes) {
                document.getElementById('notesSection').classList.remove('hidden');
                document.getElementById('detailNotes').textContent = orderData.notes;
            } else {
                document.getElementById('notesSection').classList.add('hidden');
            }

            // Photos
            if (orderData.photo) {
                document.getElementById('photoSection').classList.remove('hidden');
                const photoContainer = document.getElementById('detailPhotoContainer');
                photoContainer.innerHTML = '';
                const img = document.createElement('img');
                img.src = orderData.photo;
                img.className =
                    'rounded-lg border border-gray-200 hover:shadow-lg cursor-pointer transition-all object-cover h-40 w-full';
                img.onclick = () => window.open(img.src, '_blank');
                photoContainer.appendChild(img);
            } else {
                document.getElementById('photoSection').classList.add('hidden');
            }

            // Completed At
            if (orderData.completed_at) {
                document.getElementById('completedSection').classList.remove('hidden');
                document.getElementById('detailCompletedAt').textContent = orderData.completed_at;
            } else {
                document.getElementById('completedSection').classList.add('hidden');
            }

            // Show Modal
            document.getElementById('detailModal').classList.remove('hidden');
            feather.replace();
        }

        // Close Detail Modal
        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('detailModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeDetailModal();
                }
            }
        });
    </script>

@endsection
