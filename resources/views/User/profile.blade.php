@extends('layout.main')

@section('content')
    <style>
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8 animate-fade-in">
                <div>
                    <a href="{{ route('orderlist') }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200 mb-4 group">
                        <i data-feather="arrow-left" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-medium">Kembali</span>
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">
                        <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Profil
                            Saya</span>
                    </h1>
                    <p class="text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Sidebar - Profile Card -->
                <div class="lg:col-span-1 space-y-6 animate-slide-in">
                    <!-- Profile Avatar & Info Card -->
                    <div
                        class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center mb-6 pb-6 border-b border-gray-200">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-3xl shadow-lg mb-4 ring-4 ring-blue-100">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-500 flex items-center">
                                <i data-feather="calendar" class="w-4 h-4 mr-1.5"></i>
                                Member sejak {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('M Y') }}
                            </p>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm p-3 bg-blue-50 rounded-xl">
                                <div
                                    class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i data-feather="mail" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Email</p>
                                    <p class="text-gray-900 font-medium truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-sm p-3 bg-green-50 rounded-xl">
                                <div
                                    class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i data-feather="phone" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Telepon</p>
                                    <p class="text-gray-900 font-medium">{{ Auth::user()->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-3">
                            <a href="{{ route('orderlist') }}"
                                class="group w-full flex items-center justify-center px-4 py-3.5 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                <i data-feather="shopping-bag"
                                    class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform"></i>
                                Lihat Pesanan Saya
                            </a>
                        </div>
                    </div>

                    <!-- Info Box - Tips Keamanan -->
                    <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-xl p-6 text-white">
                        <div class="flex items-start mb-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                <i data-feather="alert-circle" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1">Tips Keamanan</h3>
                                <p class="text-xs text-green-200">Jaga Akun Tetap Aman</p>
                            </div>
                        </div>
                        <ul class="space-y-2 text-sm text-green-100">
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Gunakan password yang kuat dan unik</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Jangan bagikan informasi login Anda</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Perbarui password secara berkala</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="lg:col-span-2 space-y-6 animate-fade-in" style="animation-delay: 0.2s">
                    <!-- Personal Information Card -->
                    <div
                        class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-feather="user" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                Informasi Pribadi
                            </h2>
                            <button onclick="toggleEdit('personal')"
                                class="group flex items-center px-4 py-2 text-blue-600 hover:text-white hover:bg-blue-600 font-medium text-sm rounded-lg border-2 border-blue-600 transition-all duration-300">
                                <i data-feather="edit-2"
                                    class="w-4 h-4 mr-1.5 group-hover:rotate-12 transition-transform"></i>
                                <span id="personalEditText">Edit</span>
                            </button>
                        </div>

                        <form id="personalForm" class="space-y-4" action="{{ route('profileupdate', $user->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i data-feather="user" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-50 disabled:text-gray-600">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i data-feather="mail" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-50 disabled:text-gray-600">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i data-feather="phone" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                                    No. Telepon
                                </label>
                                <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" disabled
                                    placeholder="Masukkan nomor telepon"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-50 disabled:text-gray-600">
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i data-feather="map-pin" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                                    Alamat
                                </label>
                                <textarea disabled name="address" rows="3" placeholder="Masukkan alamat lengkap"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all disabled:bg-gray-50 disabled:text-gray-600 resize-none">{{ Auth::user()->address ?? '' }}</textarea>
                            </div>

                            <!-- Save Buttons (Hidden by default) -->
                            <div id="personalButtons" class="hidden pt-4 border-t border-gray-200">
                                <div class="flex gap-3 justify-end">
                                    <button type="button" onclick="toggleEdit('personal')"
                                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-300">
                                        <i data-feather="x" class="w-4 h-4 inline-block mr-1.5"></i>
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <i data-feather="save" class="w-4 h-4 inline-block mr-1.5"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Security Card -->
                    <div
                        class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                <i data-feather="shield" class="w-5 h-5 text-purple-600"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Keamanan Akun</h2>
                        </div>

                        <div class="space-y-3">
                            <!-- Change Password -->
                            <button onclick="openPasswordModal()"
                                class="w-full group flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl hover:shadow-md transition-all cursor-pointer border-2 border-transparent hover:border-purple-200">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                        <i data-feather="lock" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-gray-900">Ubah Password</p>
                                        <p class="text-sm text-gray-500">Perbarui kata sandi secara berkala</p>
                                    </div>
                                </div>
                                <i data-feather="chevron-right"
                                    class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Logout Card -->
                    <div
                        class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl shadow-xl p-6 border-2 border-red-200 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                <i data-feather="log-out" class="w-5 h-5 text-red-600"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Keluar dari Akun</h2>
                        </div>

                        <div class="bg-white border border-red-200 rounded-xl p-4 mb-4">
                            <p class="text-sm text-gray-700 flex items-start">
                                <i data-feather="alert-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-red-500"></i>
                                <span>Pastikan Anda telah menyimpan semua perubahan sebelum logout.</span>
                            </p>
                        </div>

                        <form action="{{ route('authlogout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="group w-full md:w-auto px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i data-feather="log-out"
                                    class="w-4 h-4 inline-block mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Logout Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ubah Password -->
    <div id="changePasswordModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-t-2xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                            <i data-feather="lock" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Ubah Password</h3>
                            <p class="text-sm text-purple-200">Perbarui kata sandi Anda</p>
                        </div>
                    </div>
                    <button onclick="closePasswordModal()"
                        class="text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="changePasswordForm" class="p-6" action="{{ route('updatePassword') }}" method="POST">
                @csrf
                <!-- Password Lama -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i data-feather="lock" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                        Password Lama
                    </label>
                    <div class="relative">
                        <input type="password" id="oldPassword" name="old_password" placeholder="Masukkan password lama"
                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <button type="button" onclick="togglePassword('oldPassword')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-feather="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Baru -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i data-feather="key" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="new_password" placeholder="Masukkan password baru"
                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <button type="button" onclick="togglePassword('newPassword')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-feather="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <!-- Password Hint -->
                    <p class="mt-2 text-xs text-gray-500">Minimal 8 karakter, kombinasi huruf dan angka</p>
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i data-feather="check-circle" class="w-4 h-4 mr-1.5 text-gray-500"></i>
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" name="confirm_password"
                            placeholder="Ulangi password baru"
                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <button type="button" onclick="togglePassword('confirmPassword')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-feather="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i data-feather="info" class="w-5 h-5 text-purple-600 mr-2 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm text-purple-800">
                            <p class="font-semibold mb-1">Tips Password Aman:</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Minimal 8 karakter</li>
                                <li>• Kombinasi huruf besar & kecil</li>
                                <li>• Tambahkan angka dan simbol</li>
                                <li>• Hindari informasi pribadi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-3">
                    <button type="button" onclick="closePasswordModal()"
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-300">
                        <i data-feather="x" class="w-4 h-4 inline-block mr-1.5"></i>
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i data-feather="check" class="w-4 h-4 inline-block mr-1.5"></i>
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleEdit(formType) {
            const form = document.getElementById(`${formType}Form`);
            const buttons = document.getElementById(`${formType}Buttons`);
            const inputs = form.querySelectorAll('input, select, textarea');
            const editText = document.getElementById(`${formType}EditText`);

            const isDisabled = inputs[0].disabled;

            // Toggle input states
            inputs.forEach(input => {
                input.disabled = !isDisabled;
            });

            // Toggle button visibility
            if (buttons) {
                if (isDisabled) {
                    buttons.classList.remove('hidden');
                } else {
                    buttons.classList.add('hidden');
                }
            }

            // Update text button
            if (editText) {
                editText.textContent = isDisabled ? 'Batal' : 'Edit';
            }

            // Refresh feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Fungsi untuk membuka modal password
        function openPasswordModal() {
            const modal = document.getElementById('changePasswordModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling

            // Refresh feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Fungsi untuk menutup modal password
        function closePasswordModal() {
            const modal = document.getElementById('changePasswordModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling

            // Reset form
            document.getElementById('changePasswordForm').reset();
        }

        // Fungsi untuk toggle show/hide password
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-feather', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-feather', 'eye');
            }

            // Refresh feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Handle form submission untuk profile
        document.getElementById('personalForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Memproses...',
                html: 'Sedang menyimpan perubahan',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit form
            this.submit();
        });

        // Handle form submission untuk change password
        document.getElementById('changePasswordForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get values
            const oldPassword = document.getElementById('oldPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Simple validation
            if (!oldPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Semua field harus diisi!',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Password baru dan konfirmasi password tidak sama!',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
                return;
            }

            if (newPassword.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Terlalu Pendek',
                    text: 'Password minimal harus 8 karakter!',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Memproses...',
                html: 'Sedang mengubah password',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit form
            this.submit();
        });

        // Close modal when clicking outside
        document.getElementById('changePasswordModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordModal();
            }
        });

        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endpush
