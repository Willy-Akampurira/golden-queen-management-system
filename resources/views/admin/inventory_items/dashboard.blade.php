@extends('layouts.admin')

@section('title', 'Inventory Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    {{-- 🔢 Total Items --}}
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-400">
        <h2 class="text-sm font-semibold text-gray-600">Total Inventory Items</h2>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalItems }}</p>
    </div>

    {{-- ⚠️ Low Stock Highlight --}}
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
        <h2 class="text-sm font-semibold text-gray-600">Low Stock Alerts</h2>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ $lowStockItems->count() }}</p>
    </div>

    {{-- 📆 Daily Consumption --}}
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <h2 class="text-sm font-semibold text-gray-600">Today’s Consumption</h2>
        <p class="text-xl font-bold text-blue-700 mt-1">{{ $dailyConsumption }} units</p>
    </div>

    {{-- 📅 Weekly Consumption --}}
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <h2 class="text-sm font-semibold text-gray-600">Weekly Consumption</h2>
        <p class="text-xl font-bold text-green-700 mt-1">{{ $weeklyConsumption }} units</p>
    </div>
</div>

{{-- 🔘 Quick Action Button --}}
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.inventory-transactions.create') }}"
       class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-4 py-2 rounded shadow transition">
        ➕ Log Stock Transaction
    </a>
</div>

{{-- 📦 Item Breakdown Table --}}
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3 text-left">Item</th>
                <th class="p-3 text-left">Current Qty</th>
                <th class="p-3 text-left">Unit</th>
                <th class="p-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                @php
                    $isLow = $item->quantity <= $item->reorder_level;
                @endphp
                <tr class="border-t {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="p-3 font-medium text-gray-800">{{ $item->name }}</td>
                    <td class="p-3 text-gray-700">{{ $item->quantity }}</td>
                    <td class="p-3 text-gray-600">{{ $item->unit }}</td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $isLow ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $isLow ? 'Low Stock' : 'OK' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
