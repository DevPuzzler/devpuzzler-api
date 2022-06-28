<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\PostCategories;
use Illuminate\Database\Seeder;

class BlogPostAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        PostCategories::factory(10)
            ->has(
                BlogPost::factory(10)
                    ->state( function( $attrs, PostCategories $postCategories ) {
                        return [
                            BlogPost::COLUMN_CATEGORY_ID => $postCategories->getAttribute(PostCategories::COLUMN_ID)
                        ];
                }),
            'blogPosts'
        )->create();
    }
}
