@extends('layouts.app')

@section('title', 'Edit Menu Item')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Edit Menu Item</h1>

    <form action="{{ route('admin.menu.update', ['menu' => $menu->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Name:</label>
            <input type="text" name="name" value="{{ old('name', $menu->name) }}" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Description:</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Price: (in thousands of UGX)</label>
            <input type="number" name="price" step="0.01" value="{{ old('price', $menu->price) }}" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Category:</label>
            <input type="text" name="category" value="{{ old('category', $menu->category) }}" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-1">Current Image:</label>
            @if($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" alt="Current Image" class="w-32 h-32 object-cover mb-2 rounded">
            @else
                <p class="text-sm italic text-gray-500">No image uploaded</p>
            @endif

            <label class="block text-sm font-semibold mt-2">Change Image:</label>
            <input type="file" name="image" class="w-full">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Update Item
        </button>
    </form>
</div>
@endsection
