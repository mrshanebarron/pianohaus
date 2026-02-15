<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rental_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // delivery, pickup, exchange, tuning
            $table->string('status')->default('pending'); // pending, scheduled, in_transit, completed, cancelled
            $table->date('scheduled_date')->nullable();
            $table->string('scheduled_time_slot')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('assigned_to')->nullable();
            $table->json('address');
            $table->text('notes')->nullable();
            $table->text('customer_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_tasks');
    }
};
