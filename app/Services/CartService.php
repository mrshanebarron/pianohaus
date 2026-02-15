<?php

namespace App\Services;

use App\Models\Piano;

class CartService
{
    public function add(Piano $piano): void
    {
        if (!$piano->canBePurchased()) {
            throw new \RuntimeException('This piano is not available for purchase.');
        }

        $cart = session('cart', []);
        $cart[$piano->id] = [
            'piano_id' => $piano->id,
            'name' => $piano->name,
            'price' => $piano->sale_price,
            'photo' => $piano->primary_photo_url,
            'brand' => $piano->brand->name,
            'sku' => $piano->sku,
        ];
        session(['cart' => $cart]);
    }

    public function remove(int $pianoId): void
    {
        $cart = session('cart', []);
        unset($cart[$pianoId]);
        session(['cart' => $cart]);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function items(): array
    {
        return session('cart', []);
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function subtotal(): int
    {
        return collect($this->items())->sum('price');
    }

    public function tax(): int
    {
        return (int) round($this->subtotal() * config('pianohaus.tax_rate'));
    }

    public function deliveryFee(): int
    {
        return $this->count() > 0 ? config('pianohaus.delivery.base_fee') : 0;
    }

    public function total(): int
    {
        return $this->subtotal() + $this->tax() + $this->deliveryFee();
    }

    public function formattedSubtotal(): string
    {
        return '$' . number_format($this->subtotal() / 100, 2);
    }

    public function formattedTax(): string
    {
        return '$' . number_format($this->tax() / 100, 2);
    }

    public function formattedDeliveryFee(): string
    {
        return '$' . number_format($this->deliveryFee() / 100, 2);
    }

    public function formattedTotal(): string
    {
        return '$' . number_format($this->total() / 100, 2);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function has(int $pianoId): bool
    {
        return isset(session('cart', [])[$pianoId]);
    }
}
