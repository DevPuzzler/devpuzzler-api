<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            User::COLUMN_NAME => 'Test User',
            User::COLUMN_EMAIL => 'test@test.test',
         ]);

        $this->call(BlogPostAndCategoriesSeeder::class);
    }
}
