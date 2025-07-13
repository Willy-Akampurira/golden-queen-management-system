<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu items.
     */
    public function index()
    {
        // Fetch all active (non-deleted) menu items
        $menuItems = MenuItem::with('ratings')->get();

        return view('menu.index', compact('menuItems'));
    }

    /**
     * Handle on-card star rating submission via AJAX.
     */
    public function rate(Request $request, MenuItem $item)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        // Optional: Prevent duplicate rating by the same user
        if (Auth::check()) {
            $existing = $item->ratings()
                ->where('user_id', Auth::id())
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already rated this item.',
                ], 409);
            }
        }

        // Store rating
        $item->ratings()->create([
            'user_id' => Auth::id(), // null for guest
            'rating' => $validated['rating'],
        ]);

        return response()->json([
            'success' => true,
            'item' => $item->name,
        ]);
    }
}
