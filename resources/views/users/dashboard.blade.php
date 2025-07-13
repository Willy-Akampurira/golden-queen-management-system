@extends('layouts.app')

@section('title', 'Your Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    <div class="mb-6 flex gap-4">
    <a href="{{ route('menu.index') }}"
       class="inline-block px-5 py-3 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600 transition">
        🍽️ View Menu
    </a>
    <a href="{{ route('orders.create') }}"
       class="inline-block px-5 py-3 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 transition">
        📝 Place an Order
    </a>
</div>


    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">Meal</th>
                    <th class="p-3 border-b">Table</th>
                    <th class="p-3 border-b">Status</th>
                    <th class="p-3 border-b">Date</th>
                    <th class="p-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @php
                        $badgeColors = [
                            'pending'   => 'bg-yellow-100 text-yellow-800',
                            'preparing' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusClass = $badgeColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                        $menu = $order->menuItem ?? null;
                    @endphp
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="p-3 font-medium text-gray-700">#{{ $order->id }}</td>
                        <td class="p-3 text-gray-900">{{ $menu?->name ?? '—' }}</td>
                        <td class="p-3 text-gray-700">{{ $order->table_number }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $order->created_at->format('M d, Y g:i A') }}
                        </td>
                        <td class="p-3">
                            <a href="{{ route('orders.show', $order) }}"
                               class="text-sm text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            You haven’t placed any orders yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
