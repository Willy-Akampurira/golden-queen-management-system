@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Users</h1>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.create') }}"
           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-1.5 rounded text-sm font-semibold transition">
            Add New User
        </a>
        <a href="{{ route('admin.users.export') }}"
            class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            ⬇️ Export Users CSV
        </a>
        <a href="{{ route('admin.users.trashed') }}"
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

<table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
    <thead class="bg-gray-100 text-left text-gray-700">
        <tr>
            <th class="p-3 border-b">Name</th>
            <th class="p-3 border-b">Email</th>
            <th class="p-3 border-b">Role</th>
            <th class="p-3 border-b">Joined</th>
            <th class="p-3 border-b">Last Login</th>
            <th class="p-3 border-b">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class="border-t hover:bg-gray-50 transition">
            <td class="p-3 font-medium text-gray-800">{{ $user->name }}</td>
            <td class="p-3 text-gray-700">{{ $user->email }}</td>
            <td class="p-3">
                <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                    @if($user->role === 'admin')
                        bg-blue-100 text-blue-800
                    @elseif($user->role === 'worker')
                        bg-yellow-100 text-yellow-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst($user->role) }}
                </span>
            </td>
            <td class="p-3 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
            <td class="p-3 text-gray-500 italic">
                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
            </td>
            <td class="p-3">
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded text-sm font-medium transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this user?')">
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

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
