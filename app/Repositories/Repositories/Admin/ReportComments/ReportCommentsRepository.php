<?php

namespace App\Repositories\Repositories\Admin\ReportComments;

use App\Models\ReportRating;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationFeedback;
use App\Repositories\Interfaces\Admin\ReportComments\ReportCommentsInterface;

class ReportCommentsRepository implements ReportCommentsInterface
{
    /**
     * Get Organization/Peer Data (Home Page)
     *
     * @param [type] $request
     * @return void
     */
    public function deleteReportedComments($request)
    {
        try {
            DB::beginTransaction();
            $report = ReportRating::find($request->id);
            // Check if the report is associated with an organization rating
            if ($report->organizationRatingId) {
                $organizationRating = $report->organizationRating;
                if ($organizationRating) {
                    $organizationRating->delete();
                }
            }

            // Check if the report is associated with a peer rating
            if ($report->peerRatingId) {
                $peerRating = $report->peerRating;
                if ($peerRating) {
                    $peerRating->delete();
                }
            }

            // Delete the report
            $report->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function getReportedComments($request)
    {
        try {
            $report = ReportRating::with(['user', 'organizationRating.organization', 'organizationRating'])
                ->where('id', $request->id)
                ->first();
            return $report;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get Peer Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function getPeerReportedComments($request)
    {
        try {
            $report = ReportRating::with(['user', 'peerRating.peer', 'peerRating'])
                ->where('id', $request->id)
                ->first();

            return $report;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Delete Peer Reported Comments
     *
     * @param [type] $request
     * @return void
     */
    public function deletePeerReportedComments($request)
    {
        try {
            DB::beginTransaction();
            $report = ReportRating::find($request->id);
            $peerRating = $report->peerRating;
            $peerRating->delete();
            $report->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Keep Peer Comment
     *
     * @param [type] $request
     * @return void
     */
    public function keepPeerComment($request) {
        try {
            DB::beginTransaction();
            $report = ReportRating::where('id', $request->keepPeerId)->first();
            $report->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Keep Organization Comment
     *
     * @param [type] $request
     * @return void
     */

    public function keepOrganizationComment($request) {
        try {
            DB::beginTransaction();
            $report = ReportRating::where('id', $request->keepId)->first();
            $report->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
