<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\CustomerCart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/u/cart', [CustomersController::class,"getCartProducts"]);

// Route::get('/test', function () {
//     return view('test');
// });

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get("/products/lists", [ProductController::class, "showProducts"])->name('products.list');

    Route::get('/inventory', [ProductController::class, "test"])->name('inventory');
    Route::get('/products', [ProductController::class, "index"])->name('products'); // Admin product list
    Route::post('/products', [ProductController::class, "store"])->name('products_save'); // Admin add product
    Route::post('/products/{id}', [ProductController::class, "update"])->name('products_update'); // Admin update product
});

// Guest and Authenticated User Routes
Route::group([], function () {
    // Public product browsing
    Route::get('/u/products', [CustomersController::class, "getProducts"])->name('products.browse'); // Guest access to products
    // Route::get('/u/products/{id}', [ProductController::class, "show"])->name('products.show'); // Show individual product details

    // Cart functionality
    Route::prefix('u/cart')->group(function () {
        Route::get('/', [CustomerCart::class, 'index'])->name('cart.index'); // View cart (guest and authenticated)
        // Route::post('/add', [CartController::class, 'add'])->name('cart.add'); // Add item to cart
        // Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove'); // Remove item from cart
    });

    // Checkout route requiring authentication
    Route::get('/checkout', function () {
        return view('checkout'); // Show checkout page
    })->middleware('auth')->name('checkout'); // Requires authentication
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';
