<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('cards.index', [
            'cards' => $user->cards()->orderByRaw("CASE card_type WHEN 'credit' THEN 1 ELSE 2 END")->get(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function show(Card $card)
    {
        $this->authorizeCard($card);

        return view('cards.show', [
            'card' => $card->load('account'),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function toggleFrozen(Request $request, Card $card)
    {
        $this->authorizeCard($card);

        $card->update(['frozen' => ! $card->frozen]);

        return back()->with('success', $card->frozen
            ? $card->card_name . ' is now frozen. New purchases are blocked.'
            : $card->card_name . ' is now unfrozen.');
    }

    public function updateControls(Request $request, Card $card)
    {
        $this->authorizeCard($card);

        $data = $request->validate([
            'online_purchases' => ['nullable', 'boolean'],
            'international_purchases' => ['nullable', 'boolean'],
            'atm_withdrawals' => ['nullable', 'boolean'],
            'contactless' => ['nullable', 'boolean'],
        ]);

        $card->update([
            'online_purchases' => $request->boolean('online_purchases'),
            'international_purchases' => $request->boolean('international_purchases'),
            'atm_withdrawals' => $request->boolean('atm_withdrawals'),
            'contactless' => $request->boolean('contactless'),
        ]);

        return back()->with('success', 'Card controls updated.');
    }

    public function pin(Card $card)
    {
        $this->authorizeCard($card);

        return back()->with('success', 'PIN delivery is not connected in this prototype. No PIN has been sent or changed.');
    }

    private function authorizeCard(Card $card): void
    {
        abort_unless($card->user_id === Auth::id(), 403);
    }
}
