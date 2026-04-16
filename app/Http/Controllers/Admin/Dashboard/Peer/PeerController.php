<?php

namespace App\Http\Controllers\Admin\Dashboard\Peer;

use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\ErrorLogService;
use App\Http\Controllers\Controller;
use App\Enums\OrganizationStatusEnum;
use App\Repositories\Interfaces\Admin\Peer\AdminPeerInterface;

class PeerController extends Controller
{
    public function __construct(private AdminPeerInterface $peerRepository) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->orderBy('name', 'asc')->get();
            return view('dashboard.peer.peer', compact('organizations'));
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Fetch approved peers
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetehPeers(Request $request)
    {
        if ($request->ajax()) {
            // Get approved organizations from the repository
            $filteredData = $this->peerRepository->getApprovedPeers($request);

            return Datatables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                        <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 11px; height: 12px; margin-right: 5px;">
                        <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                    </a>';
                    return $btn;
                })->editColumn('status', function ($row) {
                    if ($row->status == OrganizationStatusEnum::APPROVED) {
                        return '<span class="badge badge-pill badge-success text-white px-2 py-1" style="font-weight: 600; font-size: 16px; line-height: 22.78px; border-radius: 8px;">Active</span>';
                    }
                })->editColumn('peerName', function ($row) {
                    $firstName = $row?->firstName ?? '';
                    $lastName = $row?->lastName ?? '';
                    $fullName = trim($firstName . ' ' . $lastName);
                    $formattedName = empty($fullName) ? 'Anonymous' : ucwords(strtolower($fullName));
                    $formattedName = strlen($formattedName) > 30 ? substr($formattedName, 0, 30) . '...' : $formattedName;
                    $staticImage = asset('img/SignUpDefaultAvatar.png');
                    // HTML for image with fallback and formatted name
                    return '<img src="' . $staticImage . '" onerror="this.src=\'' . $staticImage . '\'" class="rounded-circle object-fit-cover mr-1" width="32px" height="32px" /> ' . $formattedName;
                })
                ->rawColumns(['action', 'status', 'peerName'])
                ->make(true);
        }
    }

    /**
     * Delete a peer
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deletePeer(Request $request)
    {
        try {
            $this->peerRepository->deletePeer($request);
            return response()->json(['success' => 'Peer deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Fetch pending approval peers
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function pendingApproval(Request $request)
    {
        if ($request->ajax()) {
            // Get pending approval organizations from the repository
            $filteredData = $this->peerRepository->getPendingApprovalPeers($request);

            return Datatables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn" style="background-color:#34A853; width: 67px; height: 32px; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif; color:#FFFFFF">View</span></a>';
                })->editColumn('status', function ($row) {
                    if ($row->status == OrganizationStatusEnum::NEED_APPROVAL) {
                        return '<span class="badge badge-pill badge-warning text-dark px-2 py-1" style="font-weight: 600; font-size: 16px; line-height: 22.78px; border-radius: 8px; background-color:#FFD700; color:#161617;">Pending Approval</span>';
                    }
                })->editColumn('firstName', function ($row) {
                    $firstName = $row?->firstName ?? '';
                    $lastName = $row?->lastName ?? '';
                    $fullName = trim($firstName . ' ' . $lastName);
                    $formattedName = empty($fullName) ? 'Anonymous' : ucwords(strtolower($fullName));
                    $formattedName = strlen($formattedName) > 30 ? substr($formattedName, 0, 30) . '...' : $formattedName;
                    $staticImage = asset('img/SignUpDefaultAvatar.png');

                    // HTML for image with fallback and formatted name
                    return '<img src="' . $staticImage . '" onerror="this.src=\'' . $staticImage . '\'" class="rounded-circle object-fit-cover mr-1" width="32px" height="32px" /> ' . $formattedName;
                })

                ->rawColumns(['action', 'status', 'firstName'])
                ->make(true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $peer = $this->peerRepository->getPeerById($id);
            return response()->json(['peer' => $peer]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Approve a peer
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function approvePeer(Request $request)
    {
        try {
            $this->peerRepository->approvePeer($request->id);
            return response()->json(['success' => 'Organization approved successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Reject a peer
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function rejectPeer(Request $request)
    {
        try {
            // Delegate the rejection logic to the repository
            $this->peerRepository->rejectPeer($request->id);
            return response()->json(['success' => 'Organization rejected successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get peer ratings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function peerRating(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Delegate the logic to the repository
                $data = $this->peerRepository->getPeerRatings($request->id);

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn" style="background-color:#34A853; width: 67px; height: 32px;border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px;">
                    <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif; color:#FFFFFF">View</span></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                ErrorLogService::errorLog($e);
                return response()->json(['error' => $e->getMessage()]);
            }
        }

        // For non-AJAX requests
        $peer = $this->peerRepository->getPeerById($request->id);
        return view('dashboard.peer.peerReview', compact('peer'));
    }

    /**
     * Get peer reviews detail
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function peerReviewsDetail(Request $request)
    {
        try {
            // Delegate the logic to the repository
            $peer = $this->peerRepository->getPeerReviewDetails($request->id);

            return response()->json(['peer' => $peer]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
