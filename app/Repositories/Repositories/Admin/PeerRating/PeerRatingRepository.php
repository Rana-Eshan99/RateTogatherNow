<?php

namespace App\Repositories\Repositories\Admin\PeerRating;

use App\Models\PeerRating;
use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use App\Enums\PeerRatingStatusEnum;
use App\Traits\OrganizationOverallRating;
use App\Enums\OrganizationRatingStatusEnum;
use App\Repositories\Interfaces\Admin\PeerRating\PeerRatingInterface;

class PeerRatingRepository implements PeerRatingInterface
{
    use OrganizationOverallRating;
    public function show($id)
    {

        try {
            DB::beginTransaction();

            $rating = PeerRating::find($id);
            $ratingCount = $this->getOverAllPeerRating($rating?->id);
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
            $rating = PeerRating::find($id);
            $rating->status = PeerRatingStatusEnum::APPROVED;
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
            $rating = PeerRating::find($id);
            $rating->status = PeerRatingStatusEnum::REJECTED;
            $rating->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
