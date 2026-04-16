<?php

namespace Database\Seeders;


use App\Models\Peer;
use App\Models\User;
use App\Enums\GenderEnum;
use Faker\Factory as Faker;
use App\Enums\EthnicityEnum;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\OrganizationStatusEnum;

class PeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $count = Peer::count();
        if ($count < 20) {
            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)
                ->whereHas('departments') // Checks that the organization has at least one department
                ->with('departments') // Eager load the departments relationship
                ->get();
            $userRoleId = Role::where('name', 'User')->first()->id;
            $users = User::whereHas('roles', function ($query) use ($userRoleId) {
                $query->where('role_id', $userRoleId);
            })->get();

            $genderStatuses = [
                GenderEnum::MALE,
                GenderEnum::FEMALE,
                GenderEnum::OTHER,
            ];

            $ethnicityStatuses = [
                EthnicityEnum::WHITE,
                EthnicityEnum::BLACK,
                EthnicityEnum::HISPANIC_OR_LATINO,
                EthnicityEnum::MIDDLE_EASTERN,
                EthnicityEnum::AMERICAN_INDIAN_OR_ALASKA_NATIVE,
                EthnicityEnum::ASIAN,
                EthnicityEnum::NATIVE_HAWAIIAN_OR_OTHER_PACIFIC_ISLANDER,
                EthnicityEnum::OTHER,
            ];

            foreach ($users as $user) {
                // Iterate to create peers of every user on random count of organizations
                for ($i = 0; $i < 10; $i++) {
                    $randomOrganization = $organizations->random();
                    $randomDepartment = $randomOrganization->departments->random();
                    $firstName = $faker->firstName;
                    $lastName = $faker->lastName;
                    $fullName = $firstName . "_" . $lastName;

                    Peer::create([
                        'userId' => $user->id,
                        'organizationId' => $randomOrganization->id,
                        'departmentId' => $randomDepartment->id,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'gender' => $genderStatuses[array_rand($genderStatuses)],
                        'ethnicity' => $ethnicityStatuses[array_rand($ethnicityStatuses)],
                        'jobTitle' => $faker->jobTitle,
                        'image' => "upload/peer/" . $fullName . ".png",
                        'status' => PeerStatusEnum::APPROVED,
                    ]);
                }
            }
        } else {
            return;
        }
    }
}
