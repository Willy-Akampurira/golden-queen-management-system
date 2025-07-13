@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
        </div>

        <div class="mb-4">
            <label class="block font-medium">New Password (optional)</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
        </div>

        <div class="mb-6">
            <label class="block font-medium mb-1">User Role</label>
            <select name="role" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="worker" {{ $user->role === 'worker' ? 'selected' : '' }}>Worker</option>
            </select>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700">
            Update User
        </button>
    </form>
</div>
@endsection
