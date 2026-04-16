<?php

namespace App\Repositories\Repositories\Admin\Organization;

use App\Models\Peer;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use App\Services\ErrorLogService;
use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use App\Enums\PeerRatingStatusEnum;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\Admin\Organization\AdminOrganizationInterface;

class AdminOrganizationRepository implements AdminOrganizationInterface
{

    public function deleteOrganization($request)
    {
        DB::beginTransaction();
        try {
            $organization = Organization::find($request->id);

            if (!$organization) {
                throw new \ErrorException(__('messages.error.invalidOrganization'));
            }

            $relatedPeersCount = Peer::where('organizationId', $request->id)->count();

            if ($relatedPeersCount > 0) {
                throw new \ErrorException(__('messages.error.organizationHasPeers'));
            }

            $organization->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    public function getOrganizationDetails($id)
    {
        try {
            $organization = Organization::with([
                'peers' => function ($query) {
                    $query->where('status', 'APPROVED');
                },
                'ratings'
            ])->find($id);

            if (!$organization) {
                throw new \Exception('Organization not found');
            }

            $organizationRatings = $organization->ratings->where('status', 'APPROVED')->count();

            $organizationAverages = OrganizationRating::where('organizationId', $id)
                ->where('status', OrganizationRatingStatusEnum::APPROVED)
                ->selectRaw('
                            AVG(employeeHappyness) as employeeHappiness,
                            AVG(companyCulture) as companyCulture,
                            AVG(careerDevelopment) as careerDevelopment,
                            AVG(workLifeBalance) as workLifeBalance,
                            AVG(compensationBenefit) as compensationBenefit,
                            AVG(jobStability) as jobStability,
                            AVG(workplaceDEI) as workplaceDEI,
                            AVG(companyReputation) as companyReputation,
                            AVG(workplaceSS) as workplaceSS,
                            AVG(growthFuturePlan) as growthFuturePlan
                        ')
                ->first();

            $averages = collect([
                'employeeHappiness' => $organizationAverages->employeeHappiness,
                'companyCulture' => $organizationAverages->companyCulture,
                'careerDevelopment' => $organizationAverages->careerDevelopment,
                'workLifeBalance' => $organizationAverages->workLifeBalance,
                'compensationBenefit' => $organizationAverages->compensationBenefit,
                'jobStability' => $organizationAverages->jobStability,
                'workplaceDEI' => $organizationAverages->workplaceDEI,
                'companyReputation' => $organizationAverages->companyReputation,
                'workplaceSS' => $organizationAverages->workplaceSS,
                'growthFuturePlan' => $organizationAverages->growthFuturePlan,
            ])->map(function ($value) {
                return round($value, 1);
            });

            $overAllRating = round($averages->avg(), 1);

            return [
                'organization' => $organization,
                'organizationRatings' => $organizationRatings,
                'overAllRating' => $overAllRating,
            ];
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            throw $e;
        }
    }

    public function getPendingApprovalOrganizations()
    {
        // Fetch the organizations with 'NEED_APPROVAL' status
        $data = Organization::where('status', OrganizationStatusEnum::NEED_APPROVAL)
            ->orderBy('createdAt', 'desc')
            ->get();

        // Modify the data as needed
        $filteredData = $data->map(function ($item) {
            $item->countries = optional($item->country);
            $item->states = optional($item->state);
            return $item;
        });

        return $filteredData;
    }

    public function getApprovedOrganizations()
    {
        // Fetch organizations with related models and status APPROVED
        $data = Organization::with(['peers', 'ratings'])
            ->where('status', OrganizationStatusEnum::APPROVED)
            ->latest('updatedAt')
            ->get();
        // Filter and process the data
        $filteredData = $data->map(function ($item) {
            $item->ratingtotal = $item->ratings->where('status', OrganizationRatingStatusEnum::APPROVED)->count();
            $item->peertotal = $item->peers->where('status', PeerStatusEnum::APPROVED)->count();
            return $item;
        });

        return $filteredData;
    }

    public function approveOrganization($id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            throw new \Exception('Organization not found.');
        }

        $organization->status = OrganizationStatusEnum::APPROVED;
        $organization->save();

        return $organization;
    }

    public function rejectOrganization($id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            throw new \Exception('Organization not found.');
        }

        $organization->status = OrganizationStatusEnum::REJECTED;
        $organization->save();

        return $organization;
    }

    public function getOrganizationPeers($id)
    {
        $organization = Organization::with([
            'peers' => function ($query) {
                $query->where('status', 'APPROVED');
            },
            'peers.department',
            'departments',
            'peers.ratings',
        ])->find($id);

        if (!$organization) {
            throw new \Exception('Organization not found.');
        }

        $organization->peers->map(function ($item) {
            $item->departmentName = optional($item->department)->name;
            $item->organizationName = optional($item->organization)->name;
            $item->ratingtotal = $item->ratings->where('status', PeerRatingStatusEnum::APPROVED)->count();
            return $item;
        });

        return $organization->peers;
    }

    public function getOrganizationRatings($id)
    {
        $organization = Organization::with(['country', 'state', 'peers', 'ratings'])->find($id);

        if (!$organization) {
            throw new \Exception('Organization not found.');
        }

        return $organization->ratings->where('status', 'APPROVED')->sortByDesc('createdAt')->map(function ($item) {
            $item->organizationName = optional($item->organization)->name;
            $item->jobTitle = optional($item->user)->jobTitle;
            $item->userName = $item->user ?
                ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName)) :
                'Anonymous';

            $overAllRating = ($item->employeeHappyness + $item->companyCulture + $item->careerDevelopment + $item->workLifeBalance +
                $item->compensationBenefit + $item->jobStability + $item->workplaceDEI + $item->companyReputation +
                $item->workplaceSS + $item->growthFuturePlan) / 10;

            $item->ratingTotal = number_format($overAllRating, 1);
            return $item;
        });
    }

    public function getOrganizationReviewDetails($id)
    {
        $organization = OrganizationRating::with(['organization'])->where('id', $id)->where('status', 'APPROVED')->get();
        if (!$organization) {
            throw new \Exception('Organization review not found.');
        }

        return $organization;
    }

    public function deleteOrganizationPeer($orgId, $peerId)
    {
        $organizationPeer = Peer::where('id', $peerId)->where('organizationId', $orgId)->first();

        if (!$organizationPeer) {
            throw new \Exception('Organization peer not found.');
        }

        $organizationPeer->delete();
        return 'Organization peer deleted successfully';
    }
}
