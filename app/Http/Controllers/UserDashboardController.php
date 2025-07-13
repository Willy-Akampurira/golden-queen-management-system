<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('menuItem')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('users.dashboard', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('menuItem');

        return view('users.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled.');
    }

    public function reorder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        Order::create([
            'user_id' => auth()->id(),
            'menu_item_id' => $order->menu_item_id,
            'quantity' => $order->quantity,
            'status' => 'pending',
            'table_number' => $order->table_number,
        ]);

        return back()->with('success', 'Order placed again!');
    }
}
