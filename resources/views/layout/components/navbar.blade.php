<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Alert Messages untuk Success/Error -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: '✅ Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        }
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: '❌ Gagal!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        }
    });
</script>
@endif

<nav class="fixed bg-white/80 backdrop-blur-md top-0 left-0 w-full z-50 shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-2">
            <i data-feather="tool" class="w-6 h-6 text-blue-600"></i>
            <span class="text-xl font-bold text-blue-600">ServisIn</span>
        </a>

        <!-- Menu Items -->
        <div class="hidden md:flex items-center space-x-8 font-medium text-gray-700">
            @if (Auth::check())
                @if (Auth::user()->role->nama_role == 'admin')

                @endif
            @endif
        </div>

        <!-- Auth Buttons (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            @if (Auth::check())
                @if (Auth::user()->role->nama_role === 'user')
                    <div class="relative">
                        <button id="profileDropdownBtn"
                            class="flex items-center space-x-2 px-3 py-2 rounded-full hover:bg-blue-50 transition-all group">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold ring-2 ring-blue-200 group-hover:ring-blue-300 transition-all shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span
                                class="font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ Str::limit(Auth::user()->name, 10) }}</span>
                            <i data-feather="chevron-down"
                                class="w-4 h-4 text-gray-600 group-hover:text-blue-600 transition-transform duration-200"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible transform scale-95 transition-all duration-200">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('profileindex') }}"
                                    class="flex items-center px-4 py-3 hover:bg-blue-50 transition-colors group">
                                    <div
                                        class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                        <i data-feather="user" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Profil
                                        Saya</span>
                                </a>

                                <a href="{{ route('orderlist') }}"
                                    class="flex items-center px-4 py-3 hover:bg-green-50 transition-colors group">
                                    <div
                                        class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                        <i data-feather="shopping-bag" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-600">Pesanan
                                        Saya</span>
                                </a>
                            </div>

                            <hr class="my-2 border-gray-200">

                            <!-- Logout -->
                            <div class="py-2">
                                <form action="{{ route('authlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center px-4 py-3 hover:bg-red-50 transition-colors group">
                                        <div
                                            class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                            <i data-feather="log-out" class="w-4 h-4 text-red-600"></i>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-red-600">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif (Auth::user()->role->nama_role === 'technician')
                    @php
                        $technician = Auth::user()->technician;
                    @endphp
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileDropdownBtn"
                            class="flex items-center space-x-2 px-3 py-2 rounded-full hover:bg-blue-50 transition-all group">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold ring-2 ring-blue-200 group-hover:ring-blue-300 transition-all shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span
                                class="font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ Str::limit(Auth::user()->name, 10) }}</span>
                            <i data-feather="chevron-down"
                                class="w-4 h-4 text-gray-600 group-hover:text-blue-600 transition-transform duration-200"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible transform scale-95 transition-all duration-200 z-50">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('technicianDashboard') }}"
                                    class="flex items-center px-4 py-3 hover:bg-blue-50 transition-colors group">
                                    <div
                                        class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                        <i data-feather="home" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Dashboard</span>
                                </a>

                                <a href="{{ route('technicianmyOrder') }}"
                                    class="flex items-center px-4 py-3 hover:bg-green-50 transition-colors group">
                                    <div
                                        class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                        <i data-feather="clipboard" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-600">My Order</span>
                                </a>
                            </div>

                            <!-- Status Toggle Section -->
                            <div class="px-4 py-3 border-t border-b border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i data-feather="power" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-700">Status</span>
                                            <p class="text-xs text-gray-500" id="statusLabel">
                                                @if ($technician && $technician->status === 'online')
                                                    Siap menerima pesanan
                                                @else
                                                    Tidak tersedia
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Toggle Switch dengan Form -->
                                    <form id="statusForm" action="{{ route('technicianupdateStatus') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" id="statusInput"
                                            value="{{ $technician && $technician->status === 'online' ? 'offline' : 'online' }}">

                                        <button type="button" onclick="toggleStatusTechnician(event)" id="statusToggle"
                                            class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                @if ($technician && $technician->status === 'online') bg-green-500
                                @else
                                    bg-gray-300 @endif"
                                            data-status="{{ $technician ? $technician->status : 'offline' }}">
                                            <span class="sr-only">Toggle status</span>
                                            <span
                                                class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition-transform duration-300
                            @if ($technician && $technician->status === 'online') translate-x-6
                            @else
                                translate-x-1 @endif"></span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Status Indicator -->
                                <div class="p-2 rounded-lg
                    @if ($technician && $technician->status === 'online') bg-green-50
                    @else
                        bg-gray-50 @endif"
                                    id="statusIndicator">
                                    <div class="flex items-center text-xs">
                                        <div
                                            class="w-2 h-2 rounded-full mr-2
                            @if ($technician && $technician->status === 'online') bg-green-500 animate-pulse
                            @else
                                bg-gray-400 @endif"
                                            id="statusDot">
                                        </div>
                                        <span
                                            class="font-medium
                            @if ($technician && $technician->status === 'online') text-green-700
                            @else
                                text-gray-600 @endif"
                                            id="statusText">
                                            @if ($technician && $technician->status === 'online')
                                                Online - Siap Bekerja
                                            @else
                                                Offline - Tidak Menerima Pesanan
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2 border-gray-200">

                            <!-- Logout -->
                            <div class="py-2">
                                <form action="{{ route('authlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center px-4 py-3 hover:bg-red-50 transition-colors group">
                                        <div
                                            class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                            <i data-feather="log-out" class="w-4 h-4 text-red-600"></i>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-red-600">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="py-2">
                                <form action="{{ route('authlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center px-4 py-3 hover:bg-red-50 transition-colors group">
                                        <div
                                            class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                            <i data-feather="log-out" class="w-4 h-4 text-red-600"></i>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-red-600">Logout</span>
                                    </button>
                                </form>
                            </div>
                @endif
            @else
                <a href="{{ route('authlogin') }}" class="hover:text-blue-600 font-medium">Login</a>
                <a href="{{ route('authregister') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-full hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">Sign
                    Up</a>
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-gray-700 focus:outline-none">
            <i data-feather="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu"
        class="hidden md:hidden bg-white border-t border-gray-100 transition-all duration-300 ease-in-out">
        <div class="px-6 py-4 flex flex-col space-y-4 text-gray-700 font-medium">
            @if (Auth::check())
                <!-- User Info Mobile -->
                <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                @if (Auth::user()->role->nama_role === 'user')
                    <a href="{{ route('orderlist') }}" class="hover:text-blue-600 flex items-center">
                        <i data-feather="home" class="w-4 h-4 mr-3"></i>
                        Home
                    </a>
                    <a href="{{ route('profileindex') }}" class="hover:text-blue-600 flex items-center">
                        <i data-feather="user" class="w-4 h-4 mr-3"></i>
                        Profil Saya
                    </a>
                    <a href="{{ route('orderlist') }}" class="hover:text-blue-600 flex items-center">
                        <i data-feather="shopping-bag" class="w-4 h-4 mr-3"></i>
                        Pesanan Saya
                    </a>
                @elseif(Auth::user()->role->nama_role === 'technician')
                    <a href="{{ route('technicianDashboard') }}" class="hover:text-blue-600 flex items-center">
                        <i data-feather="home" class="w-4 h-4 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('technicianmyOrder') }}" class="hover:text-blue-600 flex items-center">
                        <i data-feather="clipboard" class="w-4 h-4 mr-3"></i>
                        My Order
                    </a>
                @endif

                <hr class="border-gray-200">

                <form action="{{ route('authlogout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white text-center py-3 w-full rounded-xl hover:bg-red-700 transition-all flex items-center justify-center shadow-md">
                        <i data-feather="log-out" class="w-4 h-4 mr-2"></i>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('authlogin') }}" class="block text-center hover:text-blue-600">Login</a>
                <a href="{{ route('authregister') }}"
                    class="block text-center bg-blue-600 text-white py-2 rounded-full hover:bg-blue-700 transition">Sign
                    Up</a>
            @endif
        </div>
    </div>
</nav>


@push('script')
    <script>
        (function() {
            'use strict';

            window.toggleStatusTechnician = function(event) {
                console.log('🎯 toggleStatusTechnician called!');

                event.preventDefault();
                event.stopPropagation();

                const toggle = document.getElementById('statusToggle');
                const statusForm = document.getElementById('statusForm');
                const statusInput = document.getElementById('statusInput');

                if (!toggle || !statusForm) {
                    console.error('❌ Form or toggle not found!');
                    return;
                }

                const currentStatus = toggle.dataset.status;
                const newStatus = currentStatus === 'online' ? 'offline' : 'online';

                console.log('📊 Current status:', currentStatus);
                console.log('📊 New status:', newStatus);

                // Update hidden input value
                statusInput.value = newStatus;

                // Submit form
                statusForm.submit();
            };

            // DOM Ready Event Handlers
            document.addEventListener("DOMContentLoaded", function() {
                console.log('✅ DOM Ready');

                // Mobile Menu Toggle
                const mobileMenuBtn = document.getElementById("mobileMenuBtn");
                const mobileMenu = document.getElementById("mobileMenu");
                const icon = mobileMenuBtn?.querySelector("i");

                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener("click", () => {
                        const isHidden = mobileMenu.classList.contains("hidden");
                        mobileMenu.classList.toggle("hidden");

                        if (icon) {
                            if (isHidden) {
                                icon.setAttribute("data-feather", "x");
                            } else {
                                icon.setAttribute("data-feather", "menu");
                            }
                            feather.replace();
                        }
                    });
                }

                // Profile Dropdown Toggle
                const profileDropdownBtn = document.getElementById("profileDropdownBtn");
                const profileDropdown = document.getElementById("profileDropdown");

                if (profileDropdownBtn && profileDropdown) {
                    profileDropdownBtn.addEventListener("click", (e) => {
                        e.stopPropagation();
                        profileDropdown.classList.toggle("opacity-0");
                        profileDropdown.classList.toggle("invisible");
                        profileDropdown.classList.toggle("scale-95");
                        feather.replace();
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener("click", (e) => {
                        if (!profileDropdownBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                            profileDropdown.classList.add("opacity-0", "invisible", "scale-95");
                        }
                    });
                }

                // Prevent dropdown from closing when clicking toggle
                const statusToggle = document.getElementById('statusToggle');
                if (statusToggle) {
                    console.log('✅ Status toggle found');
                    statusToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }

                // Initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                    console.log('✅ Feather icons initialized');
                }
            });
        })(); // End of IIFE
    </script>
@endpush
