<nav class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center">
        <a href="{{ route('user.dashboard') }}" class="text-xl font-bold text-gray-800 flex items-center">
            <span>Logo</span>
        </a>
    </div>

    <!-- Right Side: Cart Icon & Username Dropdown -->
    <div class="flex items-center">
        <!-- Cart Icon -->
        <a href="{{ route('cart.index') }}" class="text-gray-800 hover:text-gray-600 relative mr-4"
            title="Lihat Keranjang">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h7.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
        </a>
        <!-- Username & Dropdown -->
        <div class="hidden md:flex items-center">
            <div class="relative">
                <button id="user-menu" class="flex items-center text-gray-800 focus:outline-none">
                    <span class="mr-2">{{ Auth::user()->username }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown-menu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-50">
                    <a href="{{ route('user.profile.edit') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('orders.user') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat
                        Pembelian</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Hamburger Button (Mobile) -->
        <div class="md:hidden ml-2">
            <button id="navbar-toggle" class="text-gray-800 focus:outline-none transition-transform duration-300">
                <svg id="hamburger-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu"
    class="md:hidden fixed top-[64px] left-0 w-full bg-white shadow-lg border-t z-40 transition-all duration-300 ease-in-out transform -translate-y-4 opacity-0 pointer-events-none">
    <div class="px-4 pb-3">
        <div class="border-t pt-3">

            <div class="relative">
                <button id="mobile-user-menu" class="flex items-center w-full text-gray-800 focus:outline-none">
                    <span class="mr-2">{{ Auth::user()->username }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobile-dropdown-menu" class="hidden mt-2 w-full bg-white border rounded shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('orders.user') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat
                        Pembelian</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hamburger menu toggle
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('hamburger-icon');
        if (menu.classList.contains('opacity-0')) {
            menu.classList.remove('opacity-0', '-translate-y-4', 'pointer-events-none');
            menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
            // icon.classList.add('rotate-90'); // Optional: animate icon
        } else {
            menu.classList.add('opacity-0', '-translate-y-4', 'pointer-events-none');
            menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
            // icon.classList.remove('rotate-90');
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

    // Optional: Click outside to close dropdowns
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
        // Tutup mobile menu jika klik di luar
        const mobileMenu = document.getElementById('mobile-menu');
        const navbarToggle = document.getElementById('navbar-toggle');
        if (!mobileMenu.contains(event.target) && !navbarToggle.contains(event.target)) {
            mobileMenu.classList.add('opacity-0', '-translate-y-4', 'pointer-events-none');
            mobileMenu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
        }
    });
</script>
