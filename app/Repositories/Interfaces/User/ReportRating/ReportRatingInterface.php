<?php

namespace App\Repositories\Interfaces\User\ReportRating;

interface ReportRatingInterface{
    /**
     * Get Report Rating of the Organization Against Provided Organization Rating Id
     *
     * @param array $data
     * @param [type] $organizationRatingId
     * @return void
     */
    public function getOrganizationReportRatingData($organizationRatingId);

    /**
     * Create Report Rating of the Organization Against Provided Organization Rating Id
     *
     * @param array $data
     * @return void
     */
    public function createOrganizationReportRating(array $data);

    /**
     * Get Report Rating of the Peer Against Provided Peer Rating Id
     *
     * @param array $data
     * @param [type] $peerRatingId
     * @return void
     */
    public function getPeerReportRatingData($peerRatingId);

    /**
     * Create Report Rating of the Peer Against Provided Peer Rating Id
     *
     * @param array $data
     * @return void
     */
    public function createPeerReportRating(array $data);
}
