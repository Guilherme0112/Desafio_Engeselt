<?php

namespace App\Http\Controllers;

use App\Models\Confectionery;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    /** Método que retorna o GET de criar produtos
     *  @param confectionery Id da confeitaria que está registrando o produto
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

    /** Método que faz o registro das confeitarias no banco de dados
     * 
     * @param confectionery Id da confeitaria que está registrando o produto
     * @param request Dados recebidos do formulário
     * @throws ModelNotFoundException Quando não existe o registro ele redireciona o para a tela inicial
     */
    public function store(Request $request, $confectioneryId)
    {

        try {

            // Busca os dados da confeitaria, se não houver, ele lança uma exceção
            $confectionery = Confectionery::findOrFail($confectioneryId);

            // Inicializa a variavel para salvar as imagens
            $paths = [];

            // Adiciona a rota das imagens a array
            foreach ($request->file("images") as $image) {
                $paths[] = $image->store("products", "public");
            }

            // Valida os dados
            $validated = $request->validate([
                "product" => "required|string|max:255",
                "price" => "required|numeric|min:0",
                "description" => "nullable|string",
                "images" => "required|array|max:2",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            ]);

            // Caso passe na validação, o salva no banco de dados
            Product::create([
                'product' => $request->product,
                'price' => $request->price,
                'description' => $request->description,
                'images' => json_encode($paths),
                'id_confectionery' => $confectionery["id"],
            ]);

            // Redireciona para a página da confeitaria que onde foi registrado o produto
            return redirect()->route("confectionery.show", $confectionery["id"]);

        } catch (ModelNotFoundException $e) {

            return redirect("/");
        }
    }

    /**
     * Exibe detalhes do do produto selecionado
     * @param productId Id do produto
     * @param confectioneryId Id da confeitaria
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
}
