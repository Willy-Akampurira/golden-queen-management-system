<x-guest-layout>
    {{-- 🌟 Golden Queen Login UI --}}
    <div class="min-h-screen flex items-center justify-center bg-[#fffdf4] px-4">
        <div class="w-full max-w-md bg-white border border-yellow-100 rounded-lg shadow-lg p-6 space-y-6">

            {{-- 🖼️ Logo + Heading --}}
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo" class="h-14 mb-2">
                <h2 class="text-xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-sm text-gray-500">Log in to manage your dashboard</p>
            </div>

            {{-- ✅ Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- 🔐 Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required autofocus autocomplete="username"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me & Forgot --}}
                <div class="flex justify-between items-center text-sm">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="h-4 w-4 text-orange-600 border-gray-300 rounded shadow-sm focus:ring-orange-500"
                               name="remember">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-orange-600 hover:underline focus:outline-none focus:ring-2 focus:ring-orange-500 rounded-md">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600 text-white font-semibold shadow">
                        🔓 Log in
                    </x-primary-button>
                </div>
            </form>

            {{-- 🆕 Register Prompt --}}
            <p class="text-sm text-center text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-orange-600 hover:underline font-semibold">
                    Register here
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
