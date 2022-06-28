<?php

namespace Database\Factories;

use App\Models\PostCategory;
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
            PostCategory::COLUMN_NAME => $this->faker->colorName(),
            PostCategory::COLUMN_DESCRIPTION => $this->faker->realText()
        ];
    }
}
