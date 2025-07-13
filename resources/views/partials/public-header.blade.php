<header class="sticky top-0 z-50 w-full bg-white border-b border-yellow-100 shadow-sm">
    <div class="w-full flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8 xl:px-12">

        {{-- 🔰 Logo --}}
        <div class="flex-shrink-0">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo" class="h-10 w-auto">
            </a>
        </div>

        {{-- 🌐 Navigation --}}
        <nav class="flex flex-wrap gap-4 sm:gap-6 text-sm font-medium text-gray-700">
            <a href="{{ route('menu.index') }}" class="hover:text-yellow-600 transition whitespace-nowrap">🍽️ Menu</a>
            <a href="{{ route('orders.create') }}" class="hover:text-indigo-600 transition whitespace-nowrap">📝 Order Form</a>
            <a href="{{ route('feedbacks.create') }}" class="hover:text-green-600 transition whitespace-nowrap">✍️ Leave Review</a>
        </nav>

        {{-- 👤 Account Dropdown (click-to-toggle using Alpine) --}}
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                    class="text-sm font-medium text-gray-700 hover:text-yellow-600 focus:outline-none whitespace-nowrap">
                👤 Account
            </button>

            <div x-show="open"
                 x-transition
                 class="absolute right-0 mt-2 bg-white shadow rounded border z-50 w-40"
                 @click="open = false">
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50">🔐 Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50">📝 Register</a>
            </div>
        </div>

    </div>
</header>
