<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Biller;
use App\Models\Card;
use App\Models\Document;
use App\Models\InvestmentHolding;
use App\Models\Loan;
use App\Models\MessageThread;
use App\Models\SavingsGoal;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private function signIn(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    public function test_dashboard_renders_for_an_authenticated_customer(): void
    {
        $this->signIn();

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total net worth', false);
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_dashboard_never_shows_another_customers_balances(): void
    {
        $other = User::factory()->create();
        Account::factory()->create(['user_id' => $other->id, 'balance' => 987654.32]);

        $this->signIn();

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('987654.32');
    }

    public function test_every_authenticated_section_page_renders(): void
    {
        $user = $this->signIn();

        $account = Account::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create(['account_id' => $account->id]);
        $card = Card::factory()->create(['user_id' => $user->id, 'account_id' => $account->id]);
        $loan = Loan::factory()->create(['user_id' => $user->id]);
        $goal = SavingsGoal::factory()->create(['user_id' => $user->id]);
        $biller = Biller::factory()->create(['user_id' => $user->id, 'account_id' => $account->id]);
        $document = Document::factory()->create(['user_id' => $user->id]);

        $this->get(route('accounts.index'))->assertOk();
        $this->get(route('accounts.create'))->assertOk();
        $this->get(route('accounts.show', $account))->assertOk();
        $this->get(route('transactions.index'))->assertOk();
        $this->get(route('transactions.show', $transaction))->assertOk();
        $this->get(route('transfer'))->assertOk();
        $this->get(route('deposit'))->assertOk();
        $this->get(route('deposit.mobile'))->assertOk();
        $this->get(route('withdraw'))->assertOk();
        $this->get(route('cards.index'))->assertOk();
        $this->get(route('cards.show', $card))->assertOk();
        $this->get(route('loans.index'))->assertOk();
        $this->get(route('loans.show', $loan))->assertOk();
        $this->get(route('loans.payment', $loan))->assertOk();
        $this->get(route('loans.payoff', $loan))->assertOk();
        $this->get(route('goals.index'))->assertOk();
        $this->get(route('goals.create'))->assertOk();
        $this->get(route('goals.show', $goal))->assertOk();
        $this->get(route('billers.index'))->assertOk();
        $this->get(route('billers.create'))->assertOk();
        $this->get(route('billers.show', $biller))->assertOk();
        $this->get(route('billers.pay', $biller))->assertOk();
        $this->get(route('documents.index'))->assertOk();
        $this->get(route('documents.download', $document))->assertOk();
        $this->get(route('notifications.index'))->assertOk();
        $this->get(route('security.index'))->assertOk();
        $this->get(route('messages.index'))->assertOk();
        $this->get(route('messages.create'))->assertOk();
        $this->get(route('settings.index'))->assertOk();
        $this->get(route('search'))->assertOk();
        $this->get(route('search', ['q' => 'savings']))->assertOk();
        $this->get(route('investments.index'))->assertOk();
        $this->get(route('investments.show', InvestmentHolding::factory()->create([
            'user_id' => $user->id,
        ])))->assertOk();
    }

    public function test_every_authenticated_page_renders_against_the_real_seeder(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::where('email', 'demo@securebank.com')->firstOrFail();
        $this->actingAs($user);

        $card = $user->cards()->firstOrFail();
        $loan = $user->loans()->firstOrFail();
        $goal = $user->savingsGoals()->firstOrFail();
        $biller = $user->billers()->firstOrFail();
        $document = $user->documents()->firstOrFail();
        $holding = $user->investmentHoldings()->firstOrFail();
        $thread = MessageThread::where('user_id', $user->id)->firstOrFail();
        $transaction = Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
            ->firstOrFail();
        $account = $user->accounts()->firstOrFail();

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('accounts.index'))->assertOk();
        $this->get(route('accounts.show', $account))->assertOk();
        $this->get(route('transactions.index'))->assertOk();
        $this->get(route('transactions.show', $transaction))->assertOk();
        $this->get(route('transfer'))->assertOk();
        $this->get(route('deposit'))->assertOk();
        $this->get(route('deposit.mobile'))->assertOk();
        $this->get(route('withdraw'))->assertOk();
        $this->get(route('cards.index'))->assertOk();
        $this->get(route('cards.show', $card))->assertOk();
        $this->get(route('loans.index'))->assertOk();
        $this->get(route('loans.show', $loan))->assertOk();
        $this->get(route('loans.payment', $loan))->assertOk();
        $this->get(route('loans.payoff', $loan))->assertOk();
        $this->get(route('investments.index'))->assertOk();
        $this->get(route('investments.show', $holding))->assertOk();
        $this->get(route('goals.index'))->assertOk();
        $this->get(route('goals.create'))->assertOk();
        $this->get(route('goals.show', $goal))->assertOk();
        $this->get(route('billers.index'))->assertOk();
        $this->get(route('billers.create'))->assertOk();
        $this->get(route('billers.show', $biller))->assertOk();
        $this->get(route('billers.pay', $biller))->assertOk();
        $this->get(route('documents.index'))->assertOk();
        $this->get(route('documents.download', $document))->assertOk();
        $this->get(route('notifications.index'))->assertOk();
        $this->get(route('security.index'))->assertOk();
        $this->get(route('messages.index'))->assertOk();
        $this->get(route('messages.create'))->assertOk();
        $this->get(route('messages.show', $thread))->assertOk();
        $this->get(route('settings.index'))->assertOk();
        $this->get(route('search'))->assertOk();
        $this->get(route('search', ['q' => 'rent']))->assertOk();
    }

    public function test_a_customer_cannot_open_another_customers_record(): void
    {
        $this->signIn();

        $other = User::factory()->create();
        $card = Card::factory()->create(['user_id' => $other->id]);
        $loan = Loan::factory()->create(['user_id' => $other->id]);
        $goal = SavingsGoal::factory()->create(['user_id' => $other->id]);
        $biller = Biller::factory()->create(['user_id' => $other->id]);
        $document = Document::factory()->create(['user_id' => $other->id]);

        $this->get(route('cards.show', $card))->assertForbidden();
        $this->get(route('loans.show', $loan))->assertForbidden();
        $this->get(route('goals.show', $goal))->assertForbidden();
        $this->get(route('billers.show', $biller))->assertForbidden();
        $this->get(route('documents.download', $document))->assertForbidden();
    }

    public function test_toggling_a_card_freezes_and_unfreezes_it(): void
    {
        $user = $this->signIn();
        $card = Card::factory()->create(['user_id' => $user->id, 'frozen' => false]);

        $this->post(route('cards.toggleFrozen', $card))->assertRedirect();
        $this->assertTrue($card->fresh()->frozen);

        $this->post(route('cards.toggleFrozen', $card->fresh()));
        $this->assertFalse($card->fresh()->frozen);
    }

    public function test_card_controls_are_saved(): void
    {
        $user = $this->signIn();
        $card = Card::factory()->create(['user_id' => $user->id, 'international_purchases' => true]);

        $this->patch(route('cards.controls', $card), [
            'online_purchases' => '1',
            'contactless' => '1',
        ])->assertRedirect();

        $fresh = $card->fresh();
        $this->assertTrue($fresh->online_purchases);
        $this->assertTrue($fresh->contactless);
        $this->assertFalse($fresh->international_purchases);
    }

    public function test_loan_payment_moves_money_and_reduces_the_balance(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'account_type' => 'checking',
            'balance' => 1000,
            'available_balance' => 1000,
        ]);
        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'balance' => 5000,
            'status' => 'active',
        ]);

        $this->post(route('loans.payment', $loan), [
            'account_id' => $account->id,
            'amount' => 250,
        ])->assertRedirect(route('loans.show', $loan));

        $this->assertSame(750.0, (float) $account->fresh()->balance);
        $this->assertSame(4750.0, (float) $loan->fresh()->balance);
    }

    public function test_loan_payment_is_rejected_without_funds(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'account_type' => 'checking',
            'balance' => 10,
            'available_balance' => 10,
        ]);
        $loan = Loan::factory()->create(['user_id' => $user->id, 'balance' => 5000]);

        $this->post(route('loans.payment', $loan), ['account_id' => $account->id, 'amount' => 9999])
            ->assertSessionHas('error');

        $this->assertSame(10.0, (float) $account->fresh()->balance);
        $this->assertSame(5000.0, (float) $loan->fresh()->balance);
    }

    public function test_paying_a_bill_posts_a_transaction(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'account_type' => 'checking',
            'balance' => 900,
            'available_balance' => 900,
        ]);
        $biller = Biller::factory()->create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'amount_due' => 120,
            'status' => 'due',
        ]);

        $this->post(route('billers.pay', $biller), ['account_id' => $account->id, 'amount' => 120])
            ->assertRedirect(route('billers.index'));

        $this->assertSame(780.0, (float) $account->fresh()->balance);
        $this->assertSame('paid', $biller->fresh()->status);
        $this->assertDatabaseHas('transactions', ['account_id' => $account->id, 'amount' => 120]);
    }

    public function test_contributing_to_a_goal_updates_its_progress(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'account_type' => 'savings',
            'balance' => 500,
            'available_balance' => 500,
        ]);
        $goal = SavingsGoal::factory()->create([
            'user_id' => $user->id,
            'target_amount' => 1000,
            'current_amount' => 200,
            'status' => 'active',
        ]);

        $this->post(route('goals.contribute', $goal), ['account_id' => $account->id, 'amount' => 300])
            ->assertRedirect();

        $this->assertSame(500.0, (float) $goal->fresh()->current_amount);
    }

    public function test_marking_all_notifications_read(): void
    {
        $user = $this->signIn();
        $user->bankNotifications()->create([
            'category' => 'system',
            'title' => 'Test',
            'body' => 'Body',
        ]);

        $this->post(route('notifications.readAll'))->assertRedirect();

        $this->assertSame(0, $user->bankNotifications()->unread()->count());
    }

    public function test_search_finds_a_transaction_by_merchant(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create(['user_id' => $user->id]);
        Transaction::factory()->create([
            'account_id' => $account->id,
            'description' => 'Blue Bottle Coffee',
            'merchant' => 'Blue Bottle',
        ]);

        $this->get(route('search', ['q' => 'blue bottle']))
            ->assertOk()
            ->assertSee('Blue Bottle');
    }

    public function test_no_authenticated_page_contains_dead_placeholder_links(): void
    {
        $user = $this->signIn();
        $account = Account::factory()->create(['user_id' => $user->id]);
        $card = Card::factory()->create(['user_id' => $user->id, 'account_id' => $account->id]);

        $urls = [
            route('dashboard'),
            route('accounts.index'),
            route('cards.index'),
            route('cards.show', $card),
            route('security.index'),
            route('settings.index'),
            route('documents.index'),
            route('notifications.index'),
        ];

        foreach ($urls as $url) {
            $html = $this->get($url)->assertOk()->getContent();

            $this->assertStringNotContainsString('href="#"', $html, "Dead link found on {$url}");
        }
    }

    public function test_balance_privacy_toggle_script_is_present(): void
    {
        $this->signIn();

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('data-toggle-balances', false)
            ->assertSee('securebank.balancesVisible', false);
    }

    public function test_documents_are_marked_as_demo_content(): void
    {
        $user = $this->signIn();
        $document = Document::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('documents.download', $document))->assertOk();

        $this->assertStringContainsString('DEMONSTRATION DOCUMENT', (string) $response->getContent());
    }
}
