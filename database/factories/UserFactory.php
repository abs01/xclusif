<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [

            'name' => fake()->firstName(),

            'lastname' => fake()->lastName(),

            'dni' => fake()->unique()->regexify('[0-9]{8}[A-Z]'),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            'phone' => fake()->phoneNumber(),

            'password' => static::$password ??= Hash::make('password'),

            'status' => 'y',

            'tier_id' => fake()->numberBetween(1,3),

            'role_id'   => Role::where('name', 'usuari')->value('id'),

            'remember_token' => Str::random(10),

        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}