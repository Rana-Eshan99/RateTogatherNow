<?php

namespace Database\Seeders;

use App\Models\ApplicationFeedback;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoleId = Role::where('name', 'User')->first()->id;
        $users = User::whereHas('roles', function ($query) use ($userRoleId) {
            $query->where('role_id', $userRoleId);
        })->limit(20)->pluck('id');

        $count = count($users);
        $feelings = ['BAD', 'SOME_WHAT', 'NEUTRAL', 'GOOD', 'GREAT'];
        $status = ['APPROVED', 'REJECTED', 'NEED_APPROVAL'];
        foreach ($users as $user) {

            ApplicationFeedback::create(
                [
                    'userId' => $user,
                    'feeling' => $feelings[rand(0, 4)],
                    'status' => $status[rand(0, 2)],
                    'feedback' => 'Application running smoothly.'
                ]
            );
        }
    }
}