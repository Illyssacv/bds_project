<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class Users_Seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        User::create([
           'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'status' => 1,
            'role' => 'admin',
            'password' => Hash::make('123456'),
            'profile_picture' => null,
            'phone_number' => '0900000000',
            'email_verified_at' => now(),
        ]);
        //
        User::create([
              'name' => 'User',
                'email' => 'user@gmail.com',
                'status' => 1,
                'role' => 'user',
                'password' => Hash::make('123456'),
                'profile_picture' => null,
                'phone_number' => '0900000001',
                'email_verified_at' => now(),
        ]);
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'status' => 1,
                'role' => 'user',
                'password' => Hash::make('123456'),
                'profile_picture' => null,
                'phone_number' => $faker->phoneNumber(),
                'email_verified_at' => now(),
            ]);
        }
    }
}
