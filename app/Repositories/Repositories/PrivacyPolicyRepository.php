<?php

namespace App\Repositories\Repositories;

use Exception;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PrivacyPolicyInterface;

class PrivacyPolicyRepository implements PrivacyPolicyInterface
{
    /**
     * Privacy & Policy Create.
     *
     * @return array
     */
    public function createprivacyPolicy($data)
    {
        try {
            DB::beginTransaction();

            $privacyPolicy = PrivacyPolicy::first()->update([
                'title' => $data['title'],
                'description' => $data['description'],
            ]);

            DB::commit();
            return $privacyPolicy;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
