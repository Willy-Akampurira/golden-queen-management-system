<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#fffdf4] px-4">
        <div class="w-full max-w-md bg-white border border-yellow-100 rounded-lg shadow-lg p-6 space-y-6">

            {{-- 🖼️ Logo + Heading --}}
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo" class="h-14 mb-2">
                <h2 class="text-xl font-bold text-gray-800">Create an Account</h2>
                <p class="text-sm text-gray-500">Join Golden Queen and manage your dashboard</p>
            </div>

            {{-- 📝 Registration Form --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name"
                                  :value="old('name')" required autofocus autocomplete="name"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email"
                                  :value="old('email')" required autocomplete="username"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password"
                                  required autocomplete="new-password"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                  required autocomplete="new-password"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600 text-white font-semibold shadow">
                        📝 Register
                    </x-primary-button>
                </div>
            </form>

            {{-- 🔁 Login Prompt --}}
            <p class="text-sm text-center text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-orange-600 hover:underline font-semibold">
                    Log in here
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
