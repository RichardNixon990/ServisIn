// ===== UTILITY FUNCTIONS =====
function formatRupiah(value) {
    if (!value || value === null || value === '' || value == 0) return 'Belum ditentukan';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

function getDeviceIcon(deviceType) {
    const icons = {
        'hp': 'smartphone',
        'laptop': 'monitor',
        'tablet': 'tablet'
    };
    return icons[deviceType] || 'smartphone';
}

// ===== FILTER ORDERS FUNCTION =====
function filterOrders(status) {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const orderRows = document.querySelectorAll('.order-row');
    const orderCards = document.querySelectorAll('.order-card');

    // Update button states
    filterButtons.forEach(btn => {
        if (btn.getAttribute('data-filter') === status) {
            btn.classList.remove('bg-gray-100', 'text-gray-700');
            btn.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'active');
        } else {
            btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'active');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        }
    });

    // Filter desktop table rows
    orderRows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    // Filter mobile cards
    orderCards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        if (status === 'all' || cardStatus === status) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });

    // Refresh feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

// ===== RATING MODAL FUNCTIONS =====
function openRatingModal(orderId, technicianId, deviceType, brand) {
    console.log('Opening rating modal:', { orderId, technicianId, deviceType, brand });

    try {
        // Set order ID
        const orderIdInput = document.getElementById('orderId');
        if (!orderIdInput) {
            console.error('Element orderId not found!');
            return;
        }
        orderIdInput.value = orderId;

        // Set technician ID
        const techIdInput = document.getElementById('technicianId');
        if (!techIdInput) {
            console.error('Element technicianId not found!');
            return;
        }
        techIdInput.value = technicianId;

        // Set device info
        const deviceInfo = document.getElementById('modalDeviceInfo');
        if (!deviceInfo) {
            console.error('Element modalDeviceInfo not found!');
            return;
        }
        deviceInfo.textContent = `${deviceType.toUpperCase()} - ${brand}`;

        // Reset rating
        resetRating();

        // Show modal
        const modal = document.getElementById('ratingModal');
        if (!modal) {
            console.error('Element ratingModal not found!');
            return;
        }
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Refresh feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        console.log('Rating modal opened successfully');
    } catch (error) {
        console.error('Error opening rating modal:', error);
        alert('Terjadi kesalahan saat membuka modal rating. Silakan refresh halaman.');
    }
}

function closeRatingModal() {
    const modal = document.getElementById('ratingModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    const form = document.getElementById('ratingForm');
    if (form) {
        form.reset();
    }

    resetRating();
}

function setRating(rating) {
    // Set hidden input value
    const ratingInput = document.getElementById('ratingValue');
    if (ratingInput) {
        ratingInput.value = rating;
    }

    // Update stars visual
    for (let i = 1; i <= 5; i++) {
        const starButton = document.getElementById(`star${i}`);
        if (starButton) {
            const star = starButton.querySelector('[data-feather="star"]');
            if (star) {
                if (i <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400', 'fill-current');
                } else {
                    star.classList.remove('text-yellow-400', 'fill-current');
                    star.classList.add('text-gray-300');
                }
            }
        }
    }

    // Update rating text
    const ratingTexts = {
        1: 'Sangat Buruk',
        2: 'Buruk',
        3: 'Cukup',
        4: 'Baik',
        5: 'Sangat Baik'
    };

    const ratingText = document.getElementById('ratingText');
    if (ratingText) {
        ratingText.textContent = ratingTexts[rating] || 'Rating dipilih';
    }

    // Refresh feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function resetRating() {
    const ratingInput = document.getElementById('ratingValue');
    if (ratingInput) {
        ratingInput.value = '';
    }

    for (let i = 1; i <= 5; i++) {
        const starButton = document.getElementById(`star${i}`);
        if (starButton) {
            const star = starButton.querySelector('[data-feather="star"]');
            if (star) {
                star.classList.remove('text-yellow-400', 'fill-current');
                star.classList.add('text-gray-300');
            }
        }
    }

    const ratingText = document.getElementById('ratingText');
    if (ratingText) {
        ratingText.textContent = 'Pilih bintang untuk rating';
    }

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

// ===== DETAIL MODAL FUNCTIONS =====
function openDetailModal(orderData) {
    console.log('Opening detail modal:', orderData);

    try {
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

        // Cost
        document.getElementById('detailEstimatedCost').textContent = formatRupiah(orderData.estimated_cost);
        document.getElementById('detailFinalCost').textContent = formatRupiah(orderData.final_cost);

        // Status
        const statusMap = {
            'pending': { text: 'Menunggu', class: 'bg-yellow-100 text-yellow-800' },
            'on_process': { text: 'Dikerjakan', class: 'bg-blue-100 text-blue-800' },
            'completed': { text: 'Selesai', class: 'bg-green-100 text-green-800' },
            'cancelled': { text: 'Dibatalkan', class: 'bg-red-100 text-red-800' }
        };
        const status = statusMap[orderData.status] || { text: orderData.status, class: 'bg-gray-100 text-gray-800' };
        const statusEl = document.getElementById('detailStatus');
        statusEl.textContent = status.text;
        statusEl.className = `px-4 py-2 text-xs font-bold rounded-full ${status.class} shadow-sm`;

        // Technician
        if (orderData.technician_name) {
            document.getElementById('detailTechnicianName').textContent = orderData.technician_name;
            document.getElementById('detailTechnicianContact').textContent = orderData.technician_phone || 'Hubungi melalui aplikasi';
            document.getElementById('detailTechnicianInitial').textContent = orderData.technician_name.charAt(0).toUpperCase();
        } else {
            document.getElementById('detailTechnicianName').textContent = 'Belum Ditugaskan';
            document.getElementById('detailTechnicianContact').textContent = '';
            document.getElementById('detailTechnicianInitial').textContent = '?';
        }

        // Notes
        const notesSection = document.getElementById('notesSection');
        if (orderData.notes) {
            notesSection.classList.remove('hidden');
            document.getElementById('detailNotes').textContent = orderData.notes;
        } else {
            notesSection.classList.add('hidden');
        }

        // Photos
        const photoSection = document.getElementById('photoSection');
        if (orderData.photo) {
            photoSection.classList.remove('hidden');
            const photoContainer = document.getElementById('detailPhotoContainer');
            photoContainer.innerHTML = '';

            const img = document.createElement('img');
            img.src = orderData.photo;
            img.className = 'rounded-lg border border-gray-200 hover:shadow-lg cursor-pointer transition-all object-cover h-40 w-full';
            img.onclick = () => window.open(img.src, '_blank');
            photoContainer.appendChild(img);
        } else {
            photoSection.classList.add('hidden');
        }

        // Show Modal
        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Refresh feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        console.log('Detail modal opened successfully');
    } catch (error) {
        console.error('Error opening detail modal:', error);
        alert('Terjadi kesalahan saat membuka detail pesanan.');
    }
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// ===== EVENT LISTENERS =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('ListOrder.js loaded and DOM ready');

    // Rating form validation
    const ratingForm = document.getElementById('ratingForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(e) {
            const rating = document.getElementById('ratingValue');
            if (!rating || !rating.value) {
                e.preventDefault();
                alert('Silakan pilih rating terlebih dahulu!');
                return false;
            }
        });
    }

    // Close modals on click outside
    const ratingModal = document.getElementById('ratingModal');
    if (ratingModal) {
        ratingModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRatingModal();
            }
        });
    }

    const detailModal = document.getElementById('detailModal');
    if (detailModal) {
        detailModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    }

    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (ratingModal && !ratingModal.classList.contains('hidden')) {
                closeRatingModal();
            }
            if (detailModal && !detailModal.classList.contains('hidden')) {
                closeDetailModal();
            }
        }
    });

    // Refresh feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
        console.log('Feather icons initialized');
    }
});

// ===== EXPOSE FUNCTIONS TO WINDOW (IMPORTANT!) =====
// Ini PENTING agar function bisa dipanggil dari onclick di Blade
window.filterOrders = filterOrders;
window.openRatingModal = openRatingModal;
window.closeRatingModal = closeRatingModal;
window.setRating = setRating;
window.resetRating = resetRating;
window.openDetailModal = openDetailModal;
window.closeDetailModal = closeDetailModal;

console.log('ListOrder.js functions exposed to window');
