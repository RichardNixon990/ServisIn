
        (function() {
            'use strict';

            window.toggleStatusTechnician = function(event) {
                console.log('🎯 toggleStatusTechnician called!');

                event.preventDefault();
                event.stopPropagation();

                const toggle = document.getElementById('statusToggle');
                const statusForm = document.getElementById('statusForm');
                const statusInput = document.getElementById('statusInput');

                if (!toggle || !statusForm) {
                    console.error('❌ Form or toggle not found!');
                    return;
                }

                const currentStatus = toggle.dataset.status;
                const newStatus = currentStatus === 'online' ? 'offline' : 'online';

                console.log('📊 Current status:', currentStatus);
                console.log('📊 New status:', newStatus);

                // Update hidden input value
                statusInput.value = newStatus;

                // Submit form
                statusForm.submit();
            };

            // DOM Ready Event Handlers
            document.addEventListener("DOMContentLoaded", function() {
                console.log('✅ DOM Ready');

                // Mobile Menu Toggle
                const mobileMenuBtn = document.getElementById("mobileMenuBtn");
                const mobileMenu = document.getElementById("mobileMenu");
                const icon = mobileMenuBtn?.querySelector("i");

                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener("click", () => {
                        const isHidden = mobileMenu.classList.contains("hidden");
                        mobileMenu.classList.toggle("hidden");

                        if (icon) {
                            if (isHidden) {
                                icon.setAttribute("data-feather", "x");
                            } else {
                                icon.setAttribute("data-feather", "menu");
                            }
                            feather.replace();
                        }
                    });
                }

                // Profile Dropdown Toggle
                const profileDropdownBtn = document.getElementById("profileDropdownBtn");
                const profileDropdown = document.getElementById("profileDropdown");

                if (profileDropdownBtn && profileDropdown) {
                    profileDropdownBtn.addEventListener("click", (e) => {
                        e.stopPropagation();
                        profileDropdown.classList.toggle("opacity-0");
                        profileDropdown.classList.toggle("invisible");
                        profileDropdown.classList.toggle("scale-95");
                        feather.replace();
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener("click", (e) => {
                        if (!profileDropdownBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                            profileDropdown.classList.add("opacity-0", "invisible", "scale-95");
                        }
                    });
                }

                // Prevent dropdown from closing when clicking toggle
                const statusToggle = document.getElementById('statusToggle');
                if (statusToggle) {
                    console.log('✅ Status toggle found');
                    statusToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }

                // Initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                    console.log('✅ Feather icons initialized');
                }
            });
        })(); // End of IIFE
    
