<?php

namespace App\Repositories\Repositories\Admin\Dashboard;

use Carbon\Carbon;
use App\Models\PeerRating;
use App\Models\Organization;
use App\Models\OrganizationRating;
use App\Enums\PeerRatingStatusEnum;
use App\Models\ApplicationFeedback;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\Admin\Dashboard\DashboardInterface;

class DashboardRepository implements DashboardInterface
{


    public function getChartData($year)
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];
        $startOfYear = Carbon::create($year, 1, 1, 0, 0, 0)->timestamp;
        $endOfYear = Carbon::create($year, 12, 31, 23, 59, 59)->timestamp;

        $organizationReviews = OrganizationRating::where('status', OrganizationRatingStatusEnum::APPROVED)
            ->whereBetween('createdAt', [$startOfYear, $endOfYear])
            ->get()
            ->groupBy(function ($review) {
                return Carbon::parse($review->createdAt)->format('M');
            });

        $peerReviews = PeerRating::where('status', PeerRatingStatusEnum::APPROVED)
            ->whereBetween('createdAt', [$startOfYear, $endOfYear])
            ->get()
            ->groupBy(function ($review) {
                return Carbon::parse($review->createdAt)->format('M');
            });

        $data = [];
        foreach ($labels as $label) {
            $data[] = $organizationReviews->get($label, collect())->count() + $peerReviews->get($label, collect())->count();
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'total' => array_sum($data),
        ];
    }
}
