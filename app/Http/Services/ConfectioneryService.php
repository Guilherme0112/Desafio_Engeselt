<?php

namespace App\Http\Services;

use App\Models\Confectionery;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ConfectioneryService
{

    /** Método que salva/atualiza os registros da confeitaria
     * @param request Requisição vinda do frontend
     * @param confectioneryId Id da confeitaria (Em caso de atualização)
     * 
     * @throws Exception Erro genérico
     */
    public function save($request, $confectioneryId)
    {

        try {

            // Pega o cep recebido, e faz a requisição
            $cep = $request->input("cep");

            $response = Http::withOptions(['verify' => false])->get("https://viacep.com.br/ws/{$cep}/json/");

            // Se der erro, ele retorna o erro para a view
            if ($response->failed() || isset($response->json()['erro'])) {
                throw ValidationException::withMessages([
                    'cep' => 'O CEP informado é inválido',
                ]);
            }

            // Se não der erro
            // Lê a resposta em JSON
            $data = $response->json();

            // Valores da resposta
            $logradouro = $data['logradouro'];
            $bairro = $data['bairro'];
            $localidade = $data['localidade'];
            $estado = $data['estado'];

            // Pega os valores do front
            $road = $request->input("road");
            $state = $request->input("state");
            $city = $request->input("city");
            $neighborhood = $request->input("neighborhood");


            // Validações
            // Ele subscreve a resposta do usuário pela resposta da API para
            // garantir que os dados não sejam manipulados
            $logradouro != "" ? $road = $logradouro : "";
            $bairro != "" ? $neighborhood = $bairro : "";
            $localidade != "" ? $city = $localidade : "";
            $estado != "" ? $state = $estado : "";

            // Se passar, ele valida o resto e salva (caso passe na validação)
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

            // Se houver registro da confeitaria, ele apenas atualiza os dados
            $confectionery = Confectionery::find($confectioneryId);
            if ($confectionery) {
                return $confectionery->update($validated);
            }

            // Senão, salva o registro
            return Confectionery::create($validated);
        } catch (ValidationException $e) {

            throw $e;
        } catch (Exception $e) {

            throw new \Exception("Erro ao criar/atualizar confeitaria: " . $e->getMessage());
        }
    }

    /** Método que deleta a confeitaria e seus produtos
     * @param confectioneryId Id da confeitaria qus erá deletada
     * 
     * @throws ModelNotFoundException Caso a confeitaria não exista
     * @throws Exception Erro genérico
     */
    public function delete($confectioneryId)
    {

        try {

            // Busca pela confeitaria
            $confectionery = Confectionery::findOrFail($confectioneryId);

            // Pega todos os produtos da confeitaria
            $products = Product::where('id_confectionery', $confectioneryId)->get();

            // Deleta as imagens associadas aos produtos
            foreach ($products as $product) {

                // Verifica se há imagens e decodifica o JSON
                if ($product->images) {
                    $images = json_decode($product->images, true);

                    // Se houver, deleta todas elas
                    if (is_array($images)) {
                        foreach ($images as $image) {
                            // Deleta cada imagem
                            Storage::disk('public')->delete($image);
                        }
                    }
                }
            }

            // Deleta todos os produtos da confeitaria
            Product::where('id_confectionery', $confectioneryId)->delete();

            // Deleta a confeitaria
            $confectionery->delete();
            
        } catch (ModelNotFoundException $e) {

            throw new \Exception("Não foi possível encontrar a confeitaria: " + $e->getMessage());
        } catch (Exception $e) {

            throw new \Exception("Não foi possível apagar a confeitaria: " + $e->getMessage());
        }
    }
}
