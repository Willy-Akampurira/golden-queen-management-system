@extends('layouts.admin') {{-- or use layouts.app if you have a simplified one --}}

@section('title', 'Worker Dashboard')

@section('content')
<div class="space-y-6">
    {{-- 📊 Inventory Overview --}}
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Inventory Overview</h2>

        @if($inventoryStats->isEmpty())
            <p class="text-sm text-gray-600">No inventory items available.</p>
        @else
            <ul class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                @foreach($inventoryStats as $item)
                    <li>
                        <strong>{{ $item->name }}:</strong> {{ $item->quantity }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- 🔁 Recent Transactions --}}
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Recent Inventory Actions</h2>

        @if($recentTransactions->isEmpty())
            <p class="text-sm text-gray-600">No recent inventory actions found.</p>
        @else
            <table class="w-full text-sm">
                <thead class="text-left border-b">
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $txn)
                        <tr class="border-t">
                            <td class="py-2">{{ $txn->item_name }}</td>
                            <td class="py-2">{{ ucfirst($txn->type) }}</td>
                            <td class="py-2">{{ $txn->quantity }}</td>
                            <td class="py-2 text-gray-500">{{ $txn->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- 📦 Assigned Orders --}}
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">My Orders</h2>

        @if($activeOrders->isEmpty())
            <p class="text-sm text-gray-600">No active orders at the moment.</p>
        @else
            <ul class="space-y-2 text-sm">
                @foreach($activeOrders as $order)
                    <li class="border border-gray-200 rounded p-3">
                        <div class="flex justify-between items-center">
                            <span><strong>Order #{{ $order->id }}</strong> - Table {{ $order->table_number }}</span>
                            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded font-medium">{{ ucfirst($order->status) }}</span>
                        </div>
                        <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
