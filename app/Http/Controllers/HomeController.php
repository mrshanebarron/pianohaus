<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Piano;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Piano::with(['brand', 'category', 'primaryPhoto', 'approvedReviews'])
            ->published()->available()->featured()
            ->take(6)->get();

        $categories = Category::active()
            ->whereHas('pianos', fn ($q) => $q->available()->published())
            ->withCount(['pianos' => fn ($q) => $q->available()->published()])
            ->get();

        $brands = Brand::active()
            ->whereHas('pianos', fn ($q) => $q->available()->published())
            ->withCount(['pianos' => fn ($q) => $q->available()->published()])
            ->orderByDesc('pianos_count')
            ->take(8)->get();

        $reviews = Review::approved()
            ->with(['customer', 'piano'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(3)->get();

        $stats = [
            'pianos' => Piano::available()->published()->count(),
            'brands' => Brand::active()->count(),
            'reviews' => Review::approved()->count(),
        ];

        return view('storefront.home', compact('featured', 'categories', 'brands', 'reviews', 'stats'));
    }
}
