<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class BankingNavigation
{
    /**
     * Primary navigation for the authenticated banking shell.
     *
     * Every entry must resolve to a registered named route, and `icon` must match
     * a symbol defined in the inline SVG sprite partial.
     *
     * @return array<int, array{label: string, items: array<int, array{label: string, route: string, icon: string, description?: string, badge?: string}>}>
     */
    public static function groups(): array
    {
        return [
            [
                'label' => 'Overview',
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'route' => 'dashboard',
                        'icon' => 'grid',
                        'description' => 'Balances, activity, and quick actions',
                    ],
                ],
            ],
            [
                'label' => 'Banking',
                'items' => [
                    [
                        'label' => 'Accounts',
                        'route' => 'accounts.index',
                        'icon' => 'building',
                        'description' => 'Balances, details, and statements',
                    ],
                    [
                        'label' => 'Transactions',
                        'route' => 'transactions.index',
                        'icon' => 'activity',
                        'description' => 'Search and review account activity',
                    ],
                    [
                        'label' => 'Transfers',
                        'route' => 'transfer',
                        'icon' => 'arrows',
                        'description' => 'Move money between your accounts',
                    ],
                    [
                        'label' => 'Pay a bill',
                        'route' => 'billers.index',
                        'icon' => 'receipt',
                        'description' => 'Pay billers and manage autopay',
                    ],
                ],
            ],
            [
                'label' => 'Cards & credit',
                'items' => [
                    [
                        'label' => 'Cards',
                        'route' => 'cards.index',
                        'icon' => 'card',
                        'description' => 'Card controls and spending limits',
                    ],
                    [
                        'label' => 'Loans',
                        'route' => 'loans.index',
                        'icon' => 'mortgage',
                        'description' => 'Loan balances and payment schedules',
                    ],
                ],
            ],
            [
                'label' => 'Wealth & planning',
                'items' => [
                    [
                        'label' => 'Investments',
                        'route' => 'investments.index',
                        'icon' => 'chart',
                        'description' => 'Holdings and performance',
                    ],
                    [
                        'label' => 'Savings goals',
                        'route' => 'goals.index',
                        'icon' => 'target',
                        'description' => 'Track progress toward your goals',
                    ],
                ],
            ],
            [
                'label' => 'Records & support',
                'items' => [
                    [
                        'label' => 'Documents',
                        'route' => 'documents.index',
                        'icon' => 'document',
                        'description' => 'Statements, tax forms, and notices',
                    ],
                    [
                        'label' => 'Messages',
                        'route' => 'messages.index',
                        'icon' => 'chat',
                        'description' => 'Secure conversations with our team',
                    ],
                ],
            ],
            [
                'label' => 'Account',
                'items' => [
                    [
                        'label' => 'Notifications',
                        'route' => 'notifications.index',
                        'icon' => 'bell',
                        'description' => 'Alerts and recent updates',
                    ],
                    [
                        'label' => 'Security',
                        'route' => 'security.index',
                        'icon' => 'shield',
                        'description' => 'Sign-in activity and protection',
                    ],
                    [
                        'label' => 'Settings',
                        'route' => 'settings.index',
                        'icon' => 'cog',
                        'description' => 'Profile, preferences, and statements',
                    ],
                ],
            ],
        ];
    }

    /**
     * Flattened list of every navigation item, for search and mobile menus.
     *
     * @return array<int, array{label: string, route: string, icon: string, description?: string, group: string}>
     */
    public static function flat(): array
    {
        $items = [];

        foreach (self::groups() as $group) {
            foreach ($group['items'] as $item) {
                $items[] = [...$item, 'group' => $group['label']];
            }
        }

        return $items;
    }

    /**
     * @return array<int, array{label: string, route: string, icon: string}>
     */
    public static function mobilePrimary(): array
    {
        return [
            ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'grid'],
            ['label' => 'Accounts', 'route' => 'accounts.index', 'icon' => 'building'],
            ['label' => 'Transfer', 'route' => 'transfer', 'icon' => 'arrows'],
            ['label' => 'Cards', 'route' => 'cards.index', 'icon' => 'card'],
        ];
    }

    public static function isCurrent(string $routeName): bool
    {
        return request()->routeIs($routeName);
    }

    public static function url(string $routeName): string
    {
        return Route::has($routeName) ? route($routeName) : url('/');
    }
}
