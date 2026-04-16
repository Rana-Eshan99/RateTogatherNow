<?php

namespace App\Http\Controllers\User\Home;

use Exception;
use App\Services\ErrorLogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReportRating\AddReportRatingRequest;
use App\Repositories\Interfaces\User\ReportRating\ReportRatingInterface;
use App\Repositories\Repositories\User\ReportRating\ReportRatingRepository;

class ReportRatingController extends Controller
{
    /**
     * The repository instance
     *
     * @var ReportRatingRepository
     */
    private $reportRatingRepository;

    /**
     * Home => ReportRatingController Constructor
     *
     * @param ReportRatingInterface $reportRatingRepository
     */
    public function __construct(ReportRatingInterface $reportRatingRepository)
    {
        $this->reportRatingRepository = $reportRatingRepository;
    }

    /**
     * Show Report Rating Form Associated with Organization Rating Id
     *
     * @param [type] $organization_peerRatingId
     * @return void
     */
    public function organizationReportRatingForm($organization_peerRatingId)
    {
        try {
            $data = $this->reportRatingRepository->getOrganizationReportRatingData($organization_peerRatingId);
            return view('home.reportRating.reportRating', compact('organization_peerRatingId', 'data'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add Report of Organization Associated with Organization Rating Id
     *
     * @param AddReportRatingRequest $request
     * @return void
     */
    public function addReportRatingOrganization(AddReportRatingRequest $request)
    {
        try {

            $this->reportRatingRepository->createOrganizationReportRating($request->all());

            session()->flash('reportRated', true);  // Set reportRate to true or false
            session()->flash('type', 'organization');  // Set type to 'organization' or 'peer'

            // Redirect with organization_peerRatingId
            return redirect()->route('user.organization.organizationReportRatingForm', ['organization_peerRatingId' => $request->organization_peerRatingId]);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show Report Rating Form Associated with Peer Rating Id
     *
     * @param [type] $organization_peerRatingId
     * @return void
     */
    public function peerReportRatingForm($organization_peerRatingId)
    {
        try {
            $data = $this->reportRatingRepository->getPeerReportRatingData($organization_peerRatingId);
            return view('home.reportRating.reportRating', compact('organization_peerRatingId', 'data'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add Report of Peer Associated with Peer Rating Id
     *
     * @param AddReportRatingRequest $request
     * @return void
     */
    public function addReportRatingPeer(AddReportRatingRequest $request)
    {
        try {
           
            $this->reportRatingRepository->createPeerReportRating($request->all());

            session()->flash('reportRated', true);  // Set reportRate to true or false
            session()->flash('type', 'peer');  // Set type to 'peer' or 'peer'

            // Redirect with organization_peerRatingId
            return redirect()->route('user.peer.peerReportRatingForm', ['organization_peerRatingId' => $request->organization_peerRatingId]);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
