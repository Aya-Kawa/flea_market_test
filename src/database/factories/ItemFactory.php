<?php

namespace Database\Factories;

use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand_name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'condition_id' => Condition::factory(),
            'user_id' => User::factory(),

        ];
    }
}
