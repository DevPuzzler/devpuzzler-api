<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class BlogPostAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        PostCategory::factory(10)
            ->has(
                BlogPost::factory(10)
                    ->state( function($attrs, PostCategory $postCategories ) {
                        return [
                            BlogPost::COLUMN_CATEGORY_ID => $postCategories->getAttribute(PostCategory::COLUMN_ID)
                        ];
                }),
            PostCategory::RELATION_BLOG_POSTS
        )->create();
    }
}
