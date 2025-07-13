@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
    <span class="status-badge {{ $order->gc_status }}">{{ ucfirst($order->gc_status) }}</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Order Information</h2>

        <div class="space-y-4">
            <div>
                <h3 class="font-medium text-gray-500">Customer Name</h3>
                <p>{{ $order->customer_name }}</p>
            </div>

            <div>
                <h3 class="font-medium text-gray-500">Gender</h3>
                <p>{{ ucfirst($order->gender) }}</p>
            </div>

            <div>
                <h3 class="font-medium text-gray-500">Table Number</h3>
                <p>{{ $order->table_number }}</p>
            </div>

            <div>
                <h3 class="font-medium text-gray-500">Order Date</h3>
                <p>{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Meal Details</h2>

        <div class="flex items-start mb-4"> 
            <img src="{{ asset('storage/' . $order->menuItem->image) }}" alt="{{ $order->menuItem->name }}" class="w-20 h-20 object-cover rounded mr-4">
            <div>
                <h3 class="font-bold">{{ $order->menuItem->name }}</h3>
                <p class="text-gray-600">{{ $order->menuItem->description }}</p>
                <p class="font-bold">UGX {{ number_format($order->menuItem->price * 1000) }}</p>
            </div>
        </div>

        @if($order->drinks)
        <div class="mt-4">
            <h3 class="font-medium text-gray-500">Drinks</h3>
            <ul class="list-disc pl-5">
                @foreach(json_decode($order->drinks) as $drink)
                    <li>{{ ucfirst($drink) }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="status" class="block mb-1 font-medium">Update Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Update Status
            </button>
        </form>
    </div>
</div>
@endsection
