<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Tampilkan halaman pusat notifikasi mahasiswa.
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filter = $request->query('filter', 'all');

        $query = Notification::where('user_id', $userId);

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->latest()->paginate(10)->withQueryString();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        $totalCount = Notification::where('user_id', $userId)->count();

        return view('student.notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'totalCount' => $totalCount,
            'currentFilter' => $filter,
        ]);
    }

    /**
     * Tandai sebuah notifikasi telah dibaca.
     */
    public function markAsRead(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi berhasil ditandai sebagai telah dibaca.');
    }

    /**
     * Tandai semua notifikasi milik mahasiswa sebagai telah dibaca.
     */
    public function markAllAsRead(): RedirectResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai telah dibaca.');
    }

    /**
     * Hapus sebuah notifikasi.
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
