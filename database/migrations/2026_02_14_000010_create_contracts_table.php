<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->string('type'); // rental_agreement, purchase_agreement, rent_to_own
            $table->string('status')->default('draft'); // draft, sent, viewed, signed, expired, voided
            $table->longText('content');
            $table->string('pdf_path')->nullable();
            $table->longText('customer_signature')->nullable(); // base64 PNG
            $table->timestamp('customer_signed_at')->nullable();
            $table->string('customer_ip')->nullable();
            $table->longText('admin_signature')->nullable();
            $table->timestamp('admin_signed_at')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
