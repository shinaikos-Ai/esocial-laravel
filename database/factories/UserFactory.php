<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'              => fake('pt_BR')->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'nr_insc'           => null,
            'role'              => 'operador',
        ];
    }

    /** Estado: usuário administrador. */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /** Estado: usuário com empresa vinculada. */
    public function withEmpresa(string $nrInsc): static
    {
        return $this->state(fn (array $attributes) => [
            'nr_insc' => preg_replace('/\D/', '', $nrInsc),
        ]);
    }

    /** Estado: e-mail não verificado. */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
