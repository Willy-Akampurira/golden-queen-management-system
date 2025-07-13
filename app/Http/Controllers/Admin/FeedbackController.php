<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['user', 'order.menuItem'])->latest()->paginate(10);
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['user', 'order.menuItem']);
        return view('admin.feedbacks.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()
            ->route('admin.feedbacks.index')
            ->with('success', '🗑️ Feedback deleted successfully.');
    }

    public function reply(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $feedback->update([
            'admin_reply' => $validated['admin_reply'],
        ]);

        return redirect()
            ->route('admin.feedbacks.show', $feedback)
            ->with('success', '✅ Reply posted successfully.');
    }

    // ✅ Robust CSV Export for Feedback
    public function exportCsv(): StreamedResponse
    {
        $feedbacks = Feedback::with(['user', 'order.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'feedbacks.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($feedbacks) {
            $file = fopen('php://output', 'w');

            if ($file === false) {
                echo 'Unable to open output stream.';
                return;
            }

            fputcsv($file, ['ID', 'Customer', 'Meal', 'Rating', 'Comment', 'Reply', 'Status', 'Submitted']);

            foreach ($feedbacks as $fb) {
                fputcsv($file, [
                    $fb->id,
                    $fb->user?->name ?? $fb->name ?? 'Anonymous',
                    optional($fb->order?->menuItem)->name ?? '—',
                    $fb->rating,
                    $fb->comment,
                    $fb->admin_reply ?? '—',
                    $fb->admin_reply ? '✅ Replied' : '⏳ Pending',
                    $fb->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
