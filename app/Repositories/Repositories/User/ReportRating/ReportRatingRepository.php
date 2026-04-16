<?php

namespace App\Repositories\Repositories\User\ReportRating;

use App\Models\PeerRating;
use App\Models\ReportRating;
use App\Enums\PeerStatusEnum;
use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use App\Enums\PeerRatingStatusEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\User\ReportRating\ReportRatingInterface;

class ReportRatingRepository implements ReportRatingInterface{

    /**
     * Get Report Rating of the Organization Against Provided Organization Rating Id
     *
     * @param array $data
     * @param [type] $organizationRatingId
     * @return void
     */
    public function getOrganizationReportRatingData($organizationRatingId){
        try {
            $organizationRatingData = OrganizationRating::where(['id' => $organizationRatingId, 'status' => OrganizationRatingStatusEnum::APPROVED])
                    ->whereHas('organization', function ($query) {
                        $query->where('status', OrganizationStatusEnum::APPROVED);
                    })
                    ->first();
            if(!$organizationRatingData){
                throw new \ErrorException(__('messages.error.invalidOrganization'));
            }
            else{
                $organizationId = $organizationRatingData->organizationId;
                $organizationRatingId = $organizationRatingData->id;
                $visitorId = session('visitorId');
                $userId = auth()->check() ? auth()->user()->id : null;

                // Check if a helpful record already exists
                $reportRating = ReportRating::where([
                    'organizationRatingId' => $organizationRatingId,
                    'organizationId' => $organizationId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();

                // Return Report rating data of the organization rating id
                return $reportRating;
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Create Report Rating of the Organization Against Provided Organization Rating Id
     *
     * @param array $data
     * @param [type] $organizationRatingId
     * @return void
     */
    public function createOrganizationReportRating(array $data){
        try {
            DB::beginTransaction();
            $organizationRatingData = OrganizationRating::where(['id' => $data['organization_peerRatingId'], 'status' => OrganizationRatingStatusEnum::APPROVED])
                    ->whereHas('organization', function ($query) {
                        $query->where('status', OrganizationStatusEnum::APPROVED);
                    })
                    ->first();
            if(!$organizationRatingData){
                throw new \ErrorException(__('messages.error.invalidOrganization'));
            }
            else{
                $organizationId = $organizationRatingData->organizationId;
                $organizationRatingId = $organizationRatingData->id;
                $visitorId = session('visitorId');
                Log::info('visitorId: '.$visitorId);
                $userId = auth()->check() ? auth()->user()->id : null;
                $reportRating = ReportRating::where([
                    'organizationRatingId' => $organizationRatingId,
                    'organizationId' => $organizationId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();
                if($reportRating){
                    // Report Rating Exist Now Update the record
                    $reportRating->update([
                        'report' => $data['experience']
                    ]);
                }
                else{
                    // Report Rating doesn't Exist Now create the new record
                    $reportRatingData = [
                        'userId' => $userId,
                        'organizationId' => $organizationId,
                        'organizationRatingId' => $organizationRatingId,
                        'report' => $data['experience'],
                    ];
                    if (!$userId) {
                        $reportRatingData['deviceIdentifier'] = $visitorId;
                    }
                    ReportRating::create($reportRatingData);
                }
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get Report Rating of the Peer Against Provided Peer Rating Id
     *
     * @param array $data
     * @param [type] $peerRatingId
     * @return void
     */
    public function getPeerReportRatingData($peerRatingId){
        try {
            $peerRatingData = PeerRating::where(['id' => $peerRatingId, 'status' => PeerRatingStatusEnum::APPROVED])
                    ->whereHas('peer', function ($query) {
                        $query->where('status', PeerStatusEnum::APPROVED);
                    })
                    ->first();
            if(!$peerRatingData){
                throw new \ErrorException(__('messages.error.invalidPeer'));
            }
            else{

                $peerId = $peerRatingData->peerId;
                $peerRatingId = $peerRatingData->id;
                $visitorId = session('visitorId');
                $userId = auth()->check() ? auth()->user()->id : null;

                // Check if a helpful record already exists
                $reportRating = ReportRating::where([
                    'peerRatingId' => $peerRatingId,
                    'peerId' => $peerId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();
                // Return Report rating data of the organization rating id
                return $reportRating;
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Create Report Rating of the Peer Against Provided Peer Rating Id
     *
     * @param array $data
     * @return void
     */
    public function createPeerReportRating(array $data){
        try {
            DB::beginTransaction();
            $peerRatingData = PeerRating::where(['id' => $data['organization_peerRatingId'], 'status' => PeerRatingStatusEnum::APPROVED])
                    ->whereHas('organization', function ($query) {
                        $query->where('status', PeerStatusEnum::APPROVED);
                    })
                    ->first();
            if(!$peerRatingData){
                throw new \ErrorException(__('messages.error.invalidPeer'));
            }
            else{

                $peerId = $peerRatingData->peerId;
                $peerRatingId = $peerRatingData->id;
                $visitorId = session('visitorId');
                $userId = auth()->check() ? auth()->user()->id : null;

                // Check if a helpful record already exists
                $reportRating = ReportRating::where([
                    'peerRatingId' => $peerRatingId,
                    'peerId' => $peerId,
                    'userId' => $userId ?: null,
                    'deviceIdentifier' => $userId ? null : $visitorId
                ])->first();
                if($reportRating){
                    // Report Rating Exist Now Update the record
                    $reportRating->update([
                        'report' => $data['experience']
                    ]);
                }
                else{
                    $reportRatingData = [
                        'userId' => $userId,
                        'peerId' => $peerId,
                        'peerRatingId' => $peerRatingId,
                        'report' => $data['experience'],
                    ];

                    if (!$userId) {
                        $reportRatingData['deviceIdentifier'] = $visitorId;
                    }

                    ReportRating::create($reportRatingData);
                }
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

}
