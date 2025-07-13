<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryTransaction;
use App\Models\InventoryItem;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        $transactions = InventoryTransaction::latest()->with('item')->paginate(25);
        return view('admin.inventory_transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = InventoryItem::orderBy('name')->get();
        return view('admin.inventory_transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'type'              => 'required|in:restock,use,adjustment',
            'quantity'          => 'required|integer|min:1',
            'note'              => 'nullable|string|max:500',
        ]);

        $transaction = InventoryTransaction::create([
            'inventory_item_id' => $validated['inventory_item_id'],
            'type'              => $validated['type'],
            'quantity'          => $validated['quantity'],
            'note'              => $validated['note'],
            'transaction_date'  => now(),
        ]);

        $item = InventoryItem::findOrFail($validated['inventory_item_id']);

        match ($validated['type']) {
            'restock'    => $item->quantity += $validated['quantity'],
            'use'        => $item->quantity -= $validated['quantity'],
            'adjustment' => null,
        };

        $item->save();

        return redirect()->route('admin.inventory-transactions.index')
                         ->with('success', 'Transaction recorded successfully.');
    }

    public function show(string $id)
    {
        $transaction = InventoryTransaction::with('item')->findOrFail($id);
        return view('admin.inventory_transactions.show', compact('transaction'));
    }

    public function edit(string $id)
    {
        $transaction = InventoryTransaction::findOrFail($id);
        $items = InventoryItem::orderBy('name')->get();
        return view('admin.inventory_transactions.edit', compact('transaction', 'items'));
    }

    public function update(Request $request, string $id)
    {
        $transaction = InventoryTransaction::findOrFail($id);

        $validated = $request->validate([
            'type'     => 'required|in:restock,use,adjustment',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:500',
        ]);

        $transaction->update($validated);

        return redirect()->route('inventory-transactions.index')
                         ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(string $id)
    {
        $transaction = InventoryTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('inventory-transactions.index')
                         ->with('success', 'Transaction deleted.');
    }

    // ✅ CSV Export for Inventory Transactions
    public function exportCsv(): StreamedResponse
    {
        $transactions = InventoryTransaction::with('item')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $filename = 'inventory_transactions.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Item Name', 'Type', 'Quantity', 'Note', 'Date']);

            foreach ($transactions as $txn) {
                fputcsv($file, [
                    $txn->id,
                    optional($txn->item)->name,
                    ucfirst($txn->type),
                    $txn->quantity,
                    $txn->note,
                    $txn->transaction_date,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
