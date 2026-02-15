<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContractSigningController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\RentalApplicationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public storefront
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pianos', [CatalogController::class, 'index'])->name('catalog');
Route::get('/pianos/{piano:slug}', [CatalogController::class, 'show'])->name('piano.show');
Route::get('/sale', [CatalogController::class, 'sale'])->name('catalog.sale');
Route::get('/rent', [CatalogController::class, 'rent'])->name('catalog.rent');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{piano}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{piano}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Rental Application
Route::get('/rent/{piano:slug}/apply', [RentalApplicationController::class, 'create'])->name('rental.apply');
Route::post('/rent/{piano:slug}/apply', [RentalApplicationController::class, 'store'])->name('rental.apply.store');
Route::get('/rent/confirmation/{rentalNumber}', [RentalApplicationController::class, 'confirmation'])->name('rental.confirmation');

// Reviews
Route::post('/pianos/{piano}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth routes
Route::middleware('auth')->group(function () {
    // Customer Portal
    Route::prefix('portal')->name('portal.')->group(function () {
        Route::get('/', [PortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [PortalController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [PortalController::class, 'orderDetail'])->name('orders.show');
        Route::get('/rentals', [PortalController::class, 'rentals'])->name('rentals');
        Route::get('/rentals/{rental}', [PortalController::class, 'rentalDetail'])->name('rentals.show');
        Route::get('/payments', [PortalController::class, 'payments'])->name('payments');
        Route::get('/documents', [PortalController::class, 'documents'])->name('documents');
        Route::get('/profile', [PortalController::class, 'profile'])->name('profile');
        Route::put('/profile', [PortalController::class, 'updateProfile'])->name('profile.update');
    });

    // Contract signing
    Route::get('/contracts/{contract}/sign', [ContractSigningController::class, 'show'])->name('contract.sign');
    Route::post('/contracts/{contract}/sign', [ContractSigningController::class, 'store'])->name('contract.sign.store');
});

// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pianos', Admin\PianoController::class);
    Route::post('pianos/{piano}/photos', [Admin\PianoPhotoController::class, 'store'])->name('pianos.photos.store');
    Route::delete('pianos/{piano}/photos/{photo}', [Admin\PianoPhotoController::class, 'destroy'])->name('pianos.photos.destroy');
    Route::resource('brands', Admin\BrandController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('customers', Admin\CustomerController::class)->only(['index', 'show']);
    Route::resource('orders', Admin\OrderController::class)->only(['index', 'show']);
    Route::post('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::resource('rentals', Admin\RentalController::class)->only(['index', 'show']);
    Route::post('rentals/{rental}/approve', [Admin\RentalController::class, 'approve'])->name('rentals.approve');
    Route::post('rentals/{rental}/deny', [Admin\RentalController::class, 'deny'])->name('rentals.deny');
    Route::resource('invoices', Admin\InvoiceController::class)->only(['index', 'show']);
    Route::get('invoices/{invoice}/pdf', [Admin\InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::post('orders/{order}/invoice', [Admin\OrderController::class, 'generateInvoice'])->name('orders.invoice');
    Route::resource('contracts', Admin\ContractController::class)->only(['index', 'show']);
    Route::get('contracts/{contract}/pdf', [Admin\ContractController::class, 'downloadPdf'])->name('contracts.pdf');
    Route::post('rentals/{rental}/contract', [Admin\RentalController::class, 'generateContract'])->name('rentals.contract');
    Route::get('reviews', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports');
});
