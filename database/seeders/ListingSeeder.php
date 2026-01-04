<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get host user
        $host = User::firstOrCreate([
            'email' => 'host@example.com',
        ], [
            'name' => 'Host User',
            'password' => bcrypt('password'),
            'role' => 'host',
            'bio' => 'Professional host with excellent properties',
        ]);

        // Create sample listings
        $listings = [
            [
                'title' => 'Beautiful Beach Villa',
                'description' => 'A stunning beachfront villa with modern amenities and breathtaking ocean views. Perfect for families or groups.',
                'address' => 'House no. 123, Road no. 1',
                'city' => 'Miami Beach',
                'state' => 'Florida',
                'zip_code' => '33139',
                'country' => 'USA',
                'property_type' => 'villa',
                'guest_capacity' => 8,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'price_per_night' => 350,
                'amenities' => ['wifi', 'pool', 'kitchen', 'beach_access', 'parking'],
                'status' => 'published',
            ],
            [
                'title' => 'Cozy Downtown Apartment',
                'description' => 'Modern apartment in the heart of downtown with easy access to restaurants, shops, and entertainment.',
                'address' => 'House no. 456, Road no. 2',
                'city' => 'New York',
                'state' => 'New York',
                'zip_code' => '10001',
                'country' => 'USA',
                'property_type' => 'apartment',
                'guest_capacity' => 4,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'price_per_night' => 200,
                'amenities' => ['wifi', 'kitchen', 'gym', 'doorman', 'parking'],
                'status' => 'published',
            ],
            [
                'title' => 'Luxurious Mountain Cabin',
                'description' => 'Secluded mountain cabin with fireplace, hot tub, and panoramic mountain views. Ideal for a peaceful retreat.',
                'address' => 'House no. 789, Road no. 3',
                'city' => 'Aspen',
                'state' => 'Colorado',
                'zip_code' => '81611',
                'country' => 'USA',
                'property_type' => 'cabin',
                'guest_capacity' => 6,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'price_per_night' => 300,
                'amenities' => ['wifi', 'kitchen', 'fireplace', 'hot_tub', 'hiking'],
                'status' => 'published',
            ],
            [
                'title' => 'Historic Townhouse',
                'description' => 'Charming historic townhouse in a vibrant neighborhood with unique character and modern conveniences.',
                'address' => 'House no. 101, Road no. 4',
                'city' => 'Boston',
                'state' => 'Massachusetts',
                'zip_code' => '02101',
                'country' => 'USA',
                'property_type' => 'townhouse',
                'guest_capacity' => 5,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'price_per_night' => 250,
                'amenities' => ['wifi', 'kitchen', 'backyard', 'parking', 'heating'],
                'status' => 'published',
            ],
            [
                'title' => 'Sunny Garden Studio',
                'description' => 'Bright and airy studio apartment with a private garden. Perfect for couples or solo travelers.',
                'address' => 'House no. 202, Road no. 5',
                'city' => 'Los Angeles',
                'state' => 'California',
                'zip_code' => '90001',
                'country' => 'USA',
                'property_type' => 'studio',
                'guest_capacity' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'price_per_night' => 120,
                'amenities' => ['wifi', 'kitchen', 'garden', 'air_conditioning'],
                'status' => 'published',
            ],
            [
                'title' => 'Elegant Penthouse',
                'description' => 'Spectacular penthouse with 360-degree city views, rooftop access, and premium finishes throughout.',
                'address' => 'House no. 303, Road no. 6',
                'city' => 'San Francisco',
                'state' => 'California',
                'zip_code' => '94102',
                'country' => 'USA',
                'property_type' => 'penthouse',
                'guest_capacity' => 6,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'price_per_night' => 450,
                'amenities' => ['wifi', 'kitchen', 'rooftop_access', 'concierge', 'gym'],
                'status' => 'published',
            ],
        ];

        foreach ($listings as $listingData) {
            Listing::updateOrCreate(
                ['title' => $listingData['title']],
                array_merge($listingData, ['user_id' => $host->id])
            );
        }
    }
}
