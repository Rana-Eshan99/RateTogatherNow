<?php

namespace App\Http\Controllers;
use App\Models\OrganizationRating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Enums\OrganizationRatingStatusEnum;

class DataScriptController extends Controller
{
    public function dataScript()
    {
        if (App::environment(['local', 'staging'])) {
            try {
                DB::beginTransaction();

                for ($i = 1; $i <= 100; $i++) {
                    $this->createFakeRecord($i);
                }

                DB::commit();

                return response()->json(['message' => 'Successfully created records'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'An error occurred while creating records: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Not allowed in this environment'], 403);
        }
    }

    private function createFakeRecord($i)
    {
        $recordCreate = [
            'userId' => '1',
            'organizationId' => "1",
            'employeeHappyness' => rand(1, 5),
            'companyCulture' => rand(1, 5),
            'careerDevelopment' => rand(1, 5),
            'workLifeBalance' => rand(1, 5),
            'compensationBenefit' => rand(1, 5),
            'jobStability' => rand(1, 5),
            'workplaceDEI' => rand(1, 5),
            'companyReputation' => rand(1, 5),
            'workplaceSS' => rand(1, 5),
            'growthFuturePlan' => rand(1, 5),
            'experience' => 'This is a test experience',
            'status' => OrganizationRatingStatusEnum::APPROVED,
        ];
        OrganizationRating::create($recordCreate);
    }
}

