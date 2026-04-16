<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatusEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $count = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->count();

        if ($count < 5) {
            $userRole = Role::where('name', 'User')->first();

            // Iterate to create 5 unique users
            for ($i = 0; $i < 5; $i++) {
                $user = User::create([
                    'firstName' => $faker->firstName,
                    'lastName' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail, // safer for testing,
                    'password' => Hash::make('user1234'),
                    'jobTitle' => $faker->jobTitle,
                    'image' => "upload/profile/abc.png",
                    'status' => UserStatusEnum::ACTIVE,
                ]);

                // Assign the role to the user
                $user->assignRole($userRole);
            }

            // Create the last user (Muhammad Ali) only if they do not exist
            $user = User::firstOrCreate(
                ['email' => 'ali667@testing.com'], // Search for a user with this email
                [
                    'firstName' => "Muhammad",
                    'lastName' => "Ali",
                    'password' => Hash::make('TechSwivel#001'),
                    'jobTitle' => $faker->jobTitle,
                    'image' => "upload/profile/abc.png",
                    'status' => UserStatusEnum::ACTIVE,
                ]
            );

            // Assign the role to the user
            $user->assignRole($userRole);
        } else {
            return;
        }
    }
}
