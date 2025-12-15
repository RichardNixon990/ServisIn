@extends('layout.main')

@section('content')
    <style>
        .tab-btn.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-btn:not(.active) {
            color: #6b7280;
            border-bottom-color: transparent;
        }

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

        /* ===== ANIMATION UTILITIES ===== */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out;
        }
    </style>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">
                        <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Admin
                            Dashboard</span>
                    </h1>
                    <p class="text-gray-600">Kelola sistem dan monitoring seluruh aktivitas</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-white px-5 py-3 rounded-xl shadow-lg border border-gray-100">
                        <div class="flex items-center text-gray-600">
                            <i data-feather="clock" class="w-5 h-5 mr-2 text-blue-600"></i>
                            <span class="text-sm font-semibold" id="currentTime"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Orders -->
                <div
                    class="group bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90 mb-1 font-medium">Total Pesanan</p>
                            <h3 class="text-5xl font-bold mb-1">{{ $totalStatus ?? 0 }}</h3>
                            <p class="text-xs opacity-75">Semua status</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-feather="package" class="w-8 h-8"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Technicians -->
                <div
                    class="group bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90 mb-1 font-medium">Teknisi Aktif</p>
                            <h3 class="text-5xl font-bold mb-1">
                                {{ $technicians->where('status', 'online')->count() }}/{{ $totalTechnician }}</h3>
                            <p class="text-xs opacity-75">Sedang bekerja</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-feather="users" class="w-8 h-8"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div
                    class="group bg-gradient-to-br from-green-500 to-emerald-600 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90 mb-1 font-medium">Total Customer</p>
                            <h3 class="text-5xl font-bold mb-1">{{ $totalUser ?? 0 }}</h3>
                            <p class="text-xs opacity-75">Terdaftar</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-feather="user-check" class="w-8 h-8"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed Today -->
                <div
                    class="group bg-gradient-to-br from-purple-500 to-purple-700 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90 mb-1 font-medium">Selesai Hari Ini</p>
                            <h3 class="text-5xl font-bold mb-1">{{ $completedToday ?? 0 }}</h3>
                            <p class="text-xs opacity-75">Pesanan selesai</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-feather="check-circle" class="w-8 h-8"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <!-- Tambah Teknisi -->
                <button onclick="showAddTechModal()"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <i data-feather="user-plus" class="w-5 h-5 mr-2"></i>
                    <span>Tambah Teknisi</span>
                </button>

                <!-- Export PDF / Laporan -->
                <a href="{{ route('adminexportPdf') }}" target="_blank"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-amber-600 to-orange-700 hover:from-amber-700 hover:to-orange-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <i data-feather="download" class="w-5 h-5 mr-2"></i>
                    <span>Export Laporan Bulanan</span>
                </a>

                <!-- Refresh Data -->
                <button onclick="location.reload()"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <i data-feather="refresh-cw" class="w-5 h-5 mr-2"></i>
                    <span>Refresh Data</span>
                </button>
            </div>

            <!-- Tabs Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 flex overflow-x-auto bg-gray-50" id="tab-buttons">
                    <button
                        class="tab-btn active flex items-center px-6 py-4 text-sm font-bold whitespace-nowrap border-b-4 transition-all duration-300 hover:bg-white"
                        data-tab="orders">
                        <i data-feather="package" class="w-5 h-5 mr-2"></i>
                        Pesanan Terbaru
                    </button>
                    <button
                        class="tab-btn flex items-center px-6 py-4 text-sm font-bold whitespace-nowrap border-b-4 transition-all duration-300 hover:bg-white"
                        data-tab="technicians">
                        <i data-feather="users" class="w-5 h-5 mr-2"></i>
                        Teknisi
                    </button>
                    <button
                        class="tab-btn flex items-center px-6 py-4 text-sm font-bold whitespace-nowrap border-b-4 transition-all duration-300 hover:bg-white"
                        data-tab="customers">
                        <i data-feather="user-check" class="w-5 h-5 mr-2"></i>
                        Customer
                    </button>
                    <button
                        class="tab-btn flex items-center px-6 py-4 text-sm font-bold whitespace-nowrap border-b-4 transition-all duration-300 hover:bg-white"
                        data-tab="analytics">
                        <i data-feather="bar-chart-2" class="w-5 h-5 mr-2"></i>
                        Analitik
                    </button>
                </div>

                <!-- Tab Content: Orders -->
                <div id="orders" class="tab-content p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Customer</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Teknisi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Perangkat</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Jadwal</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Example Data - Replace with real data loop -->
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-blue-50 transition-colors">

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">{{ $order->id ?? 'Tidak diketahui' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $order->user->name ?? 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $order->technician->user->name ?? 'Teknisi belum tersedia' }} </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i data-feather="smartphone" class="w-4 h-4 mr-2 text-blue-600"></i>
                                                <span
                                                    class="text-sm text-gray-900">{{ $order->device_type ?? 'tidak ditemukan' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">{{ $order->status ?? 'tidak ditemukan' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($order->schedule_date)->translatedFormat('j F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-2">
                                                <button
                                                    onclick='openViewOrderModal({
                                                    id: {{ $order->id }},
                                                    status: "{{ $order->status }}",
                                                    customer_name: "{{ $order->user->name }}",
                                                    customer_phone: "{{ $order->user->phone }}",
                                                    customer_email: "{{ $order->user->email }}",
                                                    technician_name: "{{ $order->technician->user->name ?? '' }}",
                                                    technician_specialization: "{{ $order->technician->specialization ?? '' }}",
                                                    technician_phone: "{{ $order->technician->user->phone ?? '' }}",
                                                    technician_experience: "{{ $order->technician->experience_years ?? '' }}",
                                                    device_type: "{{ $order->device_type }}",
                                                    brand: "{{ str_replace('"', '\"', $order->brand) }}",
                                                    issue_description: "{{ str_replace(["\r", "\n", '"'], ['', ' ', '\"'], $order->issue_description) }}",
                                                    schedule_date_formatted: "{{ \Carbon\Carbon::parse($order->schedule_date)->translatedFormat('l, j F Y') }}",
                                                    estimated_cost: "{{ $order->estimated_cost ?? '' }}",
                                                    address: "{{ str_replace(["\r", "\n", '"'], ['', ' ', '\"'], $order->address ?? '') }}",
                                                    photo: "{{ $order->photo ? asset('storage/' . $order->photo) : '' }}",
                                                    final_cost: "{{ $order->final_cost ?? '' }}",
                                                    completed_at_formatted: "{{ $order->completed_at ? \Carbon\Carbon::parse($order->completed_at)->translatedFormat('l, j F Y - H:i') . ' WIB' : '' }}",
                                                    cancelled_at_formatted: "{{ $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->translatedFormat('l, j F Y - H:i') . ' WIB' : '' }}",
                                                    notes: "{{ str_replace(["\r", "\n", '"'], ['', ' ', '\"'], $order->notes ?? '') }}"
                                                        })'
                                                    class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                                    title="Lihat Detail">
                                                    <i data-feather="eye" class="w-4 h-4"></i>
                                                </button>
                                                <button
                                                    onclick="openEditOrderModal({{ $order->id }}, {
                                                        technician_id: '{{ $order->technician_id ?? '' }}',
                                                        device_type: '{{ $order->device_type }}',
                                                        brand: '{{ $order->brand }}',
                                                        schedule_date: '{{ $order->schedule_date }}',
                                                        estimated_cost: '{{ $order->estimated_cost ?? '' }}',
                                                        status: '{{ $order->status }}',
                                                        address: '{{ addslashes($order->address ?? '') }}'
                                                    })"
                                                    class="p-2 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                                </button>
                                                <form action={{ route('orderdelete', $order->id) }} method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                                        title="Hapus">
                                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Add empty state if no data -->
                                @if ($orders->isEmpty())
                                    <tr id="emptyOrders">
                                        <td colspan="7" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <i data-feather="inbox" class="w-16 h-16 text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 font-medium">Belum ada pesanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Content: Technicians -->
                <div id="technicians" class="tab-content hidden p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Example Technician Card - Replace with real data -->
                        @foreach ($technicians as $technician)
                            @php
                                $techData = [
                                    'name' => $technician->user->name,
                                    'email' => $technician->user->email,
                                    'phone' => $technician->user->phone,
                                    'address' => $technician->user->address ?? '',
                                    'specialization' => $technician->specialization,
                                    'experience_years' => $technician->experience_years,
                                    'status' => $technician->status,
                                ];
                            @endphp
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:-translate-y-1 transition-all relative">

                                <!-- Action Buttons di Pojok Kanan Atas -->
                                <div class="absolute top-4 right-4 flex gap-2">
                                    <!-- Button Detail -->
<button
    onclick="viewTechnicianDetail({
        id: {{ $technician->id }},
        name: '{{ e($technician->user->name) }}',
        email: '{{ e($technician->user->email) }}',
        phone: '{{ e($technician->user->phone) }}',
        address: '{{ e($technician->user->address) }}',
        specialization: '{{ e($technician->specialization) }}',
        experience_years: {{ $technician->experience_years ?? 'null' }},
        status: '{{ $technician->status }}',
        average_rating: {{ $technician->average_rating ?? 0 }},
        total_orders: {{ $technician->total_orders ?? 0 }},
        completed_orders: {{ $technician->completed_orders ?? 0 }},
        active_orders: {{ $technician->active_orders ?? 0 }}
    })"
    class="group w-8 h-8 bg-blue-100 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all duration-300"
    title="Lihat Detail">
    <i data-feather="eye"
       class="w-4 h-4 text-blue-600 group-hover:text-white transition-colors"></i>
</button>

                                    <!-- Button Edit -->
                                    <button onclick='editTechnician({{ $technician->id }}, @json($techData))'
                                        class="group w-8 h-8 bg-amber-100 hover:bg-amber-600 rounded-lg flex items-center justify-center transition-all duration-300"
                                        title="Edit Teknisi">
                                        <i data-feather="edit-2"
                                            class="w-4 h-4 text-amber-600 group-hover:text-white transition-colors"></i>
                                    </button>


                                    <!-- Button Delete -->
                                    <form action="{{ route('admindelete', $technician->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event, '{{ addslashes($technician->user->name) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="group w-8 h-8 bg-red-100 hover:bg-red-600 rounded-lg flex items-center justify-center transition-all duration-300"
                                            title="Hapus Teknisi">
                                            <i data-feather="trash-2"
                                                class="w-4 h-4 text-red-600 group-hover:text-white transition-colors"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="flex items-center mb-4 pr-20">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        {{ strtoupper(substr($technician->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $technician->user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $technician->user->phone }}</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-semibold text-gray-700">Pesanan Aktif</span>
                                        <span class="font-bold text-gray-900">{{ $technician->active_orders }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ ($technician->active_orders / 5) * 100 }}%"></div>
                                    </div>
                                </div>

                                <div class="flex items-center mb-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($technician->average_rating ?? 0))
                                            <i data-feather="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                                        @else
                                            <i data-feather="star" class="w-4 h-4 text-gray-300 fill-current"></i>
                                        @endif
                                    @endfor
                                    <span
                                        class="ml-2 text-sm text-gray-600">({{ number_format($technician->average_rating ?? 0, 1) }})</span>
                                </div>

                                @if ($technician->status === 'online')
                                    <span
                                        class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold mb-4">Tersedia</span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold mb-4">Tidak
                                        Tersedia</span>
                                @endif

                                <div class="flex gap-2">
                                    <a href="{{ 'https://wa.me/+62' . ltrim($technician->user->phone, 0) }}"
                                        target="_blank"
                                        class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-all">
                                        <i data-feather="phone" class="w-4 h-4 inline mr-1"></i>Hubungi
                                    </a>

                                    <button onclick="window.location='{{ route('adminshowOrder', $technician->id) }}'"
                                        class="flex-1 px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold rounded-lg transition-all">
                                        <i data-feather="list" class="w-4 h-4 inline mr-1"></i>Pesanan
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab Content: Customers -->
                <div id="customers" class="tab-content hidden p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-green-600 to-green-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Telepon</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Total Pesanan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Bergabung</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name ?? 'Tidak Ditemukan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email ?? 'Email Tidak Ditemukan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->phone ?? 'Tidak Ditemukan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">
                                                {{ $user->orders_count }} Pesanan
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('j F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-2">
                                                <button
                                                    class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors view-customer-detail-btn"
                                                    title="Lihat Detail" data-customer-id="{{ $user->id }}"
                                                    data-customer-name="{{ $user->name }}"
                                                    data-customer-email="{{ $user->email }}"
                                                    data-customer-phone="{{ $user->phone }}"
                                                    data-customer-address="{{ $user->address ?? '-' }}"
                                                    data-customer-total-orders="{{ $user->orders_count ?? 0 }}"
                                                    data-customer-completed="{{ $user->completed_orders_count ?? 0 }}"
                                                    data-customer-active="{{ $user->active_orders_count ?? 0 }}"
                                                    data-customer-pending="{{ $user->pending_orders_count ?? 0 }}"
                                                    data-customer-join-date="{{ $user->created_at ? $user->created_at->translatedFormat('l, j F Y') : '-' }}">
                                                    <i data-feather="eye" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Content: Analytics -->
                <div id="analytics" class="tab-content hidden p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Device Analytics -->
                        <div class="bg-gray-50 rounded-2xl p-6 border-2 border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="pie-chart" class="w-5 h-5 mr-2 text-blue-600"></i>
                                Pesanan per Jenis Perangkat
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">HP</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $deviceStats['hp'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $barDevice['hp'] }}%">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Laptop</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $deviceStats['laptop'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-purple-500 h-3 rounded-full"
                                            style="width: {{ $barDevice['laptop'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Tablet</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $deviceStats['tablet'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-green-500 h-3 rounded-full"
                                            style="width: {{ $barDevice['tablet'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Analytics -->
                        <div class="bg-gray-50 rounded-2xl p-6 border-2 border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="activity" class="w-5 h-5 mr-2 text-blue-600"></i>
                                Pesanan per Status
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">pending</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $statusStats['pending'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-yellow-500 h-3 rounded-full"
                                            style="width: {{ $barStatus['pending'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Dikerjakan</span>
                                        <span
                                            class="text-sm font-bold text-gray-900">{{ $statusStats['on_process'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-amber-500 h-3 rounded-full"
                                            style="width: {{ $barStatus['on_process'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Selesai</span>
                                        <span
                                            class="text-sm font-bold text-gray-900">{{ $statusStats['completed'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-green-500 h-3 rounded-full"
                                            style="width: {{ $barStatus['completed'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Dibatalkan</span>
                                        <span
                                            class="text-sm font-bold text-gray-900">{{ $statusStats['cancelled'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-red-500 h-3 rounded-full"
                                            style="width: {{ $barStatus['cancelled'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL --}}
    <div id="addTechnicianModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeAddTechnicianModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="user-plus" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Tambah Teknisi Baru</h3>
                                <p class="text-blue-100 text-sm">Isi informasi teknisi baru</p>
                            </div>
                        </div>
                        <button onclick="closeAddTechnicianModal()"
                            class="text-white hover:text-blue-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="addTechnicianForm" method="POST" action={{ route('adminstoreTechnician') }}>
                    @csrf
                    <div class="p-6 space-y-6">
                        <!-- NAME INPUT -->
                        <div>
                            <label for="techName" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="user" class="w-4 h-4 text-blue-600"></i>
                                </div>
                                Nama Lengkap <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="techName" name="name"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Masukkan nama lengkap teknisi">
                        </div>

                        <!-- EMAIL INPUT -->
                        <div>
                            <label for="techEmail" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="mail" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Email <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="email" id="techEmail" name="email"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="contoh@email.com">
                        </div>

                        <div>
                            <label for="techPhone" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="phone" class="w-4 h-4 text-green-600"></i>
                                </div>
                                No. Telepon <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="techPhone" name="phone"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="08xx xxxx xxxx">
                            <p class="text-xs text-gray-500 mt-1 ml-1">
                                <i data-feather="info" class="w-3 h-3 inline-block mr-1"></i>
                                Format: 08xxxxxxxxxx
                            </p>
                        </div>


                        <div>
                            <label for="techAddress" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="map-pin" class="w-4 h-4 text-red-600"></i>
                                </div>
                                Alamat Lengkap <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea id="techAddress" name="address" rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all outline-none text-gray-800 resize-none"
                                placeholder="Masukkan alamat lengkap teknisi"></textarea>
                        </div>

                        <div>
                            <label for="techSpecialization"
                                class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-amber-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="tool" class="w-4 h-4 text-amber-600"></i>
                                </div>
                                Keahlian/Spesialisasi <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="techSpecialization" name="specialization"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Contoh: HP, Laptop, Tablet">
                        </div>

                        <div>
                            <label for="techExperience" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="award" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                                Pengalaman (Tahun) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="number" id="techExperience" name="experience_years" min="0"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Masukkan pengalaman dalam tahun">
                        </div>

                        <div>
                            <label for="techPassword" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-rose-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="lock" class="w-4 h-4 text-rose-600"></i>
                                </div>
                                Password <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="password" id="techPassword" name="password"  minlength="8"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Minimal 8 karakter">
                            <p class="text-xs text-gray-500 mt-1 ml-1">
                                <i data-feather="alert-circle" class="w-3 h-3 inline-block mr-1"></i>
                                Password minimal 8 karakter
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-xl border-l-4 border-blue-400 shadow-sm">
                            <div class="flex items-start">
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                    <i data-feather="info" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-blue-700 mb-1">INFORMASI</h4>
                                    <p class="text-xs text-blue-600 leading-relaxed">Pastikan semua data yang
                                        dimasukkan
                                        sudah benar. Teknisi akan mendapatkan akses login setelah berhasil
                                        ditambahkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 flex gap-3">
                        <button type="button" onclick="closeAddTechnicianModal()"
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                            <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <i data-feather="check-circle" class="w-4 h-4 inline-block mr-2"></i>Tambah Teknisi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal edit order --}}
    <!-- ===== EDIT ORDER MODAL ===== -->
    <div id="editOrderModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeEditOrderModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-amber-600 to-orange-700 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="edit-2" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Edit Pesanan</h3>
                                <p class="text-orange-100 text-sm">Ubah informasi pesanan</p>
                            </div>
                        </div>
                        <button onclick="closeEditOrderModal()"
                            class="text-white hover:text-orange-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="editOrderForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Order Info -->
                        <div class="bg-amber-50 p-4 rounded-xl border-2 border-amber-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center mr-3">
                                    <i data-feather="info" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-amber-600">ORDER ID</p>
                                    <p class="text-sm font-bold text-gray-800" id="editModalOrderId">#0000</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Technician Select -->
                            <div class="md:col-span-2">
                                <label for="edit_technician_id"
                                    class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="user-check" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    Teknisi <span class="text-gray-400 ml-1 text-xs">(Opsional)</span>
                                </label>
                                <select id="edit_technician_id" name="technician_id"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-gray-800 font-semibold">
                                    <option value="">Pilih Teknisi (Opsional)</option>
                                    @foreach ($technicians ?? [] as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->user->name }} -
                                            {{ $tech->specialization }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1 ml-1">
                                    <i data-feather="info" class="w-3 h-3 inline-block mr-1"></i>
                                    Kosongkan jika belum ada teknisi yang ditugaskan
                                </p>
                            </div>

                            <!-- Device Type -->
                            <div>
                                <label for="edit_device_type"
                                    class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="smartphone" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                    Jenis Perangkat <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="edit_device_type" name="device_type"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all outline-none text-gray-800 font-semibold">
                                    <option value="">Pilih Jenis Perangkat</option>
                                    <option value="hp">HP</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="tablet">Tablet</option>
                                </select>
                            </div>

                            <!-- Brand -->
                            <div>
                                <label for="edit_brand" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="tag" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    Merk <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" id="edit_brand" name="brand"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-800 font-semibold"
                                    placeholder="Contoh: Samsung, Apple, Asus">
                            </div>

                            <!-- Schedule Date -->
                            <div>
                                <label for="edit_schedule_date"
                                    class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="calendar" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    Jadwal Servis <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="date" id="edit_schedule_date" name="schedule_date"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-gray-800 font-semibold">
                                <p class="text-xs text-gray-500 mt-1 ml-1">
                                    <i data-feather="alert-circle" class="w-3 h-3 inline-block mr-1"></i>
                                    Tanggal harus hari ini atau sesudahnya
                                </p>
                            </div>

                            <!-- Estimated Cost -->
                            <div>
                                <label for="edit_estimated_cost"
                                    class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="dollar-sign" class="w-4 h-4 text-yellow-600"></i>
                                    </div>
                                    Estimasi Biaya <span class="text-gray-400 ml-1 text-xs">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                    <input type="number" id="edit_estimated_cost" name="estimated_cost" min="0"
                                        step="1000"
                                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none text-gray-800 font-semibold"
                                        placeholder="Estimasi biaya">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-2">
                                <label for="edit_status" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="activity" class="w-4 h-4 text-indigo-600"></i>
                                    </div>
                                    Status <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="edit_status" name="status"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none text-gray-800 font-semibold">
                                    <option value="">Pilih Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="on_process">Sedang Dikerjakan</option>
                                    <option value="completed">Selesai</option>
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="edit_address" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                    <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                        <i data-feather="map-pin" class="w-4 h-4 text-red-600"></i>
                                    </div>
                                    Alamat <span class="text-gray-400 ml-1 text-xs">(Opsional)</span>
                                </label>
                                <textarea id="edit_address" name="address" rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all outline-none text-gray-800 resize-none"
                                    placeholder="Masukkan alamat lengkap (opsional)"></textarea>
                                <p class="text-xs text-gray-500 mt-1 ml-1">
                                    <i data-feather="info" class="w-3 h-3 inline-block mr-1"></i>
                                    Alamat dapat dikosongkan jika menggunakan alamat default customer
                                </p>
                            </div>
                        </div>

                        <!-- Warning Box -->
                        <div class="bg-amber-50 p-4 rounded-xl border-2 border-amber-200">
                            <div class="flex items-start">
                                <div
                                    class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                    <i data-feather="alert-triangle" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-amber-900 mb-1">Perhatian!</h4>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Pastikan data yang diubah sudah benar. Perubahan akan langsung tersimpan
                                        setelah
                                        dikonfirmasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 flex gap-3">
                        <button type="button" onclick="closeEditOrderModal()"
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                            <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-700 hover:from-amber-700 hover:to-orange-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <i data-feather="save" class="w-4 h-4 inline-block mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal detail order --}}
    <div id="viewOrderModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeViewOrderModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="file-text" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Detail Pesanan</h3>
                                <p class="text-blue-100 text-sm">Informasi lengkap pesanan</p>
                            </div>
                        </div>
                        {{-- <button onclick="closeViewOrderModal()" class="text-white hover:text-blue-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button> --}}
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <!-- Order ID & Status -->
                    <div class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px] bg-blue-50 p-4 rounded-xl border-2 border-blue-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <i data-feather="hash" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-blue-600">ORDER ID</p>
                                    <p class="text-sm font-bold text-gray-800" id="viewOrderId">#0000</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex-1 min-w-[200px] bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-xl border-2 border-purple-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <i data-feather="activity" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-purple-600">STATUS</p>
                                    <p class="text-sm font-bold text-gray-800" id="viewStatus">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="user" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">INFORMASI CUSTOMER</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-green-700 mb-1">Nama</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewCustomerName">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-green-700 mb-1">No. Telepon</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewCustomerPhone">-</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-green-700 mb-1">Email</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewCustomerEmail">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Technician Info -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-xl border-2 border-blue-200"
                        id="technicianSection">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="user-check" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">TEKNISI YANG MENANGANI</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Nama Teknisi</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewTechnicianName">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Spesialisasi</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewTechnicianSpec">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">No. Telepon</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewTechnicianPhone">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Pengalaman</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewTechnicianExp">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Device Info -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-xl border-2 border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="smartphone" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">INFORMASI PERANGKAT</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-purple-700 mb-1">Jenis Perangkat</p>
                                <p class="text-sm text-gray-800 font-medium capitalize" id="viewDeviceType">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-purple-700 mb-1">Merk</p>
                                <p class="text-sm text-gray-800 font-medium" id="viewBrand">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Issue Description -->
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 p-5 rounded-xl border-l-4 border-red-400">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="alert-circle" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">DESKRIPSI KERUSAKAN</h4>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed" id="viewIssueDesc">-</p>
                    </div>

                    <!-- Schedule & Address -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Schedule Date -->
                        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-5 rounded-xl border-2 border-amber-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="calendar" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">JADWAL SERVIS</h4>
                            </div>
                            <p class="text-sm text-gray-800 font-medium" id="viewScheduleDate">-</p>
                        </div>

                        <!-- Estimated Cost -->
                        <div
                            class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="dollar-sign" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">ESTIMASI BIAYA</h4>
                            </div>
                            <p class="text-lg text-gray-800 font-bold" id="viewEstimatedCost">-</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-5 rounded-xl border-2 border-indigo-200">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="map-pin" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">ALAMAT LENGKAP</h4>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3" id="viewAddress">-</p>
                        <a href="#" id="viewAddressMap" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center text-xs font-semibold text-indigo-700 hover:text-indigo-800 bg-white px-3 py-2 rounded-lg hover:shadow-md transition-all">
                            <i data-feather="navigation" class="w-3 h-3 mr-1.5"></i>
                            Buka di Google Maps
                            <i data-feather="external-link" class="w-3 h-3 ml-1"></i>
                        </a>
                    </div>

                    <!-- Photo (if exists) -->
                    <div id="photoSection" class="hidden">
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-5 rounded-xl border-2 border-gray-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="image" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">FOTO KERUSAKAN</h4>
                            </div>
                            <div class="relative group cursor-pointer overflow-hidden rounded-xl border-2 border-gray-300 hover:border-indigo-400 transition-all"
                                onclick="viewImageFullscreen()">
                                <img id="viewPhoto" src="" alt="Foto Kerusakan"
                                    class="w-full h-64 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                    <div class="text-center">
                                        <i data-feather="zoom-in"
                                            class="w-10 h-10 text-white mb-2 mx-auto group-hover:scale-110 transition-transform"></i>
                                        <p class="text-white font-semibold text-sm">Klik untuk memperbesar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completion Info (if completed) -->
                    <div id="completionSection" class="hidden space-y-4">
                        <!-- Final Cost -->
                        <div
                            class="bg-gradient-to-br from-yellow-50 to-orange-50 p-5 rounded-xl border-2 border-yellow-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="dollar-sign" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">BIAYA AKHIR</h4>
                            </div>
                            <p class="text-2xl text-gray-800 font-black" id="viewFinalCost">-</p>
                        </div>

                        <!-- Completed Date -->
                        <div
                            class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="check-circle" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">DISELESAIKAN PADA</h4>
                            </div>
                            <p class="text-sm text-gray-800 font-medium" id="viewCompletedDate">-</p>
                        </div>

                        <!-- Notes -->
                        <div id="notesSection"
                            class="hidden bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-xl border-l-4 border-blue-400">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="file-text" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">CATATAN TEKNISI</h4>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed" id="viewNotes">-</p>
                        </div>
                    </div>

                    <!-- Cancelled Info (if cancelled) -->
                    <div id="cancelledSection"
                        class="hidden bg-gradient-to-br from-red-50 to-pink-50 p-5 rounded-xl border-2 border-red-200">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="x-circle" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">DIBATALKAN PADA</h4>
                        </div>
                        <p class="text-sm text-gray-800 font-medium" id="viewCancelledDate">-</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 sticky bottom-0">
                    <button onclick="closeViewOrderModal()"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Fullscreen Modal -->
    <div id="imageFullscreenModal" class="hidden fixed inset-0 z-[10000] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeImageFullscreen()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <button onclick="closeImageFullscreen()"
                class="absolute top-6 right-6 z-10 text-white hover:text-gray-300 transition-all bg-white/10 backdrop-blur-md hover:bg-white/20 rounded-full p-3 group">
                <i data-feather="x" class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
            <div class="relative max-w-6xl max-h-[90vh] animate-scale-in">
                <img id="fullscreenImage" src="" alt="Preview"
                    class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl object-contain">
            </div>
        </div>
    </div>

    {{-- modal user --}}
    <div id="viewCustomerModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeViewCustomerModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-800 px-6 py-5 rounded-t-2xl sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="user" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Detail Customer</h3>
                                <p class="text-green-100 text-sm">Informasi lengkap customer</p>
                            </div>
                        </div>
                        <button onclick="closeViewCustomerModal()"
                            class="text-white hover:text-green-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">

                    <!-- Customer ID & Avatar -->
                    <div
                        class="flex items-center gap-6 bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-white text-4xl font-bold" id="modalCustomerInitial">?</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-green-600 mb-1">CUSTOMER ID</p>
                            <h2 class="text-2xl font-bold text-gray-800 mb-1" id="modalCustomerNameLarge">-</h2>
                            <p class="text-sm text-gray-600" id="modalCustomerIdLabel">#0000</p>
                        </div>
                    </div>

                    <!-- INFORMASI PRIBADI -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-xl border-2 border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="user" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">INFORMASI PRIBADI</h4>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Nama Lengkap</p>
                                <p class="text-sm text-gray-800 font-medium" id="modalCustomerName">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- INFORMASI KONTAK -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-xl border-2 border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="phone" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">INFORMASI KONTAK</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-purple-700 mb-2">Email</p>
                                <div
                                    class="flex items-center justify-between p-3 bg-white rounded-lg border border-purple-200">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <i data-feather="mail" class="w-4 h-4 text-purple-600 mr-2 flex-shrink-0"></i>
                                        <span class="text-sm font-medium text-gray-800 truncate"
                                            id="modalCustomerEmail">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-purple-700 mb-2">No. Telepon</p>
                                <div
                                    class="flex items-center justify-between p-3 bg-white rounded-lg border border-purple-200">
                                    <div class="flex items-center flex-1">
                                        <i data-feather="phone" class="w-4 h-4 text-purple-600 mr-2 flex-shrink-0"></i>
                                        <span class="text-sm font-medium text-gray-800" id="modalCustomerPhone">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-5 rounded-xl border-2 border-orange-200">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="map-pin" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">ALAMAT LENGKAP</h4>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3" id="modalCustomerAddress">-</p>
                        <a href="#" id="modalCustomerMapLink" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center text-xs font-semibold text-orange-700 hover:text-orange-800 bg-white px-3 py-2 rounded-lg hover:shadow-md transition-all">
                            <i data-feather="navigation" class="w-3 h-3 mr-1.5"></i>
                            Buka di Google Maps
                            <i data-feather="external-link" class="w-3 h-3 ml-1"></i>
                        </a>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-5 rounded-xl border-2 border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="bar-chart-2" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">STATISTIK PESANAN</h4>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white p-3 rounded-lg border border-indigo-200 text-center">
                                <p class="text-xs font-semibold text-indigo-700 mb-1">Total Pesanan</p>
                                <p class="text-2xl font-bold text-gray-800" id="modalCustomerTotalOrders">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-green-200 text-center">
                                <p class="text-xs font-semibold text-green-700 mb-1">Selesai</p>
                                <p class="text-2xl font-bold text-gray-800" id="modalCustomerCompleted">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-amber-200 text-center">
                                <p class="text-xs font-semibold text-amber-700 mb-1">Proses</p>
                                <p class="text-2xl font-bold text-gray-800" id="modalCustomerActive">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-yellow-200 text-center">
                                <p class="text-xs font-semibold text-yellow-700 mb-1">Pending</p>
                                <p class="text-2xl font-bold text-gray-800" id="modalCustomerPending">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Join Date -->
                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-5 rounded-xl border-2 border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                                <i data-feather="calendar" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-600 mb-1">BERGABUNG SEJAK</p>
                                <p class="text-sm text-gray-800 font-medium" id="modalCustomerJoinDate">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 sticky bottom-0">
                    <button onclick="closeViewCustomerModal()"
                        class="w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                        <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL DETAIL TEKNISI ===== -->
    <div id="viewTechnicianModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeViewTechnicianModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="user-check" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Detail Teknisi</h3>
                                <p class="text-blue-100 text-sm">Informasi lengkap teknisi</p>
                            </div>
                        </div>
                        <button onclick="closeViewTechnicianModal()"
                            class="text-white hover:text-blue-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">

                    <!-- Tech ID & Avatar -->
                    <div
                        class="flex items-center gap-6 bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-xl border-2 border-blue-200">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-white text-4xl font-bold" id="techModalInitial">?</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-blue-600 mb-1">TEKNISI ID</p>
                            <h2 class="text-2xl font-bold text-gray-800 mb-1" id="techModalName">-</h2>
                            <p class="text-sm text-gray-600" id="techModalIdLabel">#0000</p>
                        </div>
                    </div>

                    <!-- Status & Availability -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="activity" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">STATUS</h4>
                            </div>
                            <p class="text-lg font-bold" id="techModalStatus">-</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-xl border-2 border-purple-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="star" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">RATING</h4>
                            </div>
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-800 mr-2" id="techModalRating">0.0</span>
                                <div class="flex" id="techModalStars"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Kontak -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-xl border-2 border-amber-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="phone" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">INFORMASI KONTAK</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-amber-700 mb-1">Email</p>
                                <p class="text-sm text-gray-800 font-medium break-all" id="techModalEmail">-</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-amber-700 mb-1">No. Telepon</p>
                                <p class="text-sm text-gray-800 font-medium" id="techModalPhone">-</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-amber-700 mb-1">Alamat</p>
                                <p class="text-sm text-gray-700 leading-relaxed" id="techModalAddress">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keahlian & Pengalaman -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-5 rounded-xl border-2 border-indigo-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="tool" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">SPESIALISASI</h4>
                            </div>
                            <p class="text-lg font-bold text-gray-800" id="techModalSpec">-</p>
                        </div>

                        <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-5 rounded-xl border-2 border-rose-200">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 bg-rose-600 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="award" class="w-5 h-5 text-white"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">PENGALAMAN</h4>
                            </div>
                            <p class="text-lg font-bold text-gray-800" id="techModalExp">-</p>
                        </div>
                    </div>

                    <!-- Statistik Pesanan -->
                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-5 rounded-xl border-2 border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-2">
                                <i data-feather="bar-chart-2" class="w-5 h-5 text-white"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800">STATISTIK PESANAN</h4>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Total</p>
                                <p class="text-2xl font-bold text-gray-800" id="techModalTotalOrders">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-green-200 text-center">
                                <p class="text-xs font-semibold text-green-700 mb-1">Selesai</p>
                                <p class="text-2xl font-bold text-gray-800" id="techModalCompleted">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-amber-200 text-center">
                                <p class="text-xs font-semibold text-amber-700 mb-1">Aktif</p>
                                <p class="text-2xl font-bold text-gray-800" id="techModalActive">0</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 sticky bottom-0 flex gap-3">
                    <button onclick="closeViewTechnicianModal()"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                        <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Tutup
                    </button>
                    <a href="#" id="techModalWhatsApp" target="_blank"
                        class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all text-center">
                        <i data-feather="phone" class="w-4 h-4 inline-block mr-2"></i>Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL EDIT TEKNISI ===== -->
    <div id="editTechnicianModal" class="hidden fixed inset-0 z-[9999] animate-fade-in">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-sm" onclick="closeEditTechnicianModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-amber-600 to-orange-700 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i data-feather="edit-2" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Edit Teknisi</h3>
                                <p class="text-orange-100 text-sm">Ubah informasi teknisi</p>
                            </div>
                        </div>
                        <button onclick="closeEditTechnicianModal()"
                            class="text-white hover:text-orange-100 transition-colors">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="editTechnicianForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Technician Info -->
                        <div class="bg-amber-50 p-4 rounded-xl border-2 border-amber-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center mr-3">
                                    <i data-feather="info" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-amber-600">TEKNISI ID</p>
                                    <p class="text-sm font-bold text-gray-800" id="editTechModalId">#0000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="edit_tech_name" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="user" class="w-4 h-4 text-blue-600"></i>
                                </div>
                                Nama Lengkap <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="edit_tech_name" name="name"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="edit_tech_email" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="mail" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Email <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="email" id="edit_tech_email" name="email"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="contoh@email.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="edit_tech_phone" class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="phone" class="w-4 h-4 text-green-600"></i>
                                </div>
                                No. Telepon <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="edit_tech_phone" name="phone"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="08xx xxxx xxxx">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="edit_tech_address"
                                class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="map-pin" class="w-4 h-4 text-red-600"></i>
                                </div>
                                Alamat Lengkap <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea id="edit_tech_address" name="address" rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all outline-none text-gray-800 resize-none"
                                placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label for="edit_tech_specialization"
                                class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-amber-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="tool" class="w-4 h-4 text-amber-600"></i>
                                </div>
                                Keahlian/Spesialisasi <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="edit_tech_specialization" name="specialization"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Contoh: HP, Laptop, Tablet">
                        </div>

                        <!-- Experience Years -->
                        <div>
                            <label for="edit_tech_experience"
                                class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="award" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                                Pengalaman (Tahun) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="number" id="edit_tech_experience" name="experience_years" min="0"

                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none text-gray-800 font-semibold"
                                placeholder="Masukkan pengalaman dalam tahun">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="edit_tech_status"
                                class="flex items-center text-sm font-bold text-gray-800 mb-2">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-feather="activity" class="w-4 h-4 text-green-600"></i>
                                </div>
                                Status <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="edit_tech_status" name="status"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-800 font-semibold">
                                <option value="online">Online (Tersedia)</option>
                                <option value="offline">Offline (Tidak Tersedia)</option>
                            </select>
                        </div>

                        <!-- Warning Box -->
                        <div class="bg-amber-50 p-4 rounded-xl border-2 border-amber-200">
                            <div class="flex items-start">
                                <div
                                    class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                    <i data-feather="alert-triangle" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-amber-900 mb-1">Perhatian!</h4>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Pastikan data yang diubah sudah benar. Perubahan akan langsung tersimpan setelah
                                        dikonfirmasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200 flex gap-3">
                        <button type="button" onclick="closeEditTechnicianModal()"
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                            <i data-feather="x" class="w-4 h-4 inline-block mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-700 hover:from-amber-700 hover:to-orange-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <i data-feather="save" class="w-4 h-4 inline-block mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .tab-btn.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-btn:not(.active) {
            color: #6b7280;
            border-bottom-color: transparent;
        }

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

        /* ===== ANIMATION UTILITIES ===== */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out;
        }
    </style>

    <script>
        // ===== SUCCESS MESSAGE =====
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 2000,
                showConfirmButton: true
            });
        @endif

        // ===== REAL-TIME CLOCK =====
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
            const formatted = new Intl.DateTimeFormat('id-ID', options).format(now);
            document.getElementById('currentTime').textContent = `${formatted} WIB`;
        }
        updateTime();
        setInterval(updateTime, 60000);

        // ===== TAB SWITCHING =====
        window.switchTab = function(tabName) {
            console.log('=== SWITCHING TAB ===');
            console.log('Target tab:', tabName);

            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.add('hidden');
            });

            const allTabButtons = document.querySelectorAll('.tab-btn');
            allTabButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            const targetTab = document.getElementById(tabName);
            if (targetTab) {
                targetTab.classList.remove('hidden');
                console.log('✅ Tab displayed:', tabName);
            } else {
                console.error('❌ Tab NOT FOUND:', tabName);
            }

            const activeButton = document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
                console.log('✅ Button activated');
            }

            setTimeout(() => {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 100);
        };

        // ===== ADD TECHNICIAN MODAL =====
        window.openAddTechnicianModal = function() {
            const modal = document.getElementById('addTechnicianModal');
            const form = document.getElementById('addTechnicianForm');
            if (modal && form) {
                form.reset();
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => feather.replace(), 50);
            }
        };

        window.closeAddTechnicianModal = function() {
            const modal = document.getElementById('addTechnicianModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        window.showAddTechModal = function() {
            window.openAddTechnicianModal();
        };

        // ===== EDIT ORDER MODAL =====
        window.openEditOrderModal = function(orderId, orderData) {
            const modal = document.getElementById('editOrderModal');
            const form = document.getElementById('editOrderForm');
            const modalOrderId = document.getElementById('editModalOrderId');

            if (modal && form && modalOrderId) {
                form.action = `/admin/orders/${orderId}`;
                modalOrderId.textContent = `#${String(orderId).padStart(4, '0')}`;

                if (orderData) {
                    document.getElementById('edit_technician_id').value = orderData.technician_id || '';
                    document.getElementById('edit_device_type').value = orderData.device_type || '';
                    document.getElementById('edit_brand').value = orderData.brand || '';
                    document.getElementById('edit_schedule_date').value = orderData.schedule_date || '';
                    document.getElementById('edit_estimated_cost').value = orderData.estimated_cost || '';
                    document.getElementById('edit_status').value = orderData.status || '';
                    document.getElementById('edit_address').value = orderData.address || '';
                }

                const today = new Date().toISOString().split('T')[0];
                document.getElementById('edit_schedule_date').setAttribute('min', today);

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => feather.replace(), 50);
            }
        };

        window.closeEditOrderModal = function() {
            const modal = document.getElementById('editOrderModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        // ===== EDIT TECHNICIAN MODAL (DIPERBAIKI - TIDAK ADA DUPLIKASI) =====
        window.editTechnician = function(technicianId, techData) {
            console.log('=== EDIT TECHNICIAN ===');
            console.log('ID:', technicianId);
            console.log('Data:', techData);

            const modal = document.getElementById('editTechnicianModal');
            const form = document.getElementById('editTechnicianForm');

            if (!modal || !form) {
                console.error('❌ Modal atau form tidak ditemukan');
                return;
            }

            if (!techData) {
                console.error('❌ Data teknisi kosong');
                return;
            }

            // CRITICAL FIX: Pastikan ID adalah angka, bukan undefined
            const validId = parseInt(technicianId);
            if (isNaN(validId)) {
                console.error('❌ Invalid technician ID:', technicianId);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'ID Teknisi tidak valid'
                });
                return;
            }

            // Set form action dengan base URL yang benar
            const baseUrl = window.location.origin;
            form.action = `${baseUrl}/admin/technician/${validId}`;
            console.log('✅ Form action:', form.action);

            // Set ID display
            const idElement = document.getElementById('editTechModalId');
            if (idElement) {
                idElement.textContent = `#${String(validId).padStart(4, '0')}`;
                console.log('✅ ID set:', idElement.textContent);
            }

            // Fill form fields
            document.getElementById('edit_tech_name').value = techData.name || '';
            document.getElementById('edit_tech_email').value = techData.email || '';
            document.getElementById('edit_tech_phone').value = techData.phone || '';
            document.getElementById('edit_tech_address').value = techData.address || '';
            document.getElementById('edit_tech_specialization').value = techData.specialization || '';
            document.getElementById('edit_tech_experience').value = techData.experience_years || 0;
            document.getElementById('edit_tech_status').value = techData.status || 'offline';

            console.log('✅ Form fields filled');
            console.log('Form data:', {
                name: techData.name,
                email: techData.email,
                phone: techData.phone
            });

            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            console.log('✅ Modal opened');

            // Refresh feather icons
            setTimeout(() => {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                    console.log('✅ Feather icons refreshed');
                }
            }, 100);
        };

        window.closeEditTechnicianModal = function() {
            const modal = document.getElementById('editTechnicianModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';

                // PERBAIKAN: Jangan reset form di sini!
                // Form akan direset otomatis setelah page reload dari server
                // Kalau direset sekarang, data akan hilang sebelum submit
            }
        };

        // ===== VIEW ORDER MODAL =====
        window.openViewOrderModal = function(orderData) {
            const modal = document.getElementById('viewOrderModal');
            if (!modal || !orderData) return;

            document.getElementById('viewOrderId').textContent = `#${String(orderData.id).padStart(4, '0')}`;

            const statusElement = document.getElementById('viewStatus');
            let statusText = '',
                statusClass = '';

            if (orderData.status === 'pending') {
                statusText = 'Pending';
                statusClass = 'text-yellow-700';
            } else if (orderData.status === 'on_process') {
                statusText = 'Sedang Dikerjakan';
                statusClass = 'text-amber-700';
            } else if (orderData.status === 'completed') {
                statusText = 'Selesai';
                statusClass = 'text-green-700';
            } else if (orderData.status === 'cancelled') {
                statusText = 'Dibatalkan';
                statusClass = 'text-red-700';
            }
            statusElement.textContent = statusText;
            statusElement.className = `text-sm font-bold ${statusClass}`;

            document.getElementById('viewCustomerName').textContent = orderData.customer_name || '-';
            document.getElementById('viewCustomerPhone').textContent = orderData.customer_phone || '-';
            document.getElementById('viewCustomerEmail').textContent = orderData.customer_email || '-';

            const techSection = document.getElementById('technicianSection');
            if (orderData.technician_name) {
                techSection.classList.remove('hidden');
                document.getElementById('viewTechnicianName').textContent = orderData.technician_name || '-';
                document.getElementById('viewTechnicianSpec').textContent = orderData.technician_specialization || '-';
                document.getElementById('viewTechnicianPhone').textContent = orderData.technician_phone || '-';
                document.getElementById('viewTechnicianExp').textContent = orderData.technician_experience ?
                    `${orderData.technician_experience} Tahun` : '-';
            } else {
                techSection.classList.add('hidden');
            }

            document.getElementById('viewDeviceType').textContent = orderData.device_type || '-';
            document.getElementById('viewBrand').textContent = orderData.brand || '-';
            document.getElementById('viewIssueDesc').textContent = orderData.issue_description || '-';
            document.getElementById('viewScheduleDate').textContent = orderData.schedule_date_formatted || '-';
            document.getElementById('viewEstimatedCost').textContent = orderData.estimated_cost ?
                `Rp ${parseInt(orderData.estimated_cost).toLocaleString('id-ID')}` : 'Belum ada estimasi';
            document.getElementById('viewAddress').textContent = orderData.address || '-';

            const mapLink = document.getElementById('viewAddressMap');
            if (orderData.address) {
                mapLink.href = `https://maps.google.com/?q=${encodeURIComponent(orderData.address)}`;
            }

            const photoSection = document.getElementById('photoSection');
            if (orderData.photo) {
                photoSection.classList.remove('hidden');
                document.getElementById('viewPhoto').src = orderData.photo;
            } else {
                photoSection.classList.add('hidden');
            }

            const completionSection = document.getElementById('completionSection');
            if (orderData.status === 'completed') {
                completionSection.classList.remove('hidden');
                document.getElementById('viewFinalCost').textContent = orderData.final_cost ?
                    `Rp ${parseInt(orderData.final_cost).toLocaleString('id-ID')}` : '-';
                document.getElementById('viewCompletedDate').textContent = orderData.completed_at_formatted || '-';

                const notesSection = document.getElementById('notesSection');
                if (orderData.notes) {
                    notesSection.classList.remove('hidden');
                    document.getElementById('viewNotes').textContent = orderData.notes;
                } else {
                    notesSection.classList.add('hidden');
                }
            } else {
                completionSection.classList.add('hidden');
            }

            const cancelledSection = document.getElementById('cancelledSection');
            if (orderData.status === 'cancelled') {
                cancelledSection.classList.remove('hidden');
                document.getElementById('viewCancelledDate').textContent = orderData.cancelled_at_formatted || '-';
            } else {
                cancelledSection.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => feather.replace(), 100);
        };

        window.closeViewOrderModal = function() {
            const modal = document.getElementById('viewOrderModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        // ===== IMAGE FULLSCREEN =====
        window.viewImageFullscreen = function() {
            const photoSrc = document.getElementById('viewPhoto').src;
            if (photoSrc) {
                const modal = document.getElementById('imageFullscreenModal');
                const fullscreenImage = document.getElementById('fullscreenImage');
                fullscreenImage.src = photoSrc;
                modal.classList.remove('hidden');
                setTimeout(() => feather.replace(), 100);
            }
        };

        window.closeImageFullscreen = function() {
            const modal = document.getElementById('imageFullscreenModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        };

        // ===== VIEW CUSTOMER MODAL =====
        window.openViewCustomerModal = function(customerData) {
            const modal = document.getElementById('viewCustomerModal');
            if (!modal || !customerData) return;

            const initial = customerData.name ? customerData.name.charAt(0).toUpperCase() : '?';
            document.getElementById('modalCustomerInitial').textContent = initial;
            document.getElementById('modalCustomerNameLarge').textContent = customerData.name || '-';
            document.getElementById('modalCustomerIdLabel').textContent =
            `#${String(customerData.id).padStart(4, '0')}`;
            document.getElementById('modalCustomerName').textContent = customerData.name || '-';
            document.getElementById('modalCustomerEmail').textContent = customerData.email || '-';
            document.getElementById('modalCustomerPhone').textContent = customerData.phone || '-';
            document.getElementById('modalCustomerAddress').textContent = customerData.address || '-';
            document.getElementById('modalCustomerTotalOrders').textContent = customerData.total_orders || 0;
            document.getElementById('modalCustomerCompleted').textContent = customerData.completed_orders || 0;
            document.getElementById('modalCustomerActive').textContent = customerData.active_orders || 0;
            document.getElementById('modalCustomerPending').textContent = customerData.pending_orders || 0;
            document.getElementById('modalCustomerJoinDate').textContent = customerData.join_date_formatted || '-';

            const addressMapLink = document.getElementById('modalCustomerMapLink');
            if (addressMapLink && customerData.address) {
                addressMapLink.href =
                    `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(customerData.address)}`;
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => feather.replace(), 100);
        };

        window.closeViewCustomerModal = function() {
            const modal = document.getElementById('viewCustomerModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        // ===== VIEW TECHNICIAN MODAL =====
        window.viewTechnicianDetail = function(techData) {
            const modal = document.getElementById('viewTechnicianModal');
            if (!modal || !techData) return;

            const initial = techData.name ? techData.name.substring(0, 2).toUpperCase() : '??';
            document.getElementById('techModalInitial').textContent = initial;
            document.getElementById('techModalName').textContent = techData.name || '-';
            document.getElementById('techModalIdLabel').textContent = `#${String(techData.id).padStart(4, '0')}`;

            const statusElement = document.getElementById('techModalStatus');
            if (techData.status === 'online') {
                statusElement.innerHTML =
                    '<span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">✓ Tersedia</span>';
            } else {
                statusElement.innerHTML =
                    '<span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">✗ Tidak Tersedia</span>';
            }

            const rating = parseFloat(techData.average_rating) || 0;
            document.getElementById('techModalRating').textContent = rating.toFixed(1);

            const starsContainer = document.getElementById('techModalStars');
            starsContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                star.setAttribute('data-feather', 'star');
                star.className = i <= Math.round(rating) ? 'w-4 h-4 text-yellow-400 fill-current' :
                    'w-4 h-4 text-gray-300';
                starsContainer.appendChild(star);
            }

            document.getElementById('techModalEmail').textContent = techData.email || '-';
            document.getElementById('techModalPhone').textContent = techData.phone || '-';
            document.getElementById('techModalAddress').textContent = techData.address || '-';
            document.getElementById('techModalSpec').textContent = techData.specialization || '-';
            document.getElementById('techModalExp').textContent = techData.experience_years ?
                `${techData.experience_years} Tahun` : '-';
            document.getElementById('techModalTotalOrders').textContent = techData.total_orders || 0;
            document.getElementById('techModalCompleted').textContent = techData.completed_orders || 0;
            document.getElementById('techModalActive').textContent = techData.active_orders || 0;

            const waLink = document.getElementById('techModalWhatsApp');
            if (techData.phone) {
                const cleanPhone = techData.phone.replace(/\D/g, '').replace(/^0+/, '');
                waLink.href = `https://wa.me/62${cleanPhone}`;
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => feather.replace(), 100);
        };

        window.closeViewTechnicianModal = function() {
            const modal = document.getElementById('viewTechnicianModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        // ===== DELETE CONFIRMATION =====
        window.confirmDelete = function(event, technicianName) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Teknisi?',
                html: `Apakah Anda yakin ingin menghapus teknisi <strong>${technicianName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        };

        // ===== FORM SUBMISSIONS =====
        document.getElementById('editOrderForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const deviceType = document.getElementById('edit_device_type').value;
            const brand = document.getElementById('edit_brand').value.trim();
            const scheduleDate = document.getElementById('edit_schedule_date').value;
            const status = document.getElementById('edit_status').value;

            if (!deviceType || !brand || !scheduleDate || !status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap!',
                    text: 'Mohon isi semua field yang wajib.'
                });
                return;
            }

            window.closeEditOrderModal();
            setTimeout(() => {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                setTimeout(() => this.submit(), 200);
            }, 200);
        });

        document.getElementById('addTechnicianForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('techName').value.trim();
            const email = document.getElementById('techEmail').value.trim();
            const phone = document.getElementById('techPhone').value.trim();
            const password = document.getElementById('techPassword').value;

            if (!name || !email || !phone || !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap!',
                    text: 'Semua field harus diisi.'
                });
                return;
            }

            window.closeAddTechnicianModal();
            setTimeout(() => {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                setTimeout(() => this.submit(), 200);
            }, 200);
        });

        document.getElementById('editTechnicianForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('edit_tech_name').value.trim();
            const email = document.getElementById('edit_tech_email').value.trim();
            const phone = document.getElementById('edit_tech_phone').value.trim();
            const address = document.getElementById('edit_tech_address').value.trim();
            const specialization = document.getElementById('edit_tech_specialization').value.trim();
            const experience = document.getElementById('edit_tech_experience').value;
            const status = document.getElementById('edit_tech_status').value;

            // Validasi semua field required
            if (!name || !email || !phone || !address || !specialization || !experience || !status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap!',
                    text: 'Semua field harus diisi dengan benar.'
                });
                return;
            }

            console.log('=== SUBMITTING FORM ===');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            console.log('Data to submit:', {
                name,
                email,
                phone,
                address,
                specialization,
                experience,
                status
            });

            // Cek FormData sebelum submit
            const formData = new FormData(this);
            console.log('FormData entries:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // PERBAIKAN KRITIS: Jangan tutup modal dulu, jangan reset form!
            // Langsung submit saja

            Swal.fire({
                title: 'Memproses...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            // Submit form LANGSUNG tanpa menutup modal
            this.submit();
        });

        // ===== EVENT LISTENERS =====
        document.addEventListener('click', function(e) {
            // Customer detail button
            const customerBtn = e.target.closest('.view-customer-detail-btn');
            if (customerBtn) {
                e.preventDefault();
                const customerData = {
                    id: customerBtn.dataset.customerId,
                    name: customerBtn.dataset.customerName,
                    email: customerBtn.dataset.customerEmail,
                    phone: customerBtn.dataset.customerPhone,
                    address: customerBtn.dataset.customerAddress,
                    total_orders: customerBtn.dataset.customerTotalOrders,
                    completed_orders: customerBtn.dataset.customerCompleted,
                    active_orders: customerBtn.dataset.customerActive,
                    pending_orders: customerBtn.dataset.customerPending,
                    join_date_formatted: customerBtn.dataset.customerJoinDate
                };
                window.openViewCustomerModal(customerData);
            }
        });

        // Keyboard events
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modals = ['editOrderModal', 'addTechnicianModal', 'viewOrderModal', 'imageFullscreenModal',
                    'viewCustomerModal', 'viewTechnicianModal', 'editTechnicianModal'
                ];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (modal && !modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
        });

        // ===== INITIALIZE =====
        document.addEventListener('DOMContentLoaded', () => {
            console.log('🚀 Initializing dashboard...');

            // Setup tab click listeners
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');
                    if (tabName) {
                        window.switchTab(tabName);
                    }
                });
            });

            // Show first tab
            window.switchTab('orders');

            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
                console.log('✅ Feather icons loaded');
            }

            console.log('✅ Dashboard ready!');
        });
    </script>
@endpush
