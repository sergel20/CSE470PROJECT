<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        // Ensure we have a host user
        $host = User::firstOrCreate(
            ['email' => 'host@example.com'],
            [
                'name' => 'Sample Host',
                'password' => bcrypt('password'),
                'role' => 'host',
            ]
        );

        $sample = [
            [
                'host_id' => $host->id,
                'title' => 'Cozy Downtown Apartment',
                'description' => 'A comfy apartment in the city center.',
                'price' => 85,
                'rating' => 4.5,
                'featured' => true,
                'photo' => null,
            ],
            [
                'host_id' => $host->id,
                'title' => 'Beachside Bungalow',
                'description' => 'Steps away from the beach.',
                'price' => 120,
                'rating' => 4.8,
                'featured' => true,
                'photo' => null,
            ],
            [
                'host_id' => $host->id,
                'title' => 'Mountain Cabin Retreat',
                'description' => 'Quiet cabin with scenic views.',
                'price' => 140,
                'rating' => 4.9,
                'featured' => false,
                'photo' => null,
            ],
        ];

        foreach ($sample as $item) {
            Property::create($item);
        }
    }
}
