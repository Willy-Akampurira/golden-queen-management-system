@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center mt-12 px-4 text-center">
    {{-- Logo --}}
    <img src="{{ asset('images/logo.png') }}" alt="Golden Queen Logo" class="w-16 h-16 mb-2 shadow-sm">

    {{-- Heading --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-4">📲 Scan to View Our Menu</h2>

    {{-- QR Code --}}
    <div class="bg-white p-5 rounded shadow-md">
        {!! $qr !!}
    </div>

    {{-- Direct Link --}}
    <p class="mt-4 text-gray-600 text-sm">
        Or visit: <a href="http://192.168.0.113:8000/menu" class="text-blue-600 underline" target="_blank">
            http://192.168.0.113:8000/menu
        </a>
    </p>

    {{-- Download Button --}}
   <a href="{{ route('qr.menu.svg') }}"
        class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow transition">
        ⬇️ Download QR Code as SVG
    </a>

</div>
@endsection
