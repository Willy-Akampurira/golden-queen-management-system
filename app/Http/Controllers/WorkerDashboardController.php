<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Order;

class WorkerDashboardController extends Controller
{
    /**
     * Display the worker dashboard view with essential data.
     */
    public function index()
    {
        // 🧮 Inventory overview
        $inventoryStats = InventoryItem::orderBy('name')
            ->select('name', 'quantity')
            ->get();

        // 🕒 Latest inventory movements
        $recentTransactions = InventoryTransaction::latest()
            ->take(10)
            ->get();

        // 📝 Pending orders
        $activeOrders = Order::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('worker.dashboard', compact(
            'inventoryStats',
            'recentTransactions',
            'activeOrders'
        ));
    }
}
