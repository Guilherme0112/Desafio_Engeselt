<?php

namespace App\Http\Controllers;

use App\Models\Confectionery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Método que retorna 
     */
    public function index()
    {

        $amountConfectioneries = Confectionery::count();

        return Inertia::render("Dashboard", [
            'amountConfectioneries' => $amountConfectioneries
        ]);
    }
}
