@extends('layouts.admin')

@section('title', 'Inventory Items')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Inventory Items</h1>
    <div class="flex items-center gap-1.5">
        <a href="{{ route('admin.inventory-items.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-4 py-1.5 rounded shadow transition">
            ➕ Add New Item
        </a>
        <a href="{{ route('admin.inventory-items.export') }}"
            class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-green-700">
            ⬇️ Export Inventory CSV
         </a>
        <a href="{{ route('admin.inventory-items.trashed') }}"
           class="bg-gray-100 hover:bg-gray-200 text-black-600 text-sm font-semibold px-4 py-1.5 rounded shadow-sm transition">
            🗑️ View Trash
        </a>
    </div>
</div>


@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3 border-b">Name</th>
                <th class="p-3 border-b">Category</th>
                <th class="p-3 border-b">Unit</th>
                <th class="p-3 border-b">Quantity</th>
                <th class="p-3 border-b">Reorder Level</th>
                <th class="p-3 border-b">Unit Price</th>
                <th class="p-3 border-b">Supplier</th>
                <th class="p-3 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3 font-medium text-gray-800">{{ $item->name }}</td>
                    <td class="p-3 capitalize text-gray-600">{{ $item->category }}</td>
                    <td class="p-3 text-gray-600">{{ $item->unit }}</td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $item->quantity <= $item->reorder_level ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-800' }}">
                            {{ $item->quantity }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-600">{{ $item->reorder_level }}</td>
                    <td class="p-3 text-gray-700">UGX {{ number_format($item->unit_price) }}</td>
                    <td class="p-3 text-gray-600">{{ $item->supplier }}</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.inventory-items.edit', $item->id) }}"
                               class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded text-sm font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.inventory-items.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded text-sm font-semibold transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">
                        No inventory items found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
