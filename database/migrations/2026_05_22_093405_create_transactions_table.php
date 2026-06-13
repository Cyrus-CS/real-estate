<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 60)->unique()->comment('Public-facing transaction ID e.g. TXN-2025-00042');
            $table->foreignId('property_id')
                ->constrained('properties')
                ->restrictOnDelete();
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('agent_id')
                ->constrained('agents')
                ->restrictOnDelete();
            $table->foreignId('rent_id')
                ->nullable()
                ->constrained('rents')
                ->nullOnDelete();
            $table->enum('transaction_type', ['rent', 'sale'])->index();
            $table->enum('status', [
                'pending',
                'completed',
                'cancelled',
                'refunded',
            ])->default('pending')->index();
            $table->unsignedBigInteger('amount_cents')->comment('Amount in cents');
            $table->string('currency', 3)->default('USD');
            $table->unsignedBigInteger('commission_cents')->nullable()->comment('Agent commission in cents');
            $table->string('payment_method', 60)->nullable()->comment('e.g. bank_transfer, stripe, paypal');
            $table->string('payment_reference', 150)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};