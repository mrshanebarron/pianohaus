<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('piano_id')->constrained()->cascadeOnDelete();
            $table->string('rental_number')->unique();
            $table->string('status')->default('pending_application'); // pending_application, approved, active, past_due, suspended, completed, cancelled, denied
            $table->integer('monthly_rate'); // cents
            $table->integer('deposit_amount'); // cents
            $table->boolean('deposit_paid')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('minimum_end_date')->nullable();
            $table->date('next_payment_date')->nullable();
            $table->json('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('return_condition')->nullable(); // excellent, very_good, good, fair, damaged
            $table->string('stripe_subscription_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->text('application_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
