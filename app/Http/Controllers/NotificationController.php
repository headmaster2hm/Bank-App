<?php

namespace App\Http\Controllers;

use App\Models\BankNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->string('filter')->toString();

        $notifications = $user->bankNotifications()
            ->when($filter === 'unread', fn ($q) => $q->whereNull('read_at'))
            ->when($filter === 'read', fn ($q) => $q->whereNotNull('read_at'))
            ->recent()
            ->get();

        return view('notifications.index', [
            'notifications' => $notifications,
            'filter' => $filter,
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function readAll()
    {
        Auth::user()->bankNotifications()->unread()->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function read(BankNotification $notification)
    {
        $this->authorizeNotification($notification);

        if (! $notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        $target = $notification->action_url;

        return $target ? redirect($target) : back();
    }

    public function destroy(BankNotification $notification)
    {
        $this->authorizeNotification($notification);

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    private function authorizeNotification(BankNotification $notification): void
    {
        abort_unless($notification->user_id === Auth::id(), 403);
    }
}
