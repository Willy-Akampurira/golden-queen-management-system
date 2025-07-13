@extends('layouts.app')

@section('title', 'Add New Menu Item')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Add New Menu Item</h1>

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Name:</label>
            <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Description:</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Price:</label>
            <input type="number" name="price" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Category:</label>
            <input type="text" name="category" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-1">Image:</label>
            <input type="file" name="image" class="w-full">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Save Item
        </button>
    </form>
</div>
@endsection
