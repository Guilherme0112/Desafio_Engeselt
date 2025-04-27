<?php

namespace Tests\Feature;

use App\Models\Confectionery;
use App\Models\User;
use Tests\TestCase;

class ConfectioneryTest extends TestCase
{

    /** Testa o método save que serve tanto para salvar quanto para atualizar registros
     * no banco de dados
     */
    public function testSaveConfectionery()
    {
        // Cria um usuário
        $user = User::factory()->create();

        // Autentica o usuário no teste
        $this->actingAs($user);

        // Dados iniciais para a confeitaria
        $initialConfectioneryData = [
            'confectionery' => "Confeitaria Inicial",
            'phone' => "00000000000",
            'latitude' => '0.000000',
            'longitude' => '0.000000',
            'cep' => "58080150",
            'city' => "Cidade Inicial",
            'state' => "Estado Inicial",
            'neighborhood' => "Bairro Inicial",
            'road' => "Rua Inicial",
            'number' => "000",
        ];

        // Cria a confeitaria
        $response = $this->post(route('confectionery.store'), $initialConfectioneryData);

        // Verifica se a resposta é um redirecionamento (302)
        $response->assertStatus(302);
    }


    /** Testa o método que deleta a confeitaria do banco de dados
     */
    public function testeDeleteConfectionery()
    {
        // Cria um usuário
        $user = User::factory()->create();

        // Autentica o usuário no teste
        $this->actingAs($user);

        // Cria a confeitaria que será deletada
        $confectionery = Confectionery::factory()->create();

        // Faz a requisição DELETE para deletar a confeitaria
        $response = $this->delete(route('confectionery.destroy', $confectionery->id));

        // Verifica se a resposta é um redirecionamento (302)
        $response->assertStatus(302);

        // Verifica se a confeitaria foi realmente deletada do banco de dados
        $this->assertDatabaseMissing('confectioneries', ['id' => $confectionery->id]);
    }
}
