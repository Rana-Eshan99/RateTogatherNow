<?php

namespace App\Traits;

use App\Enums\OrganizationRatingStatusEnum;
use App\Enums\OrganizationStatusEnum;
use App\Enums\PeerRatingStatusEnum;
use App\Models\PeerRating;
use App\Models\OrganizationRating;

trait OrganizationOverallRating
{
    /**
     * Check if entries already exist in the specified model.
     *
     * @param  string  $modelClass
     * @return bool
     */
    public function getOverAllOrganizationRating($organizationId)
    {
        $organizationRatings = OrganizationRating::where('id', $organizationId)->get();

        $ratingFields = [
            'employeeHappyness',
            'companyCulture',
            'careerDevelopment',
            'workLifeBalance',
            'compensationBenefit',
            'jobStability',
            'workplaceDEI',
            'companyReputation',
            'workplaceSS',
            'growthFuturePlan'
        ];

        $totalRating = 0;
        $fieldCount = count($ratingFields);

        if (!$organizationRatings->isEmpty()) {
            foreach ($ratingFields as $field) {
                $average = number_format($organizationRatings->avg($field), 1);
                $totalRating += $average;
            }

            $overAllRating = number_format($totalRating / $fieldCount, 1);
        } else {
            $overAllRating = "0.0";
        }

        return $overAllRating;
    }


    /**
     * Check if entries already exist in the specified model.
     *
     * @param  string  $modelClass
     * @return bool
     */
    public function getOverAllPeerRating($peerId)
    {
        $peerRatings = PeerRating::where('id', $peerId)->get();

        $ratingFields = [
            'easyWork',
            'dependableWork',
            'communicateUnderPressure',
            'meetDeadline',
            'receivingFeedback',
            'respectfullOther',
            'assistOther',
            'collaborateTeam'
        ];

        $totalRating = 0;
        $fieldCount = count($ratingFields);

        if (!$peerRatings->isEmpty()) {
            foreach ($ratingFields as $field) {
                $average = number_format($peerRatings->avg($field), 1);
                $totalRating += $average;
            }

            $overAllRating = number_format($totalRating / $fieldCount, 1);
        } else {
            $overAllRating = "0.0";
        }

        return $overAllRating;
    }
}
