<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['menuItem', 'user']) // eager-load both relationships
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'menuItem']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }

    // ✅ CSV Export for Orders
    public function exportCsv(): StreamedResponse
    {
        $orders = Order::with(['menuItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'orders.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // CSV Header Row
            fputcsv($file, ['Order ID', 'Customer', 'Item', 'Quantity', 'Status', 'Total Price', 'Ordered At']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    optional($order->user)->name,
                    optional($order->menuItem)->name,
                    $order->quantity,
                    $order->status,
                    $order->total_price,
                    $order->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
