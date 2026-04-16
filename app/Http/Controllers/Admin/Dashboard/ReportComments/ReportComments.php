<?php

namespace App\Http\Controllers\Admin\Dashboard\ReportComments;

use App\Models\ReportRating;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\ErrorLogService;
use App\Models\OrganizationRating;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\ReportComments\ReportCommentsInterface;

class ReportComments extends Controller
{
    public function __construct(private ReportCommentsInterface $reportCommentsRepository)
    {
    }

    /**
     * Display the reported comments page
     *
     * @return \Illuminate\View\View
     */
    public function reportedComments()
    {
        try {
            return view('dashboard.reportedComments.reportedComments');
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the reported comments  organization tab page
     *
     * @return \Illuminate\View\View
     */
    public function fetehReportedComments(Request $request)
    {
        if ($request->ajax()) {
            // Fetch the data with related models
            $data = ReportRating::with(['user', 'organizationRating.organization', 'organizationRating'])->orderBy('createdAt', 'desc')->get();

            // Filter out records where either organizationRating, organization, or user is null
            $filteredData = $data->filter(function ($item) {
                return $item->organizationRating && $item->organizationRating->organization;
            });

            // Process the filtered data to add custom fields
            $filteredData->map(function ($item) {
                $item->organizationName = $item->organizationRating->organization->name;
                $item->experience = $item->organizationRating->experience;
                $item->userName = $item->user ?
                    ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName)) :
                    'Anonymous';
                return $item;
            });
            return Datatables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn" style="background-color:#34A853; width: 67px; height: 32px;border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif; color:#FFFFFF">View</span></a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                            <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 11px; height: 12px; margin-right: 5px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                        </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Delete reported comments
     *
     * @return \Illuminate\View\View
     */
    public function deleteReportedComments(Request $request)
    {
        try {
            $this->reportCommentsRepository->deleteReportedComments($request);
            return response()->json(['success' => 'Reported comment deleted successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the reported comments peer tab page
     *
     * @return \Illuminate\View\View
     */
    public function fetehPeerReportedComments(Request $request)
    {
        if ($request->ajax()) {
            // Fetch the data with related models
            $data = ReportRating::with(['user', 'peerRating.peer', 'peerRating'])->orderBy('createdAt', 'desc')->get();

            // Filter out records where either peerRating, peer, or user is null
            $filteredData = $data->filter(function ($item) {
                return $item->peerRating && $item->peerRating->peer;
            });

            // Process the filtered data to add custom fields
            $filteredData->map(function ($item) {
                $item->peerName = $item->peerRating->peer->firstName . ' ' . $item->peerRating->peer->lastName;
                $item->userName = $item->user ?
                    ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName)) :
                    'Anonymous';
                $item->experience = $item->peerRating->experience;
                return $item;
            });

            // Return the filtered data for DataTables
            return Datatables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view-peer btn" style="background-color:#34A853; width: 67px; height: 32px;border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif; color:#FFFFFF">View</span></a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                            <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 10px; height: 12px; margin-right: 5px;">
                            <span style="font-size: 16px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                        </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Get reported comments for organization modal view
     *
     * @return \Illuminate\View\View
     */
    public function getReportedComments(Request $request)
    {
        try {
            $report = $this->reportCommentsRepository->getReportedComments($request);
            return response()->json(['success' => $report]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Get reported comments for peer modal view
     *
     * @return \Illuminate\View\View
     */
    public function getPeerReportedComments(Request $request)
    {
        try {
            $report = $this->reportCommentsRepository->getPeerReportedComments($request);
            return response()->json(['success' => $report]);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete reported comments for peer
     *
     * @return \Illuminate\View\View
     */
    public function deletePeerReportedComments(Request $request)
    {
        try {
            $this->reportCommentsRepository->deletePeerReportedComments($request);
            return response()->json(['success' => 'Reported comment deleted successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Keep reported comments for peer
     *
     * @return \Illuminate\View\View
     */
    public function keepPeerComment(Request $request)
    {
        try {
            $this->reportCommentsRepository->keepPeerComment($request);
            return response()->json(['success' => 'Comment kept successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Keep reported comments for organization
     *
     * @return \Illuminate\View\View
     */
    public function keepOrganizationComment(Request $request)
    {
        try {
            $this->reportCommentsRepository->keepOrganizationComment($request);
            return response()->json(['success' => 'Comment kept successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
