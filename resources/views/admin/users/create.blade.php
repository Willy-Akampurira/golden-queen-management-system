@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">User Role</label>
            <select name="role" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="user">Customer</option>
                <option value="admin">Admin</option>
                <option value="worker">Worker</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Create User
        </button>
    </form>
</div>
@endsection
