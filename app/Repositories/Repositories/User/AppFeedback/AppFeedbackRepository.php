<?php

namespace App\Repositories\Repositories\User\AppFeedback;

use Illuminate\Support\Facades\DB;
use App\Models\ApplicationFeedback;
use App\Repositories\Interfaces\User\AppFeedback\AppFeedbackInterface;

class AppFeedbackRepository implements AppFeedbackInterface
{
    /**
     * Get Organization/Peer Data (Home Page)
     *
     * @param [type] $request
     * @return void
     */
    public function rateApp($request)
    {
        DB::beginTransaction();
        try {
            $userId = auth()->check() ? auth()->user()->id : null;
            $created = ApplicationFeedback::create([
                'userId' => $userId,
                'feeling' => $request->feelings,
                'feedback' => $request->feedback,
                'deviceIdentifier' => $request->visitorId,
            ]);
            DB::commit();
            return $created;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }
}
