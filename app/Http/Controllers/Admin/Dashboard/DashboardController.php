<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Carbon\Carbon;
use App\Models\Peer;
use App\Models\PeerRating;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use App\Models\OrganizationRating;
use App\Enums\PeerRatingStatusEnum;
use App\Models\ApplicationFeedback;
use App\Http\Controllers\Controller;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\Admin\Dashboard\DashboardInterface;

class DashboardController extends Controller
{

    public function __construct(private DashboardInterface $dashboardRepository) {}
    /**
     * Display the dashboard page
     *
     * @return \Illuminate\View\View
     */
    public function index()

    {
        try {

            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->count();
            $peers = Peer::where('status', PeerStatusEnum::APPROVED)->count();
            $pendingOrganizations = Organization::where('status', OrganizationStatusEnum::NEED_APPROVAL)->count();
            $pendingPeers = Peer::where('status', PeerStatusEnum::NEED_APPROVAL)->count();
            $pendingReviews = OrganizationRating::where('status', OrganizationRatingStatusEnum::NEED_APPROVAL)->count() + PeerRating::where('status', PeerRatingStatusEnum::NEED_APPROVAL)->count();
            return view('dashboard.index', compact('organizations', 'peers', 'pendingOrganizations', 'pendingPeers', 'pendingReviews'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function chart($year)
    {
        return response()->json($this->dashboardRepository->getChartData($year));
    }
}
