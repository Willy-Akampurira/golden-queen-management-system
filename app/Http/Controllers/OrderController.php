<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $menuItems = MenuItem::all();
        return view('orders.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|max:50',
            'gender' => 'required|in:male,female,other',
            'menu_item_id' => 'required|exists:menu_items,id',
            'table_number' => 'required|integer|min:1|max:12',
            'drinks' => 'nullable|array',
            'drinks.*' => 'in:wine,beer,soda,water',
        ]);

        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->check() ? auth()->id() : null;
        $validated['drinks'] = isset($validated['drinks']) ? json_encode($validated['drinks']) : null;

        Order::create($validated);

        return redirect()->route('orders.create')->with('success', 'Your order has been placed!');
    }
}
