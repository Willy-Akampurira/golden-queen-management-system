@extends('layouts.app')

@section('title', 'What Our Customers Say')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">💬 Customer Reviews</h2>

    @if ($feedbacks->isEmpty())
        <div class="text-gray-600 text-center">
            No feedback has been submitted yet.
        </div>
    @else
        <div class="space-y-6">
            @foreach ($feedbacks as $feedback)
                <div class="bg-white rounded shadow p-5 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $feedback->user?->name ?? $feedback->name ?? 'Anonymous' }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            {{ $feedback->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="flex items-center mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}"
                                 viewBox="0 0 24 24" stroke="currentColor"
                                 class="w-5 h-5 {{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.913c.969 0 1.372 1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.89a1 1 0 00-1.175 0l-3.976 2.89c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.89c-.784-.57-.38-1.81.588-1.81h4.913a1 1 0 00.95-.69l1.518-4.674z" />
                            </svg>
                        @endfor
                    </div>

                    <p class="text-gray-700 mb-2">{{ $feedback->comment ?? 'No comment left.' }}</p>

                    @if ($feedback->admin_reply)
                        <div class="mt-4 bg-gray-50 rounded p-3 border border-yellow-100">
                            <strong class="text-sm text-yellow-800 block mb-1">Admin Reply:</strong>
                            <p class="text-sm text-gray-800">{{ $feedback->admin_reply }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $feedbacks->links() }}
        </div>
    @endif
</div>
@endsection
