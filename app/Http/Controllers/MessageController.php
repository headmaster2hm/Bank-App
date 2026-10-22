<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('messages.index', [
            'threads' => $user->messageThreads()
                ->with('latestMessage')
                ->orderByDesc('last_message_at')
                ->get(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function create()
    {
        return view('messages.create', [
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:120'],
            'category' => ['required', 'in:general,accounts,loans,cards,security,fraud'],
            'body' => ['required', 'string', 'min:10', 'max:4000'],
        ]);

        $thread = MessageThread::create([
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'category' => $data['category'],
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Message::create([
            'message_thread_id' => $thread->id,
            'sender_type' => 'customer',
            'body' => $data['body'],
            'sent_at' => now(),
        ]);

        return redirect()->route('messages.show', $thread)
            ->with('success', 'Your message was sent securely. We usually reply within one business day.');
    }

    public function show(MessageThread $thread)
    {
        $this->authorizeThread($thread);

        $thread->update(['status' => 'open']);

        return view('messages.show', [
            'thread' => $thread,
            'messages' => $thread->messages()->get(),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function reply(Request $request, MessageThread $thread)
    {
        $this->authorizeThread($thread);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:4000'],
        ]);

        Message::create([
            'message_thread_id' => $thread->id,
            'sender_type' => 'customer',
            'body' => $data['body'],
            'sent_at' => now(),
        ]);

        $thread->update([
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        return back()->with('success', 'Your reply was sent.');
    }

    private function authorizeThread(MessageThread $thread): void
    {
        abort_unless($thread->user_id === Auth::id(), 403);
    }
}
