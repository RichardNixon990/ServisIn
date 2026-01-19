
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
    
