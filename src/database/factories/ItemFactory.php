<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'price' => 1000,
            'description' => $this->faker->sentence(),
            'condition' => '良好',
            'image' => 'test.jpg',
        ];
    }
}