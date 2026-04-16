<?php

namespace Database\Seeders;

use App\Enums\OrganizationStatusEnum;
use App\Models\User;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizationIds = Organization::all()->pluck('id')->toArray();
        $departmentNames = [
            'Accounting',
            'Advertising',
            'Analytics',
            'Audit',
            'Brand Management',
            'Business Development',
        ];

        $departmentCount = count($departmentNames);

        foreach ($organizationIds as $organizationId) {
            // Randomly select a number of departments between 3 and the total count
            $randomCount = rand(3, $departmentCount);
            $randomDepartments = array_rand(array_flip($departmentNames), $randomCount);

            foreach ($randomDepartments as $departmentName) {
                if (Department::where('organizationId', $organizationId)->where('name', $departmentName)->exists()) {
                    continue; // Skip this department
                }
                Department::create([
                    'organizationId' => $organizationId,
                    'name' => $departmentName,
                ]);
            }
        }

        $approvedOrganization = Organization::where('status', OrganizationStatusEnum::APPROVED)->get();

        // Get users with null organizationId and departmentId
        $users = User::whereNull('organizationId')->whereNull('departmentId')->get();
        foreach ($users as $user) {
            $randomApprovedOrganization = $approvedOrganization->random();
            $randomDepartment = $randomApprovedOrganization->departments->random();
            $user->update([
                'organizationId' => $randomApprovedOrganization->id,
                'departmentId' => $randomDepartment->id,
            ]);
        }
    }
}
