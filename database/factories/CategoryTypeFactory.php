<?php

namespace Database\Factories;

use App\Models\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryType>
 */
class CategoryTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement([CategoryType::STATUS_ACTIVE, CategoryType::STATUS_INACTIVE]),
        ];
    }
}
