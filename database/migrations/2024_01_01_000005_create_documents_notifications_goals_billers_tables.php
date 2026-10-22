<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('document_type');
            $table->string('title');
            $table->string('period_label')->nullable();
            $table->date('document_date');
            $table->string('file_size_label')->nullable();
            $table->string('status')->default('available');
            $table->timestamps();

            $table->index(['user_id', 'document_type']);
        });

        Schema::create('bank_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->string('title');
            $table->text('body');
            $table->string('action_label')->nullable();
            $table->string('action_url')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
        });

        Schema::create('savings_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('purpose')->nullable();
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('target_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('billers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('account_reference')->nullable();
            $table->decimal('amount_due', 15, 2)->default(0);
            $table->date('due_date');
            $table->boolean('autopay')->default(false);
            $table->string('autopay_frequency')->nullable();
            $table->string('status')->default('due');
            $table->timestamps();
        });
    }
};
