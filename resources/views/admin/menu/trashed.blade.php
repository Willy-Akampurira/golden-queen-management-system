@extends('layouts.admin')

@section('title', 'Trashed Menu Items')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Trashed Menu Items</h1>
    <a href="{{ route('admin.menu.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Back to Menu Items
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 border-b">Name</th>
                <th class="p-3 border-b">Deleted At</th>
                <th class="p-3 border-b">Category</th>
                <th class="p-3 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trashed as $item)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3 font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="p-3 text-gray-600">{{ $item->deleted_at->format('M d, Y g:i A') }}</td>
                    <td class="p-3 text-gray-700">{{ ucfirst($item->category) }}</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            {{-- Restore --}}
                            <form action="{{ route('admin.menu.restore', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline text-sm">Restore</button>
                            </form>

                            {{-- Force Delete --}}
                            <form action="{{ route('admin.menu.force-delete', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Permanently delete this menu item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete Forever</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">
                        No trashed menu items found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
