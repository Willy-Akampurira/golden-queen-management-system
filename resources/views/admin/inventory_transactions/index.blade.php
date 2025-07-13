@extends('layouts.admin')

@section('title', 'Inventory Transactions')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Inventory Transactions</h1>
</div>

<div class="flex justify-end mb-4 space-x-3">
    <a href="{{ route('admin.inventory-transactions.create') }}"
       class="bg-yellow-500 text-white hover:bg-yellow-600 px-4 py-1.5 rounded text-sm font-semibold transition">
        ➕ Log New Transaction
    </a>

    <a href="{{ route('admin.inventory-transactions.export') }}"
       class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
        ⬇️ Export Transactions CSV
    </a>
</div>



@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3 border-b">Item</th>
                <th class="p-3 border-b">Type</th>
                <th class="p-3 border-b">Quantity</th>
                <th class="p-3 border-b">Note</th>
                <th class="p-3 border-b">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3 font-medium text-gray-800">
                        {{ $transaction->item->name ?? '—' }}
                    </td>
                    <td class="p-3">
                                    @php
                            $badgeColor = match($transaction->type) {
                                'restock'    => 'bg-green-100 text-green-700',
                                'use'        => 'bg-red-100 text-red-700',
                                'adjustment' => 'bg-yellow-100 text-yellow-700',
                                default      => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                            {{ ucfirst($transaction->type) }}
                        </span>

                    </td>
                    <td class="p-3 text-gray-700">{{ $transaction->quantity }}</td>
                    <td class="p-3 text-gray-600">{{ $transaction->note ?? '—' }}</td>
                    <td class="p-3 text-gray-500">{{ \Carbon\Carbon::parse($transaction->transaction_date)->diffForHumans() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        No transactions logged yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $transactions->links() }}
</div>
@endsection
