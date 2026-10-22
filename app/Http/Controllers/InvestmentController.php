<?php

namespace App\Http\Controllers;

use App\Models\InvestmentHolding;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $holdings = $user->investmentHoldings()->get();

        $totalValue = (float) $holdings->sum(fn (InvestmentHolding $h) => $h->marketValue());
        $totalCost = (float) $holdings->sum(fn (InvestmentHolding $h) => $h->costBasis());

        return view('investments.index', [
            'holdings' => $holdings,
            'totalValue' => $totalValue,
            'totalCost' => $totalCost,
            'totalGain' => round($totalValue - $totalCost, 2),
            'totalGainPercent' => $totalCost > 0 ? round((($totalValue - $totalCost) / $totalCost) * 100, 2) : 0.0,
            'byClass' => $holdings->groupBy('asset_class')->map(
                fn ($group) => (float) $group->sum(fn (InvestmentHolding $h) => $h->marketValue())
            ),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function show(InvestmentHolding $holding)
    {
        abort_unless($holding->user_id === Auth::id(), 403);

        return view('investments.show', [
            'holding' => $holding,
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }
}
