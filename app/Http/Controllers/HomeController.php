<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peer;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Enums\PeerStatusEnum;
use Yajra\DataTables\DataTables;
use App\Models\ApplicationFeedback;
use App\Enums\OrganizationStatusEnum;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $organizations = Organization::count();
        $peers = Peer::count();
        $pendingOrganizations = Organization::where('status', OrganizationStatusEnum::NEED_APPROVAL)->count();
        $pendingPeers = Peer::where('status', PeerStatusEnum::NEED_APPROVAL)->count();
        $pendingReviews = ApplicationFeedback::where('status', PeerStatusEnum::NEED_APPROVAL)->count();
        return view('admin.home', compact('organizations', 'peers', 'pendingOrganizations', 'pendingPeers', 'pendingReviews'));
    }



    public function getUsers()
    {
        return view('admin.datatable');
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        return Datatables::of(User::select('id', 'firstName', 'email', 'createdAt', 'updatedAt')->get())->make(true);
    }
}
