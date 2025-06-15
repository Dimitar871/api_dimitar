<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">AutoCorrect API</h1>

        <!-- Desktop menu -->
        <ul class="hidden md:flex space-x-6 text-gray-700">
            <li><a href="{{ route('home') }}" class="hover:text-blue-500">Home</a></li>
            <li><a href="{{ route('info') }}" class="hover:text-blue-500">Info</a></li>
            <li><a href="{{ route('contact') }}" class="hover:text-blue-500">Contact</a></li>
        </ul>

        <!-- Hamburger button -->
        <button id="menu-button" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
        <ul class="space-y-2 text-gray-700">
            <li><a href="{{ route('home') }}" class="block hover:text-blue-500">Home</a></li>
            <li><a href="{{ route('info') }}" class="block hover:text-blue-500">Info</a></li>
            <li><a href="{{ route('contact') }}" class="hover:text-blue-500">Contact</a></li>
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuButton = document.getElementById('menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            menuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</nav>
