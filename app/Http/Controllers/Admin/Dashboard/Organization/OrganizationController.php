<?php

namespace App\Http\Controllers\Admin\Dashboard\Organization;

use App\Models\Peer;
use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\ErrorLogService;
use App\Models\OrganizationRating;
use App\Http\Controllers\Controller;
use App\Enums\OrganizationStatusEnum;
use App\Repositories\Interfaces\Admin\Organization\AdminOrganizationInterface;

class OrganizationController extends Controller
{
    public function __construct(private AdminOrganizationInterface $organizationRepository) {}
    /**
     * Display the organization page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            return view('dashboard.organization.organization');
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display Active and Approved organizations Table on the organization page
     *
     * @return \Illuminate\View\View
     */
    public function fetehOrganizations(Request $request)
    {
        if ($request->ajax()) {
            // Get approved organizations from the repository
            $filteredData = $this->organizationRepository->getApprovedOrganizations();

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
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    /**
     * Delete an organization from the organization page
     *
     * @param Request $request
     */
    public function deleteOrganization(Request $request)
    {
        try {
            $this->organizationRepository->deleteOrganization($request);
            return response()->json(['success' => 'Organization deleted successfully'], 200 );
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the pending approval organizations Table on the organization page
     *
     * @return \Illuminate\View\View
     */
    public function pendingApproval(Request $request)
    {
        if ($request->ajax()) {
            // Get pending approval organizations from the repository
            $filteredData = $this->organizationRepository->getPendingApprovalOrganizations();

            return Datatables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn" style="background-color:#34A853; width: 67px; height: 32px; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif; color:#FFFFFF">View</span></a>';
                })->editColumn('status', function ($row) {
                    if ($row->status == OrganizationStatusEnum::NEED_APPROVAL) {
                        return '<span class="badge badge-pill badge-warning text-dark px-2 py-1" style="font-weight: 600; font-size: 16px; line-height: 22.78px; border-radius: 8px; background-color:#FFD700; color:#161617;">Pending Approval</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    /**
     * Display the organization detail page
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            if (request()->ajax()) {
                $data = $this->organizationRepository->getOrganizationDetails($id);
                return response()->json(['organization' => $data['organization']]);
            }

            $data = $this->organizationRepository->getOrganizationDetails($id);

            return view('dashboard.organization.organizationDetail', [
                'organization' => $data['organization'],
                'organizationRatings' => $data['organizationRatings'],
                'formattedOverAllRating' => $data['overAllRating'],
            ]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Approve an organization
     *
     * @param Request $request
     */
    public function approveOrganization(Request $request)
    {
        try {
            // Delegate the approval logic to the repository
            $this->organizationRepository->approveOrganization($request->id);
            return response()->json(['success' => 'Organization approved successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Reject an organization
     *
     * @param Request $request
     */
    public function rejectOrganization(Request $request)
    {
        try {
            // Delegate the rejection logic to the repository
            $this->organizationRepository->rejectOrganization($request->id);
            return response()->json(['success' => 'Organization rejected successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get organization peers
     *
     * @param Request $request
     */
    public function organizationPeers(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Delegate the logic to the repository
                $peers = $this->organizationRepository->getOrganizationPeers($request->id);

                return Datatables::of($peers)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="org-peer-delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                        <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 11px; height: 12px; margin-right: 5px;">
                        <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                    </a>';
                        return $btn;
                    })
                    ->editColumn('firstName', function ($row) {
                        $Name = $row->firstName . ' ' . $row->lastName;
                        $formattedName = strlen($Name) > 30 ? substr($Name, 0, 30) . '...' : $Name;
                        $staticImage = asset('img/SignUpDefaultAvatar.png');
                        $image = $staticImage;
                        return '<img src="' . $image . '" onerror="this.src=\'' . $staticImage . '\'" class="rounded-circle object-fit-cover mr-1" width="32px" height="32px" /> ' . $formattedName;
                    })
                    ->rawColumns(['action', 'firstName'])
                    ->make(true);
            } catch (\Exception $e) {
                ErrorLogService::errorLog($e);
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Get organization ratings
     *
     * @param Request $request
     */
    public function organizationRating(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Delegate the logic to the repository
                $data = $this->organizationRepository->getOrganizationRatings($request->id);

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
        $organization = Organization::with(['country', 'state', 'peers', 'ratings'])->find($request->id);
        return view('dashboard.organization.organizationReview', compact('organization'));
    }

    /**
     * Get organization reviews detail
     *
     * @param Request $request
     */

    public function organizationReviewsDetail(Request $request)
    {
        try {
            // Delegate the logic to the repository
            $organization = $this->organizationRepository->getOrganizationReviewDetails($request->id);

            return response()->json(['organization' => $organization]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    /**
     * deleteOrganizationPeer
     *
     * @param Request $request
     */
    public function deleteOrganizationPeer($orgId, $peerId)
    {
        try {
            // Delegate the logic to the repository
            $message = $this->organizationRepository->deleteOrganizationPeer($orgId, $peerId);
            return response()->json(['success' => $message]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
