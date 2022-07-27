<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            BlogPost::COLUMN_TITLE => $this->faker->unique()->word(),
            BlogPost::COLUMN_EXCERPT => $this->faker->text(),
            BlogPost::COLUMN_CATEGORY_ID => PostCategory::
                all()
                ->random()
                ->getAttribute(PostCategory::COLUMN_ID),
            BlogPost::COLUMN_CONTENT => $this->faker->randomHtml(),
            BlogPost::COLUMN_IS_ACTIVE => $this->faker->boolean(),
            BlogPost::COLUMN_IS_RESTRICTED => $this->faker->boolean(30)
        ];
    }
}
