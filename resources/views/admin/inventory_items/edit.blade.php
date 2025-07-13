@extends('layouts.admin')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Item: {{ $item->name }}</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.inventory-items.update', $item->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Item Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" id="category" value="{{ old('category', $item->category) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit', $item->unit) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $item->quantity) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="reorder_level" class="block text-sm font-medium text-gray-700">Reorder Level</label>
                <input type="number" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', $item->reorder_level) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price (UGX)</label>
                <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price', $item->unit_price) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
            <input type="text" name="supplier" id="supplier" value="{{ old('supplier', $item->supplier) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.inventory-items.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900 transition underline">
               ← Cancel
            </a>
            <button type="submit"
                    class="bg-green-600 text-white hover:bg-green-700 px-5 py-2 rounded text-sm font-semibold transition">
                Update Item
            </button>
        </div>
    </form>
</div>
@endsection
