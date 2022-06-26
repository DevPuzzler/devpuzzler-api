<?php

namespace Database\Seeders;

use App\Models\PostCategories;
use Illuminate\Database\Seeder;

class PostCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategories::factory()->count(5)->create();
    }
}
