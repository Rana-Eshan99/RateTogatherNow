<?php

namespace App\Repositories\Repositories\Admin\Peer;

use App\Models\Peer;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use App\Services\ErrorLogService;
use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use App\Enums\PeerRatingStatusEnum;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationRatingStatusEnum;
use App\Models\PeerRating;
use App\Repositories\Interfaces\Admin\Peer\AdminPeerInterface;

class AdminPeerRepository implements AdminPeerInterface
{


    /**
     * Get approved peers
     *
     * @param $request
     * @return mixed
     */
    public function getApprovedPeers($request)
    {
        // Initialize the query with necessary relationships and status filter
        $query = Peer::with(['organization', 'department', 'ratings'])
                     ->where('status', PeerStatusEnum::APPROVED)
                     ->latest('updatedAt');

        // Apply organization filter if provided
        if (!empty($request->organization)) {
            $query->where('organizationId', $request->organization);
        }

        // Apply department filter if provided
        if (!empty($request->department)) {
            $query->where('organizationId', $request->organization)->where('departmentId', $request->department);
        }

        // Retrieve the filtered and ordered data
        $peers = $query->get();

        // Return early if no data found
        if ($peers->isEmpty()) {
            return collect(); // Return an empty collection
        }

        // Process and modify the peer data
        $filteredPeers = $peers->map(function ($peer) {
            $peer->organizationName = optional($peer->organization)->name;
            $peer->departmentName = optional($peer->department)->name;
            $peer->ratingtotal = $peer->ratings->where('status', OrganizationRatingStatusEnum::APPROVED)->count();
            return $peer;
        });

        return $filteredPeers;
    }

    /**
     * Delete peer
     *
     * @param $request
     * @return mixed
     */
    public function deletePeer($request)
    {
        DB::beginTransaction();
        try {
            $peer = Peer::find($request->id);
            if (!($peer)) {
                throw new \ErrorException(__('messages.error.invalidPeer'));
            } else {
                $peer->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get pending approval peers
     *
     * @param $request
     * @return mixed
     */
    public function getPendingApprovalPeers($request)
    {
        // Initialize the query with necessary relationships and status filter
        $query = Peer::with(['organization', 'department', 'ratings'])
                     ->where('status', PeerStatusEnum::NEED_APPROVAL);

        if (!empty($request->organization)) {
            $query->where('organizationId', $request->organization);
        }

        if (!empty($request->department)) {
            $query->where('organizationId', $request->organization)->where('departmentId', $request->department);
        }

        // Retrieve the filtered and ordered data
        $data = $query->orderBy('createdAt', 'desc')->get();

        // Return early if no data found
        if ($data->isEmpty()) {
            return collect(); // Return an empty collection
        }
        // Modify the data as needed
        $filteredData = $data->map(function ($item) {
            $item->organizationName = optional($item->organization)->name;
            $item->departmentName = optional($item->department)->name;
            $item->ratingtotal = $item->ratings->where('status', OrganizationRatingStatusEnum::APPROVED)->count();
            return $item;
        });

        return $filteredData;
    }

    /**
     * Get peer by id
     *
     * @param $id
     * @return mixed
     */
    public function getPeerById($id)
    {
        $peer = Peer::with(['organization', 'department', 'ratings'])->find($id);

        if (!$peer) {
            throw new \Exception('Peer not found.');
        }

        $peer->organizationName = optional($peer->organization)->name;
        $peer->departmentName = optional($peer->department)->name;
        $peer->ratingtotal = $peer->ratings->where('status', OrganizationRatingStatusEnum::APPROVED)->count();

        return $peer;
    }

    /**
     * Approve a peer
     *
     * @param $request
     * @return mixed
     */
    public function approvePeer($id)
    {
        $peer = Peer::find($id);

        if (!$peer) {
            throw new \Exception('Peer not found.');
        }

        $peer->status = PeerStatusEnum::APPROVED;
        $peer->save();

        return $peer;
    }

    /**
     * Reject a peer
     *
     * @param $request
     * @return mixed
     */
    public function rejectPeer($id)
    {
        $peer = Peer::find($id);

        if (!$peer) {
            throw new \Exception('Peer not found.');
        }

        $peer->status = PeerStatusEnum::REJECTED;
        $peer->save();

        return $peer;
    }

    /**
     * Get peer ratings
     *
     * @param $request
     * @return mixed
     */
    public function getPeerRatings($id)
    {
        $peer = Peer::with(['organization', 'department', 'ratings'])->find($id);
        if (!$peer) {
            throw new \Exception('Organization not found.');
        }

        return $peer->ratings->where('status', PeerRatingStatusEnum::APPROVED)->sortByDesc('createdAt')->map(function ($item) {

            $item->organizationName = optional($item->organization)->name;
            $item->peerName = $item->peer ? optional($item->peer)->firstName . ' ' . optional($item->peer)->lastName : 'Anonymous';
            $item->givenBy = $item->user ? optional($item->user)->firstName . ' ' . optional($item->user)->lastName : 'Anonymous';
            $overAllRating = (
                $item->assistOther +
                $item->collaborateTeam +
                $item->communicateUnderPressure +
                $item->dependableWork +
                $item->easyWork +
                $item->meetDeadline +
                $item->receivingFeedback +
                $item->respectfullOther
                ) / 8;

            $item->ratingTotal = number_format($overAllRating, 1);
            return $item;
        });
    }

    /**
     * Get peer review details
     *
     * @param $request
     * @return mixed
     */
    public function getPeerReviewDetails($id)
    {

        $peer = PeerRating::with(['peer', 'user', 'organization'])->where('id', $id)->where('status', PeerRatingStatusEnum::APPROVED)->get();

        if (!$peer) {
            throw new \Exception('Peer review not found.');
        }

        return $peer;
    }

}
