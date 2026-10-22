<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('card_type');
            $table->string('card_name');
            $table->string('card_brand')->default('SecureBank');
            $table->string('last_four', 4);
            $table->string('expiry_month', 2)->nullable();
            $table->string('expiry_year', 4)->nullable();
            $table->string('status')->default('active');
            $table->boolean('frozen')->default(false);
            $table->boolean('online_purchases')->default(true);
            $table->boolean('international_purchases')->default(false);
            $table->boolean('atm_withdrawals')->default(true);
            $table->boolean('contactless')->default(true);
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('minimum_payment', 15, 2)->nullable();
            $table->unsignedSmallInteger('payment_due_day')->nullable();
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('loan_type');
            $table->string('loan_name');
            $table->string('reference_number', 30)->unique();
            $table->decimal('original_amount', 15, 2);
            $table->decimal('balance', 15, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('next_payment_amount', 15, 2);
            $table->date('next_payment_date');
            $table->unsignedSmallInteger('term_months');
            $table->unsignedSmallInteger('payments_remaining')->default(0);
            $table->date('first_payment_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }
};
