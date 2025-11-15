
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace(); // render ikon pertama kali
    });

    function openRatingModal(orderId, deviceInfo) {
        document.getElementById('ratingModal').classList.remove('hidden');
        document.getElementById('orderId').value = orderId;
        document.getElementById('modalDeviceInfo').innerText = `Perangkat: ${deviceInfo}`;
        feather.replace(); // render ulang ikon dalam modal
    }

    function closeRatingModal() {
        document.getElementById('ratingModal').classList.add('hidden');
        resetStars();
    }

    function setRating(value) {
        document.getElementById('ratingValue').value = value;
        for (let i = 1; i <= 5; i++) {
            const star = document.querySelector(`#star${i} svg`);
            if (star) {
                star.classList.toggle('text-yellow-400', i <= value);
                star.classList.toggle('text-gray-300', i > value);
            }
        }
    }

    function resetStars() {
        for (let i = 1; i <= 5; i++) {
            const star = document.querySelector(`#star${i} svg`);
            if (star) {
                star.classList.add('text-gray-300');
                star.classList.remove('text-yellow-400');
            }
        }
        document.getElementById('ratingValue').value = '';
        document.getElementById('comment').value = '';
    }

    // filter user
     function filterOrders(status) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            const activeBtn = document.querySelector(`[data-filter="${status}"]`);
            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
            activeBtn.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md');

            // Filter desktop table rows
            const rows = document.querySelectorAll('.order-row');
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Filter mobile cards
            const cards = document.querySelectorAll('.order-card');
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
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


