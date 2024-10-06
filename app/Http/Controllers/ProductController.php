<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function index(){
        $pcategory = Category::all();
        return view('products', compact("pcategory"));
    }
    public function store(Request $request){
        $data = $request->validate([
            'pname' => ['required', 'min:3', 'max:255'],
            'price' => ['required', 'numeric'],
            'pcategory' => ['required'],
            // 'pimage' => ['required', 'image', 'mimes:jpeg,png,jpg']
        ], [
            'pname.required' => 'The product name is required.',
            'pname.min' => 'The product name must be at least 3 characters.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'pcategory.required' => 'The category is required.',
            // 'pimage.required' => 'An image is required.',
            // 'pimage.image' => 'The file must be an image.',
            // 'pimage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
        ]);

        // Create a new product instance
        $product = new Product();
        $product->name = $data['pname'];
        $product->price = $data['price'];
        $product->category_id = $data['pcategory'];
        
        // Optionally handle description and stock_quantity if they are part of your form
        if ($request->has('pdescription')) {
            $product->description = $request->input('pdescription');
        }

        // if ($request->has('stock_quantity')) {
        //     $product->stock_quantity = $request->input('stock_quantity');
        // }

        // Handle the optional image upload
        if ($request->hasFile('pimage')) {
            $image = $request->file('pimage');
            $imagePath = $image->store('products', 'public'); // Store the image in public/products directory
            $product->p_image = $imagePath; // Save the image path in the p_image column
        }

        // Save the product to the database
        $product->save();

        // Redirect or respond as needed
        // return redirect()->route('products.index')->with('success', 'Product created successfully.');
        return response()->json(['code' => 200, 'message' => 'Product created successfully.']);
    }

    public function update(Request $request, $id) {

        // Validate the request data
        $data = $request->validate([
            'pname' => ['required', 'min:3', 'max:255'],
            'price' => ['required', 'numeric'],
            'pcategory' => ['required'],
            // 'pimage' => ['sometimes', 'image', 'mimes:jpeg,png,jpg'] // Image is optional
        ], [
            'pname.required' => 'The product name is required.',
            'pname.min' => 'The product name must be at least 3 characters.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'pcategory.required' => 'The category is required.',
            // 'pimage.image' => 'The file must be an image.',
            // 'pimage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
        ]);
    
        // Find the existing product by ID
        $product = Product::findOrFail($id); // This will throw a 404 if the product is not found
    
        // Update product details
        $product->name = $data['pname'];
        $product->price = $data['price'];
        $product->category_id = $data['pcategory'];
    
        // Optionally handle description and stock_quantity
        if ($request->has('pdescription')) {
            $product->description = $request->input('pdescription');
        }

        // Handle optional image upload
        if ($request->hasFile('pimage')) {
            $image = $request->file('pimage');
            // $imagePath = $image->store('products', 'public'); // Store the image in public/products directory
            // $product->p_image = $imagePath; // Update the image path in the p_image column

            // Create a unique filename for the image
            $filename = uniqid() . '.' . $image->getClientOriginalExtension(); 

            // Resize the image
            // $resizedImage = Image::make($image)
            //     ->fit(300, 300) // Adjust size as needed (300x300 in this example)
            //     ->save(storage_path('app/public/products/' . $filename)); // Save in the public/products directory
             // Resize the image without cropping
            $resizedImage = Image::make($image)
            ->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
                $constraint->upsize(); // Prevent upsizing if the image is smaller
            })
            ->save(storage_path('app/public/products/' . $filename));

            // Update the image path in the p_image column
            $product->p_image = 'products/' . $filename; // Store the path in a format that can be accessed publicly
        }
    
        // Save the updated product
        $product->save();
    
        // Redirect or respond as needed
        return response()->json(['code' => 200, 'message' => 'Product updated successfully.']);
    }
    

    public function test(){
        return "inventory test";
    }

    public function showProducts(Request $request){

        return DataTables::of(Product::with("category")->latest()->get())->make(true);
    }
    public function productList()
    {
        
    }
}
