@extends('layouts.admin')

@section('title', 'New Inventory Transaction')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">➕ Log Inventory Transaction</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.inventory-transactions.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- 📦 Item Selector --}}
        <div>
            <label for="inventory_item_id" class="block text-sm font-medium text-gray-700">Inventory Item</label>
            <select name="inventory_item_id" id="inventory_item_id"
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">-- Select Item --</option>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }} ({{ $item->quantity }} {{ $item->unit }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 🔁 Transaction Type --}}
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
            <select name="type" id="type"
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">-- Select Type --</option>
                <option value="restock" {{ old('type') == 'restock' ? 'selected' : '' }}>Restock</option>
                <option value="use" {{ old('type') == 'use' ? 'selected' : '' }}>Use</option>
                <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
            </select>
        </div>

        {{-- 🔢 Quantity Input --}}
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-yellow-500 focus:border-yellow-500">
        </div>

        {{-- 📝 Optional Note --}}
        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Note (optional)</label>
            <textarea name="note" id="note" rows="3"
                      class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('note') }}</textarea>
        </div>

        {{-- ✅ Save Button --}}
        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.inventory-transactions.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900 transition underline">
                ← Cancel
            </a>
            <button type="submit"
                    class="bg-yellow-500 text-white hover:bg-yellow-600 px-5 py-2 rounded text-sm font-semibold transition">
                Log Transaction
            </button>
        </div>
    </form>
</div>
@endsection
