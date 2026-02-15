<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('piano', 'customer');

        if ($request->filled('filter') && $request->filter === 'pending') {
            $query->where('is_approved', false);
        }

        $reviews = $query->latest()->paginate(15);
        $pendingCount = Review::where('is_approved', false)->count();

        return view('admin.reviews.index', compact('reviews', 'pendingCount'));
    }

    public function approve(Review $review)
    {
        $review->approve();
        return back()->with('success', 'Review approved.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
