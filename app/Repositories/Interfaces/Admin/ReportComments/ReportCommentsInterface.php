<?php

namespace App\Repositories\Interfaces\Admin\ReportComments;

Interface ReportCommentsInterface{

    /**
     * Delete Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function deleteReportedComments($request);

    /**
     * Get Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function getReportedComments($request);

    /**
     * Get Peer Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function getPeerReportedComments($request);

    /**
     * Delete Peer Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function deletePeerReportedComments($request);

    /**
     * Keep Comment
     *
     * @param [type] $request
     * @return void
     */
    public function keepPeerComment($request);

    /**
     * Keep Organization Comment
     *
     * @param [type] $request
     * @return void
     */
    public function keepOrganizationComment($request);
}

