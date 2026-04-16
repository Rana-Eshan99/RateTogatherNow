<?php

namespace App\Repositories\Repositories;

use App\Models\TermsCondition;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\TermsConditionInterface;

class TermsConditionRepository implements TermsConditionInterface
{
    /**
     * Terms & Condition Create.
     *
     * @return array
     */
    public function createTerms($data)
    {
        try {
            DB::beginTransaction();

            $termsCondition = TermsCondition::first()->update([
                'title' => $data['title'],
                'description' => $data['description'],
            ]);

            DB::commit();
            return $termsCondition;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
