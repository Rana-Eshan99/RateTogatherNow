<?php

namespace App\Repositories\Repositories\Admin\OrganizationRating;

use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use App\Traits\OrganizationOverallRating;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\Admin\OrganizationRating\OrganizationRatingInterface;

class OrganizationRatingRepository implements OrganizationRatingInterface
{
    use OrganizationOverallRating;
    public function show($id)
    {

        try {
            DB::beginTransaction();
            $rating = OrganizationRating::find($id);
            $ratingCount = $this->getOverAllOrganizationRating($rating?->id);
            DB::commit();
            return [
                'rating' => $rating,
                'ratingCount' => $ratingCount
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $rating = OrganizationRating::find($id);
            $rating->status = OrganizationRatingStatusEnum::APPROVED;
            $rating->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $rating = OrganizationRating::find($id);
            $rating->status = OrganizationRatingStatusEnum::REJECTED;
            $rating->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
