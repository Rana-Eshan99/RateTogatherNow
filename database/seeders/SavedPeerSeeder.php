<?php

namespace Database\Seeders;

use App\Models\Peer;
use App\Models\User;
use App\Models\Saved;
use App\Enums\PeerStatusEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SavedPeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Saved::whereNotNull('peerId')->count();
        if ($count < 20) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'User');
            })->pluck('id');

            $approvedPeers = Peer::where('status', PeerStatusEnum::APPROVED)->pluck('id');

            // Saved Peer for every users
            foreach ($users as $user) {
                for ($i = 0; $i < 10; $i++) {
                    $peerId = $approvedPeers[$i];
                    $savedPeer = Saved::where(['peerId' => $peerId, 'userId' => $user])->first();
                    if (!($savedPeer)) {
                        Saved::create([
                            'userId' => $user,
                            'peerId' => $peerId,
                        ]);
                    }
                }
            }
        } else {
            return;
        }
    }
}
