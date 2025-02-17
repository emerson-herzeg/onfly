<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use  App\Models\UserModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelOrderModel>
 */
class TravelOrderModelFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => fake()->numberBetween(1000, 9999), // Gere um order_id aleatório
            'user_id' => UserModel::factory(), // Associa a um usuário existente ou cria um novo
            'applicant_name' => fake()->name,
            'destination' => fake()->city,
            'departure_date' => fake()->date(),
            'return_date' => fake()->date(),
            'status' => fake()->randomElement(['requested', 'approved', 'canceled']), // Escolha um status aleatório
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withUser(UserModel $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
