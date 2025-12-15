@extends('layout.main')
@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-6 md:pt-32">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <a href={{ route('orderlist') }}
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 transition-colors duration-200 mb-6 group">
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-medium">Kembali ke Daftar Pesanan</span>
                </a>
                <div class="text-center mb-2">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                        Buat Pesanan <span class="text-blue-600">Baru</span>
                    </h1>
                    <p class="text-base text-gray-600 max-w-2xl mx-auto">
                        Isi detail perangkat dan keluhan Anda. Teknisi terbaik kami akan segera membantu memperbaiki
                        perangkat Anda.
                    </p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i data-feather="clipboard" class="w-6 h-6 mr-3"></i>
                        Detail Pesanan
                    </h2>
                </div>

                <form action="{{ route('orderstore') }}" method="POST" enctype="multipart/form-data"
                    class="p-8 md:p-10 space-y-6" id="order-form">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Device Type -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="smartphone" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Jenis Perangkat
                            </label>
                            <div class="relative">
                                <select name="device_type" id="device_type" required
                                    class="w-full pl-4 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white hover:border-gray-300 cursor-pointer">
                                    <option value="" selected disabled>Pilih Jenis Perangkat</option>
                                    <option value="hp">HP</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="tablet">Tablet</option>
                                </select>
                                <i data-feather="chevron-down"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Device Brand -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="tag" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Merek Perangkat
                            </label>
                            <input type="text" name="brand" id="brand" required placeholder="Contoh: Samsung, Apple, Asus..."
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                        </div>
                    </div>

                    <!-- Damage Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i data-feather="alert-circle" class="w-4 h-4 mr-2 text-blue-600"></i>
                            Deskripsi Kerusakan
                        </label>
                        <textarea name="issue_description" id="issue_description" rows="5" required
                            placeholder="Jelaskan secara detail masalah yang dialami perangkat Anda..."
                            class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none hover:border-gray-300"></textarea>
                    </div>

                    <!-- Schedule & Address -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Schedule Date -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="calendar" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Tanggal Penjadwalan
                            </label>
                            <input type="date" name="schedule_date" id="schedule_date" required
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="map-pin" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Alamat Lengkap Perbaikan
                            </label>

                            <input type="text" name="address" id="address" value="{{ auth()->user()->address }}"
                                placeholder="Masukkan alamat lengkap jika berbeda dari alamat akun..."
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">
                                Biarkan seperti ini untuk menggunakan alamat dari akun Anda.
                            </p>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="image" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Upload Foto Kerusakan
                                <span class="ml-2 text-xs font-normal text-gray-500">(Opsional)</span>
                            </label>

                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-all duration-200 bg-gray-50 hover:bg-blue-50 cursor-pointer group"
                                id="upload-area">
                                <input type="file" name="photo" id="photo-input"
                                    accept="image/png,image/jpeg,image/jpg"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                <!-- Upload Icon (Default) -->
                                <div class="flex flex-col items-center" id="upload-placeholder">
                                    <div
                                        class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                                        <i data-feather="upload-cloud" class="w-8 h-8 text-blue-600"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Klik untuk upload atau drag & drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Max. 2MB)</p>
                                </div>

                                <!-- Preview Image (Hidden by default) -->
                                <div class="hidden" id="image-preview-container">
                                    <img src="" alt="Preview" id="image-preview"
                                        class="max-h-48 mx-auto rounded-lg shadow-md mb-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2" id="file-name"></p>
                                    <button type="button" id="remove-image"
                                        class="text-xs text-red-600 hover:text-red-800 font-medium flex items-center justify-center mx-auto">
                                        <i data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all duration-200 flex items-center justify-center group">
                                <i data-feather="send"
                                    class="w-5 h-5 mr-3 group-hover:translate-x-1 transition-transform"></i>
                                Kirim Pesanan Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('order-form');
            const input = document.getElementById('photo-input');
            const uploadArea = document.getElementById('upload-area');
            const placeholder = document.getElementById('upload-placeholder');
            const previewContainer = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            const fileName = document.getElementById('file-name');
            const removeBtn = document.getElementById('remove-image');

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('schedule_date').setAttribute('min', today);

            // Form validation with SweetAlert
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form values
                const deviceType = document.getElementById('device_type').value;
                const brand = document.getElementById('brand').value.trim();
                const issueDescription = document.getElementById('issue_description').value.trim();
                const scheduleDate = document.getElementById('schedule_date').value;
                const address = document.getElementById('address').value.trim();

                // Validation checks
                if (!deviceType) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Jenis Perangkat Belum Dipilih',
                        text: 'Silakan pilih jenis perangkat terlebih dahulu!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (!brand) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Merek Perangkat Kosong',
                        text: 'Silakan isi merek perangkat Anda!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (brand.length < 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Merek Terlalu Pendek',
                        text: 'Merek perangkat minimal 2 karakter!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (!issueDescription) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Deskripsi Kerusakan Kosong',
                        text: 'Silakan jelaskan masalah yang dialami perangkat Anda!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (issueDescription.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Deskripsi Terlalu Singkat',
                        text: 'Deskripsi kerusakan minimal 10 karakter agar teknisi dapat memahami masalahnya!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (!scheduleDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Belum Dipilih',
                        text: 'Silakan pilih tanggal penjadwalan perbaikan!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                // Check if date is in the past
                const selectedDate = new Date(scheduleDate);
                const todayDate = new Date(today);
                if (selectedDate < todayDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal penjadwalan tidak boleh di masa lalu!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                if (!address) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Alamat Kosong',
                        text: 'Silakan isi alamat perbaikan!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                // Confirmation before submit
                Swal.fire({
                    title: 'Konfirmasi Pesanan',
                    html: `
                        <div class="text-left space-y-2">
                            <p><strong>Perangkat:</strong> ${deviceType.toUpperCase()} - ${brand}</p>
                            <p><strong>Tanggal:</strong> ${new Date(scheduleDate).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            <p><strong>Alamat:</strong> ${address}</p>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">Apakah data yang Anda masukkan sudah benar?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Kirim Pesanan',
                    cancelButtonText: 'Periksa Kembali',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Mengirim Pesanan...',
                            html: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        form.submit();
                    }
                });
            });

            // Handle file selection
            input.addEventListener('change', function(e) {
                handleFile(e.target.files[0]);
            });

            // Drag & Drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-500', 'bg-blue-100');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-500', 'bg-blue-100');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-500', 'bg-blue-100');

                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;
                    handleFile(file);
                }
            });

            // Remove image
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();

                Swal.fire({
                    title: 'Hapus Foto?',
                    text: 'Foto yang sudah diupload akan dihapus',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        input.value = '';
                        placeholder.classList.remove('hidden');
                        previewContainer.classList.add('hidden');
                        preview.src = '';

                        Swal.fire({
                            icon: 'success',
                            title: 'Foto Dihapus',
                            text: 'Foto berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            function handleFile(file) {
                if (!file) return;

                // Validate file type
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Hanya file PNG, JPG, atau JPEG yang diperbolehkan!',
                        confirmButtonColor: '#2563eb'
                    });
                    input.value = '';
                    return;
                }

                // Validate file size (2MB)
                const maxSize = 2048 * 1024;
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran File Terlalu Besar',
                        html: `
                            <p>Ukuran file: <strong>${(file.size / 1024 / 1024).toFixed(2)} MB</strong></p>
                            <p>Maksimal: <strong>2 MB</strong></p>
                            <p class="mt-2 text-sm text-gray-600">Silakan kompres atau pilih foto yang lebih kecil</p>
                        `,
                        confirmButtonColor: '#2563eb'
                    });
                    input.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    fileName.textContent = file.name;
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');

                    // Success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Foto Berhasil Diupload',
                        text: file.name,
                        timer: 1500,
                        showConfirmButton: false
                    });
                };
                reader.readAsDataURL(file);
            }

            // Reinitialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        // Display Laravel validation errors with SweetAlert
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `
                    <ul class="text-left">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-600">• {{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#2563eb'
            });
        @endif

        // Display success message if exists
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2563eb'
            });
        @endif

        // Display error message if exists
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#2563eb'
            });
        @endif
    </script>
@endsection
