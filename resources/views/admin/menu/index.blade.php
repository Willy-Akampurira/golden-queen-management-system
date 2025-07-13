@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Manage Menu Items')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Menu Items</h1>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.menu.create') }}"
           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-1.5 rounded text-sm font-semibold transition">
            Add New Item
        </a>
        <a href="{{ route('admin.menu.export') }}"
            class="inline-block bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
            ⬇️ Export Menu CSV
        </a>

        <a href="{{ route('admin.menu.trashed') }}"
           class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-1.5 rounded text-sm font-medium transition">
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
                <th class="p-3 border-b">Image</th>
                <th class="p-3 border-b">Name</th>
                <th class="p-3 border-b">Description</th>
                <th class="p-3 border-b">Price</th>
                <th class="p-3 border-b">Category</th>
                <th class="p-3 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menuItems->unique('name') as $item)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-3">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-14 h-14 object-cover rounded">
                    @else
                        <span class="text-gray-400 italic">No image</span>
                    @endif
                </td>
                <td class="p-3 font-medium text-gray-800">{{ $item->name }}</td>
                <td class="p-3 text-gray-600">{{ Str::limit($item->description, 50) }}</td>
                <td class="p-3">UGX {{ number_format($item->price * 1000) }}</td>
                <td class="p-3 capitalize text-gray-700">{{ $item->category }}</td>
                <td class="p-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.menu.edit', $item->id) }}"
                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded text-sm font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this item?')">
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
