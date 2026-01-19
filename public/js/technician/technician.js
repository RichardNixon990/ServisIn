
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
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'Sedang mengambil pesanan, mohon tunggu...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

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

        // ===== PAGE LOAD INITIALIZATION =====
        document.addEventListener('DOMContentLoaded', () => {
            featherReplace();
        });

        // ===== PAGE UNLOAD ANIMATION =====
        window.addEventListener('beforeunload', () => {
            document.body.style.opacity = '0.7';
            document.body.style.transition = 'opacity 0.3s';
        });
    
