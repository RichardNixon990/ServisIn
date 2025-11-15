<nav class="fixed bg-white/80 backdrop-blur-md top-0 left-0 w-full z-50 shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
<a href="/" class="flex items-center space-x-2">
<i data-feather="tool" class="w-6 h-6 text-blue-600"></i>

    <span class="text-xl font-bold text-blue-600">ServisIn</span>
</a>

        <!-- Menu Items -->
        <div class="hidden md:flex items-center space-x-8 font-medium text-gray-700">
            @if (Auth::check())
            <a href={{route('landing')}} class="hover:text-blue-600 transition-colors duration-200">Home</a>
            <a href="#how-it-works" class="hover:text-blue-600 transition-colors duration-200">How It Works</a>
            <a href="#features" class="hover:text-blue-600 transition-colors duration-200">Features</a>
            <a href="#testimonials" class="hover:text-blue-600 transition-colors duration-200">Testimonials</a>
            <a href="#book" class="hover:text-blue-600 transition-colors duration-200">Book</a>
            @else

            @endif
        </div>

        <!-- Auth Buttons (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            @if (Auth::check())
                <form action="{{ route('authlogout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('authlogin') }}" class="hover:text-blue-600">Login</a>
                <a href="{{ route('authregister') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">Sign Up</a>
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-gray-700 focus:outline-none">
            <i data-feather="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100 transition-all duration-300 ease-in-out">
        <div class="px-6 py-4 flex flex-col space-y-4 text-gray-700 font-medium">
            <a href="#home" class="hover:text-blue-600">Home</a>
            <a href="#how-it-works" class="hover:text-blue-600">How It Works</a>
            <a href="#features" class="hover:text-blue-600">Features</a>
            <a href="#testimonials" class="hover:text-blue-600">Testimonials</a>
            <a href="#book" class="hover:text-blue-600">Book</a>
            <hr class="border-gray-200">
            <div>
                @if (Auth::check())
                    <form action="{{ route('authlogout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 text-white text-center py-2 w-full rounded-full hover:bg-blue-700 transition">
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('authlogin') }}" class="block text-center hover:text-blue-600">Login</a>
                    <a href="{{ route('authregister') }}"
                        class="block text-center bg-blue-600 text-white py-2 rounded-full hover:bg-blue-700 transition">Sign Up</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>

<!-- Navbar Toggle Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuBtn = document.getElementById("mobileMenuBtn");
        const mobileMenu = document.getElementById("mobileMenu");
        const icon = mobileMenuBtn.querySelector("i");

        mobileMenuBtn.addEventListener("click", () => {
            const isHidden = mobileMenu.classList.contains("hidden");

            // Toggle tampil/sembunyi menu
            mobileMenu.classList.toggle("hidden");
            mobileMenu.classList.toggle("opacity-0");
            mobileMenu.classList.toggle("opacity-100");

            // Ganti icon menu ↔ x
            if (isHidden) {
                icon.setAttribute("data-feather", "x");
            } else {
                icon.setAttribute("data-feather", "menu");
            }

            feather.replace();
        });

        feather.replace();
    });
</script>
