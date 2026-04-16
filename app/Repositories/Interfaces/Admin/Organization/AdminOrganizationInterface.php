<?php

namespace App\Repositories\Interfaces\Admin\Organization;

interface AdminOrganizationInterface
{

    /**
     * Delete Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function deleteOrganization($request);

    /**
     * Get Organization Details
     *
     * @param [type] $id
     * @return void
     */
    public function getOrganizationDetails($id);

    /**
     * Get Pending Approval Organizations
     *
     * @return void
     */
    public function getPendingApprovalOrganizations();

    /**
     * Get Approved Organizations
     *
     * @return void
     */
    public function getApprovedOrganizations();

    /**
     * approveOrganization
     *
     * @return void
     */
    public function approveOrganization($id);

    /**
     * rejectOrganization
     *
     * @return void
     */
    public function rejectOrganization($id);

    /**
     * getOrganizationPeers
     *
     * @return void
     */
    public function getOrganizationPeers($id);

    /**
     * getOrganizationRatings
     *
     * @return void
     */
    public function getOrganizationRatings($id);

    /**
     * getOrganizationReviewDetails
     *
     * @return void
     */
    public function getOrganizationReviewDetails($id);

    /**
     * deleteOrganizationPeer
     *
     * @return void
     */
    public function deleteOrganizationPeer($orgId, $peerId);

}
