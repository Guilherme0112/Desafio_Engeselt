<?php

namespace App\Http\Services;

use App\Models\Confectionery;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductService
{

    /** Método que salva/atualiza registros de produtos do banco de dados
     * 
     * @param request Requisição vinda do frontend
     * @param confectioneryId Id da confetaria que terá o produto registrado (Caso ele não exista)
     * @param productId Id do produto que terá os dados atualizados (Caso exista)
     * 
     * @throws ValidationException Erros de validação
     * @throws Exception Erros genérico
     */
    public function save($request, $confectioneryId, $productId)
    {

        try {

            // Busca os dados da confeitaria
            $confectionery = Confectionery::find($confectioneryId);

            // Inicializa a variável para salvar os caminhos das imagens
            $paths = [];

            // Salva as novas imagens e adiciona o caminho à array
            if ($request->hasFile("images")) {
                foreach ($request->file("images") as $image) {
                    $paths[] = $image->store("products", "public");
                }
            }

            // Valida os dados
            $validated = $request->validate([
                "product" => "required|string|max:255",
                "price" => "required|numeric|min:0",
                "description" => "nullable|string",
                "images" => "required|array|max:2",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            ]);

            // Verifica se o produto já está registrado
            $product = Product::find($productId);
            if ($product) {

                // Se houver produto, deleta imagens antigas
                $imagesDatabase = json_decode($product->images);
                if ($imagesDatabase && is_array($imagesDatabase)) {

                    foreach ($imagesDatabase as $imgPath) {

                        if (Storage::disk('public')->exists($imgPath)) {
                            Storage::disk('public')->delete($imgPath);
                        }
                    }
                }

                // Atualiza o produto
                $product->update([
                    'product' => $request->product,
                    'price' => $request->price,
                    'description' => $request->description,
                    'images' => json_encode($paths),
                ]);

                return $product;
            }

            // Caso não exista, cria novo
            return Product::create([
                'product' => $request->product,
                'price' => $request->price,
                'description' => $request->description,
                'images' => json_encode($paths),
                'id_confectionery' => $confectionery->id,
            ]);
            
        } catch (ValidationException $e) {

            throw $e;
    
        } catch (Exception $e) {

            throw new \Exception("Erro ao criar/atualizar produto: " . $e->getMessage());
        }
    }

    /** Método que deleta o produto
     * 
     * @param productId Id do produto que será deletado
     * 
     * @throws ModelNotFoundException Erro caso o produto não exista
     * @throws Exception Erro genérico
     */
    public function delete($productId)
    {

        try {
            // Pega o id do produto
            $product = Product::findOrFail($productId);

            // Pega as imagens do produto
            $images = json_decode($product->images, true);

            // Deleta as imagens caso elas existam
            foreach ($images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            // Após deletar as imagens, deleta o registro do produto
            $product->delete();

        } catch (ModelNotFoundException $e) {

            throw new \Exception("O produto não existe", 404);

        } catch (Exception $e){

            throw new \Exception("Erro ao deletar o produto ou suas imagens: " . $e->getMessage());
        }
    }
}
