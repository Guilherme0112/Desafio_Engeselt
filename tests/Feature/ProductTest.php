<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Confectionery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testSaveProduct()
{
    // Cria um usuário
    $user = User::factory()->create();

    // Autentica o usuário
    $this->actingAs($user);

    // Cria uma confeitaria
    $confectionery = Confectionery::factory()->create();
    
    // Cria o arquivo fake
    $image = UploadedFile::fake()->image('bolo.jpg');

    // Dados do produto
    $productData = [
        'product' => 'Bolo de Chocolate',
        'description' => 'Delicioso bolo de chocolate',
        'price' => 29.90,
        'images' => [$image],  // Coloque a imagem dentro de um array
        'id_confectionery' => $confectionery->id,
    ];

    // Faz a requisição para salvar o produto
    $response = $this->post(route('product.store', $confectionery->id), $productData);

    // Verifica se a resposta foi um redirecionamento (Status 302)
    $response->assertStatus(302);

    // Verifica se o produto foi salvo no banco de dados, mas sem comparar diretamente o campo 'images'
    $this->assertDatabaseHas('products', [
        'product' => 'Bolo de Chocolate',
        'price' => 29.90,
        'description' => 'Delicioso bolo de chocolate',
        'id_confectionery' => $confectionery->id,
    ]);

    // Verifica se o arquivo foi armazenado no diretório correto
    $storedImagePath = 'products/' . $image->hashName();
    Storage::disk('public')->assertExists($storedImagePath);

    // Também pode verificar se o caminho foi corretamente armazenado no campo 'images'
    $product = Product::where('product', 'Bolo de Chocolate')->first();
    $this->assertContains($storedImagePath, json_decode($product->images, true));  // Verifica se o caminho da imagem está no array de 'images'
}


    /** Método responsavel pelos testes de deletar produtos
     * 
     */
    public function testDeleteProduct()
    {
        // Cria um usuário
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user);

        // Cria uma confeitaria
        $confectionery = Confectionery::factory()->create();

        // Cria um produto
        $product = Product::factory()->create([
            'id_confectionery' => $confectionery->id,
        ]);

        // Faz a requisição para deletar o produto
        $response = $this->delete(route('product.destroy', $product->id));

        // Verifica se redirecionou
        $response->assertStatus(302);

        // Verifica se o produto foi removido do banco
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
