<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\SalePost;
use App\Models\User;

class Sales_Seed extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        $userIds = User::pluck('id')->toArray();
        for ($i = 0; $i < 30; $i++) {
            SalePost::create([
                'user_id' => $faker->randomElement($userIds),
                'title' => $faker->sentence(6, true),
                'description' => $faker->paragraphs(3, true),
                'price' => $faker->randomFloat(2, 500000000, 5000000000),
                'area' => $faker->randomFloat(2, 30, 500),
                'address' => $faker->address(),
                'bedrooms' => $faker->numberBetween(1, 5),
                'bathrooms' => $faker->numberBetween(1, 3),
                'is_furnished' => $faker->boolean(),
                'status' => $faker->numberBetween(0,2), // 80% chance of being true (available)
            ]);
            //
        }
    }
}
