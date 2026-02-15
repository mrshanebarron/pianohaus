<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->string('status')->default('pending'); // pending, confirmed, processing, ready_for_delivery, delivered, completed, cancelled, refunded
            $table->integer('subtotal'); // cents
            $table->integer('tax_amount')->default(0); // cents
            $table->integer('delivery_fee')->default(0); // cents
            $table->integer('discount_amount')->default(0); // cents
            $table->integer('total'); // cents
            $table->decimal('tax_rate', 5, 4)->default(0.0825);
            $table->json('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
