@extends('layouts.app')

@section('title', 'Welcome to Golden Queen')

{{-- Meta tag for auto-redirect after 3 seconds --}}
@push('meta')
    <meta http-equiv="refresh" content="3;url={{ route('menu.index') }}">
@endpush

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen text-center py-20">
        {{-- Logo --}}
        <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo"
             class="w-32 h-32 mb-6 rounded-full shadow-md border border-yellow-400">

        {{-- Welcome Text --}}
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">
            Welcome to Golden Queen 👑
        </h1>

        <p class="text-gray-600 text-lg mb-6">
            Fresh meals, smooth orders.<br class="hidden sm:inline" />
            You're being redirected to our delicious menu...
        </p>

        {{-- Manual fallback link --}}
        <p class="text-sm text-gray-500">
            Or <a href="{{ route('menu.index') }}" class="text-yellow-600 hover:underline">
                click here
            </a> if it doesn’t load automatically.
        </p>
    </div>
@endsection
