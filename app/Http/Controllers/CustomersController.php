<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(Customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }

    public function getProducts()
    {
        $products = Product::limit(10)->get();
        return view("customer.products", compact("products"));
    }

    public function mergeGuestCart(Request $request) {
        $user = auth()->user();
        $guestCart = $request->input('guestCart'); // array of product IDs
    
        // Fetch user's existing cart from the database
        $userCart = $user->cartItems()->pluck('product_id')->toArray();
    
        // Merge guest cart with user's existing cart
        $mergedCart = array_unique(array_merge($guestCart, $userCart));
    
        // Update the user's cart in the database
        foreach ($mergedCart as $productId) {
            // Save each product in user's cart
            $user->cartItems()->updateOrCreate(
                ['product_id' => $productId],
                ['quantity' => 1] // Or merge quantities if you have that feature
            );
        }
    
        return response()->json(['success' => true]);
    }

    public function getCartProducts(Request $request)
    {
        $productIds = $request->input('productIDs');

        // Validate product IDs if necessary
        if (empty($productIds) || !is_array($productIds)) {
            return response()->json(['error' => 'Invalid product IDs'], 400);
        }

        // Get the product list from the model
        $products = (new Product)->getProductList($productIds);

        return response()->json(['products' => $products]);
    }
}
