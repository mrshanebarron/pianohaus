<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Piano;
use Illuminate\Http\Request;

class PianoController extends Controller
{
    public function index(Request $request)
    {
        $query = Piano::with('brand', 'category', 'primaryPhoto');

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $pianos = $query->latest()->paginate(15);
        $brands = Brand::active()->orderBy('name')->get();
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.pianos.index', compact('pianos', 'brands', 'categories'));
    }

    public function create()
    {
        $brands = Brand::active()->orderBy('name')->get();
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.pianos.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'condition' => 'required|in:excellent,very_good,good,fair,needs_restoration',
            'finish' => 'nullable|string|max:255',
            'sale_price' => 'nullable|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'rental_price_monthly' => 'nullable|numeric|min:0',
            'rental_deposit' => 'nullable|numeric|min:0',
            'rental_minimum_months' => 'integer|min:1',
            'type' => 'required|in:sale,rental,both',
            'status' => 'required|in:available,reserved,maintenance,retired',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_certified' => 'boolean',
        ]);

        // Convert dollar amounts to cents
        foreach (['sale_price', 'original_price', 'rental_price_monthly', 'rental_deposit'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = (int) round($validated[$field] * 100);
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_certified'] = $request->boolean('is_certified');
        $validated['sku'] = Piano::generateSku($validated['name']);
        $validated['published_at'] = now();

        $piano = Piano::create($validated);

        return redirect()->route('admin.pianos.show', $piano)
            ->with('success', 'Piano created successfully.');
    }

    public function show(Piano $piano)
    {
        $piano->load('brand', 'category', 'photos', 'reviews.customer', 'orderItems.order', 'rentals.customer');
        return view('admin.pianos.show', compact('piano'));
    }

    public function edit(Piano $piano)
    {
        $brands = Brand::active()->orderBy('name')->get();
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.pianos.edit', compact('piano', 'brands', 'categories'));
    }

    public function update(Request $request, Piano $piano)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'condition' => 'required|in:excellent,very_good,good,fair,needs_restoration',
            'finish' => 'nullable|string|max:255',
            'sale_price' => 'nullable|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'rental_price_monthly' => 'nullable|numeric|min:0',
            'rental_deposit' => 'nullable|numeric|min:0',
            'rental_minimum_months' => 'integer|min:1',
            'type' => 'required|in:sale,rental,both',
            'status' => 'required|in:available,reserved,sold,rented,maintenance,retired',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_certified' => 'boolean',
        ]);

        foreach (['sale_price', 'original_price', 'rental_price_monthly', 'rental_deposit'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = (int) round($validated[$field] * 100);
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_certified'] = $request->boolean('is_certified');

        $piano->update($validated);

        return redirect()->route('admin.pianos.show', $piano)
            ->with('success', 'Piano updated successfully.');
    }

    public function destroy(Piano $piano)
    {
        $piano->delete();
        return redirect()->route('admin.pianos.index')
            ->with('success', 'Piano deleted successfully.');
    }
}
