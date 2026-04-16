<?php

namespace App\Http\Controllers\User\Peer;

use Exception;
use ErrorException;
use App\Enums\GenderEnum;
use App\Enums\EthnicityEnum;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Models\CurrentUserLocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Services\DistanceMatrixService;
use App\Http\Requests\User\Peer\AddPeerRequest;
use App\Http\Requests\User\Peer\RatePeerRequest;
use App\Repositories\Interfaces\User\Peer\PeerInterface;
use App\Repositories\Repositories\User\Peer\PeerRepository;
use App\Repositories\Interfaces\User\Department\DepartmentInterface;
use App\Repositories\Repositories\User\Department\DepartmentRepository;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;

class PeerController extends Controller
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
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * The repository instance
     *
     * @var PeerRepository
     */
    private $peerRepository;

    /**
     * The service instance
     *
     * @var DistanceMatrixService
     */
    protected $distanceService;

    /**
     * AuthController Constructor
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationInterface $organizationRepository, PeerInterface $peerRepository, DepartmentInterface $departmentRepository, DistanceMatrixService $distanceService)
    {
        $this->organizationRepository = $organizationRepository;
        $this->peerRepository = $peerRepository;
        $this->departmentRepository = $departmentRepository;
        $this->distanceService = $distanceService;
    }

    /**
     * Add Peer Form
     *
     * @return void
     */

    public function addPeerForm(Request $request, $id = null)
    {
        try {
            $id = $id ?? $request->query('id');
            $organizationsData = $this->organizationRepository->getOrganizations();
            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Sort organizations by proximity if location is available
                $organizations = $organizationsData->map(function ($organization) use ($currentLat, $currentLng) {
                    $organization->distance = $this->distanceService->calculatedDistance(
                        "{$currentLat},{$currentLng}",
                        "{$organization->latitude},{$organization->longitude}",
                        'miles'
                    );
                    return $organization;
                })->sortBy('distance')->values();
            } else {
                // Sort organizations by creation date if location is not available
                $organizations = $organizationsData->sortByDesc('created_at')->values();
            }


            // Check if ID exists and fetch departments if so
            $departments = $id ? $this->departmentRepository->getDepartments($id) : null;

            if ($departments instanceof \Illuminate\Http\RedirectResponse) {
                return $departments;
            }

            // Possible genders
            $genders = [
                GenderEnum::MALE,
                GenderEnum::FEMALE,
                GenderEnum::OTHER,
            ];

            // Possible ethnicities
            $ethnicityStatuses = [
                EthnicityEnum::WHITE,
                EthnicityEnum::BLACK,
                EthnicityEnum::HISPANIC_OR_LATINO,
                EthnicityEnum::MIDDLE_EASTERN,
                EthnicityEnum::AMERICAN_INDIAN_OR_ALASKA_NATIVE,
                EthnicityEnum::ASIAN,
                EthnicityEnum::NATIVE_HAWAIIAN_OR_OTHER_PACIFIC_ISLANDER,
                EthnicityEnum::OTHER,
            ];

            $organizationId = $id;

            // Compacting variables for the view
            $data = compact('organizations', 'genders', 'ethnicityStatuses', 'organizationId');
            if ($departments) {
                $data['departments'] = $departments;
            }

            return view('user.peer.addPeer', $data);
        } catch (Exception $e) {
            dd($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Save Peer Record
     *
     * @param AddPeerRequest $request
     * @return void
     */
    public function savePeer(AddPeerRequest $request)
    {
        try {
            $department = $this->departmentRepository->isValidDepartment($request->organizationId, $request->departmentId);
            if (!($department)) {
                throw new ErrorException(__('messages.error.invalidDepartment'));
            }
            $this->peerRepository->createPeer($request->all());
            session()->flash('peerSaved');
            return redirect()->route('user.peer.addPeerForm', $request->only('organizationId'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Saved the Peer in the User Profile (i.e Saveds Table)
     *
     * @param Request $request
     * @return void
     */
    public function savedPeer(Request $request)
    {
        try {
            $message =  $this->peerRepository->savedPeer($request->savedPeerId);
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
                    'message' => $e->getMessage(),
                ]
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the rate Peer Form
     *
     * @param [type] $peerId
     * @return void
     */
    public function ratePeerForm($peerId, Request $request)
    {
        try {
            $edit = $request->has('edit');
            $ratingId = $request->ratingId;
            $peer = $this->peerRepository->getPeer($peerId);
            if (!$peer) {
                if (Auth::check()) {
                    return redirect()->route('user.peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                } else {
                    return redirect()->route('peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                }
            }
            $overAllRating = $this->peerRepository->getOverAllPeerRating($peerId, $workAgainVariable = true);
            $peerRating = $this->peerRepository->getPeerRating($peerId, $edit, $ratingId);
            $isSavedPeer = $this->peerRepository->isSavedPeer($peerId);

            // Array of possible background colors
            $backgroundColors = ['#B6BC9E', '#F4BC81', '#81BDC3'];

            // Select a random color
            $randomColor = $backgroundColors[array_rand($backgroundColors)];

            return view('user.peer.ratePeer', compact(
                'peer',
                'overAllRating',
                'peerRating',
                'isSavedPeer',
                'randomColor',
                'edit',
                'ratingId'
            ));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            if (Auth::check()) {
                return redirect()->route('user.peer.listPeer')->with('error', $e->getMessage());
            } else {
                return redirect()->route('peer.listPeer')->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Save or Update the Peer Rating
     *
     * @param RatePeerRequest $request
     * @return void
     */
    public function savePeerRating(RatePeerRequest $request)
    {
        try {
            $peerExists = $this->peerRepository->ratePeer($request->all());

            if (!$peerExists) {
                if (auth()->check()) {
                    return redirect()->route('user.peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                } else {
                    return redirect()->route('peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                }
            }

            session()->flash('peerRated');
            if (auth()->check()) {
                return redirect()->route('user.peer.ratePeerForm', ['peerId' => $request->peerId]);
            } else {
                return redirect()->route('peer.ratePeerForm', ['peerId' => $request->peerId]);
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Compare Peer Form And Provide the Compare Peer data Against the Given or Selected Peer
     *
     * @param Request $request
     * @param [type] $peerId
     * @return void
     */
    public function comparePeerForm(Request $request, $peerId)
    {
        try {
            $data = $this->peerRepository->comparePeer($peerId);

            if (!$data) {
                if (Auth::check()) {
                    return redirect()->route('user.peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                } else {
                    return redirect()->route('peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                }
            }
            if ($request->ajax()) {
                return response()->json([
                    'response' => [
                        'status' => true,
                        'data' => $data,
                    ]
                ], JsonResponse::HTTP_OK);
            } else {
                $peerCompareListData = $this->peerRepository->getPeersById($peerId);
                $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

                if ($userLocation) {
                    $currentLat = $userLocation->latitude;
                    $currentLng = $userLocation->longitude;

                    // Sort organizations by proximity if location is available
                    $peerCompareList = $peerCompareListData->map(function ($peer) use ($currentLat, $currentLng) {
                        $organization = Organization::find($peer->organizationId);
                        if ($organization) {
                            $peer->distance = $this->distanceService->calculatedDistance(
                                "{$currentLat},{$currentLng}",
                                "{$organization->latitude},{$organization->longitude}",
                                'miles'
                            );
                        }
                        return $peer;
                    })->sortBy('distance')->values();
                } else {
                    // Sort organizations by creation date if location is not available
                    $peerCompareList = $peerCompareListData->sortByDesc('createdAt')->values();
                }
                return view('user.peer.comparePeer', compact(
                    'data',
                    'peerCompareList'
                ));
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            if ($request->ajax()) {
                return response()->json([
                    'response' => [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]
                ], JsonResponse::HTTP_BAD_REQUEST);
            } else {
                if (Auth::check()) {
                    return redirect()->route('user.peer.listPeer')->with('error', $e->getMessage());
                } else {
                    return redirect()->route('peer.listPeer')->with('error', $e->getMessage());
                }
            }
        }
    }

    /**
     * Get the List of Peer (or Provide All Peer Against the provided organization)
     *
     * @param Request $request
     * @param [type] $organizationId
     * @return void
     */
    public function listPeer(Request $request, $organizationId = null)
    {
        try {
            // Retrieve visitorId from request or session
            $visitorId = $request->visitorId ?? session('visitorId');
            if ($request->visitorId) {
                session(['visitorId' => $request->visitorId]);
            }

            if ($request->ajax()) {
                $data = $this->peerRepository->getPeerListByQuery($request->all());
                // Pass the additional data to the view
                $view =  view(
                    'user.peer.ajaxView.peerDataList',
                    [
                        'peerList' => $data['peerRatings'],
                        'peerCount' => $data['count'],
                        'paginatedRatings' => $data['paginatedRatings'],
                    ]
                )->render();
                return response()->json([
                    'html' => $view,
                    'peerCount' => $data['count'],
                ]);
            } else {
                if ($organizationId != null) {
                    $departments = $this->departmentRepository->getDepartments($organizationId);
                    if ($departments instanceof \Illuminate\Http\RedirectResponse) {
                        return $departments;
                    }
                    $data = $this->peerRepository->getPeerList($organizationId);
                    $peerList = $data['peerRatings'];
                    $peerCount = $data['count'];
                    $paginatedRatings = $data['paginatedRatings'];
                } else {
                    $data = $this->peerRepository->getPeerList();
                    $peerList = $data['peerRatings'];
                    $peerCount = $data['count'];
                    $paginatedRatings = $data['paginatedRatings'];
                    $departments = [];
                }
                $organizationsData = $this->organizationRepository->getOrganizations();
                $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

                if ($userLocation) {
                    $currentLat = $userLocation->latitude;
                    $currentLng = $userLocation->longitude;

                    // Sort organizations by proximity if location is available
                    $organizations = $organizationsData->map(function ($organization) use ($currentLat, $currentLng) {
                        $organization->distance = $this->distanceService->calculatedDistance(
                            "{$currentLat},{$currentLng}",
                            "{$organization->latitude},{$organization->longitude}",
                            'miles'
                        );
                        return $organization;
                    })->sortBy('distance')->values();
                } else {
                    // Sort organizations by creation date if location is not available
                    $organizations = $organizationsData->sortByDesc('created_at')->values();
                }


                if ($organizations instanceof \Illuminate\Http\RedirectResponse) {
                    return $organizations;
                }
                $allOrganizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->orderBy('name', 'asc')->get();
                return view('user.peer.listPeer', compact('organizationId', 'organizations', 'peerList', 'peerCount', 'paginatedRatings', 'departments', 'allOrganizations'));
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
