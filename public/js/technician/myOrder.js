
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
                // Set form action using data attribute
                const baseAction = form.dataset.baseAction;
                form.action = baseAction.replace(':id', orderId);

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
    
