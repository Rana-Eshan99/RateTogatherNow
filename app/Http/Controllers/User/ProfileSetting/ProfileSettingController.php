<?php

namespace App\Http\Controllers\User\ProfileSetting;

use Exception;
use ErrorException;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\User\Peer\PeerInterface;
use App\Http\Requests\User\ProfileSetting\ProfileUpdateRequest;
use App\Repositories\Interfaces\User\Department\DepartmentInterface;
use App\Repositories\Repositories\User\Department\DepartmentRepository;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;
use App\Repositories\Interfaces\User\ProfileSetting\ProfileSettingInterface;
use App\Repositories\Repositories\User\ProfileSetting\ProfileSettingRepository;

class ProfileSettingController extends Controller
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
     * @var ProfileSettingRepository
     */
    private $profileSettingRepository;

    /**
     * The repository instance
     *
     * @var PeerRepository
     */
    private $peerRepository;

    /**
     * ProfileController Constructor
     *
     * @param OrganizationRepository $organizationRepository
     * @param DepartmentRepository $departmentRepository
     * @param ProfileSettingRepository $profileSettingRepository
     */
    public function __construct(
        DepartmentInterface $departmentRepository,
        OrganizationInterface $organizationRepository,
        ProfileSettingInterface $profileSettingRepository, PeerInterface $peerRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->organizationRepository = $organizationRepository;
        $this->profileSettingRepository = $profileSettingRepository;
        $this->peerRepository = $peerRepository;
    }

    /**
     * Profile Setting Form
     *
     * @return void
     */
    public function profileSettingForm(Request $request)
    {
        try {
            if ($request->ajax()) {
                if ($request->requestType == "myOrganizationRating") {
                    $dataOrganizationRated = $this->organizationRepository->getUserRatedOrganizationsByName($request->searchMyOrganizationRating);

                    // Pass the additional data to the view
                    $viewOrganizationRating = view('user.profileSetting.tabs.ratings.organizationRating', [
                        'dataOrganizationRated' => $dataOrganizationRated,
                    ])->render();

                    return response()->json([
                        'html' => $viewOrganizationRating,
                    ]);
                } else if ($request->requestType == "myPeerRating") {
                    $dataPeerRated = $this->peerRepository->getUserRatedPeersByName($request->searchMyOrganizationRating);

                    // Pass the additional data to the view
                    $viewPeerRating = view('user.profileSetting.tabs.ratings.peerRating', [
                        'dataPeerRated' => $dataPeerRated,
                    ])->render();

                    return response()->json([
                        'html' => $viewPeerRating,
                    ]);
                } else if ($request->requestType == "savedsOrganization") {
                    $data = $this->organizationRepository->getUserSavedsOrganizationsByName($request->searchSavedsOrganization);
                    // Pass the additional data to the view
                    $view = view('user.profileSetting.tabs.savedOrganization.savedsOrganization', [
                        'userSavedsOrganizations' => $data,
                    ])->render();

                    return response()->json([
                        'html' => $view,
                        'organizationCount' => $data['count'],
                    ]);
                } else if ($request->requestType == "savedsPeer") {
                    $data = $this->peerRepository->getUserSavedsPeersByName($request->searchSavedPeer);
                    // Pass the additional data to the view
                    $view = view('user.profileSetting.tabs.savedPeer.savedsPeer', [
                        'userSavedsPeers' => $data,
                    ])->render();

                    return response()->json([
                        'html' => $view,
                        'savedPeerCount' => $data['count'],
                    ]);
                } else {
                    throw new ErrorException(__('messages.error.invalidRequest'));
                }
            } else {
                $dataOrganizationRated = $this->organizationRepository->getUserRatedOrganizations();
                $dataPeerRated = $this->peerRepository->getUserRatedPeers();
                $userSavedsPeers =  $this->peerRepository->getUserSavedsPeers();
                $organizations = $this->organizationRepository->getOrganizations();
                $userOrganizationId = Auth::user()->organizationId;
                if (empty($userOrganizationId)) {
                    $departments = [];
                } else {
                    $departments = $this->departmentRepository->getDepartments($userOrganizationId);
                }
                $userSavedsOrganizations = $this->organizationRepository->getUserSavedsOrganizations();
                $departmentName = Auth::user()->departmentName;
                return view(
                    'user.profileSetting.index',
                    compact(
                        'organizations',
                        'departments',
                        'userSavedsOrganizations',
                        'userSavedsPeers',
                        'dataPeerRated',
                        'dataOrganizationRated',
                        'departmentName'
                    )
                );
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

    /**
     * Update the User Profile
     *
     * @param ProfileUpdateRequest $request
     * @return void
     */
    public function update(ProfileUpdateRequest $request)
    {
        try {
            $this->profileSettingRepository->updateProfile($request->all());
            return redirect()->route('user.profileSetting.profileSettingForm')->with('success', __('messages.success.profileUpdated'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Un-Save the Organization from User's Profile
     *
     * @param Request $request
     * @return void
     */
    public function unSaveOrganization(Request $request)
    {
        try {
            // Check that given organization should be valid and saveds.
            $saved = $this->organizationRepository->isSavedOrganization($request->savedOrganizationId);
            if ($saved == true) {
                // Un-Saved the organization
                $message = $this->organizationRepository->savedOrganization($request->savedOrganizationId);

                // Get the Remaining saveds organization with the applied filters.
                $data = $this->organizationRepository->getUserSavedsOrganizationsByName($request->searchSavedOrganizationFilter);

                // Pass the additional data to the view
                $view = view('user.profileSetting.tabs.savedOrganization.savedsOrganization', [
                    'userSavedsOrganizations' => $data,
                ])->render();

                // Send the response
                return response()->json([
                    'response' => [
                        'status' => true,
                        'message' => $message,
                        'html' => $view,
                        'organizationCount' => $data['count'],
                    ]
                ], JsonResponse::HTTP_OK);
            } else {
                throw new ErrorException(__('messages.error.invalidOrganization'));
            }
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
     * Un-Save the Peer from User's Profile
     *
     * @param Request $request
     * @return void
     */
    public function unSavePeer(Request $request)
    {
        try {
            // Check that given peer should be valid and saveds.
            $saved = $this->peerRepository->isSavedPeer($request->savedPeerId);
            if ($saved == true) {
                // Un-saved the peer
                $message = $this->peerRepository->savedPeer($request->savedPeerId);

                // Get the Remaining saveds peer with the applied filters.
                $data =  $this->peerRepository->getUserSavedsPeersByName($request->searchSavedPeerFilter);

                // Pass the additional data to the view
                $view = view('user.profileSetting.tabs.savedPeer.savedsPeer', [
                    'userSavedsPeers' => $data,
                ])->render();

                // Send the response
                return response()->json([
                    'response' => [
                        'status' => true,
                        'message' => $message,
                        'html' => $view,
                        'savedPeerCount' => $data['count'],
                    ]
                ], JsonResponse::HTTP_OK);
            } else {
                throw new ErrorException(__('messages.error.invalidPeer'));
            }
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
}
