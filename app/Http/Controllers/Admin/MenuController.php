<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::withoutTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:menu_items,name',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item created!');
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:menu_items,name,' . $menu->id,
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated!');
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu item archived!');
    }

    public function trashed()
    {
        $trashed = MenuItem::onlyTrashed()->get();
        return view('admin.menu.trashed', compact('trashed'));
    }

    public function restore($id)
    {
        $menu = MenuItem::withTrashed()->findOrFail($id);
        $menu->restore();
        return redirect()->route('admin.menu.index')->with('success', 'Menu item restored!');
    }

    public function forceDelete($id)
    {
        $menu = MenuItem::withTrashed()->findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->forceDelete();
        return redirect()->route('admin.menu.trashed')->with('success', 'Menu item permanently deleted.');
    }

    public function exportCsv(): StreamedResponse
    {
        $menuItems = MenuItem::withoutTrashed()
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get();

        $filename = 'menu_items.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($menuItems) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Category', 'Price', 'Description']);

            foreach ($menuItems as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->category,
                    $item->price,
                    $item->description,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
