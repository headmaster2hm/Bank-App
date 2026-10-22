<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('to_account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('frequency');
            $table->date('next_run_date');
            $table->date('end_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });

        Schema::create('trusted_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_name');
            $table->string('device_type')->default('desktop');
            $table->string('location')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('trusted_at');
            $table->timestamps();
        });

        Schema::create('security_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('event_type');
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_name')->nullable();
            $table->boolean('is_suspicious')->default(false);
            $table->timestamp('occurred_at');
            $table->timestamps();
        });

        Schema::create('message_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->string('category')->default('general');
            $table->string('status')->default('open');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_thread_id')->constrained()->cascadeOnDelete();
            $table->string('sender_type');
            $table->text('body');
            $table->timestamp('sent_at');
            $table->timestamps();
        });

        Schema::create('investment_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('symbol');
            $table->string('name');
            $table->string('asset_class');
            $table->decimal('quantity', 20, 6);
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('market_price', 15, 2);
            $table->timestamps();
        });

        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->boolean('balances_visible_by_default')->default(true);
            $table->boolean('two_factor_enabled')->default(false);
            $table->boolean('login_alerts')->default(true);
            $table->boolean('payment_alerts')->default(true);
            $table->boolean('promotional_emails')->default(false);
            $table->boolean('paperless_statements')->default(true);
            $table->string('statement_format')->default('pdf');
            $table->string('time_zone')->default('UTC');
            $table->timestamps();
        });

        Schema::create('credit_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('score');
            $table->string('range_label');
            $table->unsignedSmallInteger('previous_score')->nullable();
            $table->unsignedSmallInteger('month_over_month_change')->nullable();
            $table->date('updated_at_date');
            $table->timestamps();
        });
    }
};
