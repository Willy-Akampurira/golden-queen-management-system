@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', 'Our Menu')

@section('content')

@include('partials.public-header')

{{-- 🔍 Search Box --}}
<div class="mt-8 mb-6 text-center">
    <input type="text" id="search-box" placeholder="🔍 Search meals..."
           class="w-11/12 sm:w-1/2 max-w-md border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
</div>

{{-- 🍴 Menu Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
    @forelse ($menuItems->unique('name') as $item)
        <div class="food-card relative bg-white rounded-lg shadow p-3 flex flex-col items-center text-center transition hover:shadow-lg hover:ring-1 hover:ring-yellow-400 hover:-translate-y-1 duration-150"
             data-name="{{ strtolower($item->name) }}">

            {{-- 👑 Top Rated Badge --}}
            @if ($item->averageRating() >= 4.2)
                <span class="absolute top-2 right-2 bg-green-100 text-green-800 text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm uppercase tracking-wide">
                    👑 Top Rated
                </span>
            @endif

            {{-- 🖼️ Image --}}
            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default-food.png') }}"
                 alt="{{ $item->name }}"
                 class="w-full h-36 object-cover rounded-md">

            {{-- 📝 Name & Price --}}
            <h3 class="text-base font-semibold mt-2 text-gray-900 leading-tight">{{ $item->name }}</h3>
            <p class="text-yellow-700 text-sm font-medium mt-0.5">
                UGX {{ number_format($item->price * 1000) }}
            </p>

            {{-- ⭐ Star Rating --}}
            <div class="flex justify-center gap-0.5 mt-2">
                @for ($star = 1; $star <= 5; $star++)
                    <button type="button"
                            class="star-button"
                            data-item="{{ $item->id }}"
                            data-rating="{{ $star }}"
                            aria-label="Rate {{ $star }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             class="w-4 h-4 text-gray-300 hover:scale-105 transition-transform">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 
                                     4.674a1 1 0 00.95.69h4.913c.969 0 1.372 
                                     1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 
                                     1.118l1.518 4.674c.3.921-.755 1.688-1.54 
                                     1.118l-3.976-2.89a1 1 0 00-1.175 
                                     0l-3.976 2.89c-.784.57-1.838-.197-1.539-
                                     1.118l1.518-4.674a1 1 0 00-.364-
                                     1.118l-3.976-2.89c-.784-.57-.38-1.81.588-
                                     1.81h4.913a1 1 0 00.95-.69l1.518-4.674z"/>
                        </svg>
                    </button>
                @endfor
            </div>

            {{-- 📊 Rating Info --}}
            <div class="mt-1 text-xs text-gray-600 leading-tight">
                <span class="inline-block bg-yellow-100 text-yellow-800 font-semibold px-2 py-0.5 rounded">
                    ⭐ {{ number_format($item->averageRating(), 1) }}
                </span>
                <span class="ml-1">
                    · {{ $item->ratingCount() }} {{ Str::plural('rating', $item->ratingCount()) }}
                </span>
            </div>

            {{-- 🛒 Order Button --}}
            <div class="mt-3">
                <a href="{{ route('orders.create') }}"
                   class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-md transition">
                    🛒 Order Now
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 text-lg">
            😕 No meals available at the moment.
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchBox = document.getElementById('search-box');
    const cards = document.querySelectorAll('.food-card');

    searchBox?.addEventListener('input', e => {
        const term = e.target.value.toLowerCase();
        cards.forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(term) ? 'flex' : 'none';
        });
    });

    document.querySelectorAll('.star-button').forEach(button => {
        button.addEventListener('click', () => {
            const itemId = button.dataset.item;
            const rating = parseInt(button.dataset.rating);

            const allButtons = document.querySelectorAll(`.star-button[data-item="${itemId}"]`);
            allButtons.forEach(btn => {
                const svg = btn.querySelector('svg');
                const value = parseInt(btn.dataset.rating);
                svg.classList.toggle('text-yellow-400', value <= rating);
                svg.classList.toggle('text-gray-300', value > rating);
            });

            fetch(`/menu-items/${itemId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ rating })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(() => alert('Something went wrong. Please try again.'));
        });
    });
});
</script>
@endsection
