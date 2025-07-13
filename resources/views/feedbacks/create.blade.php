@extends('layouts.app')

@section('title', 'Leave Feedback')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-6 mt-6">

    <h2 class="text-xl font-semibold mb-4 text-gray-800">💬 Share Your Feedback</h2>

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❗ Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✍️ Feedback Form --}}
    <form method="POST" action="{{ route('feedbacks.store') }}">
        @csrf

        {{-- Hidden Order ID (if available) --}}
        @if (!empty($orderId))
            <input type="hidden" name="order_id" value="{{ $orderId }}">
        @endif

        {{-- Name (guests only) --}}
        @guest
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                <input type="text" name="name" required
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                       value="{{ old('name') }}">
            </div>
        @endguest

        {{-- Rating --}}
        <div class="mb-4">
            <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1 to 5)</label>
            <input type="number" name="rating" min="1" max="5" required
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                   value="{{ old('rating') }}">
        </div>

        {{-- Comment --}}
        <div class="mb-4">
            <label for="comment" class="block text-sm font-medium text-gray-700">Comment (optional)</label>
            <textarea name="comment" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                      placeholder="What did you enjoy?">{{ old('comment') }}</textarea>
        </div>

        <button type="submit"
                class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 transition">
            Submit Feedback
        </button>
    </form>

    {{-- 🔁 UX Navigation --}}
    <div class="mt-6 flex flex-wrap gap-4 text-sm">
        @auth
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
        @endauth
        <a href="{{ route('menu.index') }}" class="text-green-600 hover:underline">🍽️ View Menu Again</a>
        <a href="{{ route('orders.create') }}" class="text-indigo-600 hover:underline">📝 Place Another Order</a>
        <a href="{{ route('feedbacks.index') }}" class="text-gray-600 hover:underline">💬 See Other Reviews</a>
    </div>

</div>
@endsection
