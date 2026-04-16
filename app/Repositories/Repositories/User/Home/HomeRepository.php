<?php

namespace App\Repositories\Repositories\User\Home;

use App\Models\Peer;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Models\CurrentUserLocation;
use App\Enums\OrganizationStatusEnum;
use App\Services\DistanceMatrixService;
use App\Repositories\Interfaces\User\Home\HomeInterface;

class HomeRepository implements HomeInterface
{
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
     * Get Organization/Peer Data (Home Page)
     *
     * @param [type] $request
     * @return void
     */
    public function getData($request)
    {
        try {
            $search = $request->input('query');
            $organizationsData = Organization::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })->where('status', OrganizationStatusEnum::APPROVED)->latest()->get();

            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Sort by proximity if location is available
                $organizations = $organizationsData->map(function ($organization) use ($currentLat, $currentLng) {
                    $organization->distance = $this->distanceService->calculatedDistance(
                        "{$currentLat},{$currentLng}",
                        "{$organization->latitude},{$organization->longitude}",
                        'miles'
                    );
                    return $organization;
                })->sortBy('distance')->values();
            } else {
                // Sort by creation date if location is not available
                $organizations = $organizationsData->sortByDesc('createdAt')->values();
            }



            $peersData = Peer::where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere(DB::raw("CONCAT(firstName, ' ', lastName)"), 'LIKE', '%' . $search . '%') // Full name search
                    ->orWhere('jobTitle', 'LIKE', '%' . $search . '%');
            })
            ->where('status', PeerStatusEnum::APPROVED)
            ->latest()
            ->get();


            $userLocation = CurrentUserLocation::where('deviceIdentifier', session('visitorId'))->first();

            if ($userLocation) {
                $currentLat = $userLocation->latitude;
                $currentLng = $userLocation->longitude;

                // Sort peers by proximity if location is available
                $peers = $peersData->map(function ($peer) use ($currentLat, $currentLng) {
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
                // Sort peers by creation date if location is not available
                $peers = $peersData->sortByDesc('createdAt')->values();
            }

            return [
                'organizations' => $organizations,
                'peers' => $peers
            ];
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
