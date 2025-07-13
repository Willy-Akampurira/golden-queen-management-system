@extends('layouts.admin')

@section('title', $title)

@section('content')
<h1 class="text-2x1 font-bold mb-6">{{ $title }}</h1>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($menuItem))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Item Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $menuItem->name ?? '') }}" required>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $menuItem->description ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $menuItem->price ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="">Select a category</option>
            <option value="main" {{ old('category', $menuItem->category ?? '') == 'main' ? 'selected' : '' }}>Main Course</option>
            <option value="pasta" {{ old('category', $menuItem->category ?? '') == 'pasta' ? 'selected' : '' }}>Pasta</option>
            <option value="starter" {{ old('category', $menuItem->category ?? '') == 'starter' ? 'selected' : '' }}>Starter</option>
            <option value="dessert" {{ old('category', $menuItem->category ?? '') == 'dessert' ? 'selected' : '' }}>Dessert</option>
            <option value="drink" {{ old('category', $menuItem->category ?? '') == 'drink' ? 'selected' : '' }}>Drink</option>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image">

        @if(isset($menuItem) && $menuItem->image)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name}}" class="h-32">
        </div>
        @endif
    </div>

    <button type="submit" class="btn-primary">Save</button>
</form>
@endsection























