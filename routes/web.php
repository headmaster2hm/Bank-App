<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Support\MarketingCatalog;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Marketing content pages are registered at the very bottom of this file, after
// every application route, so real routes always take precedence.

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    Route::put('/accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
    Route::post('/accounts/{account}/freeze', [AccountController::class, 'freeze'])->name('accounts.freeze');
    Route::post('/accounts/{account}/unfreeze', [AccountController::class, 'unfreeze'])->name('accounts.unfreeze');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    // Transfers
    Route::match(['get', 'post'], '/transfer', [TransactionController::class, 'transfer'])->name('transfer');

    // Deposits
    Route::match(['get', 'post'], '/deposit', [TransactionController::class, 'deposit'])->name('deposit');

    // Withdrawals
    Route::match(['get', 'post'], '/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');

    // Deposits
    Route::get('/deposit/mobile', [TransactionController::class, 'mobileDeposit'])->name('deposit.mobile');
    Route::match(['get', 'post'], '/deposit', [TransactionController::class, 'deposit'])->name('deposit');

    // Cards
    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
    Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');
    Route::post('/cards/{card}/toggle-frozen', [CardController::class, 'toggleFrozen'])->name('cards.toggleFrozen');
    Route::patch('/cards/{card}/controls', [CardController::class, 'updateControls'])->name('cards.controls');
    Route::get('/cards/{card}/pin', [CardController::class, 'pin'])->name('cards.pin');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    Route::match(['get', 'post'], '/loans/{loan}/payment', [LoanController::class, 'payment'])->name('loans.payment');
    Route::get('/loans/{loan}/payoff', [LoanController::class, 'payoff'])->name('loans.payoff');

    // Investments
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/{holding}', [InvestmentController::class, 'show'])->name('investments.show');

    // Savings goals
    Route::get('/goals', [SavingsGoalController::class, 'index'])->name('goals.index');
    Route::get('/goals/create', [SavingsGoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [SavingsGoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{goal}', [SavingsGoalController::class, 'show'])->name('goals.show');
    Route::post('/goals/{goal}/contribute', [SavingsGoalController::class, 'contribute'])->name('goals.contribute');
    Route::post('/goals/{goal}/cancel', [SavingsGoalController::class, 'cancel'])->name('goals.cancel');

    // Bill pay
    Route::get('/billers', [BillerController::class, 'index'])->name('billers.index');
    Route::get('/billers/create', [BillerController::class, 'create'])->name('billers.create');
    Route::post('/billers', [BillerController::class, 'store'])->name('billers.store');
    Route::get('/billers/{biller}', [BillerController::class, 'show'])->name('billers.show');
    Route::match(['get', 'post'], '/billers/{biller}/pay', [BillerController::class, 'pay'])->name('billers.pay');
    Route::post('/billers/{biller}/autopay', [BillerController::class, 'toggleAutopay'])->name('billers.autopay');
    Route::post('/billers/{biller}/unpay', [BillerController::class, 'unpay'])->name('billers.unpay');
    Route::delete('/billers/{biller}', [BillerController::class, 'destroy'])->name('billers.destroy');

    // Documents and statements
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/download/{document}', [DocumentController::class, 'download'])->name('documents.download');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Security center
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::post('/security/two-factor', [SecurityController::class, 'toggleTwoFactor'])->name('security.twoFactor');
    Route::post('/security/password', [SecurityController::class, 'updatePassword'])->name('security.password');
    Route::post('/security/devices/{device}/revoke', [SecurityController::class, 'revokeDevice'])->name('security.devices.revoke');

    // Secure messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{thread}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{thread}/reply', [MessageController::class, 'reply'])->name('messages.reply');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');
    Route::patch('/settings/preferences', [SettingController::class, 'updatePreferences'])->name('settings.preferences');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
});

// Marketing content pages.
//
// Registered last so every application route takes precedence. The constraint is
// an alternation of every known slug, so an unknown URL still returns a 404
// instead of resolving to a marketing page.
Route::get('/{page}', [MarketingController::class, 'show'])
    ->where('page', MarketingCatalog::slugPattern())
    ->name('marketing.show');
