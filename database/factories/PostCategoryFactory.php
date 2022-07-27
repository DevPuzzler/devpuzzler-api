<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PostCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            PostCategory::COLUMN_NAME => $this->faker->unique()->colorName(),
            PostCategory::COLUMN_DESCRIPTION => $this->faker->realText()
        ];
    }
}
