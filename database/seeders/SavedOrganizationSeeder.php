<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Saved;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\OrganizationStatusEnum;

class SavedOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Saved::whereNotNull('organizationId')->count();
        if ($count < 20) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'User');
            })->pluck('id');

            $approvedOrganizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->pluck('id');

            foreach ($users as $user) {
                for ($i = 0; $i < 10; $i++) {
                    $organizationId = $approvedOrganizations[$i];
                    $savedPeer = Saved::where(['organizationId' => $organizationId, 'userId' => $user])->first();
                    if (!($savedPeer)) {
                        Saved::create([
                            'userId' => $user,
                            'organizationId' => $organizationId,
                        ]);
                    }
                }
            }
        } else {
            return;
        }
    }
}
