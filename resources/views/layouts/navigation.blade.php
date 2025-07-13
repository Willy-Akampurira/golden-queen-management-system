<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route('dashboard') : route('menu.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        {{-- Dashboard --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5" />
                                </svg>
                                {{ __('Dashboard') }}
                            </span>
                        </x-nav-link>

                        {{-- Admin Panel --}}
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11.25 4.5a.75.75 0 011.5 0v1.245a5.98 5.98 0 012.01.836l.877-.878a.75.75 0 111.061 1.061l-.878.877a5.978 5.978 0 01.836 2.01h1.245a.75.75 0 010 1.5h-1.245a5.978 5.978 0 01-.836 2.01l.878.877a.75.75 0 11-1.061 1.061l-.877-.878a5.98 5.98 0 01-2.01.836V19.5a.75.75 0 01-1.5 0v-1.245a5.978 5.978 0 01-2.01-.836l-.877.878a.75.75 0 11-1.061-1.061l.878-.877a5.978 5.978 0 01-.836-2.01H4.5a.75.75 0 010-1.5h1.245a5.978 5.978 0 01.836-2.01l-.878-.877a.75.75 0 111.061-1.061l.877.878a5.978 5.978 0 012.01-.836V4.5zM12 9.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                                    </svg>
                                    {{ __('Admin') }}
                                </span>
                            </x-nav-link>
                        @endif
                    @else
                        {{-- Menu --}}
                        <x-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.index')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 3.75v16.5M9 3.75v16.5M13.5 7.5h6M16.5 7.5v13.5" />
                                </svg>
                                {{ __('Menu') }}
                            </span>
                        </x-nav-link>

                        {{-- Order Now --}}
                        <x-nav-link :href="route('orders.create')" :active="request()->routeIs('orders.create')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75h6m-3 0v2.25M4.5 6.75h15v13.5h-15z" />
                                </svg>
                                {{ __('Order Now') }}
                            </span>
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- ✅ User Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 text-gray-500" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 
                                          10.586l3.293-3.293a1 1 0 111.414 
                                          1.414l-4 4a1 1 0 01-1.414 
                                          0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth
        </div>
    </div>
</nav>
