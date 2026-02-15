<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pianos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description');
            $table->string('short_description', 255)->nullable();
            $table->integer('year')->nullable();
            $table->string('condition')->default('good'); // excellent, very_good, good, fair, needs_restoration
            $table->string('finish')->nullable();
            $table->json('dimensions')->nullable(); // {width, height, depth, weight}
            $table->integer('sale_price')->nullable(); // cents
            $table->integer('original_price')->nullable(); // cents
            $table->integer('rental_price_monthly')->nullable(); // cents/month
            $table->integer('rental_deposit')->nullable(); // cents
            $table->integer('rental_minimum_months')->default(3);
            $table->string('type')->default('sale'); // sale, rental, both
            $table->string('status')->default('available'); // available, reserved, sold, rented, maintenance, retired
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_certified')->default(false);
            $table->json('features')->nullable();
            $table->json('includes')->nullable();
            $table->string('location')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('type');
            $table->index('brand_id');
            $table->index('category_id');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pianos');
    }
};
