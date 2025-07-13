@extends('layouts.admin')

@section('title', 'All Feedbacks')

@section('content')
<h1 class="text-2xl font-bold mb-6">💬 Customer Feedback</h1>

<div class="flex justify-end mb-4">
    <a href="{{ route('admin.feedbacks.export') }}"
       class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
        ⬇️ Export Feedback CSV
    </a>
</div>


@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
@endif

@if ($feedbacks->isEmpty())
    <p class="text-gray-500">No feedback submitted yet.</p>
@else
    <div class="overflow-x-auto bg-white rounded shadow border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-700 uppercase text-xs tracking-wider">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Meal</th>
                    <th class="px-4 py-2 border">Rating</th>
                    <th class="px-4 py-2 border">Comment</th>
                    <th class="px-4 py-2 border">Reply</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $feedback)
                    <tr class="hover:bg-yellow-50">
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">
                            {{ $feedback->user?->name ?? $feedback->name ?? 'Guest' }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $feedback->order?->menuItem?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 border text-yellow-500 whitespace-nowrap">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}"
                                     viewBox="0 0 24 24" stroke="currentColor"
                                     class="inline w-4 h-4 {{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.913c.969 0 1.372 1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.89a1 1 0 00-1.175 0l-3.976 2.89c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.89c-.784-.57-.38-1.81.588-1.81h4.913a1 1 0 00.95-.69l1.518-4.674z" />
                                </svg>
                            @endfor
                        </td>
                        <td class="px-4 py-2 border text-gray-700">
                            {{ $feedback->comment ?? '—' }}
                        </td>
                        <td class="px-4 py-2 border text-center">
                            @if ($feedback->admin_reply)
                                <span class="text-green-600 font-medium text-xs">✅ Replied</span>
                            @else
                                <span class="text-red-600 font-medium text-xs">⏳ Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border text-gray-500 text-xs whitespace-nowrap">
                            {{ $feedback->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-2 border text-blue-600 text-sm">
                            <a href="{{ route('admin.feedbacks.show', $feedback) }}" class="hover:underline">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4 px-4">
            {{ $feedbacks->links() }}
        </div>
    </div>
@endif
@endsection
