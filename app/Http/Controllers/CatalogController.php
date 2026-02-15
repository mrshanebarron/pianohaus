<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Piano;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Piano::with(['brand', 'category', 'primaryPhoto', 'approvedReviews'])
            ->published()->available();

        // Filters
        if ($request->filled('brand')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $request->brand));
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('type')) {
            if ($request->type === 'sale') {
                $query->forSale();
            } elseif ($request->type === 'rental') {
                $query->forRent();
            }
        }
        if ($request->filled('min_price')) {
            $query->where('sale_price', '>=', (int) $request->min_price * 100);
        }
        if ($request->filled('max_price')) {
            $query->where('sale_price', '<=', (int) $request->max_price * 100);
        }
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        $query = match ($sort) {
            'price_low' => $query->orderBy('sale_price'),
            'price_high' => $query->orderByDesc('sale_price'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('published_at'),
        };

        $pianos = $query->paginate(12)->withQueryString();

        $brands = Brand::active()
            ->whereHas('pianos', fn ($q) => $q->available()->published())
            ->withCount(['pianos' => fn ($q) => $q->available()->published()])
            ->orderBy('name')->get();

        $categories = Category::active()
            ->whereHas('pianos', fn ($q) => $q->available()->published())
            ->withCount(['pianos' => fn ($q) => $q->available()->published()])
            ->get();

        $conditions = config('pianohaus.inventory.conditions');

        $priceRange = [
            'min' => (int) ceil((Piano::published()->available()->min('sale_price') ?? 0) / 100),
            'max' => (int) ceil((Piano::published()->available()->max('sale_price') ?? 0) / 100),
        ];

        return view('storefront.catalog', compact('pianos', 'brands', 'categories', 'conditions', 'priceRange', 'sort'));
    }

    public function show(Piano $piano)
    {
        $piano->load(['brand', 'category', 'photos', 'approvedReviews.customer']);
        $piano->increment('views_count');

        $related = Piano::with(['brand', 'primaryPhoto', 'approvedReviews'])
            ->published()->available()
            ->where('id', '!=', $piano->id)
            ->where(function ($q) use ($piano) {
                $q->where('category_id', $piano->category_id)
                  ->orWhere('brand_id', $piano->brand_id);
            })
            ->take(4)->get();

        $rentalTerms = config('pianohaus.rental');

        return view('storefront.piano-detail', compact('piano', 'related', 'rentalTerms'));
    }

    public function sale(Request $request)
    {
        $request->merge(['type' => 'sale']);
        return $this->index($request);
    }

    public function rent(Request $request)
    {
        $request->merge(['type' => 'rental']);
        return $this->index($request);
    }
}
