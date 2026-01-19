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

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('order-form');
    if (form && form.dataset.errors) {
        try {
            const errors = JSON.parse(form.dataset.errors);
            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: '<ul class="text-left">' + errors.map(e => '<li class="text-sm text-red-600">• ' + e + '</li>').join('') + '</ul>',
                    confirmButtonColor: '#2563eb'
                });
            }
        } catch (e) {
            console.error('Error parsing validation errors:', e);
        }
    }
});
