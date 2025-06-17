<nav class="bg-white border-b border-green-200 px-4 py-3 flex items-center justify-between shadow-sm">
    <!-- Logo -->
    <div class="flex items-center">
        <a href="{{ route('user.home') }}" class="flex items-center gap-2">
            <!-- Simple fruit/veggie icon -->
            <svg class="w-8 h-8" viewBox="0 0 32 32" fill="none">
                <circle cx="16" cy="16" r="12" fill="#34D399" /> <!-- Green apple base -->
                <ellipse cx="16" cy="13" rx="6" ry="3" fill="#F59E42" />
                <!-- Orange carrot slice -->
                <rect x="15" y="6" width="2" height="6" rx="1" fill="#A7F3D0" /> <!-- Leaf -->
            </svg>
            <span class="text-2xl font-bold text-green-700 tracking-wide"
                style="font-family: 'Nunito', 'Segoe UI', sans-serif;">
                3-Rebu
            </span>
        </a>
    </div>

    <!-- Main Navigation -->
    <div class="hidden md:flex space-x-8 ml-8">
        <a href="{{ route('user.home') }}"
            class="px-2 py-1 rounded text-green-800 font-semibold transition hover:bg-green-50 hover:shadow-sm focus:outline-none">
            Home
        </a>
        <a href="{{ route('user.dashboard') }}"
            class="px-2 py-1 rounded text-green-800 font-semibold transition hover:bg-green-50 hover:shadow-sm focus:outline-none">
            Produk
        </a>
        <a href="{{ route('user.masukan') }}"
            class="px-2 py-1 rounded text-green-800 font-semibold transition hover:bg-green-50 hover:shadow-sm focus:outline-none">
            Kritik dan Saran
        </a>
    </div>

    <!-- Right Side: Cart & User -->
    <div class="flex items-center">
        <!-- Cart Icon -->
        <a href="{{ route('cart.index') }}" class="relative mr-4 group" title="Keranjang">
            <svg class="w-7 h-7 text-orange-500" fill="none" viewBox="0 0 24 24">
                <rect x="4" y="8" width="16" height="10" rx="4" fill="#fff" stroke="#F59E42"
                    stroke-width="2" />
                <circle cx="8" cy="20" r="1.5" fill="#F59E42" />
                <circle cx="16" cy="20" r="1.5" fill="#F59E42" />
                <path d="M6 8L8 4H16L18 8" stroke="#34D399" stroke-width="2" stroke-linecap="round" />
            </svg>
        </a>
        <!-- User Dropdown -->
        <div class="hidden md:flex items-center">
            <div class="relative">
                <button id="user-menu"
                    class="flex items-center text-green-900 font-semibold px-2 py-1 rounded hover:bg-orange-50 hover:text-orange-500 transition focus:outline-none">
                    <svg class="w-6 h-6 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" stroke="#34D399" stroke-width="2" fill="#fff" />
                        <path d="M4 20c0-4 16-4 16 0" stroke="#34D399" stroke-width="2" />
                    </svg>
                    <span>{{ Auth::user()->username }}</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown-menu"
                    class="hidden absolute right-0 mt-2 w-44 bg-white border border-green-100 rounded-xl shadow-lg z-50 overflow-hidden">
                    <a href="{{ route('user.profile.edit') }}"
                        class="block px-4 py-2 text-green-800 hover:bg-green-50 transition">Profile</a>
                    <a href="{{ route('orders.user') }}"
                        class="block px-4 py-2 text-green-800 hover:bg-green-50 transition">Riwayat Pembelian</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-green-800 hover:bg-green-50 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Hamburger (Mobile) -->
        <div class="md:hidden ml-2">
            <button id="navbar-toggle" class="text-green-800 focus:outline-none">
                <svg id="hamburger-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu"
    class="md:hidden fixed top-[64px] left-0 w-full bg-white border-t border-green-100 shadow-lg z-40 transition-all duration-300 ease-in-out transform -translate-y-4 opacity-0 pointer-events-none">
    <div class="px-4 pb-3">
        <div class="flex flex-col space-y-2 pt-3">
            <a href="{{ route('user.home') }}"
                class="block px-2 py-2 rounded text-green-800 font-semibold hover:bg-green-50 hover:shadow-sm transition">Home</a>
            <a href="{{ route('user.dashboard') }}"
                class="block px-2 py-2 rounded text-green-800 font-semibold hover:bg-green-50 hover:shadow-sm transition">Produk</a>
            <a href="{{ route('user.masukan') }}"
                class="block px-2 py-2 rounded text-green-800 font-semibold hover:bg-green-50 hover:shadow-sm transition">Kritik
                dan Saran</a>
            <div class="border-t pt-3 mt-2">
                <div class="relative">
                    <button id="mobile-user-menu"
                        class="flex items-center w-full text-green-900 font-semibold px-2 py-1 rounded hover:bg-orange-50 hover:text-orange-500 transition focus:outline-none">
                        <svg class="w-6 h-6 mr-1 text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke="#34D399" stroke-width="2"
                                fill="#fff" />
                            <path d="M4 20c0-4 16-4 16 0" stroke="#34D399" stroke-width="2" />
                        </svg>
                        <span>{{ Auth::user()->username }}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobile-dropdown-menu"
                        class="hidden mt-2 w-full bg-white border border-green-100 rounded-xl shadow-lg z-50">
                        <a href="{{ route('user.profile.edit') }}"
                            class="block px-4 py-2 text-green-800 hover:bg-green-50 transition">Profile</a>
                        <a href="{{ route('orders.user') }}"
                            class="block px-4 py-2 text-green-800 hover:bg-green-50 transition">Riwayat Pembelian</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-green-800 hover:bg-green-50 transition">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script: Dropdowns & Mobile Menu -->
<script>
    // Hamburger menu toggle
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('opacity-0')) {
            menu.classList.remove('opacity-0', '-translate-y-4', 'pointer-events-none');
            menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
        } else {
            menu.classList.add('opacity-0', '-translate-y-4', 'pointer-events-none');
            menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
        }
    });

    // Desktop dropdown
    document.getElementById('user-menu').addEventListener('click', function(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    });

    // Mobile dropdown
    document.getElementById('mobile-user-menu').addEventListener('click', function(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('mobile-dropdown-menu');
        dropdown.classList.toggle('hidden');
    });

    // Click outside to close dropdowns and mobile menu
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('user-menu');
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (!userMenu.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
        const mobileUserMenu = document.getElementById('mobile-user-menu');
        const mobileDropdownMenu = document.getElementById('mobile-dropdown-menu');
        if (!mobileUserMenu.contains(event.target) && !mobileDropdownMenu.contains(event.target)) {
            mobileDropdownMenu.classList.add('hidden');
        }
        const mobileMenu = document.getElementById('mobile-menu');
        const navbarToggle = document.getElementById('navbar-toggle');
        if (!mobileMenu.contains(event.target) && !navbarToggle.contains(event.target)) {
            mobileMenu.classList.add('opacity-0', '-translate-y-4', 'pointer-events-none');
            mobileMenu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
        }
    });
</script>
