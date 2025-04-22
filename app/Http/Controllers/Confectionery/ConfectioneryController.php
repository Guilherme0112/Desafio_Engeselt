<?php

namespace App\Http\Controllers\Confectionery;

use App\Http\Controllers\Controller;
use App\Models\Confectionery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ConfectioneryController extends Controller
{

    /** Método que renderiza a página de marketplace
     * Se não houver parametros ele retorna os dados sem filtro
     * Com o parametro query, ele retorna as confeitarias que tem o nome parecido
     * 
     */
    public function index(Request $request)
    {
        // Verifica se existe um parâmetro de busca
        $query = $request->input('query');

        if ($query) {
            // Caso exista um parâmetro de busca, realiza a busca filtrando pelo nome ou descrição
            $confectioneries = Confectionery::where('confectionery', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Caso não haja busca, retorna todos os dados com paginação
            $confectioneries = Confectionery::orderBy("created_at", 'desc')
                ->paginate(10);
        }

        // Retorna os dados para o Vue com Inertia
        return Inertia::render('Confectionery/Confectioneries', [
            'confectioneries' => $confectioneries,
            'query' => $query, // Passa a query para que o campo de busca possa ser preenchido corretamente no frontend
        ]);
    }


    /** Método que busca a confeitaria no banco de dados
     * @param id Id da confeitaria
     */
    public function show($id)
    {

        $confectionery = Confectionery::findOrFail($id);

        return Inertia::render("Confectionery/Confectionery", [
            "confectionery" => $confectionery
        ]);
    }


    /** Método que valida e salva os dados no banco de dados
     */
    public function store(Request $request)
    {

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

        // Salva o registro
        Confectionery::create($validated);

        // Retorna a view , caso tenha dado tudo certo
        return redirect()->route("dashboard.index")->with("succes", "Confeitaria registrada com sucesso");
    }



    /** Método GET que busca os dados da cofeitaria para exibir para o usuário
     * 
     * @param id Id da confeitaria passada na URL 
     * @return  // A view de editar caso os dados existam ou, o 
     */
    public function edit($id)
    {

        // Busca o valor no banco de dados
        $confectionery = Confectionery::find($id);

        // Se existir ele retorna a view com os dados, se não ele retorna para o dashboard caso não exista
        return $confectionery ? Inertia::render("Confectionery/EditConfectionery", ["confectionery" => $confectionery]) : redirect()->route("confectionery.create");
    }



    /** Método que edita os dados e salva no banco de dados
     * @param id Id do registro da confeitaria
     */
    public function update($id, Request $request)
    {
        // Pega o cep recebido, e faz a requisição
        $cep = $request->input("cep");
        $response = Http::withOptions(['verify' => false])->get("https://viacep.com.br/ws/{$cep}/json/");

        // Se der erro, ele retorna o erro para a view
        if ($response->failed() || isset($response->json()['erro'])) {
            throw ValidationException::withMessages([
                'cep' => 'O CEP informado é inválido',
            ]);
        }

        // Validar os dados passados do frontend

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

        // Substitui os dados de `validated` pelos valores obtidos da API
        $validated['road'] = $road;
        $validated['neighborhood'] = $neighborhood;
        $validated['city'] = $city;
        $validated['state'] = $state;

        // Atualiza o registro
        $confectionery = Confectionery::findOrFail($id);
        $confectionery->update($validated);

        return redirect()->route("confectionery.index")->with("succes", "Confeitaria atualizada com sucesso");
    }


    /** Método para deletar uma confeitaria
     * @param id Id da confeitaria que será deletada
     */
    public function destroy($id)
    {

        // deletar também os produtos

        $confectionery = Confectionery::findOrFail($id);
        $confectionery->delete();

        return redirect()->route("confectionery.index")->with("succes", "Confeitaria deletada com sucesso");
    }
}
