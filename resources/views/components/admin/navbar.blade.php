<div class="flex h-screen">
    <!-- Sidebar  -->
    <div id="sidebar"
        class="w-64 bg-gray-800 text-white p-4 flex flex-col fixed md:static inset-y-0 left-0 z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out md:w-64 md:block">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-bold">Admin Panel</h4>
            <!-- Close Button on mobile -->
            <button id="closeSidebar" class="md:hidden text-white p-2 rounded focus:outline-none hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-1">
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Users</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Settings</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Reports</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left py-2 px-4 rounded hover:bg-gray-700">
                    Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Hamburger Button (only on mobile) -->
    <button id="hamburger"
        class="md:hidden fixed top-4 left-4 z-40 bg-gray-800 text-white p-2 rounded focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Overlay (for mobile sidebar) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <!-- Main Content -->
        <div class="p-6 overflow-y-auto flex-1">
            {{ $isi }}
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburger');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');

    function openSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        hamburger.classList.add('hidden');
        closeSidebar.classList.remove('hidden');
    }

    function closeSidebarFunc() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        hamburger.classList.remove('hidden');
        closeSidebar.classList.add('hidden');
    }

    hamburger.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebarFunc);
    closeSidebar.addEventListener('click', closeSidebarFunc);

    // Optional: Hide sidebar on resize to md and up
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            hamburger.classList.add('hidden');
            closeSidebar.classList.add('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            hamburger.classList.remove('hidden');
            closeSidebar.classList.add('hidden');
        }
    });
</script>
