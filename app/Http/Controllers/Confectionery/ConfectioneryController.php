<?php

namespace App\Http\Controllers\Confectionery;

use App\Http\Controllers\Controller;
use App\Models\Confectionery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfectioneryController extends Controller
{

    /** Método que renderiza a página de Marketplace
     * 
     */
    public function index()
    {
        return Inertia::render('Confectionery/Confectioneries');
    }

    /** Método que renderiza a página de registrar confeitaria
     * 
     */
    public function create()
    {
        return Inertia::render("Confectionery/RegisterConfectionery");
    }

    /** Método que salva os dados no banco de dados
     */
    public function store(Request $request)
    {
        // Configurações de validação
        $validated = $request->validate([
            'confectionery' => "required|string|max:50|min:3",
            'phone' => "required|string|size:11",
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'cep' => "required|string|size:8",
            'city' => "required|string|min:2|max:80",
            'state' => "required|string|min:2|max:80",
            'neighborhood' => "required|string|min:2|max:80",
            'road' => "required|string|min:2|max:80",
            'number' => "required|string|min:1|max:5"
        ]);

        // Salva o registro
        Confectionery::create([
            'confectionery' => $validated["confectionery"],
            'phone' => $validated["phone"],
            'latitude' => $validated["latitude"],
            'longitude' => $validated["longitude"],
            'cep' => $validated["cep"],
            'city' => $validated["city"],
            'state' => $validated["state"],
            'neighborhood' => $validated["neighborhood"],
            'road' => $validated["road"],
            'number' => $validated["number"],
        ]);

        // Retorna, caso tenha dado tudo certo
        return redirect()->route("confectionery.index")->with("sucess", "Confeitaria registrada com sucesso");

    }
}
