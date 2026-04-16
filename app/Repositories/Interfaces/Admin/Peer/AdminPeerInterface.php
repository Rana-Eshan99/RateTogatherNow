<?php

namespace App\Repositories\Interfaces\Admin\Peer;

interface AdminPeerInterface
{

    /**
     * Get approved peers
     *
     * @param $request
     * @return mixed
     */
    public function getApprovedPeers($request);

    /**
     * Delete peer
     *
     * @param $request
     * @return mixed
     */
    public function deletePeer($request);

    /**
     * Get pending approval peers
     *
     * @param $request
     * @return mixed
     */
    public function getPendingApprovalPeers($request);

    /**
     * Get peer by id
     *
     * @param $id
     * @return mixed
     */
    public function getPeerById($id);

    /**
     * Approve a peer
     *
     * @param $request
     * @return mixed
     */
    public function approvePeer($request);

    /**
     * Reject a peer
     *
     * @param $request
     * @return mixed
     */
    public function rejectPeer($request);

    /**
     * Get peer ratings
     *
     * @param $request
     * @return mixed
     */
    public function getPeerRatings($request);

    /**
     * Get peer review details
     *
     * @param $request
     * @return mixed
     */
    public function getPeerReviewDetails($request);
}
