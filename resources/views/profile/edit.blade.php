@extends('layouts.app')

@section('content')
    <h1 class="text-red-600 text-center font-bold text-xl mb-6">✅ Profile view is working!</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            @php
                $user = Auth::user();
                $profileImage = null;

                if (!empty($user->profile_image)) {
                    $customImagePath = public_path('images/profile-images/' . $user->profile_image);
                    if (file_exists($customImagePath)) {
                        $profileImage = 'images/profile-images/' . $user->profile_image;
                    }
                }

                if (!$profileImage) {
                    $gender = strtolower($user->gender ?? '');
                    $fallbackMap = [
                        'female' => 'default_female.png',
                        'male' => 'default_male.png',
                    ];
                    $profileImage = 'images/profile-images/' . ($fallbackMap[$gender] ?? 'default.png');
                }
            @endphp

            {{-- Avatar Preview --}}
            <div>
                <img id="avatarPreview"
                     src="{{ asset($profileImage) }}"
                     alt="Profile Photo"
                     class="w-24 h-24 rounded-full object-cover ring-2 ring-blue-500">
            </div>

            {{-- User Info --}}
            <div class="flex-1">
                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                @if ($user->role)
                    <span class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                        {{ ucfirst($user->role) }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Avatar Upload Form --}}
        <form method="POST" action="{{ route('profile.avatar.upload') }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            <label for="avatarInput" class="block text-sm font-medium text-gray-700 mb-1">Change Profile Picture</label>
            <input type="file" name="avatar" id="avatarInput"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md p-2 mb-2 file:bg-blue-50 file:border file:border-blue-300 file:rounded file:px-3 file:py-1 file:text-sm file:text-blue-700 hover:file:bg-blue-100" />

            @error('avatar')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit"
                    class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Upload New Avatar
            </button>
        </form>

        {{-- Flash message --}}
        @if(session('avatar_success'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('avatar_success') }}
            </div>
        @endif
    </div>

    {{-- Optional Sections --}}
    <div class="mt-8 space-y-6">
        @includeIf('profile.partials.update-profile-information-form')
        @includeIf('profile.partials.update-password-form')
        @includeIf('profile.partials.delete-user-form')
    </div>

    {{-- 💫 Live Preview Script --}}
    <script>
        document.getElementById('avatarInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
