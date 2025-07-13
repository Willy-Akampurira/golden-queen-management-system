@extends('layouts.admin')

@section('title', 'Trashed Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Trashed Users</h1>
    <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Back to Users
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
                <th class="p-3 border-b">Email</th>
                <th class="p-3 border-b">Role</th>
                <th class="p-3 border-b">Deleted At</th>
                <th class="p-3 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trashed as $user)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3 font-medium text-gray-900">{{ $user->name }}</td>
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
                    <td class="p-3 text-gray-500">
                        {{ $user->deleted_at->format('M d, Y g:i A') }}
                    </td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            {{-- 🔄 Restore --}}
                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline text-sm">Restore</button>
                            </form>

                            {{-- ❌ Delete Forever --}}
                            <form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Permanently delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete Forever</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No trashed users found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
