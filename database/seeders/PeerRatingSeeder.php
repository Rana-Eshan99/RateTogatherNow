<?php

namespace Database\Seeders;

use App\Models\Peer;
use App\Models\User;
use App\Models\PeerRating;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\PeerRatingStatusEnum;
use App\Enums\OrganizationStatusEnum;

class PeerRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = PeerRating::where('status', PeerRatingStatusEnum::APPROVED)->count();
        if ($count < 20) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'User');
            })->get();

            // Possible statuses
            $statuses = [
                PeerRatingStatusEnum::APPROVED,
                PeerRatingStatusEnum::NEED_APPROVAL,
                PeerRatingStatusEnum::REJECTED,
            ];

            $workAgain = [0, 1];
            $ratingValue = [1, 2, 3, 4, 5];

            foreach ($users as $user) {
                $peers = Peer::where('userId', $user->id)->where('status', PeerStatusEnum::APPROVED)->pluck('id');

                // Skip the current user if no approved peers are found
                if ($peers->isEmpty()) {
                    continue;
                }

                // Iterate to create up to 100 Peer Ratings
                for ($i = 0; $i < 10; $i++) {
                    $peerId = $peers[$i];
                    // Check if a peer rating already exists for this user and organization
                    $peerRating = PeerRating::where(['userId' => $user->id, 'peerId' => $peerId])->first();
                    if (!$peerRating) {
                        PeerRating::create([
                            'userId' => $user->id,
                            'organizationId' => $user->organizationId,
                            'peerId' => $peerId,
                            'easyWork' => $ratingValue[array_rand($ratingValue)],
                            'workAgain' => $workAgain[array_rand($workAgain)],
                            'dependableWork' => $ratingValue[array_rand($ratingValue)],
                            'communicateUnderPressure' => $ratingValue[array_rand($ratingValue)],
                            'meetDeadline' => $ratingValue[array_rand($ratingValue)],
                            'receivingFeedback' => $ratingValue[array_rand($ratingValue)],
                            'respectfullOther' => $ratingValue[array_rand($ratingValue)],
                            'assistOther' => $ratingValue[array_rand($ratingValue)],
                            'collaborateTeam' => $ratingValue[array_rand($ratingValue)],
                            'experience' => "This is a peer's experience. This is a peer's experience. This is a peer's experience.",
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
