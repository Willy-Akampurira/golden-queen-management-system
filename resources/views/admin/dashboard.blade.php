@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div x-data x-cloak>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- 🟦 Total Orders --}}
    <div class="bg-blue-500 text-white rounded-lg shadow hover:shadow-lg transition-shadow p-4 flex items-start gap-4">
        <div class="text-3xl">📦</div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide">Total Orders</p>
            <p class="text-2xl font-extrabold mt-1">{{ $ordersCount }}</p>
        </div>
    </div>

    {{-- 🟨 Pending Orders --}}
    <div class="bg-yellow-400 text-gray-900 rounded-lg shadow hover:shadow-lg transition-shadow p-4 flex items-start gap-4">
        <div class="text-3xl">⏳</div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide">Pending Orders</p>
            <p class="text-2xl font-extrabold mt-1">{{ $pendingOrdersCount }}</p>
        </div>
    </div>

    {{-- 🟩 Menu Items (No Icon) --}}
    <div class="bg-emerald-500 text-white rounded-lg shadow hover:shadow-lg transition-shadow p-4 overflow-hidden">
        <p class="text-xs font-semibold uppercase tracking-wide mb-1">Menu Items ({{ $menuItemsCount }})</p>
        <ul class="text-sm text-emerald-100 space-y-1 overflow-y-auto max-h-28 pr-1">
            @foreach ($menuItems as $item)
                <li class="truncate">• {{ $item->name }}</li>
            @endforeach
        </ul>
    </div>

    {{-- 🟪 Registered Users --}}
    <div class="bg-purple-500 text-white rounded-lg shadow hover:shadow-lg transition-shadow p-4 flex items-start gap-4">
        <div class="text-3xl">👥</div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide">Registered Users</p>
            <p class="text-2xl font-extrabold mt-1">{{ $usersCount }}</p>
        </div>
    </div>

</div>



    {{-- 📈 Charts: Side by Side with h-44 --}}
    <div class="flex flex-col md:flex-row gap-6 mb-6">
        {{-- 📉 Orders Overview (Bar) --}}
        <div class="bg-white rounded-lg shadow p-4 w-full md:w-1/2">
            <h2 class="text-sm font-semibold text-gray-700 mb-2">Orders Overview</h2>
            <div class="relative h-44">
                <canvas id="ordersChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        {{-- 📈 Status Trends (Line) --}}
        <div class="bg-white rounded-lg shadow p-4 w-full md:w-1/2">
            <h2 class="text-sm font-semibold text-gray-700 mb-2">Order Status Trends</h2>
            <div class="relative h-44">
                <canvas id="statusChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>
    </div>


    {{-- 🧾 Recent Orders Table --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <h2 class="text-xl font-semibold text-gray-800 px-4 py-4 border-b">Recent Orders</h2>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 font-medium">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Meal</th>
                    <th class="px-4 py-2 text-left">Table</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse ($recentOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $order->id }}</td>
                    <td class="px-4 py-2">{{ $order->customer_name }}</td>
                    <td class="px-4 py-2">{{ $order->menuItem->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $order->table_number }}</td>
                    <td class="px-4 py-2">
                        @php
                            $status = strtolower($order->status);
                            $icon = match($status) {
                                'preparing' => '⏳',
                                'completed' => '✅',
                                'cancelled' => '❌',
                                'pending' => '⌛',
                                default => '📝',
                            };
                            $badgeClass = match($status) {
                                'preparing' => 'bg-yellow-100 text-yellow-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'pending' => 'bg-gray-100 text-gray-700',
                                default => 'bg-gray-200 text-gray-700',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                            {{ $icon }} {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No recent orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const labels = @json($chartLabels);

new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Orders',
            data: @json($barData),
            backgroundColor: 'rgba(59,130,246,0.5)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

new Chart(document.getElementById('statusChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Pending',
                data: @json($linePending),
                borderColor: 'rgba(234,179,8,1)',
                backgroundColor: 'rgba(234,179,8,0.2)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Completed',
                data: @json($lineCompleted),
                borderColor: 'rgba(34,197,94,1)',
                backgroundColor: 'rgba(34,197,94,0.2)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
