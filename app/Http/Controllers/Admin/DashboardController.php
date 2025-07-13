<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Total Orders per Day (Bar Chart)
        $ordersByDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📈 Pending + Completed Orders per Day (Line Chart)
        $completed = Order::where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $pending = Order::where('status', 'pending')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        // 🗓️ Consistent labels (dates formatted for X-axis)
        $labels = $ordersByDay->pluck('date')->map(fn ($d) => Carbon::parse($d)->format('M d'))->toArray();

        // 🔢 Normalize data to match label order
        $lineCompleted = collect($ordersByDay)->map(fn ($day) => $completed[$day->date] ?? 0);
        $linePending   = collect($ordersByDay)->map(fn ($day) => $pending[$day->date] ?? 0);

        // 🧹 Deduplicate Menu Items for accurate dashboard display
        $uniqueMenuItems = MenuItem::get()->unique('name');

        return view('admin.dashboard', [
            'ordersCount'        => Order::count(),
            'pendingOrdersCount' => Order::where('status', 'pending')->count(),
            'menuItemsCount'     => $uniqueMenuItems->count(),
            'usersCount'         => User::count(),
            'menuItems'          => $uniqueMenuItems,
            'recentOrders'       => Order::with('menuItem')->latest()->take(5)->get(),

            // 📈 Chart Data
            'chartLabels'        => $labels,
            'barData'            => $ordersByDay->pluck('count'),
            'lineCompleted'      => $lineCompleted,
            'linePending'        => $linePending,
        ]);
    }
}
