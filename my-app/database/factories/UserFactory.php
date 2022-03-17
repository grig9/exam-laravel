<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

            'image' => $this->faker->imageUrl($width=100, $height=100, 'cats'),
            'title' => $this->faker->company() . $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            
            'status' => $this->faker->numberBetween(0, 2),
            'is_admin' =>$this->faker->boolean(),

            'remember_token' => Str::random(10),
        ];
    }

    // 'vk' => $this->faker->vk(),
    //         'telegram' => $this->faker->telegram(),
    //         'instagram' => $this->faker->instagram(),

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
