<aside
    class="w-64 min-h-screen bg-yellow-300 shadow fixed top-0 left-0 z-10 pt-16"
>
    {{-- 🌟 Logo --}}
    <div class="p-6 border-b border-yellow-200 flex justify-center">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo" class="h-12">
        </a>
    </div>

    <nav class="p-4 space-y-4">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 text-gray-800 hover:text-blue-600 {{ request()->routeIs('admin.dashboard') ? 'font-semibold text-blue-700' : '' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-700' : 'text-blue-500' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5" />
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Menu Items --}}
        <a href="{{ route('admin.menu.index') }}"
           class="flex items-center gap-3 text-gray-800 hover:text-green-600 {{ request()->routeIs('admin.menu.*') ? 'font-semibold text-green-700' : '' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.menu.*') ? 'text-green-700' : 'text-green-500' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.5 3.75v16.5M9 3.75v16.5M13.5 7.5h6M16.5 7.5v13.5" />
            </svg>
            <span>Menu Items</span>
        </a>

        {{-- Orders --}}
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-3 text-gray-800 hover:text-yellow-600 {{ request()->routeIs('admin.orders.*') ? 'font-semibold text-yellow-700' : '' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-yellow-700' : 'text-yellow-500' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 3.75h6m-3 0v2.25M4.5 6.75h15v13.5h-15zM9 12h6M9 15.75h4.5" />
            </svg>
            <span>Orders</span>
        </a>

        {{-- 🗃️ Inventory Management --}}
        <div x-data="{ open: {{ request()->routeIs('admin.inventory-items.*') || request()->routeIs('admin.inventory-transactions.*') || request()->routeIs('inventory-items.dashboard') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center gap-3 w-full px-4 py-2 text-gray-800 text-sm leading-tight
                    hover:text-orange-600 {{ request()->routeIs('admin.inventory-items.*') || request()->routeIs('admin.inventory-transactions.*') || request()->routeIs('inventory-items.dashboard') ? 'font-semibold text-orange-700' : '' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.inventory-items.*') || request()->routeIs('admin.inventory-transactions.*') || request()->routeIs('inventory-items.dashboard') ? 'text-orange-700' : 'text-orange-500' }}"
                    fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 5.25h16.5v2.25H3.75V5.25zM3.75 10.5h16.5v2.25H3.75V10.5zM3.75 15.75h16.5v2.25H3.75V15.75z" />
                </svg>
                <span>Inventory Management</span>
                <svg class="w-4 h-4 ml-auto transform transition-transform duration-300" :class="{ 'rotate-90': open }"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-cloak class="pl-8 mt-2 space-y-1">
                <a href="{{ route('inventory-items.dashboard') }}"
                class="block text-sm text-gray-700 hover:text-orange-600 {{ request()->routeIs('inventory-items.dashboard') ? 'font-semibold text-orange-700' : '' }}">
                    ▸ Inventory Dashboard
                </a>
                <a href="{{ route('admin.inventory-items.index') }}"
                class="block text-sm text-gray-700 hover:text-orange-600 {{ request()->routeIs('admin.inventory-items.*') ? 'font-semibold text-orange-700' : '' }}">
                    ▸ Inventory Items
                </a>
                <a href="{{ route('admin.inventory-transactions.index') }}"
                class="block text-sm text-gray-700 hover:text-orange-600 {{ request()->routeIs('admin.inventory-transactions.*') ? 'font-semibold text-orange-700' : '' }}">
                    ▸ Transactions
                </a>
            </div>
        </div>

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 text-gray-800 hover:text-purple-600 {{ request()->routeIs('admin.users.*') ? 'font-semibold text-purple-700' : '' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-purple-700' : 'text-purple-500' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM6 20.25a6 6 0 1112 0H6z" />
            </svg>
            <span>Users</span>
        </a>

        {{-- 💬 Feedback --}}
        <a href="{{ route('admin.feedbacks.index') }}"
           class="flex items-center gap-3 text-gray-800 hover:text-pink-600 {{ request()->routeIs('admin.feedbacks.*') ? 'font-semibold text-pink-700' : '' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.feedbacks.*') ? 'text-pink-700' : 'text-pink-500' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3h6m-6 3h4.5M4.5 5.25h15v13.5l-3-2.25H4.5V5.25z" />
            </svg>
            <span>Customer Feedback</span>
        </a>
    </nav>
</aside>
