@extends('layouts.app')

@section('title', 'Place Your Order')

@section('content')
<div class="flex justify-center items-start min-h-screen pt-12 px-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">

        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Golden Queen" class="h-16">
        </div>

        <form id="order-form" action="{{ route('orders.store') }}" method="POST">
            @csrf

            <h2 class="text-2xl font-bold mb-4 text-center">Place Your Order</h2>

            @if(session('success'))
            <div class="alert alert-success mb-4 text-green-700 font-semibold">
                {{ session('success') }}
            </div>
            @endif

            <div class="form-group mb-4">
                <label for="customer_name" class="block text-sm font-medium">Name:</label>
                <input type="text" id="customer_name" name="customer_name" required maxlength="50" placeholder="Your name" class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
            </div>

            <div class="form-group mb-4">
                <label class="block text-sm font-medium mb-1">Gender:</label>
                <div class="flex gap-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="gender" value="male" required class="accent-blue-600 w-4 h-4 rounded-full">
                        <span>Male</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="gender" value="female" class="accent-pink-500 w-4 h-4 rounded-full">
                        <span>Female</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="gender" value="other" class="accent-gray-500 w-4 h-4 rounded-full">
                        <span>Other</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="menu_item_id" class="block text-sm font-medium">Chosen Meal:</label>
                <select id="menu_item_id" name="menu_item_id" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                    <option value="">-- Select a meal --</option>
                    @foreach($menuItems as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} - UGX {{ number_format($item->price * 1000) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="table_number" class="block text-sm font-medium">Table Number:</label>
                <input type="number" id="table_number" name="table_number" min="1" max="12" required placeholder="1 - 12" class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
            </div>

            <div class="form-group mb-6">
                <label class="block text-sm font-medium mb-1">Drinks:</label>
                <div class="grid grid-cols-2 gap-2">
                    <label><input type="checkbox" name="drinks[]" value="wine" class="mr-1">Wine</label>
                    <label><input type="checkbox" name="drinks[]" value="beer" class="mr-1">Beer</label>
                    <label><input type="checkbox" name="drinks[]" value="soda" class="mr-1">Soda</label>
                    <label><input type="checkbox" name="drinks[]" value="water" class="mr-1">Water</label>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition duration-200">Place Order</button>
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 mb-2">
                    Curious what others think? Browse recent feedback before placing your order.
                </p>
                <a href="{{ route('feedbacks.index') }}"
                class="inline-block text-sm text-blue-600 hover:underline">
                    💬 See What Customers Are Saying →
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
