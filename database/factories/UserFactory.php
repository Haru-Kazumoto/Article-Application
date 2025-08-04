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
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname'         => $this->faker->name(),
            'password'         => Hash::make('password'), // default password
            'user_uid'         => Str::uuid(),
            'email'            => $this->faker->unique()->safeEmail(),
            'profile_picture'  => $this->faker->imageUrl(300, 300, 'people'),
            'is_creator'       => $this->faker->boolean(40),
            'join_at'          => now(),
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
}
