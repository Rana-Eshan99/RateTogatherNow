<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Nette\Utils\Random;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\OrganizationStatusEnum;
use Faker\Factory as Faker;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $count = Organization::count();
        // Check the count of organization
        if ($count < 20) {
            $countries = Country::with('states')->get();
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'Admin');
            })->pluck('id');

            // Iterate to create 20 unique organizations
            for ($i = 0; $i < 20; $i++) {
                $randomCountry = $countries->random();
                $randomState = $randomCountry->states->random();

                Organization::create([
                    'userId' => $adminUsers->random(),
                    'country' => $faker->unique()->country,
                    'state' => $faker->unique()->state,
                    'name' => $faker->unique()->company,
                    'image' => "upload/organization/abc.png",
                    'city' => $faker->city,
                    'address' => $faker->address,
                    'status' => OrganizationStatusEnum::APPROVED,
                ]);
            }
        } else {
            return;
        }
    }
}
