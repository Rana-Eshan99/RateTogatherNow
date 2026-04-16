<?php

namespace App\Repositories\Repositories\User\Helpful;

use App\Models\OrganizationRating;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationRatingStatusEnum;
use App\Enums\PeerRatingStatusEnum;
use App\Enums\PeerStatusEnum;
use App\Models\Helpful;
use App\Models\PeerRating;
use App\Repositories\Interfaces\User\Helpful\HelpfulInterface;
use Illuminate\Support\Facades\DB;

class HelpfulRepository implements HelpfulInterface
{
    /**
     * Save or Update or Delete the Helpful record against the given organization rating id.
     *
     * @param array $data
     * @return void
     */
    public function saveHelpful_Organization(array $data)
    {
        try {
            DB::beginTransaction();
            $given_isFoundHelpful = $data['isFoundHelpful'];
            $organizationRatingData = OrganizationRating::where(['id' => $data['helpfulOrganizationRatingId'], 'status' => OrganizationRatingStatusEnum::APPROVED])
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->first();
            $visitorId = $data['visitorId'];

            if (!$organizationRatingData) {
                throw new \ErrorException(__('messages.error.invalidOrganization'));
            } else {
                $organizationId = $organizationRatingData->organizationId;
                $organizationRatingId = $organizationRatingData->id;
                $userId = auth()->check() ? auth()->user()->id : null;

                // Check if a helpful record already exists
                $helpful = Helpful::where([
                    'organizationRatingId' => $organizationRatingId,
                    'organizationId' => $organizationId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();

                if (!($helpful)) {
                    // Prepare the data for the new record
                    $helpfulData = [
                        'userId' => $userId,
                        'organizationId' => $organizationId,
                        'organizationRatingId' => $organizationRatingId,
                        'isFoundHelpful' => $given_isFoundHelpful,
                    ];

                    // Only set deviceIdentifier if the user is a guest (no Auth user)
                    if (!$userId) {
                        $helpfulData['deviceIdentifier'] = $visitorId;
                    }

                    // Create the new helpful record
                    Helpful::create($helpfulData);
                } else {
                    $existing_isFoundHelpful = $helpful->isFoundHelpful;

                    if ($existing_isFoundHelpful == $given_isFoundHelpful) {
                        // Then it Means User again selected the already selected option (it means he want to delete his record)
                        $helpful->delete();
                    } else {
                        $helpful->update([
                            'isFoundHelpful' =>  $given_isFoundHelpful,
                        ]);
                    }
                }
                $count = Helpful::where(['organizationRatingId' => $organizationRatingId, 'isFoundHelpful' => 1])->count();

                $notHelpfulCount = Helpful::where(['organizationRatingId' => $organizationRatingId, 'isFoundHelpful' => 0])->count();

                DB::commit();
                // Return Report rating data of the organization rating id
                $data = [
                    'count' => $count,
                    'notHelpfulCount' => $notHelpfulCount,
                ];
                return $data;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Save or Update or Delete the Helpful record against the given peer rating id.
     *
     * @param array $data
     * @return void
     */
    public function saveHelpful_Peer(array $data)
    {
        try {
            DB::beginTransaction();
            $given_isFoundHelpful = $data['isFoundHelpful'];
            $peerRatingData = PeerRating::where(['id' => $data['helpfulPeerRatingId'], 'status' => PeerRatingStatusEnum::APPROVED])
                ->whereHas('peer', function ($query) {
                    $query->where('status', PeerStatusEnum::APPROVED);
                })
                ->first();
            $visitorId = $data['visitorId'];
            if (!$peerRatingData) {
                throw new \ErrorException(__('messages.error.invalidPeer'));
            } else {
                $peerId = $peerRatingData->peerId;
                $peerRatingId = $peerRatingData->id;
                $userId = auth()->check() ? auth()->user()->id : null;

                // Check if a helpful record already exists
                $helpful = Helpful::where([
                    'peerRatingId' => $peerRatingId,
                    'peerId' => $peerId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();
                if (!($helpful)) {
                    // Prepare the data for the new record
                    $helpfulData = [
                        'userId' => $userId,
                        'peerId' => $peerId,
                        'peerRatingId' => $peerRatingId,
                        'isFoundHelpful' => $given_isFoundHelpful,
                    ];

                    // Only set deviceIdentifier if the user is a guest (no Auth user)
                    if (!$userId) {
                        $helpfulData['deviceIdentifier'] = $visitorId;
                    }

                    // Create the new helpful record
                    Helpful::create($helpfulData);
                } else {
                    $existing_isFoundHelpful = $helpful->isFoundHelpful;
                    if ($existing_isFoundHelpful == $given_isFoundHelpful) {
                        // Then it Means User again selected the already selected option (it means he want to delete his record)
                        $helpful->delete();
                    } else {
                        $helpful->update([
                            'isFoundHelpful' =>  $given_isFoundHelpful,
                        ]);
                    }
                }

                $count = Helpful::where(['peerRatingId' => $peerRatingId, 'isFoundHelpful' => 1])->count();

                $notHelpfulCount = Helpful::where(['peerRatingId' => $peerRatingId, 'isFoundHelpful' => 0])->count();

                DB::commit();
                // Return Report rating data of the organization rating id
                $data = [
                    'count' => $count,
                    'notHelpfulCount' => $notHelpfulCount,
                ];
                return $data;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }
}
