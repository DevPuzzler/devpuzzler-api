<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            User::COLUMN_NAME => 'Test User',
            User::COLUMN_EMAIL => 'test@test.test',
         ]);
    }
}
