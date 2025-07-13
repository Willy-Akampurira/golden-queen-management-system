@extends('layouts.admin')

@section('title', $title)

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>

<form>
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="password">{{ isset($user) ? 'New Password' : 'Password' }}</label>
        <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
        @if(isset($user))
        <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
        @endif
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="form-group">
        <label for="role">User Role</label>
        <select id="role" name="role" class="form-select" required>
            <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="worker" {{ old('role', $user->role ?? '') === 'worker' ? 'selected' : '' }}>Worker</option>
        </select>
    </div>

    <button type="submit" class="btn-primary">Save</button>
</form>
@endsection
