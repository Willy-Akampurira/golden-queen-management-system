@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<h1 class="text-2xl font-bold mb-6">Orders</h1>

<div class="flex justify-end mb-4">
    <a href="{{ route('admin.orders.export') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        ⬇️ Export Orders CSV
    </a>
</div>


<div class="bg-white p-4 rounded shadow">
    <table class="min-w-full text-sm text-left border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border-b">ID</th>
                <th class="p-2 border-b">Customer</th>
                <th class="p-2 border-b">Meal</th>
                <th class="p-2 border-b">Table</th>
                <th class="p-2 border-b">Status</th>
                <th class="p-2 border-b">Date</th>
                <th class="p-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-t">
                <td class="p-2">{{ $order->id }}</td>
                <td class="p-2">
                    @if ($order->user)
                        <span class="text-blue-700 font-semibold">
                            {{ $order->user->name }}
                            <span class="text-xs text-gray-500">(Registered)</span>
                        </span>
                    @elseif ($order->customer_name)
                        <span class="text-gray-800">
                            {{ $order->customer_name }}
                            <span class="text-xs text-yellow-600">(Guest)</span>
                        </span>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </td>
                <td class="p-2 flex items-center gap-2">
                    @if($order->menuItem && $order->menuItem->image)
                        <img src="{{ asset('storage/' . $order->menuItem->image) }}" alt="Meal image" class="w-10 h-10 object-cover rounded">
                    @endif
                    {{ $order->menuItem->name ?? 'N/A' }}
                </td>
                <td class="p-2">{{ $order->table_number }}</td>
                <td class="p-2">
                    @php
                        $status = strtolower(trim($order->status));
                        $statusIcon = match($status) {
                            'pending' => '⌛',
                            'preparing' => '⏳',
                            'completed' => '✅',
                            'cancelled' => '❌',
                            default => '📝',
                        };
                        $statusClass = match($status) {
                            'pending' => 'bg-gray-100 text-gray-700',
                            'preparing' => 'bg-yellow-100 text-yellow-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-200 text-gray-700',
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                        <span>{{ $statusIcon }}</span>
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="p-2">{{ $order->created_at->format('M d, Y H:i') }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
