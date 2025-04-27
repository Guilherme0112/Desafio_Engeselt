<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{

    /** Renderiza a página home do site
     */
    public function index()
    {
        return Inertia::render('Home');
    }


    /** Método que busca as confeitarias quando o usuário permite pega a localização dele no navegador,
     * ele busca as confeitarias que estão mais próximas dele
     * 
     * @param request Requisição com a latitude e longitude
     */
    public function show(Request $request)
    {
        try {

            // Pega os valores vindo do front
            $latitude = $request->query('latitude');
            $longitude = $request->query('longitude');

            // Busca as confeitarias em um raio de 10kms
            $maxDistance = 10;

            // Faz a query que busca as confeitarias
            $confectioneries = DB::table('confectioneries')
                ->select('*')

                // Calcula a distância entre o usuário e cada confeitaria usando a fórmula de Haversine
                // e adiciona essa distância como um campo adicional chamado "distance"
                ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [
                    $latitude,
                    $longitude,
                    $latitude
                ])

                // Filtra apenas as confeitarias que estão dentro de um raio de 10km
                // usando novamente a fórmula de Haversine para o filtro
                ->whereRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?", [
                    $latitude,
                    $longitude,
                    $latitude,
                    $maxDistance
                ])

                // Ordena o resultado pela distância (mais perto primeiro)
                ->orderBy('distance')
                ->get();


            return response()->json($confectioneries);
            
        } catch (Exception $e) {

            return response()->json([
                'error' => 'Ocorreu um erro ao processar sua solicitação',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
