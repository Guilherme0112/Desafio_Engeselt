<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConfectioneryService;
use App\Models\Confectionery;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ConfectioneryController extends Controller
{

    /** Método que renderiza a página de marketplace
     * Se não houver parametros ele retorna os dados sem filtro
     * Com o parametro query, ele retorna as confeitarias que tem o nome parecido
     * 
     * @param request Parametros recebidos da URL da requisição
     */
    public function index(Request $request)
    {
        // Verifica se existe um parâmetro de busca
        $query = $request->input('search');

        // Caso exista um parâmetro de busca, realiza a busca filtrando pelo nome ou descrição
        if ($query) {
            return Inertia::render('Confectionery/Confectioneries', [
                'confectioneries' =>  Confectionery::where('confectionery', 'like', "%{$query}%")
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate(10),
                'query' => $query
            ]);

        } 

        // Caso não haja busca, retorna todos os dados com paginação
        return Inertia::render('Confectionery/Confectioneries', [
            'confectioneries' =>  Confectionery::orderBy("created_at", 'desc')
                                                ->paginate(10),
            'query' => $query
        ]);        
    }


    /** Método que busca a confeitaria no banco de dados
     * 
     * @param id Id da confeitaria
     * 
     * @throws ModelNotFoundException Caso a confeitaria não exista
     */
    public function show($id)
    {
        try {

            $confectionery = Confectionery::findOrFail($id);
            $products = Product::where("id_confectionery", $id)->get();

            return Inertia::render("Confectionery/Confectionery", [
                "confectionery" => $confectionery,
                "products" => $products
            ]); 
            
        } catch (ModelNotFoundException $e) {

            return redirect('/');
        }
    }


    /** Método que valida e salva os dados no banco de dados
     * 
     * @param request Requisição vinda do frontend
     * @param confectioneryService Serviço da confeitaria (Principais métodos)
     * 
     * @throws ValidationException Erros de validação
     * @throws Exception Erro genérico
     */
    public function store(Request $request, ConfectioneryService $confectioneryService)
    {

        try {

            // Tenta salvar uma nova confeitaria
            $confectioneryService->save($request, null);

            // Retorna a view , caso tenha dado tudo certo
            return redirect()->route("confectionery.index")->with("succes", "Confeitaria registrada com sucesso");

        } catch (ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {

            return redirect("/");
        }
    }



    /** Método GET que busca os dados da cofeitaria para exibir para o usuário
     * 
     * @param confectioneryId Id da confeitaria passada na URL 
     * 
     * @return  // A view de editar caso os dados existam ou, a view de criar
     */
    public function edit($confectioneryId)
    {

        // Busca o valor no banco de dados
        $confectionery = Confectionery::find($confectioneryId);

        // Se existir ele retorna a view com os dados, se não ele retorna para o dashboard caso não exista
        return $confectionery ? Inertia::render("Confectionery/EditConfectionery", ["confectionery" => $confectionery]) : redirect()->route("confectionery.create");
    }



    /** Método que edita os dados e salva no banco de dados
     * 
     * @param request Requisição vinda do frontend
     * @param confectioneryId Id do registro da confeitaria
     * @param confectioneryService Serviço da confeitaria (Principais métodos)
     * 
     * @throws ValidationException Erros de validação
     * @throws Exception Erro genérico
     */
    public function update($confectioneryId, Request $request, ConfectioneryService $confectioneryService)
    {

        try {

            // Tenta atualizar os dadosda confeitaria
            $confectioneryService->save($request, $confectioneryId);

            return redirect()->route("confectionery.index")->with("succes", "Confeitaria atualizada com sucesso");

        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {

            return redirect("/");
        }
    }


    /** Método para deletar uma confeitaria
     * 
     * @param confectioneryId Id da confeitaria que será deletada
     * @param confectioneryService Serviço da confeitaria (Principais métodos)
     * 
     * @throws Exception Erro genérico
     */
    public function destroy($confectioneryId, ConfectioneryService $confectioneryService)
    {

        try {

            // Tenta fazer o delete da confeitaria com seus produtos
            $confectioneryService->delete($confectioneryId);

            return redirect()->route("confectionery.index")->with("succes", "Confeitaria deletada com sucesso");

        } catch (Exception $e) {

            return redirect("/");
        }

    }
}
