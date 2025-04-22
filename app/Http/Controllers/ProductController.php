<?php

namespace App\Http\Controllers;

use App\Models\Confectionery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function create($confectionery){

        try {

            $confectionery = Confectionery::findOrFail($confectionery);


            return Inertia::render("Confectionery/Product/RegisterProduct", [
                "nameConfectionery" => $confectionery["confectionery"]
            ]);

        } catch (ModelNotFoundException $e) {

            return redirect("/");
        }

    }
}
