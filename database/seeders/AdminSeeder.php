<?php

namespace Database\Seeders;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if (!$adminRole) {
            $this->command->error('Admin role not found. Please ensure roles are seeded first.');
            return;
        }

        $adminUsers = [
            [
                'firstName' => 'Rate Together Now  Admin',
                'lastName'  => 'Admin',
                'email'     => 'admin@gmail.com',
                'password'  => 'admin1234',
            ],
        ];

        if (App::environment(['production'])) {
            $adminUsers[] = [
                'firstName' => 'Rate togather Now QA',
                'lastName'  => 'Admin',
                'email'     => 'abc@gmail.com',
                'password'  => 'admin1234',
            ];
        }

        foreach ($adminUsers as $adminUser) {
            $existingUser = User::where('email', $adminUser['email'])->first();

            if (!$existingUser) {
                $user = User::create([
                    'firstName' => $adminUser['firstName'],
                    'lastName'  => $adminUser['lastName'],
                    'email'     => $adminUser['email'],
                    'password'  => Hash::make($adminUser['password']),
                    'jobTitle'  => 'Admin',
                    'image'     => 'upload/profile/admin.png',
                    'status'    => UserStatusEnum::ACTIVE,
                ]);

                $user->assignRole($adminRole);
            }
        }
    }
}

