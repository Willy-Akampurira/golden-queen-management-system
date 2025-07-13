@extends('layouts.app')

@section('title', 'Order #'.$order->id)

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Order #{{ $order->id }}</h2>

    <div class="space-y-2 mb-6">
        <p><strong>Meal:</strong> {{ $order->menuItem->name ?? 'N/A' }}</p>
        <p><strong>Table Number:</strong> {{ $order->table_number }}</p>
        <p><strong>Status:</strong> <span class="capitalize">{{ $order->status }}</span></p>
        <p><strong>Placed On:</strong> {{ $order->created_at->format('F j, Y • g:i A') }}</p>
        @if($order->drinks)
            <p><strong>Drinks:</strong> {{ implode(', ', json_decode($order->drinks)) }}</p>
        @endif
    </div>

    <div class="flex gap-4">
        @if(!in_array($order->status, ['cancelled', 'completed']))
            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cancel</button>
            </form>
        @endif

        <form method="POST" action="{{ route('orders.reorder', $order) }}">
            @csrf
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Reorder</button>
        </form>

        <a href="{{ route('dashboard') }}" class="ml-auto text-gray-600 hover:underline">← Back to dashboard</a>
    </div>
</div>
@endsection
