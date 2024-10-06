<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'stock_quantity', 'category_id', 'p_image', 'file_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getFormattedCreatedAtAttribute() {
        return Carbon::parse($this->created_at)->format('M-d-Y h:i A');
    }

    public function getProductList(array $productIds)
    {
        // Fetch products with the given IDs
        return Product::whereIn('id', $productIds)
                    ->select('id', 'name', 'price', 'p_image', 'stock_quantity') // Select necessary fields
                    ->get()
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'quantity' => $product->stock_quantity, 
                            'price' => $product->price,
                            'image' => $product->p_image ?: 'default.webp'
                        ];
                    });
    }
}
