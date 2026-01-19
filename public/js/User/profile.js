
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
    
