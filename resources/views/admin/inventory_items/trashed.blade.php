@extends('layouts.admin')

@section('title', 'Trashed Inventory Items')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Trashed Inventory Items</h1>
    <a href="{{ route('admin.inventory-items.index') }}"
       class="text-sm text-orange-600 font-semibold hover:underline">← Back to Inventory</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full text-sm">
        <thead class="bg-red-50 text-gray-700 uppercase text-xs font-semibold">
            <tr>
                <th class="p-3 text-left">Item</th>
                <th class="p-3 text-left">Category</th>
                <th class="p-3 text-left">Unit</th>
                <th class="p-3 text-left">Qty</th>
                <th class="p-3 text-left">Supplier</th>
                <th class="p-3 text-left">Deleted At</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr class="border-t {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="p-3 font-semibold text-red-700">{{ $item->name }}</td>
                    <td class="p-3 text-gray-600">{{ $item->category }}</td>
                    <td class="p-3 text-gray-600">{{ $item->unit }}</td>
                    <td class="p-3 text-gray-600">{{ $item->quantity }}</td>
                    <td class="p-3 text-gray-600">{{ $item->supplier }}</td>
                    <td class="p-3 text-gray-500">{{ $item->deleted_at->format('M d, Y h:i A') }}</td>
                    <td class="p-3 text-center space-x-2">
                        <form method="POST" action="{{ route('admin.inventory-items.restore', $item->id) }}" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                🔄 Restore
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.inventory-items.force-delete', $item->id) }}" class="inline-block"
                              onsubmit="return confirm('Permanently delete this item? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                ❌ Delete Forever
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        No deleted inventory items found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
