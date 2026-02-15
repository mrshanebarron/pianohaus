<?php

namespace App\Http\Controllers;

use App\Models\Piano;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        private CartService $cart
    ) {}

    public function index()
    {
        $items = collect($this->cart->items())->map(function ($item) {
            $piano = Piano::with(['brand', 'primaryPhoto'])->find($item['piano_id']);
            return array_merge($item, [
                'piano' => $piano,
                'formatted_price' => '$' . number_format($item['price'] / 100, 0),
            ]);
        })->filter(fn ($item) => $item['piano'] !== null);

        return view('storefront.cart', [
            'items' => $items,
            'subtotal' => $this->cart->formattedSubtotal(),
            'tax' => $this->cart->formattedTax(),
            'deliveryFee' => $this->cart->formattedDeliveryFee(),
            'total' => $this->cart->formattedTotal(),
            'isEmpty' => $this->cart->isEmpty(),
        ]);
    }

    public function add(Piano $piano)
    {
        try {
            $this->cart->add($piano);
            return redirect()->route('cart')->with('success', "{$piano->name} added to cart.");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(Piano $piano)
    {
        $this->cart->remove($piano->id);
        return redirect()->route('cart')->with('success', 'Item removed from cart.');
    }
}
