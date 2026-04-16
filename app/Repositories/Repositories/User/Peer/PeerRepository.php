<?php

namespace App\Repositories\Repositories\User\Peer;

use ErrorException;
use App\Models\Peer;
use App\Models\Saved;
use App\Models\Helpful;
use App\Models\PeerRating;
use App\Models\Organization;
use App\Models\ReportRating;
use App\Enums\PeerStatusEnum;
use App\Traits\ThousandIntoKTrait;
use Illuminate\Support\Facades\DB;
use App\Enums\PeerRatingStatusEnum;
use App\Models\CurrentUserLocation;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Services\DistanceMatrixService;
use App\Repositories\Interfaces\User\Peer\PeerInterface;

class PeerRepository implements PeerInterface
{
    /**
     * Show Rating in unit of K's (e.g 1K,2K)
     */
    use ThousandIntoKTrait;

    /**
     * workAgainRating variable
     *
     * @var boolean
     */
    protected $workAgainRating = false;

    /**
     * toComparePeer variable
     *
     * @return void
     */
    protected $toComparePeer = false;

    /**
     * Distance Service
     *
     * @var DistanceMatrixService
     */
    protected $distanceService;
    public function __construct(DistanceMatrixService $distanceService)
    {
        $this->distanceService = $distanceService;
    }

    /**
     * Get Approved Peer by peerId
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeer($peerId)
    {
        try {
            $peer = Peer::where(['id' => $peerId, 'status' => PeerStatusEnum::APPROVED])->first();
            if (!($peer)) {
                throw new \ErrorException(__('messages.error.invalidPeer'));
            }
            return $peer;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get All Approved Peers
     *
     * @return void
     */
    public function getPeers()
    {
        try {
            $peers = Peer::where('status', PeerStatusEnum::APPROVED)->orderBy('firstName', 'asc')->get();
            return $peers;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get All Approved Peers by Id
     *
     * @return void
     */
    public function getPeersById($peerId)
    {
        try {
            $peers = Peer::where('status', PeerStatusEnum::APPROVED)
                ->where('id', '!=', $peerId)
                ->orderBy('firstName', 'asc')
                ->get();
            return $peers;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get status Peer is saved or not.
     *
     * @param [type] $peerId
     * @return boolean
     */
    public function isSavedPeer($peerId)
    {
        try {
            $this->getPeer($peerId);
            $savedPeer = false;

            if (Auth::check()) {
                $saved = Saved::where(['peerId' => $peerId, 'userId' => Auth::user()->id])->first();
                if ($saved) {
                    $savedPeer = true;
                }
            }

            return $savedPeer;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Saved the peer in User Profile
     *
     * @param [type] $peerId
     * @return void
     */
    public function savedPeer($peerId)
    {
        try {
            DB::beginTransaction();
            $this->getPeer($peerId);

            $savedPeer = Saved::where(['peerId' => $peerId, 'userId' => Auth::user()->id])->first();
            if (!$savedPeer) {
                // Record doesn't exist save the record in the table.
                $savedData = [
                    'userId' => Auth::user()->id,
                    'peerId' => $peerId,
                ];
                Saved::create($savedData);
                $message = __('messages.success.savedPeer');
            } else {
                // Record exist Un save the record in the table.
                $savedPeer->delete();
                $message = __('messages.success.unSavedPeer');
            }

            DB::commit();
            return $message;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Create Peer
     *
     * @param array $data
     * @return void
     */
    public function createPeer(array $data)
    {
        try {
            DB::beginTransaction();

            // Query to check for existing peers with identical profiles
            $existingPeer = Peer::where('organizationId', $data['organizationId'])
                ->where('departmentId', $data['departmentId'])
                ->where('firstName', $data['firstName'])
                ->where('lastName', $data['lastName'])
                ->where('gender', $data['gender'])
                ->where('ethnicity', $data['ethnicity'])
                ->where('jobTitle', $data['jobTitle'])
                ->where('status', '!=', 'REJECTED')
                ->first();

            // Throw an exception if a duplicate peer exists
            if ($existingPeer) {
                throw new \Exception('A peer with an identical profile already exists. At least one attribute must be different.');
            }

            $userId = auth()->check() ? auth()->user()->id : null;

            // Create the new peer
            Peer::create([
                'userId' => $userId,
                'organizationId' => $data['organizationId'],
                'departmentId' => $data['departmentId'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'gender' => $data['gender'],
                'ethnicity' => $data['ethnicity'],
                'jobTitle' => $data['jobTitle'],
                'image' => "upload/peer/abc.png",
                'status' => PeerStatusEnum::NEED_APPROVAL,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get Peer Rating  by User (Using peerId and userId)
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeerRating($peerId, $edit = false, $ratingId)
    {
        try {
            $this->getPeer($peerId);

            if ($edit) {
                if (Auth::check()) {
                    // Fetch the peer rating for the authenticated user
                    $peerRating = PeerRating::where([
                        'peerId' => $peerId,
                        'userId' => Auth::user()->id,
                        'id' => $ratingId
                    ])->first();
                } else {
                    $guestId = session('visitorId');
                    // Fetch the peer rating for a guest
                    $peerRating = PeerRating::where([
                        'peerId' => $peerId,
                        'userId' => null,
                        'deviceIdentifier' => $guestId,
                        'id' => $ratingId,
                    ])->first();
                }
            } else {
                // If the 'EDIT' parameter is not provided, return null or handle it differently
                $peerRating = null;
            }

            return $peerRating;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
    /**
     * Rate the Peer (Save or Update the rating)
     *
     * @param array $data
     * @return void
     */
    public function ratePeer(array $data)
    {
        try {
            DB::beginTransaction();

            $guestId = session('visitorId');
            $userId = auth()->check() ? auth()->user()->id : null;
            $peerId = $data['peerId'];
            $edit = isset($data['edit']) && $data['edit'] == 1; // Check if 'edit' is passed

            $this->getPeer($peerId); // Ensure the peer exists

            if (!$peerId) {
                if (Auth::check()) {
                    return redirect()->route('user.peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                } else {
                    return redirect()->route('peer.listPeer')->with('error', __('messages.error.invalidPeer'));
                }
            }

            $organizationId = Peer::where('id', $peerId)->value('organizationId');

            $ratingData = [
                'userId' => $userId,
                'organizationId' => $organizationId,
                'peerId' => $peerId,
                'easyWork' => $data['easyWork'],
                'workAgain' => $data['workAgain'],
                'dependableWork' => $data['dependableWork'],
                'communicateUnderPressure' => $data['communicateUnderPressure'],
                'meetDeadline' => $data['meetDeadline'],
                'receivingFeedback' => $data['receivingFeedback'],
                'respectfullOther' => $data['respectfullOther'],
                'assistOther' => $data['assistOther'],
                'collaborateTeam' => $data['collaborateTeam'],
                'experience' => $data['experience'],
            ];

            // Add device identifier for guest users
            if (!$userId) {
                $ratingData['deviceIdentifier'] = $guestId;
            }

            // Check if a rating already exists for this peer
            $peerRating = PeerRating::where([
                'userId' => $userId ?: null,
                'peerId' => $peerId,
                'deviceIdentifier' => $userId ? null : $guestId,
                'id' => $data['ratingId'],
            ])->first();
            if ($edit && $peerRating) {
                // Update the existing rating if 'edit' is true
                $peerRating->update(array_merge($ratingData, ['status' => PeerRatingStatusEnum::NEED_APPROVAL]));
            } else {
                // Create a new rating if no existing one found
                PeerRating::create($ratingData);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get overall peer rating by peerId
     *
     * @param mixed $peerId
     * @param mixed|null $workAgainVariable
     * @return mixed
     */
    public function getOverAllPeerRating($peerId, $workAgainVariable = false)
    {

        try {
            $peerRatings = PeerRating::where('peerId', $peerId)
                ->where('status', PeerRatingStatusEnum::APPROVED)
                ->get();

            $easyWorkOverAllRating = "0";
            $workAgainOverAllRating = 0;
            $dependableWorkOverAllRating = "0.0";
            $communicateUnderPressureOverAllRating = "0.0";
            $meetDeadlineOverAllRating = "0.0";
            $receivingFeedbackOverAllRating = "0.0";
            $respectfullOtherOverAllRating = "0.0";
            $assistOtherOverAllRating = "0.0";
            $collaborateTeamOverAllRating = "0.0";
            $overAllRating = "0.0";
            if (!($peerRatings->isEmpty())) {
                $easyWorkOverAllRating = number_format($peerRatings->avg('easyWork'), 1);
                $workAgainOverAllRating = number_format($peerRatings->avg('workAgain'), 1);
                $dependableWorkOverAllRating = number_format($peerRatings->avg('dependableWork'), 1);
                $communicateUnderPressureOverAllRating = number_format($peerRatings->avg('communicateUnderPressure'), 1);
                $meetDeadlineOverAllRating = number_format($peerRatings->avg('meetDeadline'), 1);
                $receivingFeedbackOverAllRating = number_format($peerRatings->avg('receivingFeedback'), 1);
                $respectfullOtherOverAllRating = number_format($peerRatings->avg('respectfullOther'), 1);
                $assistOtherOverAllRating = number_format($peerRatings->avg('assistOther'), 1);
                $collaborateTeamOverAllRating = number_format($peerRatings->avg('collaborateTeam'), 1);
                $overAllRating = number_format((
                    $easyWorkOverAllRating +
                    $dependableWorkOverAllRating +
                    $communicateUnderPressureOverAllRating +
                    $meetDeadlineOverAllRating +
                    $receivingFeedbackOverAllRating  +
                    $respectfullOtherOverAllRating +
                    $assistOtherOverAllRating    +
                    $collaborateTeamOverAllRating
                ) / 8, 1);

                $peerRatingStats = PeerRating::where('peerId', $peerId)
                    ->where('status', PeerRatingStatusEnum::APPROVED)
                    ->selectRaw('
                                COUNT(*) as totalResponses,
                                SUM(workAgain = 1) as totalYes,
                                SUM(workAgain = 0) as totalNo
              ')->first();

                $totalResponses = $peerRatingStats->totalResponses;
                $totalYes = $peerRatingStats->totalYes;
                $totalNo = $peerRatingStats->totalNo;

                $workAgainYesPercentage = number_format($totalResponses > 0 ? ($totalYes / $totalResponses) * 100 : 0);
                $workAgainNoPercentage = number_format($totalResponses > 0 ? ($totalNo / $totalResponses) * 100 : 0);
            }

            if ($this->workAgainRating == true || $workAgainVariable == true) {
                if ($overAllRating == "0.0") {
                    $workAgainYesPercentage = 0;
                    $workAgainNoPercentage = 0;
                }
                $data = [
                    'overAllRating' => $overAllRating,
                    'workAgainYesPercentage' => $workAgainYesPercentage,
                    'workAgainNoPercentage' => $workAgainNoPercentage,
                ];
                $this->workAgainRating = false;
            } else if ($this->toComparePeer == true) {
                if ($overAllRating == "0.0") {
                    $workAgainYesPercentage = 0;
                    $workAgainNoPercentage = 0;
                }
                $data = [
                    'easyWorkRating' => $easyWorkOverAllRating,
                    'dependableWorkRating' => $dependableWorkOverAllRating,
                    'communicateUnderPressureRating' => $communicateUnderPressureOverAllRating,
                    'meetDeadlineRating' => $meetDeadlineOverAllRating,
                    'receivingFeedbackRating' => $receivingFeedbackOverAllRating,
                    'respectfullOtherRating' => $respectfullOtherOverAllRating,
                    'assistOtherRating' => $assistOtherOverAllRating,
                    'collaborateTeamRating' => $collaborateTeamOverAllRating,
                    'overAllRating' => $overAllRating,
                    'workAgainYesPercentage' => $workAgainYesPercentage,
                    'workAgainNoPercentage' => $workAgainNoPercentage,
                ];

                $this->toComparePeer = false;
            } else {
                $data = $overAllRating;
            }

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get User's All Saveds Peers
     *
     * @return void
     */
    public function getUserSavedsPeers()
    {
        try {
            // Fetch saved peer IDs in the order they were saved (latest first)
            $savedPeers = Saved::where('userId', Auth::user()->id)
                ->whereNotNull('peerId')
                ->latest() // Order by latest 'Saved' records
                ->pluck('peerId');

            // Fetch peer matching those IDs, ordered by 'Saved' record order
            $approvedSavedPeers = Peer::whereIn('id', $savedPeers)
                ->where('status', PeerStatusEnum::APPROVED)
                ->orderByRaw("FIELD(id, " . $savedPeers->implode(',') . ")") // Maintain the order of 'Saved' records
                ->paginate(9);

            $count = Peer::whereIn('id', $savedPeers)->where('status', PeerStatusEnum::APPROVED)->count();

            $data = $this->getSavedPeerData($count, $approvedSavedPeers);
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get User's All Saveds Peers by Name and Job Title
     *
     * @param [type] $peerName_jobTitle
     * @return void
     */
    public function getUserSavedsPeersByName($peerName_jobTitle)
    {
        try {
            // Fetch saved peer IDs in the order they were saved (latest first)
            $savedPeers = Saved::where('userId', Auth::user()->id)
                ->whereNotNull('peerId')
                ->latest() // Order by latest 'Saved' records
                ->pluck('peerId');

            $approvedSavedPeers = Peer::whereIn('id', $savedPeers)
                ->where(function ($query) use ($peerName_jobTitle) {
                    $query->where('firstName', 'LIKE', '%' . $peerName_jobTitle . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $peerName_jobTitle . '%')
                        ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $peerName_jobTitle . '%') // Full name search
                        ->orWhere('jobTitle', 'LIKE', '%' . $peerName_jobTitle . '%');
                })
                ->where('status', PeerStatusEnum::APPROVED)
                ->orderByRaw("FIELD(id, " . $savedPeers->implode(',') . ")") // Maintain the order of 'Saved' records
                ->paginate(9);


            $count = Peer::whereIn('id', $savedPeers)
                ->where(function ($query) use ($peerName_jobTitle) {
                    $query->where('firstName', 'LIKE', '%' . $peerName_jobTitle . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $peerName_jobTitle . '%')
                        ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $peerName_jobTitle . '%') // Full name search
                        ->orWhere('jobTitle', 'LIKE', '%' . $peerName_jobTitle . '%');
                })
                ->where('status', PeerStatusEnum::APPROVED)
                ->count();


            $data = $this->getSavedPeerData($count, $approvedSavedPeers);

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Return the Saved Peer Data of the User
     *
     * @param [type] $count
     * @param [type] $approvedSavedPeers
     * @return void
     */
    protected function getSavedPeerData($count, $approvedSavedPeers)
    {
        try {
            $peerRatings = [];
            if ($count > 0) {
                $count = $count . ($count > 1 ? " Saved Peers" : " Saved Peer");
                foreach ($approvedSavedPeers as $peer) {
                    $this->workAgainRating = true;
                    $peerRating = $this->getOverAllPeerRating($peer->id);

                    $peerRatings[$peer->id] = [
                        'peer' => $peer,
                        'overAllRating' => $peerRating['overAllRating'],
                        'workAgainYesPercentage' => $peerRating['workAgainYesPercentage'],
                        'workAgainNoPercentage' => $peerRating['workAgainNoPercentage'],
                    ];
                }
                // Create a new LengthAwarePaginator for the modified data
                $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $peerRatings,
                    $approvedSavedPeers->total(),
                    $approvedSavedPeers->perPage(),
                    $approvedSavedPeers->currentPage(),
                    ['path' => route('user.profileSetting.profileSettingForm')]
                );
                $data = [
                    'peerRatings' => $peerRatings,
                    'count' => $count,
                    'paginatedRatings' => $paginatedRatings,
                ];
            } else {
                $data = [
                    'peerRatings' => [],
                    'count' => "Saved Peer",
                    'paginatedRatings' => [],
                ];
            }
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get Peer Rating Given by the Logged-in user
     *
     * @return void
     */
    public function getUserRatedPeers()
    {
        try {
            $peerRatings = PeerRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->whereHas('peer', function ($query) {
                    $query->where('status', PeerStatusEnum::APPROVED);
                })
                ->with('peer')
                ->where(function ($query) {
                    $query->where('status', PeerRatingStatusEnum::APPROVED)
                        ->orWhere('status', PeerRatingStatusEnum::NEED_APPROVAL);
                })
                ->latest('updatedAt')
                ->paginate(3);

            $count = PeerRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->whereHas('peer', function ($query) {
                    $query->where('status', PeerStatusEnum::APPROVED);
                })
                ->where(function ($query) {
                    $query->where('status', PeerRatingStatusEnum::APPROVED)
                        ->orWhere('status', PeerRatingStatusEnum::NEED_APPROVAL);
                })
                ->count();

            $data = $this->getRatedPeerData($count, $peerRatings);

            // Return the structured data
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get User's peer-Rating by using like operator from peer first name or last Name  or jobTitle
     *
     * @param [type] $peerName_jobTitle
     * @return void
     */
    public function getUserRatedPeersByName($peerName_jobTitle)
    {
        try {
            // Retrieve the PeerRating for the authenticated user
            $peerRatings = PeerRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->whereHas('peer', function ($query) use ($peerName_jobTitle) {
                    $query->where('status', PeerStatusEnum::APPROVED)
                        ->where(function ($query) use ($peerName_jobTitle) {
                            $query->where('firstName', 'LIKE', '%' . $peerName_jobTitle . '%')
                                ->orWhere('lastName', 'LIKE', '%' . $peerName_jobTitle . '%')
                                ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $peerName_jobTitle . '%') // Full name search
                                ->orWhere('jobTitle', 'LIKE', '%' . $peerName_jobTitle . '%');
                        });
                })
                ->where(function ($query) {
                    $query->where('status', PeerRatingStatusEnum::APPROVED)
                        ->orWhere('status', PeerRatingStatusEnum::NEED_APPROVAL);
                })
                ->latest('updatedAt')
                ->paginate(3);


            $count = PeerRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->whereHas('peer', function ($query) use ($peerName_jobTitle) {
                    $query->where('status', PeerStatusEnum::APPROVED)
                        ->where(function ($query) use ($peerName_jobTitle) {
                            $query->where('firstName', 'LIKE', '%' . $peerName_jobTitle . '%')
                                ->orWhere('lastName', 'LIKE', '%' . $peerName_jobTitle . '%')
                                ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $peerName_jobTitle . '%') // Full name search
                                ->orWhere('jobTitle', 'LIKE', '%' . $peerName_jobTitle . '%');
                        });
                })
                ->where(function ($query) {
                    $query->where('status', PeerRatingStatusEnum::APPROVED)
                        ->orWhere('status', PeerRatingStatusEnum::NEED_APPROVAL);
                })
                ->count();


            $data = $this->getRatedPeerData($count, $peerRatings);

            // Return the structured data
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Return the Rated Peer Data of the User in Profile Setting
     *
     * @param [type] $count
     * @param [type] $peerRatings
     * @return void
     */
    public function getRatedPeerData($count, $peerRatings)
    {
        try {
            $peerRatingsData = [];

            if ($count > 0) {
                foreach ($peerRatings as $peerRating) {
                    $peerOverAllRating = $this->getOverAllPeerRating($peerRating->peerId);
                    $peer = $peerRating->peer;

                    // Add the rating data to the peer ratings data array
                    $peerRatingsData[] = [
                        'peer' => $peer,
                        'peerRating' => $peerRating,
                        'overAllRating' => $peerOverAllRating,
                    ];
                }

                $count = $count . ($count > 1 ? " Peers Rating" : " Peer Rating");

                // Create a new LengthAwarePaginator for the modified data
                $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $peerRatingsData,
                    $peerRatings->total(),
                    $peerRatings->perPage(),
                    $peerRatings->currentPage(),
                    ['path' => route('user.profileSetting.profileSettingForm')]
                );

                $data = [
                    'peers' => $peerRatingsData,
                    'count' => $count,
                    'paginatedRatings' => $paginatedRatings,
                ];
            } else {
                $data = [
                    'peers' => [],
                    'count' => "Peer Rating",
                    'paginatedRatings' => [],
                ];
            }
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get Peer data to Compare Peer with each other
     *
     * @param [type] $peerId
     * @return void
     */
    public function comparePeer($peerId)
    {
        try {
            $peer = $this->getPeer($peerId);
            $this->toComparePeer = true;
            $data = $this->getOverAllPeerRating($peerId);
            $data['peerFullName'] = $peer->getPeerFullNameAttribute();
            $data['id'] = $peer['id'];

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get all approved Peer List with Rating also get All Approved Peer List of the Given Organization
     *
     * @param string $organizationId
     * @return void
     */
    public function getPeerList($organizationId = null)
    {
        try {
            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            // Query for peers with an optional organization filter
            $query = Peer::where('status', PeerStatusEnum::APPROVED);
            if ($organizationId !== null) {
                $query->where('organizationId', $organizationId);
            }

            // Preload peers
            $peers = $query->latest()->get();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Add distance to each peer and sort by distance from user's location
                $filteredPeers = $peers->map(function ($peer) use ($currentLat, $currentLng) {
                    $organization = Organization::find($peer->organizationId);
                    if ($organization) {
                        $peer->distance = $this->distanceService->calculatedDistance(
                            "{$currentLat},{$currentLng}",
                            "{$organization->latitude},{$organization->longitude}",
                            'miles'
                        );
                    }
                    return $peer;
                })->sortBy('distance')->values();  // Sorting by distance without a 25-mile filter
            } else {
                // Fallback sorting when location is unavailable
                $filteredPeers = $peers->values();
            }


            $perPage = 9;
            $page = request()->input('page', 1);
            $paginatedResults = $filteredPeers->slice(($page - 1) * $perPage, $perPage);
            $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedResults,
                $filteredPeers->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $peerRatings = [];
            foreach ($paginatedRatings as $peer) {
                $this->workAgainRating = true;
                $peerRating = $this->getOverAllPeerRating($peer->id);
                $savedStatus = $this->isSavedPeer($peer->id);
                $peerData = $peer->toArray();
                $peerData['peerFullName'] = $peer->getPeerFullNameAttribute();
                $peerData['peerInitials'] = $peer->getPeerInitialsAttribute();
                $peerData['organizationName'] = $peer->organization->name ?? 'N/A';

                $peerRatings[$peer->id] = [
                    'peerData' => $peerData,
                    'overAllRating' => $peerRating['overAllRating'],
                    'workAgainYesPercentage' => $peerRating['workAgainYesPercentage'],
                    'workAgainNoPercentage' => $peerRating['workAgainNoPercentage'],
                    'saved' => $savedStatus,
                ];
            }

            $data = [
                'peerRatings' => $peerRatings,
                'count' => $filteredPeers->count() . ($filteredPeers->count() > 1 ? " Peers" : " Peer"),
                'paginatedRatings' => $paginatedRatings,
            ];

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get all approved Peer List with Rating by using the given query
     *
     * @param [type] $queryToSearch
     * @return void
     */
    public function getPeerListByQuery($queryToSearch)
    {
        try {
            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            // Query to search for peers based on the provided criteria
            $peers = Peer::where(function ($query) use ($queryToSearch) {
                $peerName_jobTitle = $queryToSearch['searchPeer'] ?? null;
                $searchOrganizationId = $queryToSearch['organizationId'] ?? null;
                $searchDepartmentId = $queryToSearch['departmentId'] ?? null;

                if ($peerName_jobTitle) {
                    $query->where(function ($query) use ($peerName_jobTitle) {
                        $query->where('firstName', 'LIKE', '%' . $peerName_jobTitle . '%')
                            ->orWhere('lastName', 'LIKE', '%' . $peerName_jobTitle . '%')
                            ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $peerName_jobTitle . '%') // Full name search
                            ->orWhere('jobTitle', 'LIKE', '%' . $peerName_jobTitle . '%');
                    });
                }


                if ($searchOrganizationId) {
                    $query->where('organizationId', $searchOrganizationId);

                    if ($searchDepartmentId) {
                        $query->where('departmentId', $searchDepartmentId);
                    }
                }
            })
                ->where('status', PeerStatusEnum::APPROVED)
                ->latest()
                ->get();

            if ($userLocation) {
                // If location is available, retrieve the latitude and longitude
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Retrieve peers and add distance
                $filteredPeers = $peers->filter(function ($peer) use ($currentLat, $currentLng) {
                    $organization = Organization::find($peer->organizationId);
                    if ($organization) {
                        $peer->distance = $this->distanceService->calculatedDistance(
                            "{$currentLat},{$currentLng}",
                            "{$organization->latitude},{$organization->longitude}",
                            'miles'
                        );
                    }
                    return $peer;
                })->sortBy('distance')->values(); // Sort by distance from the user's location
            } else {
                // If location is not available, retrieve peers sorted by latest
                $filteredPeers = $peers->values();
            }

            // Paginate the filtered results
            $perPage = 9;
            $page = request()->input('page', 1);
            $paginatedResults = $filteredPeers->slice(($page - 1) * $perPage, $perPage);
            $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedResults,
                $filteredPeers->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $peerRatings = [];
            foreach ($paginatedRatings as $peer) {
                $this->workAgainRating = true;
                $peerRating = $this->getOverAllPeerRating($peer->id);
                $savedStatus = $this->isSavedPeer($peer->id);
                $peerData = $peer->toArray();
                $peerData['peerFullName'] = $peer->getPeerFullNameAttribute();
                $peerData['peerInitials'] = $peer->getPeerInitialsAttribute();
                $peerData['organizationName'] = $peer->organization->name ?? 'N/A';

                $peerRatings[$peer->id] = [
                    'peerData' => $peerData,
                    'overAllRating' => $peerRating['overAllRating'],
                    'workAgainYesPercentage' => $peerRating['workAgainYesPercentage'],
                    'workAgainNoPercentage' => $peerRating['workAgainNoPercentage'],
                    'saved' => $savedStatus,
                ];
            }

            $data = [
                'peerRatings' => $peerRatings,
                'count' => $filteredPeers->count() . ($filteredPeers->count() > 1 ? " Peers" : " Peer"),
                'paginatedRatings' => $paginatedRatings,
            ];

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /** Get Peer Details by id (Home Page)
     *
     * @param [type] $id
     * @param [type] $request
     * @return void
     */
    public function getPeerByIdDetail($id, $request)
    {
        try {
            $peer = Peer::where('id', $id)->first();
            if (!$peer) {
                throw new \ErrorException(__('messages.error.invalidPeer'));
            }
            $organizationId = $peer->organizationId;
            $organization = Organization::where('id', $organizationId)->first();
            $peer->organization = $organization->name;

            $peerData = PeerRating::where('peerId', $id)->where('status', PeerRatingStatusEnum::APPROVED)->get();
            $easyWork = $peerData->avg('easyWork');
            $dependableWork = $peerData->avg('dependableWork');
            $communicateUnderPressure = $peerData->avg('communicateUnderPressure');
            $meetDeadline = $peerData->avg('meetDeadline');
            $receivingFeedback = $peerData->avg('receivingFeedback');
            $respectfullOther = $peerData->avg('respectfullOther');
            $assistOther = $peerData->avg('assistOther');
            $collaborateTeam = $peerData->avg('collaborateTeam');

            // Ensure all ratings are rounded to one decimal place
            $easyWork = round($easyWork, 1);
            $dependableWork = round($dependableWork, 1);
            $communicateUnderPressure = round($communicateUnderPressure, 1);
            $meetDeadline = round($meetDeadline, 1);
            $receivingFeedback = round($receivingFeedback, 1);
            $respectfullOther = round($respectfullOther, 1);
            $assistOther = round($assistOther, 1);
            $collaborateTeam = round($collaborateTeam, 1);
            
            // Calculate the overall rating
            $overAllRating = (
                $easyWork +
                $dependableWork +
                $communicateUnderPressure +
                $meetDeadline +
                $receivingFeedback +
                $respectfullOther +
                $assistOther +
                $collaborateTeam
            ) / 8;
            
            // Format the overall rating to one decimal place
            $formattedOverAllRating = round($overAllRating, 1);

            $totalYes = PeerRating::where('peerId', $id)
                ->where('status', PeerRatingStatusEnum::APPROVED)
                ->where('workAgain', 1)
                ->count();

            $totalNo = PeerRating::where('peerId', $id)
                ->where('status', PeerRatingStatusEnum::APPROVED)
                ->where('workAgain', 0)
                ->count();

            $totalResponses = PeerRating::where('peerId', $id)
                ->where('status', PeerRatingStatusEnum::APPROVED)
                ->count();

            $yesPercentage = $totalResponses > 0 ? ($totalYes / $totalResponses) * 100 : 0;
            $noPercentage = $totalResponses > 0 ? ($totalNo / $totalResponses) * 100 : 0;
            $color = $yesPercentage < 50 ? '#FF0000' : '#11951E';

            $data = [
                'peer' => $peer,
                'formattedOverAllRating' => $formattedOverAllRating,
                'yesPercentage' => $yesPercentage,
                'noPercentage' => $noPercentage,
                'color' => $color,
                'peerRating' => $peerData,
                'totalResponses' => $totalResponses
            ];
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get the Peer Rating with Report_Rating and Helpful
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeerRating_Report_Helpful($peerId)
    {
        try {
            // Now retrieve it from session to verify it's stored correctly
            $guestId = session('visitorId');
            // Get Peer Rating (Latest on the basis of Updated At)
            $userId = Auth::check() ? Auth::user()->id : $guestId; // Check if the user is authenticated
            $usersRating = PeerRating::where('peerId', $peerId)
                ->where('status', PeerRatingStatusEnum::APPROVED)
                ->latest('updatedAt')
                ->paginate(4);

            // Loop through each rating and check if a report exists for the given userId (if authenticated)
            $usersRating->getCollection()->transform(function ($userRating) use ($userId, $peerId) {
                if ($userId) {
                    // Check if a report exists for this specific rating and user
                    $report = ReportRating::where('peerId', $peerId)
                        ->where('peerRatingId', $userRating->id)
                        ->where(function ($query) use ($userId) {
                            $query->where('userId', $userId)
                                ->orWhere('deviceIdentifier', $userId);
                        })
                        ->exists();
                    // Add 'report' attribute to each rating, true if report exists, false otherwise
                    $userRating->report = $report;

                    // Check if a helpful exists for this specific rating and user
                    $helpful = Helpful::where('peerId', $peerId)
                        ->where('peerRatingId', $userRating->id)
                        ->where(function ($query) use ($userId) {
                            $query->where('userId', $userId)
                                ->orWhere('deviceIdentifier', $userId);
                        })
                        ->first();
                    $count = Helpful::where('peerId', $peerId)
                        ->where('peerRatingId', $userRating->id)
                        ->where('isFoundHelpful', true)
                        ->count();
                    $userRating->helpfulCount = $count;

                    $notHelpfulCount = Helpful::where('peerId', $peerId)
                        ->where('peerRatingId', $userRating->id)
                        ->where('isFoundHelpful', false)
                        ->count();
                    $userRating->notHelpfulCount = $notHelpfulCount;

                    if (!($helpful)) {
                        $userRating->helpfulStatus = $helpful;
                    } else {
                        $userRating->helpfulStatus = $helpful->isFoundHelpful;
                    }
                } else {
                    // If the user is a guest, set report attribute to null
                    $userRating->report = null;
                    $userRating->helpfulStatus = null;
                }

                // Return UserRating with appended columns
                return $userRating;
            });

            // Return Structural data
            return $usersRating;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
