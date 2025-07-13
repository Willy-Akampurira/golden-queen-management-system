<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show the generic public feedback form (not tied to an order).
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Show the form for creating feedback about a specific order (authenticated users only).
     */
    public function createForOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('feedbacks.create', [
            'orderId' => $order->id,
        ]);
    }

    /**
     * Store a newly submitted feedback.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:1000',
            'name'     => 'nullable|string|max:255',
        ]);

        $feedback = new Feedback([
            'order_id' => $validated['order_id'] ?? null,
            'rating'   => $validated['rating'],
            'comment'  => $validated['comment'] ?? null,
            'user_id'  => Auth::check() ? Auth::id() : null,
            'name'     => Auth::check() ? null : $validated['name'],
        ]);

        $feedback->save();

        return redirect()->route('feedbacks.index')->with('success', 'Thank you for your feedback!');
    }

    /**
     * Display all feedback publicly.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()
            ->with(['user', 'order.menuItem'])
            ->paginate(10);

        return view('feedbacks.index', compact('feedbacks'));
    }
}
