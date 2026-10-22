<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_number', 20)->unique();
            $table->string('account_type'); // checking, savings, credit
            $table->string('account_name');
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('available_balance', 15, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('active'); // active, frozen, closed
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
