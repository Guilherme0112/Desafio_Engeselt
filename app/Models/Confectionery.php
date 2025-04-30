<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Confectionery extends Model
{
    use HasFactory;
    
    // Dados que serão inseridos
    protected $fillable = [
        'confectionery',
        'phone',
        'latitude',
        'longitude',
        'cep',
        'city',
        'state',
        'neighborhood',
        'road',
        'number'
    ];

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

    }
}
