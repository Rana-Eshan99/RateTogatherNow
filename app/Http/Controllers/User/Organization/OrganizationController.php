<?php

namespace App\Http\Controllers\User\Organization;

use Exception;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Models\CurrentUserLocation;
use App\Http\Controllers\Controller;
use App\Services\DistanceMatrixService;
use App\Repositories\Interfaces\User\Country\CountryInterface;
use App\Http\Requests\User\Organization\AddOrganizationRequest;
use App\Http\Requests\User\Organization\RateOrganizationRequest;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;

class OrganizationController extends Controller
{
    /**
     * The repository instance
     *
     * @var OrganizationRepository
     */
    private $organizationRepository;


    /**
     * The repository instance
     *
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * The service instance
     *
     * @var DistanceMatrixService
     */
    protected $distanceService;

    /**
     * Organization Constructor
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationInterface $organizationRepository, CountryInterface $countryRepository,  DistanceMatrixService $distanceService)
    {
        $this->organizationRepository = $organizationRepository;
        $this->countryRepository = $countryRepository;
        $this->distanceService = $distanceService;
    }

    /**
     * Function to Show add organization blade file
     *
     * @return void
     */
    public function addOrganizationForm()
    {
        try {
            $countries = $this->countryRepository->getCountries();
            return view('user.organization.addOrganization', compact('countries'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save organization
     *
     * @param AddOrganizationRequest $request
     * @return void
     */
    public function saveOrganization(AddOrganizationRequest $request)
    {
        try {
            $this->organizationRepository->createOrganization($request->all());
            session()->flash('organizationSaved');
            return redirect()->route('user.organization.addOrganizationForm');
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Rate organization form
     *
     * @param [type] $organizationId
     * @return void
     */
    public function rateOrganizationForm($organizationId, Request $request)
    {
        try {
            $edit = $request->has('edit');
            $ratingId = $request->ratingId;
            $organization = $this->organizationRepository->getOrganization($organizationId);
            if ($organization instanceof \Illuminate\Http\RedirectResponse) {
                return $organization;
            }
            $overAllRating = $this->organizationRepository->getOverAllOrganizationRating($organizationId);
            $organizationRating = $this->organizationRepository->getOrganizationRating($organizationId, $edit, $ratingId);
            $isSavedOrganization = $this->organizationRepository->isSavedOrganization($organizationId);
            return view('user.organization.rateOrganization', compact('organization', 'isSavedOrganization', 'overAllRating', 'organizationRating', 'edit', 'ratingId'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save rating of organization
     *
     * @param RateOrganizationRequest $request
     * @return void
     */
    public function saveOrganizationRating(RateOrganizationRequest $request)
    {

        try {
            $this->organizationRepository->rateOrganization($request->all());
            session()->flash('organizationRated');
            //check auth user
            if (auth()->check()) {
                return redirect()->route('user.organization.rateOrganizationForm', ['organizationId' => $request->organizationId]);
            } else {
                return redirect()->route('organization.rateOrganizationForm', ['organizationId' => $request->organizationId]);
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save the organization in the saveds table
     *
     * @param Request $request
     * @return void
     */
    public function savedOrganization(Request $request)
    {
        try {
            $message = $this->organizationRepository->savedOrganization($request->savedOrganizationId);
            return response()->json([
                'response' => [
                    'status' => true,
                    'message' => $message,
                ]
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Compare organization Form
     *
     * @param Request $request
     * @param [type] $organizationId
     * @return void
     */
    public function compareOrganizationForm(Request $request, $organizationId)
    {
        try {
            $data = $this->organizationRepository->compareOrganization($organizationId);

            // Check if $data is a RedirectResponse
            if ($data instanceof \Illuminate\Http\RedirectResponse) {
                return $data; // Perform the redirect if necessary
            }

            if ($request->ajax()) {
                return response()->json([
                    'response' => [
                        'status' => true,
                        'data' => $data,
                    ]
                ], JsonResponse::HTTP_OK);
            } else {
                // Fetch additional organization data only if not redirecting
                $organizationCompareListData = $this->organizationRepository->getOrganizationsById($organizationId);

                $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

                if ($userLocation) {
                    $currentLat = $userLocation->latitude;
                    $currentLng = $userLocation->longitude;

                    // Sort organizations by proximity if location is available
                    $organizationCompareList = $organizationCompareListData->map(function ($organization) use ($currentLat, $currentLng) {
                        $organization->distance = $this->distanceService->calculatedDistance(
                            "{$currentLat},{$currentLng}",
                            "{$organization->latitude},{$organization->longitude}",
                            'miles'
                        );
                        return $organization;
                    })->sortBy('distance')->values();
                } else {
                    // Sort organizations by creation date if location is not available
                    $organizationCompareList = $organizationCompareListData->sortByDesc('created_at')->values();
                }


                return view('user.organization.compareOrganization', compact(
                    'data',
                    'organizationCompareList',
                ));
            }
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);

            if ($request->ajax()) {
                return response()->json([
                    'response' => [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]
                ], JsonResponse::HTTP_BAD_REQUEST);
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    /**
     *  Show list organization
     *
     * @param Request $request
     * @return void
     */
    public function listOrganization(Request $request)
    {
        try {
            // Retrieve visitorId from request or session
            $visitorId = $request->visitorId ?? session('visitorId');

            // If visitorId is provided in the request, store it in the session
            if ($request->visitorId) {
                session(['visitorId' => $request->visitorId]);
            }

            if ($request->ajax()) {
                $data = $this->organizationRepository->getOrganizationRatingListByName($request->searchOrganization);
                // Pass the additional data to the view
                $view = view('user.organization.ajaxView.listOrganizationAjaxView', [
                    'organizationRatings' => $data['organizationRatings'],
                    'organizationCount' => $data['count'],
                    'paginatedRatings' => $data['paginatedRatings']
                ])->render();

                return response()->json([
                    'html' => $view,
                    'organizationCount' => $data['count'],
                ]);
            } else {
                $data = $this->organizationRepository->getOrganizationRatingList();
                return view('user.organization.listOrganization')->with([
                    'organizationRatings' => $data['organizationRatings'],
                    'organizationCount' => $data['count'],
                    'paginatedRatings' => $data['paginatedRatings'],
                ]);
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            if ($request->ajax()) {
                return response()->json([
                    'response' => [
                        'status' => 'error',
                        'message' => $e->getMessage(),
                    ]
                ], JsonResponse::HTTP_BAD_REQUEST);
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
