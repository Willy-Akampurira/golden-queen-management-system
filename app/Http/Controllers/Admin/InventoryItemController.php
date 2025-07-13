<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryItemController extends Controller
{
    /**
     * Inventory Dashboard Summary.
     */
    public function dashboard()
    {
        $items = InventoryItem::withoutTrashed()->get();
        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'reorder_level')->withoutTrashed()->get();

        $dailyConsumption = InventoryTransaction::whereDate('transaction_date', now())
            ->where('type', 'use')->sum('quantity');

        $weeklyConsumption = InventoryTransaction::whereBetween('transaction_date', [now()->startOfWeek(), now()])
            ->where('type', 'use')->sum('quantity');

        return view('admin.inventory_items.dashboard', [
            'items'             => $items,
            'lowStockItems'     => $lowStockItems,
            'dailyConsumption'  => $dailyConsumption,
            'weeklyConsumption' => $weeklyConsumption,
            'totalItems'        => $items->count(),
        ]);
    }

    public function index()
    {
        $items = InventoryItem::withoutTrashed()->get();
        return view('admin.inventory_items.index', compact('items'));
    }

    public function trashed()
    {
        $items = InventoryItem::onlyTrashed()->get();
        return view('admin.inventory_items.trashed', compact('items'));
    }

    public function restore($id)
    {
        $item = InventoryItem::withTrashed()->findOrFail($id);
        $item->restore();

        return redirect()->route('admin.inventory-items.index')
                         ->with('success', 'Inventory item restored successfully.');
    }

    public function forceDelete($id)
    {
        $item = InventoryItem::withTrashed()->findOrFail($id);
        $item->forceDelete();

        return redirect()->route('admin.inventory-items.trashed')
                         ->with('success', 'Inventory item permanently deleted.');
    }

    public function create()
    {
        return view('admin.inventory_items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'unit'          => 'required|string|max:50',
            'quantity'      => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'supplier'      => 'required|string|max:255',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('admin.inventory-items.index')
                         ->with('success', 'Inventory item created successfully.');
    }

    public function show($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('admin.inventory_items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('admin.inventory_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'unit'          => 'required|string|max:50',
            'quantity'      => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'supplier'      => 'required|string|max:255',
        ]);

        $item = InventoryItem::findOrFail($id);
        $item->update($validated);

        return redirect()->route('admin.inventory-items.index')
                         ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.inventory-items.index')
                         ->with('success', 'Inventory item moved to trash.');
    }

    // ✅ CSV Export for Inventory Items
    public function exportCsv(): StreamedResponse
    {
        $items = InventoryItem::withoutTrashed()->orderBy('created_at', 'desc')->get();
        $filename = 'inventory_items.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Item Name', 'Category', 'Unit', 'Quantity', 'Reorder Level', 'Unit Price', 'Supplier', 'Created At']);

            foreach ($items as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->category,
                    $item->unit,
                    $item->quantity,
                    $item->reorder_level,
                    $item->unit_price,
                    $item->supplier,
                    $item->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
