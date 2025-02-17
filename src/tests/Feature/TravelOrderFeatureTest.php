<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Interfaces\UserRepositoryInterface;
use Mockery;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\AuthService;
use App\Models\UserModel;
use App\Models\TravelOrderModel;

class TravelOrderFeatureTest extends TestCase
{
    public function test_create_travel_order_success()
    {
        // Cria um usuário de teste
        $user = UserModel::factory()->create();

        // Gerar um token JWT real para o usuário
        $token = JWTAuth::fromUser($user);

        // Dados da ordem de viagem
        $data = [
            "order_id" => 123,
            "applicant_name" => "Emerson",
            "destination" => "Casa Branca",
            "departure_date" => "2025-03-01",
            "return_date" => "2025-03-20",
            "status" => "requested"
        ];

        // Simular o envio de uma requisição para a criação da ordem de viagem
        $response = $this->postJson('/api/travel-order', $data, [
            'Authorization' => 'Bearer ' . $token // Passar o token no cabeçalho Authorization
        ]);

        // Verificar se a criação foi bem-sucedida
        $response->assertStatus(200); // Como o método no controller retorna um 200
        $response->assertJsonStructure([
            'data' => [
                'order_id',
                'applicant_name',
                'destination',
                'departure_date',
                'return_date',
                'status',
            ]
        ]); // Verifica a estrutura do retorno
    }

    public function test_create_travel_order_failed()
    {
        // Cria um usuário de teste
        $user = UserModel::factory()->create();

        // Gerar um token JWT real para o usuário
        $token = JWTAuth::fromUser($user);

        // Dados da ordem de viagem
        $data = [
            "order_id" => 123,
            "applicant_name" => "Emerson",
            "destination" => "Casa Branca",
            "departure_date" => "2025-03-01",
            "return_date" => "2025-03-20",
            "status" => "xxx"
        ];

        // Simular o envio de uma requisição para a criação da ordem de viagem
        $response = $this->postJson('/api/travel-order', $data, [
            'Authorization' => 'Bearer ' . $token // Passar o token no cabeçalho Authorization
        ]);

        // Verificar se a criação não foi bem-sucedida
        $response->assertStatus(400); // Como o método no controller retorna um 200
        $response->assertJson([
            'status' => "error"
        ]); // Verifica a estrutura do retorno
    }

    public function test_update_travel_order_success()
    {
        // Cria um usuário de teste
        $user = UserModel::factory()->create();

        // Cria uma ordem de teste
        $travelOrder = TravelOrderModel::factory()->withUser($user)->create(); // Associa ao usuário existente

        // Gerar um token JWT real para o usuário
        $token = JWTAuth::fromUser($user);

        // Dados da ordem de viagem
        $data = [
            "status" => "approved"
        ];

        // Simular o envio de uma requisição para a criação da ordem de viagem
        $response = $this->postJson(route('updateOrderStatus', ['id' => $travelOrder->id]), $data, [
            'Authorization' => 'Bearer ' . $token
        ]);

        // Verificar se a criação foi bem-sucedida
        $response->assertStatus(200);
    }

    public function test_update_travel_order_failed() {
        // Cria um usuário de teste
        $user = UserModel::factory()->create();

        // Cria uma ordem de teste
        $travelOrder = TravelOrderModel::factory()->withUser($user)->create(); // Associa ao usuário existente

        // Gerar um token JWT real para o usuário
        $token = JWTAuth::fromUser($user);

        // Dados da ordem de viagem
        $data = [
            "status" => "xxx"
        ];

        // Simular o envio de uma requisição para a criação da ordem de viagem
        $response = $this->postJson(route('updateOrderStatus', ['id' => $travelOrder->id]), $data, [
            'Authorization' => 'Bearer ' . $token
        ]);

        // Verificar se a criação não foi bem-sucedida
        $response->assertStatus(400);
    }
}
