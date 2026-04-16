<?php

namespace Database\Seeders;

use App\Enums\OrganizationRatingStatusEnum;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\OrganizationStatusEnum;
use App\Models\OrganizationRating;

class OrganizationRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = OrganizationRating::where('status', OrganizationRatingStatusEnum::APPROVED)->count();

        // Check if Organization Rating table Have record less than 20 then run the seeder.
        if ($count < 20) {
            $approvedOrganizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->pluck('id');
            $userRoleId = Role::where('name', 'User')->first()->id;
            $users = User::whereHas('roles', function ($query) use ($userRoleId) {
                $query->where('role_id', $userRoleId);
            })->pluck('id');

            // Possible statuses
            $statuses = [
                OrganizationRatingStatusEnum::APPROVED,
                OrganizationRatingStatusEnum::NEED_APPROVAL,
                OrganizationRatingStatusEnum::REJECTED,
            ];

            $ratingValue = [1, 2, 3, 4, 5];

            foreach ($users as $user) {
                // Iterate to create 10 Organization Ratings
                for ($i = 0; $i < 10; $i++) {
                    $organizationId = $approvedOrganizations[$i];
                    $organizationRating = OrganizationRating::where(['userId' => $user, 'organizationId' => $organizationId])->first();
                    if (!($organizationRating)) {
                        OrganizationRating::create([
                            'userId' => $user,
                            'organizationId' => $organizationId,
                            'employeeHappyness' => $ratingValue[array_rand($ratingValue)],
                            'companyCulture' => $ratingValue[array_rand($ratingValue)],
                            'careerDevelopment' => $ratingValue[array_rand($ratingValue)],
                            'workLifeBalance' => $ratingValue[array_rand($ratingValue)],
                            'compensationBenefit' => $ratingValue[array_rand($ratingValue)],
                            'jobStability' => $ratingValue[array_rand($ratingValue)],
                            'workplaceDEI' => $ratingValue[array_rand($ratingValue)],
                            'companyReputation' => $ratingValue[array_rand($ratingValue)],
                            'workplaceSS' => $ratingValue[array_rand($ratingValue)],
                            'growthFuturePlan' => $ratingValue[array_rand($ratingValue)],
                            'experience' => "This is a user's Organization rating experience. This is a user's Organization rating experience. This is a user's Organization rating experience. This is a user's Organization rating experience. ",
                            'status' => $statuses[array_rand($statuses)],
                        ]);
                    }
                }
            }
        } else {
            return;
        }
    }
}
