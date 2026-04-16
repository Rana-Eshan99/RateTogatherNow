<?php

namespace App\Repositories\Repositories\User\Organization;

use App\Models\Peer;
use App\Models\Saved;
use App\Models\State;
use App\Models\Helpful;
use App\Models\Organization;
use App\Models\ReportRating;
use App\Enums\PeerStatusEnum;
use App\Traits\FileUploadTrait;
use App\Models\OrganizationRating;
use App\Traits\ThousandIntoKTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Services\DistanceMatrixService;
use App\Enums\OrganizationRatingStatusEnum;
use App\Models\CurrentUserLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;

class OrganizationRepository implements OrganizationInterface
{
    /**
     * File Upload Trait
     */
    use FileUploadTrait;

    /**
     * Show Rating in unit of K's (e.g 1K,2K)
     */
    use ThousandIntoKTrait;

    /**
     * employeeHappynessRating variable
     *
     * @var boolean
     */
    protected $employeeHappynessRating = false;

    /**
     * toCompareOrganization variable
     *
     * @var boolean
     */
    protected $toCompareOrganization = false;

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
     * Get All Approved Organizations
     *
     * @return void
     */
    public function getOrganizations(): Collection
    {
        try {
            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->orderBy('name', 'asc')->get();
            return $organizations;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
    /**
     * Get Approved Organizations By Id
     *
     * @return void
     */
    public function getOrganizationsById($organizationId)
    {
        try {
            // Fetch organizations with the given conditions
            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)
                ->where('id', '!=', $organizationId)
                ->orderBy('name', 'asc')
                ->get();

            return $organizations;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Create organization
     *
     * @param array $data
     * @return void
     */
    public function createOrganization(array $data)
    {
        try {
            DB::beginTransaction();

            // Check if an organization with the same name, country, state, and city already exists
            $existingOrganization = Organization::where([
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'address' => $data['address'],
            ])
            ->where('status', '!=', 'REJECTED')
            ->first();

            if ($existingOrganization) {
                throw new \ErrorException(__('messages.error.organizationExists'));
            }

            $fileName = !empty($data['fileUpload']) ? $this->uploadFile($data['fileUpload'], '/upload/organization') : 'default_organization_image.png'; // Default image
            $userId = auth()->check() ? auth()->user()->id : null;
            Organization::create([
                'userId' => $userId,
                'country' => $data['country'],
                'state' => $data['state'],
                'name' => trim($data['organizationName']),
                'image' => $fileName,
                'city' => $data['city'],
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'status' => OrganizationStatusEnum::NEED_APPROVAL,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get Approved Organization by organizationId
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganization($organizationId)
    {
        try {
            $organization = Organization::where(['id' => $organizationId, 'status' => OrganizationStatusEnum::APPROVED])->first();
            if (!($organization)) {
                if (Auth::check()) {
                    return redirect()->route('user.organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                } else {
                    return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                }
            }
            return $organization;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get Organization Details by id (Home Page)
     *
     * @param [type] $id
     * @param [type] $request
     * @return void
     */
    public function getOrganizationByIdDetail($id, $request)
    {
        try {
            $organization = Organization::findOrFail($id);
            if (!($organization)) {
                if (Auth::check()) {
                    return redirect()->route('user.organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                } else {
                    return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                }
            }
            // Retrieve all required averages in a single query
            $organizationData = OrganizationRating::where('organizationId', $id)->where('status', OrganizationRatingStatusEnum::APPROVED)->get();
            $employeeHappiness = $organizationData->avg('employeeHappyness');
            $companyCulture = $organizationData->avg('companyCulture');
            $careerDevelopment = $organizationData->avg('careerDevelopment');
            $workLifeBalance = $organizationData->avg('workLifeBalance');
            $compensationBenefit = $organizationData->avg('compensationBenefit');
            $jobStability = $organizationData->avg('jobStability');
            $workplaceDEI = $organizationData->avg('workplaceDEI');
            $companyReputation = $organizationData->avg('companyReputation');
            $workplaceSS = $organizationData->avg('workplaceSS');
            $growthFuturePlan = $organizationData->avg('growthFuturePlan');

            $formattedHappiness = round($employeeHappiness , 1);
            $formattedCompanyCulture = round($companyCulture, 1);
            $formattedCareerDevelopment = round($careerDevelopment, 1);
            $formattedWorkLifeBalance = round($workLifeBalance, 1);
            $formattedCompensationBenefit = round($compensationBenefit, 1);
            $formattedJobStability = round($jobStability, 1);
            $formattedWorkplaceDEI = round($workplaceDEI, 1);
            $formattedCompanyReputation = round($companyReputation, 1);
            $formattedWorkplaceSS = round($workplaceSS, 1);
            $formattedGrowthFuturePlan = round($growthFuturePlan, 1);

            // Calculate the overall rating
            $overAllRating = ($formattedHappiness + $formattedCompanyCulture + $formattedCareerDevelopment + $formattedWorkLifeBalance + $formattedCompensationBenefit + $formattedJobStability + $formattedWorkplaceDEI + $formattedCompanyReputation + $formattedWorkplaceSS + $formattedGrowthFuturePlan) / 10;
            $formattedOverAllRating = round($overAllRating, 1);

            // Count the number of approved ratings
            $formattedRating = $organizationData->where('status', OrganizationRatingStatusEnum::APPROVED)->count();


            // Retrieve peers and count the number of each gender
            $getPeer = Peer::where('organizationId', $id)->where('status', PeerStatusEnum::APPROVED)->get();
            $genderCounts = [
                'MALE' => $getPeer->where('gender', 'MALE')->count(),
                'FEMALE' => $getPeer->where('gender', 'FEMALE')->count(),
                'OTHER' => $getPeer->where('gender', 'OTHER')->count(),
            ];

            $ethnicityCounts = Peer::where('organizationId', $id)
                ->where('status', 'APPROVED')
                ->selectRaw('ethnicity, COUNT(*) as count')
                ->groupBy('ethnicity')
                ->pluck('count', 'ethnicity')
                ->toArray();

            // Define the ethnicity types and set the default count to 0 if not found
            $totalWhite = $ethnicityCounts['WHITE'] ?? 0;
            $totalBlack = $ethnicityCounts['BLACK'] ?? 0;
            $totalHispanic = $ethnicityCounts['HISPANIC_OR_LATINO'] ?? 0;
            $totalMiddleEastern = $ethnicityCounts['MIDDLE_EASTERN'] ?? 0;
            $totalAmericanIndian = $ethnicityCounts['AMERICAN_INDIAN_OR_ALASKA_NATIVE'] ?? 0;
            $totalAsian = $ethnicityCounts['ASIAN'] ?? 0;
            $totalHawaiian = $ethnicityCounts['NATIVE_HAWAIIAN_OR_OTHER_PACIFIC_ISLANDER'] ?? 0;
            $totalOther = $ethnicityCounts['OTHER'] ?? 0;


            $totalResponses = $totalWhite + $totalBlack + $totalHispanic + $totalMiddleEastern + $totalAmericanIndian + $totalAsian + $totalHawaiian + $totalOther;
            $totalWhitePercentage = $totalResponses > 0 ? ($totalWhite / $totalResponses) * 100 : 0;
            $totalBlackPercentage = $totalResponses > 0 ? ($totalBlack / $totalResponses) * 100 : 0;
            $totalHispanicPercentage = $totalResponses > 0 ? ($totalHispanic / $totalResponses) * 100 : 0;
            $totalMiddleEasternPercentage = $totalResponses > 0 ? ($totalMiddleEastern / $totalResponses) * 100 : 0;
            $totalAmericanIndianPercentage = $totalResponses > 0 ? ($totalAmericanIndian / $totalResponses) * 100 : 0;
            $totalAsianPercentage = $totalResponses > 0 ? ($totalAsian / $totalResponses) * 100 : 0;
            $totalHawaiianPercentage = $totalResponses > 0 ? ($totalHawaiian / $totalResponses) * 100 : 0;
            $totalOtherPercentage = $totalResponses > 0 ? ($totalOther / $totalResponses) * 100 : 0;
            $savedStatus = $this->isSavedOrganization($organization->id);
            $data = [
                'organization' => $organization,
                'formattedHappiness' => $formattedHappiness,
                'formattedCompanyCulture' => $formattedCompanyCulture,
                'formattedCareerDevelopment' => $formattedCareerDevelopment,
                'formattedWorkLifeBalance' => $formattedWorkLifeBalance,
                'formattedCompensationBenefit' => $formattedCompensationBenefit,
                'formattedJobStability' => $formattedJobStability,
                'formattedWorkplaceDEI' => $formattedWorkplaceDEI,
                'formattedCompanyReputation' => $formattedCompanyReputation,
                'formattedWorkplaceSS' => $formattedWorkplaceSS,
                'formattedGrowthFuturePlan' => $formattedGrowthFuturePlan,
                'formattedOverAllRating' => $formattedOverAllRating,
                'formattedRating' => $formattedRating,
                'genderCounts' => $genderCounts,

                'totalWhite' => $totalWhite,
                'totalBlack' => $totalBlack,
                'totalHispanic' => $totalHispanic,
                'totalMiddleEastern' => $totalMiddleEastern,
                'totalAmericanIndian' => $totalAmericanIndian,
                'totalAsian' => $totalAsian,
                'totalHawaiian' => $totalHawaiian,
                'totalOther' => $totalOther,
                'totalResponses' => $totalResponses,
                'totalWhitePercentage' => $totalWhitePercentage,
                'totalBlackPercentage' => $totalBlackPercentage,
                'totalHispanicPercentage' => $totalHispanicPercentage,
                'totalMiddleEasternPercentage' => $totalMiddleEasternPercentage,
                'totalAmericanIndianPercentage' => $totalAmericanIndianPercentage,
                'totalAsianPercentage' => $totalAsianPercentage,
                'totalHawaiianPercentage' => $totalHawaiianPercentage,
                'totalOtherPercentage' => $totalOtherPercentage,
                'saved' => $savedStatus,
            ];

            // Return Structured data
            return $data;
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
            if (Auth::check()) {
                return redirect()->route('user.organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
            } else {
                return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get status organization is saved or not.
     *
     * @param [type] $organizationId
     * @return boolean
     */
    public function isSavedOrganization($organizationId)
    {
        try {
            $this->getOrganization($organizationId);
            $savedOrganization = false;

            if (Auth::check()) {
                $saved = Saved::where(['organizationId' => $organizationId, 'userId' => Auth::user()->id])->first();
                if ($saved) {
                    $savedOrganization = true;
                }
            }

            return $savedOrganization;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get over all organization rating by organization id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOverAllOrganizationRating($organizationId)
    {
        try {
            $organizationRatings = OrganizationRating::where('organizationId', $organizationId)->where('status', OrganizationRatingStatusEnum::APPROVED)->get();
            $employeeHappynessOverAllRating = "0.0";
            $companyCultureOverAllRating = "0.0";
            $careerDevelopmentOverAllRating = "0.0";
            $workLifeBalanceOverAllRating = "0.0";
            $compensationBenefitOverAllRating = "0.0";
            $jobStabilityOverAllRating = "0.0";
            $workplaceDEIOverAllRating = "0.0";
            $companyReputationOverAllRating = "0.0";
            $workplaceSSOverAllRating = "0.0";
            $growthFuturePlanOverAllRating = "0.0";
            $overAllRating = "0.0";
            if (!($organizationRatings->isEmpty())) {
                $employeeHappynessOverAllRating = number_format($organizationRatings->avg('employeeHappyness'), 1);
                $companyCultureOverAllRating = number_format($organizationRatings->avg('companyCulture'), 1);
                $careerDevelopmentOverAllRating = number_format($organizationRatings->avg('careerDevelopment'), 1);
                $workLifeBalanceOverAllRating = number_format($organizationRatings->avg('workLifeBalance'), 1);
                $compensationBenefitOverAllRating = number_format($organizationRatings->avg('compensationBenefit'), 1);
                $jobStabilityOverAllRating = number_format($organizationRatings->avg('jobStability'), 1);
                $workplaceDEIOverAllRating = number_format($organizationRatings->avg('workplaceDEI'), 1);
                $companyReputationOverAllRating = number_format($organizationRatings->avg('companyReputation'), 1);
                $workplaceSSOverAllRating = number_format($organizationRatings->avg('workplaceSS'), 1);
                $growthFuturePlanOverAllRating = number_format($organizationRatings->avg('growthFuturePlan'), 1);
                $overAllRating = number_format((
                    $employeeHappynessOverAllRating +
                    $companyCultureOverAllRating +
                    $careerDevelopmentOverAllRating +
                    $workLifeBalanceOverAllRating +
                    $compensationBenefitOverAllRating +
                    $jobStabilityOverAllRating  +
                    $workplaceDEIOverAllRating +
                    $companyReputationOverAllRating    +
                    $workplaceSSOverAllRating   +
                    $growthFuturePlanOverAllRating
                ) / 10, 1);
            }

            if ($this->employeeHappynessRating == true) {
                $data = [
                    'employeeHappynessRating' => $employeeHappynessOverAllRating,
                    'overAllRating' => $overAllRating,
                ];
                $this->employeeHappynessRating = false;
            } else if ($this->toCompareOrganization == true) {
                $data = [
                    'employeeHappynessRating' => $employeeHappynessOverAllRating,
                    'companyCultureOverAllRating' => $companyCultureOverAllRating,
                    'careerDevelopmentOverAllRating' => $careerDevelopmentOverAllRating,
                    'workLifeBalanceOverAllRating' => $workLifeBalanceOverAllRating,
                    'compensationBenefitOverAllRating' => $compensationBenefitOverAllRating,
                    'jobStabilityOverAllRating' => $jobStabilityOverAllRating,
                    'workplaceDEIOverAllRating' => $workplaceDEIOverAllRating,
                    'companyReputationOverAllRating' => $companyReputationOverAllRating,
                    'workplaceSSOverAllRating' => $workplaceSSOverAllRating,
                    'growthFuturePlanOverAllRating' => $growthFuturePlanOverAllRating,
                    'overAllRating' => $overAllRating,
                ];
                $this->toCompareOrganization = false;
            } else {
                $data = $overAllRating;
            }
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Rate organization
     *
     * @param array $data
     * @return void
     */
    public function rateOrganization(array $data)
    {
        try {

            DB::beginTransaction();
            $guestId = session('visitorId');
            $userId = auth()->check() ? auth()->user()->id : null;
            $organizationId = $data['organizationId'];
            $edit = isset($data['edit']) && $data['edit'] == 1; // Check if 'edit' parameter is present

            $this->getOrganization($organizationId);

            $Organization = Organization::where('id', $organizationId)->first();
            if (!$Organization) {
                if (Auth::check()) {
                    return redirect()->route('user.organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                } else {
                    return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                }
            }

            $ratingData = [
                'organizationId' => $organizationId,
                'userId' => $userId,
                'employeeHappyness' => $data['employeeHappiness'],
                'companyCulture' => $data['companyCulture'],
                'careerDevelopment' => $data['careerDevelopment'],
                'workLifeBalance' => $data['workLifeBalance'],
                'compensationBenefit' => $data['compensationBenefit'],
                'jobStability' => $data['jobStability'],
                'workplaceDEI' => $data['workplaceDEI'],
                'companyReputation' => $data['companyReputation'],
                'workplaceSS' => $data['workplaceSS'],
                'growthFuturePlan' => $data['growthFuturePlan'],
                'experience' => $data['experience'],
            ];

            if (!$userId) {
                $ratingData['deviceIdentifier'] = $guestId;
            }

            // Fetch the existing organization rating
            $organizationRating = OrganizationRating::where([
                'userId' => $userId ?: null,
                'organizationId' => $organizationId,
                'deviceIdentifier' => $userId ? null : $guestId,
                'id' => $data['ratingId']
            ])->first();

            if ($edit && $organizationRating) {
                // If 'edit' is passed and the rating exists, update it
                $organizationRating->update(array_merge($ratingData, ['status' => OrganizationRatingStatusEnum::NEED_APPROVAL]));
            } else {
                // Otherwise, create a new record
                OrganizationRating::create($ratingData);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get organization rating by user id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganizationRating($organizationId, $edit = false, $ratingId)
    {
        try {

            $this->getOrganization($organizationId);

            // Only fetch the organization rating if the 'EDIT' parameter is true
            if ($edit) {
                if (Auth::check()) {
                    // Fetch the organization rating for the authenticated user
                    $organizationRating = OrganizationRating::where([
                        'organizationId' => $organizationId,
                        'userId' => Auth::user()->id,
                        'id' => $ratingId
                    ])->first();
                } else {
                    $guestId = session('visitorId');
                    // Fetch the organization rating for a guest
                    $organizationRating = OrganizationRating::where([
                        'organizationId' => $organizationId,
                        'userId' => null,
                        'deviceIdentifier' => $guestId,
                        'id' => $ratingId,
                    ])->first();
                }
            } else {
                // If the 'EDIT' parameter is not provided, return null or handle it differently
                $organizationRating = null;
            }

            return $organizationRating;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Saved the organization in User Profile
     *
     * @param [type] $organizationId
     * @return void
     */
    public function savedOrganization($organizationId)
    {
        try {
            DB::beginTransaction();
            $this->getOrganization($organizationId);

            $savedOrganization = Saved::where(['organizationId' => $organizationId, 'userId' => Auth::user()->id])->first();
            if (!$savedOrganization) {
                // Record doesn't exist save the record in the table.
                $savedData = [
                    'userId' => Auth::user()->id,
                    'organizationId' => $organizationId,
                ];
                Saved::create($savedData);
                $message = __('messages.success.savedOrganization');
            } else {
                // Record exist Un save the record in the table.
                $savedOrganization->delete();
                $message = __('messages.success.unSavedOrganization');
            }

            DB::commit();
            return $message;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get all approved organization list with all rating and pagination
     *
     * @return void
     */
    public function getOrganizationRatingList()
    {
        try {
            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            // Get all approved organizations without pagination initially
            $organizations = Organization::where('status', OrganizationStatusEnum::APPROVED)->latest()->get();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Sort organizations by proximity if location is available
                $nearByOrganizations = $organizations->map(function ($organization) use ($currentLat, $currentLng) {
                    $organization->distance = $this->distanceService->calculatedDistance(
                        "{$currentLat},{$currentLng}",
                        "{$organization->latitude},{$organization->longitude}",
                        'miles'
                    );
                    return $organization;
                })->sortBy('distance')->values();
            } else {
                // Sort organizations by creation date if location is not available
                $nearByOrganizations = $organizations->values(); // Already sorted by latest due to the `latest()` query
            }


            $perPage = 9;
            $page = request()->input('page', 1);

            $paginatedResults = $nearByOrganizations->slice(($page - 1) * $perPage, $perPage);

            // Create a LengthAwarePaginator instance
            $nearByOrganizationsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedResults,
                $nearByOrganizations->count(), // Total count of filtered organizations
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $data = $this->getOrganizationData($nearByOrganizationsPaginated, $nearByOrganizationsPaginated->items(), $nearByOrganizationsPaginated->total());

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get Organization Rating List Data using Organizations & count
     *
     * @param [type] $organizations
     * @param [type] $count
     * @return $data
     */
    protected function getOrganizationData($originalPaginator, $filteredOrganizations, $count)
    {
        try {
            $organizationRatings = [];
            if ($count > 0) {
                $count = $count . ($count > 1 ? " Organizations" : " Organization");
                foreach ($filteredOrganizations as $organization) {
                    $this->employeeHappynessRating = true;
                    $organizationRating = $this->getOverAllOrganizationRating($organization->id);
                    $savedStatus = $this->isSavedOrganization($organization->id);
                    $organizationRatings[$organization->id] = [
                        'organization' => $organization,
                        'overAllRating' => $organizationRating['overAllRating'],
                        'employeeHappynessRating' => $organizationRating['employeeHappynessRating'],
                        'saved' => $savedStatus,
                    ];
                }
                // Create a new LengthAwarePaginator for the modified data
                $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $organizationRatings,
                    $originalPaginator->total(),
                    $originalPaginator->perPage(),
                    $originalPaginator->currentPage(),
                    ['path' => $originalPaginator->path()]
                );
                $data = [
                    'organizationRatings' => $organizationRatings,
                    'count' => $count,
                    'paginatedRatings' => $paginatedRatings,
                ];
            } else {
                $data = [
                    'organizationRatings' => [],
                    'count' => "Organization",
                    'paginatedRatings' => [],
                ];
            }
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
    /**
     * Get all approved organization list with rating Using organization Name
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getOrganizationRatingListByName($organizationName)
    {
        try {
            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            $organizations = Organization::where(function ($query) use ($organizationName) {
                $query->where('name', 'LIKE', '%' . $organizationName . '%')
                    ->orWhere('address', 'LIKE', '%' . $organizationName . '%');
            })
                ->where('status', OrganizationStatusEnum::APPROVED)
                ->latest()
                ->get();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Sort organizations by proximity if location is available
                $nearByOrganizations = $organizations->map(function ($organization) use ($currentLat, $currentLng) {
                    $organization->distance = $this->distanceService->calculatedDistance(
                        "{$currentLat},{$currentLng}",
                        "{$organization->latitude},{$organization->longitude}",
                        'miles'
                    );
                    return $organization;
                })->sortBy('distance')->values();
            } else {
                // Sort organizations by latest creation if location is not available
                $nearByOrganizations = $organizations->values(); // Already sorted by `latest()`
            }


            $perPage = 9;
            $page = request()->input('page', 1);
            $paginatedResults = $nearByOrganizations->slice(($page - 1) * $perPage, $perPage);

            $nearByOrganizationsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedResults,
                $nearByOrganizations->count(), // Total count of filtered organizations
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $data = $this->getOrganizationData($nearByOrganizationsPaginated, $nearByOrganizationsPaginated->items(), $nearByOrganizationsPaginated->total());
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }



    /**
     * Get Organizational Data for Compare
     *
     * @param [type] $organizationId
     * @return void
     */
    public function compareOrganization($organizationId)
    {
        try {
            $organization = $this->getOrganization($organizationId);
            if ($organization instanceof \Illuminate\Http\RedirectResponse) {
                // Return the redirect response to the controller for immediate handling
                return $organization;
            }

            $this->toCompareOrganization = true;
            $data = $this->getOverAllOrganizationRating($organizationId);
            $data['name'] = $organization['name'];
            $data['id'] = $organization['id'];

            // Return Structured data
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Get User's All Saveds Organizations
     *
     * @return void
     */
    public function getUserSavedsOrganizations()
    {
        try {
            // Fetch saved organization IDs in the order they were saved (latest first)
            $savedOrganizations = Saved::where('userId', Auth::user()->id)
                ->whereNotNull('organizationId')
                ->latest() // Order by latest 'Saved' records
                ->pluck('organizationId');

            // Fetch organizations matching those IDs, ordered by 'Saved' record order
            $organizations = Organization::whereIn('id', $savedOrganizations)
                ->where('status', OrganizationStatusEnum::APPROVED)
                ->orderByRaw("FIELD(id, " . $savedOrganizations->implode(',') . ")") // Maintain the order of 'Saved' records
                ->paginate(9);

            $count = Organization::whereIn('id', $savedOrganizations)->where('status', OrganizationStatusEnum::APPROVED)->count();

            $data = $this->getUserSavedOrganizationsData($count, $organizations);
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException(($e->getMessage()));
        }
    }

    /**
     * Get User's Saved Organization by using like operator from organization name or address
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getUserSavedsOrganizationsByName($organizationName)
    {
        try {
            // Fetch saved organization IDs in the order they were saved (latest first)
            $savedOrganizations = Saved::where('userId', Auth::user()->id)
                ->whereNotNull('organizationId')
                ->latest() // Order by latest 'Saved' records
                ->pluck('organizationId');

            // Searching organizations in the database using the LIKE operator from column name or address
            $organizations = Organization::whereIn('id', $savedOrganizations)->where(function ($query) use ($organizationName) {
                $query->where('name', 'LIKE', '%' . $organizationName . '%')
                    ->orWhere('address', 'LIKE', '%' . $organizationName . '%');
            })
                ->where('status', OrganizationStatusEnum::APPROVED)
                ->orderByRaw("FIELD(id, " . $savedOrganizations->implode(',') . ")") // Maintain the order of 'Saved' records
                ->paginate(9);
            $count = Organization::whereIn('id', $savedOrganizations)->where(function ($query) use ($organizationName) {
                $query->where('name', 'LIKE', '%' . $organizationName . '%')
                    ->orWhere('address', 'LIKE', '%' . $organizationName . '%');
            })
                ->where('status', OrganizationStatusEnum::APPROVED)
                ->count();

            $data = $this->getUserSavedOrganizationsData($count, $organizations);
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException(($e->getMessage()));
        }
    }

    /**
     * Get the data of User's Data Organization to display in Profile Setting
     *
     * @param [type] $count
     * @param [type] $organizations
     * @return void
     */
    protected function getUserSavedOrganizationsData($count, $organizations)
    {
        try {
            $organizationRatings = [];
            if ($count > 0) {
                $count = $count . ($count > 1 ? " Saved Organizations" : " Saved Organization");
                foreach ($organizations as $organization) {
                    $this->employeeHappynessRating = true;
                    $organizationRating = $this->getOverAllOrganizationRating($organization->id);
                    $organizationRatings[$organization->id] = [
                        'organization' => $organization,
                        'overAllRating' => $organizationRating['overAllRating'],
                        'employeeHappynessRating' => $organizationRating['employeeHappynessRating'],
                    ];
                }
                // Create a new LengthAwarePaginator for the modified data
                $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $organizationRatings,
                    $organizations->total(),
                    $organizations->perPage(),
                    $organizations->currentPage(),
                    ['path' => route('user.profileSetting.profileSettingForm')]
                );
                $data = [
                    'organizationRatings' => $organizationRatings,
                    'count' => $count,
                    'paginatedRatings' => $paginatedRatings,
                ];
            } else {
                $data = [
                    'organizationRatings' => [],
                    'count' => "Saved Organization",
                    'paginatedRatings' => [],
                ];
            }
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get Organization Rating Given by the Logged-in user
     *
     * @return void
     */
    public function getUserRatedOrganizations()
    {
        try {
            $organizationRatings = OrganizationRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })
                ->with(['organization'])
                ->where(function ($query) {
                    $query->where('status', OrganizationRatingStatusEnum::APPROVED)
                        ->orWhere('status', OrganizationRatingStatusEnum::NEED_APPROVAL);
                })
                ->latest('updatedAt')
                ->paginate(3);

            $count = OrganizationRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) {
                    $query->where('status', OrganizationStatusEnum::APPROVED);
                })->where(function ($query) {
                    $query->where('status', OrganizationRatingStatusEnum::APPROVED)
                        ->orWhere('status', OrganizationRatingStatusEnum::NEED_APPROVAL);
                })->count();

            $data = $this->getUserRatedOrganizationData($count, $organizationRatings);
            // Return the structured data
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get User's Organization-Rating by using like operator from organization name or address
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getUserRatedOrganizationsByName($organizationName)
    {
        try {
            // Retrieve the organization ratings for the authenticated user
            $organizationRatings = OrganizationRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) use ($organizationName) {
                    $query->where('status', OrganizationStatusEnum::APPROVED)
                        ->where(function ($query) use ($organizationName) {
                            $query->where('name', 'LIKE', '%' . $organizationName . '%')
                                ->orWhere('address', 'LIKE', '%' . $organizationName . '%');
                        });
                })
                ->with('organization')
                ->where(function ($query) {
                    $query->where('status', OrganizationRatingStatusEnum::APPROVED)
                        ->orWhere('status', OrganizationRatingStatusEnum::NEED_APPROVAL);
                })
                ->latest('updatedAt')
                ->paginate(3);
            $count = OrganizationRating::where('userId', Auth::user()->id)
                ->whereHas('organization', function ($query) use ($organizationName) {
                    $query->where('status', OrganizationStatusEnum::APPROVED)
                        ->where(function ($query) use ($organizationName) {
                            $query->where('name', 'LIKE', '%' . $organizationName . '%')
                                ->orWhere('address', 'LIKE', '%' . $organizationName . '%');
                        });
                })->where(function ($query) {
                    $query->where('status', OrganizationRatingStatusEnum::APPROVED)
                        ->orWhere('status', OrganizationRatingStatusEnum::NEED_APPROVAL);
                })->count();
            $data = $this->getUserRatedOrganizationData($count, $organizationRatings);
            // Return the structured data
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get the data of User's Rated Organization Data to display in Profile Setting
     *
     * @param [type] $count
     * @param [type] $organizationRatings
     * @return void
     */
    protected function getUserRatedOrganizationData($count, $organizationRatings)
    {
        try {
            $organizationRatingsData = [];

            if ($count > 0) {
                foreach ($organizationRatings as $organizationRating) {
                    $organization = $organizationRating->organization;
                    $organizationOverAllRating = $this->getOverAllOrganizationRating($organization->id);

                    // Prepare the rating data
                    $ratingData = $organizationRating;
                    $ratingData['overAllRating'] = $organizationOverAllRating;

                    // Use [] to add multiple entries even with the same organization ID
                    $organizationRatingsData[] = [
                        'organization' => $organization,
                        'ratings' => $ratingData,
                        'overAllRating' => $organizationOverAllRating,
                    ];
                }

                $count = $count . ($count > 1 ? " Organizations Rating" : " Organization Rating");

                // Create a new LengthAwarePaginator for the modified data
                $paginatedRatings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $organizationRatingsData,
                    $organizationRatings->total(),
                    $organizationRatings->perPage(),
                    $organizationRatings->currentPage(),
                    ['path' => route('user.profileSetting.profileSettingForm')]
                );

                $data = [
                    'organizations' => $organizationRatingsData,
                    'count' => $count,
                    'paginatedRatings' => $paginatedRatings,
                ];
            } else {
                $data = [
                    'organizations' => [],
                    'count' => "Organization Rating",
                    'paginatedRatings' => [],
                ];
            }

            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get the Organization Rating with Reports and Helpful
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganizationRating_Report_Helpful($organizationId)
    {
        try {
            // Now retrieve it from session to verify it's stored correctly
            $guestId = session('visitorId');

            // Get Organization Rating (Latest on the basis of Updated At)
            $userId = Auth::check() ? Auth::user()->id : $guestId; // Check if the user is authenticated
            $usersRating = OrganizationRating::where('organizationId', $organizationId)
                ->where('status', OrganizationRatingStatusEnum::APPROVED)
                ->latest('updatedAt')
                ->paginate(4);

            // Loop through each rating and check if a report exists for the given userId (if authenticated)
            $usersRating->getCollection()->transform(function ($userRating) use ($userId, $organizationId) {
                if ($userId) {
                    $report = ReportRating::where('organizationId', $organizationId)
                        ->where('organizationRatingId', $userRating->id)
                        ->where(function ($query) use ($userId) {
                            $query->where('userId', $userId)
                                ->orWhere('deviceIdentifier', $userId);
                        })
                        ->exists();

                    // Add 'report' attribute to each rating, true if report exists, false otherwise
                    $userRating->report = $report;

                    // Check if a helpful exists for this specific rating and user
                    $helpful = Helpful::where('organizationId', $organizationId)
                        ->where('organizationRatingId', $userRating->id)
                        ->where(function ($query) use ($userId) {
                            $query->where('userId', $userId)
                                ->orWhere('deviceIdentifier', $userId);
                        })
                        ->first();

                    $count = Helpful::where('organizationId', $organizationId)
                        ->where('organizationRatingId', $userRating->id)
                        ->where('isFoundHelpful', true)
                        ->count();
                    $userRating->helpfulCount = $count;

                    $notHelpfulCount = Helpful::where('organizationId', $organizationId)
                        ->where('organizationRatingId', $userRating->id)
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
