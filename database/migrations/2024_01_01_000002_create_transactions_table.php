<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('related_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->string('type'); // deposit, withdrawal, transfer_in, transfer_out, payment, fee
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('description');
            $table->string('reference_number', 30)->unique();
            $table->string('status')->default('completed'); // pending, completed, failed
            $table->string('category')->nullable(); // grocery, dining, travel, etc.
            $table->string('merchant')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
