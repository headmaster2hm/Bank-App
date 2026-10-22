<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Support\BankingNavigation;
use App\Support\MarketingCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = trim($request->string('q')->toString());
        $results = [
            'features' => collect(),
            'accounts' => collect(),
            'transactions' => collect(),
            'help' => collect(),
        ];

        if ($query !== '' && mb_strlen($query) >= 2) {
            $needle = '%'.str_replace(['%', '_'], ['\%', '\_'], $query).'%';

            $results['features'] = collect(BankingNavigation::flat())
                ->filter(fn (array $item) => mb_stripos($item['label'], $query) !== false)
                ->take(6)
                ->values();

            $results['accounts'] = $user->accounts()
                ->where(fn ($q) => $q->where('account_name', 'like', $needle)
                    ->orWhere('account_type', 'like', $needle)
                    ->orWhere('account_number', 'like', $needle))
                ->get();

            $results['transactions'] = Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
                ->where(fn ($q) => $q->where('description', 'like', $needle)
                    ->orWhere('merchant', 'like', $needle)
                    ->orWhere('category', 'like', $needle)
                    ->orWhere('reference_number', 'like', $needle))
                ->with('account')
                ->latest()
                ->limit(12)
                ->get();

            $results['help'] = collect(MarketingCatalog::all())
                ->filter(fn (array $page) => mb_stripos($page['title'] ?? '', $query) !== false
                    || mb_stripos($page['lede'] ?? '', $query) !== false)
                ->take(6)
                ->values();
        }

        return view('search', [
            'query' => $query,
            'results' => $results,
            'total' => $results['features']->count()
                + $results['accounts']->count()
                + $results['transactions']->count()
                + $results['help']->count(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }
}
