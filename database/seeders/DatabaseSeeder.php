<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test guest user
        User::updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Test Guest',
                'password' => bcrypt('password'),
                'role' => 'guest',
            ]
        );

        // Create a test host user
        User::updateOrCreate(
            ['email' => 'testhost@example.com'],
            [
                'name' => 'Test Host',
                'password' => bcrypt('password'),
                'role' => 'host',
            ]
        );

        // Seed sample listings for guest homepage
        $this->call(\Database\Seeders\ListingSeeder::class);
    }
}
