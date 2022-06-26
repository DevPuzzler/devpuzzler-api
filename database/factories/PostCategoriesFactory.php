<?php

namespace Database\Factories;

use App\Models\PostCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PostCategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            PostCategories::COLUMN_NAME => $this->faker->colorName(),
            PostCategories::COLUMN_DESCRIPTION => $this->faker->realText()
        ];
    }
}
