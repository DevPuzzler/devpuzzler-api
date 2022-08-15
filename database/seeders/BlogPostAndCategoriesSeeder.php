<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogPostTag;
use App\Models\PostCategory;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        $tags = Tag::factory(10)->create();

        BlogPost::all()->each(function (BlogPost $blogPost) use ($tags) {
            $blogPost->tags()->attach(
                $tags->random(2)
            );
        });
    }
}
