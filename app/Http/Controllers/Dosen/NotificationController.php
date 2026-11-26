<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'all');
        $query = $user->notifications();

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        return view('dosen.notifications.index', [
            'notifications' => $query->latest()->paginate(10)->withQueryString(),
            'unreadCount' => $user->notifications()->where('is_read', false)->count(),
            'totalCount' => $user->notifications()->count(),
            'currentFilter' => $filter,
        ]);
    }

    public function markAsRead(Notification $notification): RedirectResponse
    {
        Auth::user()->notifications()->findOrFail($notification->getKey())
            ->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi berhasil ditandai sebagai telah dibaca.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai telah dibaca.');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        Auth::user()->notifications()->findOrFail($notification->getKey())->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
