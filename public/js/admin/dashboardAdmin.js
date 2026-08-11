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


    const baseUrl = window.location.origin;
    form.action = `${baseUrl}/admin/technician/${validId}`;
    console.log('✅ Form action:', form.action);


    const idElement = document.getElementById('editTechModalId');
    if (idElement) {
        idElement.textContent = `#${String(validId).padStart(4, '0')}`;
        console.log('✅ ID set:', idElement.textContent);
    }


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


    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    console.log('✅ Modal opened');


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



    }
};


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


window.openViewRatingDetailModal = function(ratingData) {
    const modal = document.getElementById('viewRatingDetailModal');
    if (!modal || !ratingData) return;

    document.getElementById('viewRatingId').textContent = `#${String(ratingData.id).padStart(4, '0')}`;
    document.getElementById('viewRatingOrderId').textContent = `#${String(ratingData.order_id).padStart(4, '0')}`;
    document.getElementById('viewRatingCustomerName').textContent = ratingData.customer_name || '-';
    document.getElementById('viewRatingTechnicianName').textContent = ratingData.technician_name || '-';

    const ratingValue = parseFloat(ratingData.rating_value) || 0;
    document.getElementById('viewRatingValue').textContent = ratingValue.toFixed(1);

    const starsContainer = document.getElementById('viewRatingStars');
    starsContainer.innerHTML = '';
    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('i');
        star.setAttribute('data-feather', 'star');
        star.className = i <= Math.round(ratingValue) ? 'w-4 h-4 text-yellow-400 fill-current' :
            'w-4 h-4 text-gray-300';
        starsContainer.appendChild(star);
    }

    document.getElementById('viewRatingComment').textContent = ratingData.comment || '-';
    document.getElementById('viewRatingCreatedAt').textContent = ratingData.created_at || '-';

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => feather.replace(), 100);
};

window.closeViewRatingDetailModal = function() {
    const modal = document.getElementById('viewRatingDetailModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
};


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


    const formData = new FormData(this);
    console.log('FormData entries:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }



    Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });


    this.submit();
});


document.addEventListener('click', function(e) {

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


document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modals = ['editOrderModal', 'addTechnicianModal', 'addAdminModal', 'viewOrderModal', 'imageFullscreenModal',
            'viewCustomerModal', 'viewTechnicianModal', 'editTechnicianModal', 'viewRatingDetailModal'
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


document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Initializing dashboard...');


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


    window.switchTab('orders');


    if (typeof feather !== 'undefined') {
        feather.replace();
        console.log('✅ Feather icons loaded');
    }

    console.log('✅ Dashboard ready!');
});// Session message handling
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const sessionSuccess = body.dataset.sessionSuccess;
    const sessionError = body.dataset.sessionError;

    if (sessionSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: sessionSuccess,
            timer: 1500,
            showConfirmButton: false
        });
    }

    if (sessionError) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: sessionError,
            timer: 2000,
            showConfirmButton: true
        });
    }
});

// Admin Modal Functions
window.openAddAdminModal = function() {
    const modal = document.getElementById('addAdminModal');
    const form = document.getElementById('addAdminForm');
    if (modal && form) {
        form.reset();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => feather.replace(), 50);
    }
};

window.closeAddAdminModal = function() {
    const modal = document.getElementById('addAdminModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
};

window.showAddAdminModal = function() {
    window.openAddAdminModal();
};

document.getElementById('addAdminForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('adminName').value.trim();
    const email = document.getElementById('adminEmail').value.trim();
    const phone = document.getElementById('adminPhone').value.trim();
    const password = document.getElementById('adminPassword').value;
    const address = document.getElementById('adminAddress').value.trim();

    if (!name || !email || !phone || !password || !address) {
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Lengkap!',
            text: 'Semua field harus diisi.'
        });
        return;
    }

    window.closeAddAdminModal();
    setTimeout(() => {
        Swal.fire({
            title: 'Memproses...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        setTimeout(() => this.submit(), 200);
    }, 200);
});
