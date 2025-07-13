@extends('layouts.admin')

@section('title', 'Feedback Details')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Feedback from {{ $feedback->user?->name ?? $feedback->name ?? 'Guest' }}</h1>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Feedback Details --}}
    <div class="bg-white rounded shadow p-6 mb-6 space-y-4">
        <div>
            <strong>Meal:</strong>
            {{ $feedback->order?->menuItem?->name ?? '—' }}
        </div>

        <div>
            <strong>Rating:</strong>
            <span class="text-yellow-500">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}"
                        viewBox="0 0 24 24" stroke="currentColor" class="inline w-4 h-4 {{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.913c.969 0 1.372 1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.89a1 1 0 00-1.175 0l-3.976 2.89c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.89c-.784-.57-.38-1.81.588-1.81h4.913a1 1 0 00.95-.69l1.518-4.674z" />
                    </svg>
                @endfor
            </span>
        </div>

        <div>
            <strong>Comment:</strong><br>
            <p class="text-gray-700 mt-1">{{ $feedback->comment ?? '—' }}</p>
        </div>

        <div>
            <strong>Submitted:</strong>
            {{ $feedback->created_at->format('M d, Y g:i A') }}
        </div>
    </div>

    {{-- Admin Reply Form --}}
    <h2 class="text-lg font-semibold mb-2">Your Reply</h2>
    <form method="POST" action="{{ route('admin.feedback.reply', $feedback) }}">
        @csrf
        @method('PATCH')

        <textarea name="admin_reply" rows="4" class="w-full border border-gray-300 rounded shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                  placeholder="Write your response...">{{ old('admin_reply', $feedback->admin_reply) }}</textarea>

        <button type="submit"
                class="mt-3 px-6 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
            Send Reply
        </button>
    </form>
@endsection
