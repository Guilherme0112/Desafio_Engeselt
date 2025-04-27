<?php

namespace App\Models;

use DragonCode\Contracts\Cashier\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "product",
        "price",
        "description",
        "images",
        "id_confectionery"
    ];

    public function store(Request $request)
    {

        $validated = $request->validate([
            "product" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "description" => "nullable|string",
            "images" => "required|array|max:2",
            "images.*" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "id_confectionery" => "required|integer|exists:confectionery,id"
        ]);

        Product::create([
            "product" => $validated["name"],
            "price" => $validated["price"],
            "description" => $validated["description"],
            "images" => $validated["images"],
            "id_confectionery" => $validated["id_confectionery"]
        ]);
    }
}
