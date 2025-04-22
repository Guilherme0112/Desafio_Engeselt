<?php

namespace App\Models;

use DragonCode\Contracts\Cashier\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "price",
        "description",
        "images",
        "id_product"
    ];

    public function store(Request $request)
    {

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "description" => "nullable|string",
            "images" => "required|array",
            "images.*" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "id_product" => "required|integer|exists:products,id"
        ]);

        Product::create([
            "name" => $validated["name"],
            "price" => $validated["price"],
            "description" => $validated["description"],
            "images" => $validated["images"],
            "id_product" => $validated["id_product"]
        ]);
    }
}
