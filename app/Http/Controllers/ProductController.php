<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Confectionery;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProductController extends Controller
{

    /** Método que retorna o GET de criar produtos
     *  @param confectionery Id da confeitaria que está registrando o produto
     * 
     *  @throws ModelNotFoundException Quando não existe o registro ele redireciona o para a tela inicial
     */
    public function create($confectionery)
    {

        try {

            // Busca a confeitaria no banco de daods
            $confectionery = Confectionery::findOrFail($confectionery);

            // Renderiza a página com os dados da confeitaria que irá ter o produto registrado
            return Inertia::render("Product/RegisterProduct", [
                "confectionery" => [
                    "name" => $confectionery["confectionery"],
                    "id" => $confectionery["id"],
                ]
            ]);

        } catch (ModelNotFoundException $e) {

            return redirect("/");
        }
    }

    /** Método que faz o registro dos produtos no banco de dados
     * 
     * @param confectionery Id da confeitaria que está registrando o produto
     * @param request Dados recebidos do formulário
     * @param produtoService Serviço do produto
     * 
     * @throws ValidationException Erros de validação
     * @throws ModelNotFoundException Quando não existe o registro ele redireciona o para a tela inicial
     * @throws Exception Erro genérico
     */
    public function store(Request $request, $confectioneryId, ProductService $productService)
    {

        try {

            // Faz todo o tratamento e salva o produto
            $productService->save($request, $confectioneryId, null);

            // Redireciona para a página da confeitaria que onde foi registrado o produto
            return redirect()->route("confectionery.show", $confectioneryId);

        } catch (ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (ModelNotFoundException $e) {

            return redirect("/");

        } catch (Exception $e) {

            return redirect("/");
        }
    }

    /**
     * Exibe detalhes do do produto selecionado
     * @param productId Id do produto
     * @param confectioneryId Id da confeitaria
     * 
     * @throws ModelNotFoundException Quando não existe o registro ele redireciona para a pagina da confeitaria
     */
    public function show($confectioneryId, $productId)
    {

        try {

            // Busca a confeitaria e o produto pelos seus ids ou lança uma exceção
            // caso algum não exista no banco de dados
            $confectionery = Confectionery::findOrFail($confectioneryId);
            $product = Product::findOrFail($productId);


            // Renderiza a página com o nome da confeita e os dados do produto
            return Inertia::render("Product/Product", [
                "confectionery" => $confectionery,
                "product" => $product
            ]);

        } catch (ModelNotFoundException $e) {

            return redirect()->route("confectionery.index");
        }
    }

    /** Método que renderiza a tela de edição com os dados do
     * produto
     * 
     * @param productId Id do produto
     * 
     * @throws ModelNotFoundExcpetion Caso o produto não seja encontrado
     */
    public function edit($productId)
    {

        try {

            // Busca o produto que foi passado no parâmetro
            $product = Product::findOrFail($productId);

            // Renderiza a view com os dados do produto
            return Inertia::render("Product/EditProduct", [
                "product" => $product
            ]);

            // Caso o produto não for encotrado, ele redireciona
            // para a tela Home
        } catch (ModelNotFoundException $e) {

            return redirect("/");
        }
    }

    
    /** Método que atualiza os dados dos registro do produto
     * 
     * @param request Requisição vinda do frontend
     * @param productId Id do produto que será alterado
     * 
     * @throws ValidationException Erros de validação
     * @throws ModelNotFoundException Caso o produto não seja encontrado
     * @throws Exception Erro genérico
     */
    public function update(Request $request, $productId, ProductService $productService)
    {

        try {

            // Atualiza o registro do produto
            $updateProduct = $productService->save($request, null, $productId);

            // Redireciona para a página da confeitaria que onde foi registrado o produto
            return redirect()->route("confectionery.show", $updateProduct["id_confectionery"]);

        } catch (ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (ModelNotFoundException $e) {

            return redirect("/");

        } catch (Exception $e) {

            return redirect("/");
        }
    }

    /** Método que deleta as imagens e registro do produto
     * 
     * @param productId Id do produto que será excluído
     * @param productService Serviço do produto (Principais métodos)
     * 
     * @throws ModelNotFoundExcpetion Caso o produto não seja encontrado
     * @throws Exception Erro genérico
     */
    public function destroy($productId, ProductService $productService)
    {

        try {

            // Tenta fazer o delete do registro e das imagens do produto
            $productService->delete($productId);

            // Retorna para a página com a mensagem
            return redirect()->back()->with('success', 'Produto e imagens deletadas com sucesso.');

        } catch (ModelNotFoundException $e) {

            return redirect("/");

        } catch (Exception $e) {

            return redirect("/");
        }
    }
}
