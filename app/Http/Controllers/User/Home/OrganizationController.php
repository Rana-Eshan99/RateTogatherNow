<?php

namespace App\Http\Controllers\User\Home;

use Exception;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Traits\ThousandIntoKTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;

class OrganizationController extends Controller
{
    /**
     * Show Rating in unit of K's (e.g 1K,2K)
     */
    use ThousandIntoKTrait;


    /**
     * The repository instance
     *
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * Home => OrganizationController Constructor
     *
     * @param OrganizationInterface $organizationRepository
     */
    public function __construct(OrganizationInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Show Organization Details
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function show($id, Request $request)
    {
        try {
            if ($request->ajax()) {
                $visitorId = $request->visitorId;
                session(['visitorId' => $visitorId]);
            }
            $data = $this->organizationRepository->getOrganizationByIdDetail($id, $request);
            // Check if $data is a redirect response
            if ($data instanceof \Illuminate\Http\RedirectResponse) {
                return $data; // return redirect if present
            }

            // Get the organization Rating with the status of helpful and report_ratings
            $usersRating = $this->organizationRepository->getOrganizationRating_Report_Helpful($id);
            if ($request->ajax()) {
                $view = view('organization.rating', compact('usersRating'))->render();
                return response()->json(['html' => $view]);
            }
            return view('organization.detailPage', [
                'usersRating' => $usersRating,
                'saved' => $data['saved'],
                'data' => $data
            ]);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], JsonResponse::HTTP_BAD_REQUEST);
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
