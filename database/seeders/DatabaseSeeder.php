<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategoryTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate(
        ['email' => 'user@app.com'],
        [
            'name' => 'Test User',
            'email' => 'user@app.com',
            'password' => Hash::make('12345678'),
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@app.com'],
            [
            'name' => 'Test User',
            'email' => 'admin@app.com',
            'password' => Hash::make('12345678'),
            // 'user_type' => User::USER_TYPE_ADMIN
        ]);

        $this->call([
            CategoryTypeSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
