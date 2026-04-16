<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\CheckExistingEntriesTrait;


class CountrySeeder extends Seeder
{

    use CheckExistingEntriesTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->entriesExist(Country::class)) {
            return;
        }

        $path = public_path('CountryandState.xlsx');

        $excelSpreadSheetData = Excel::toCollection(null, $path);
        $userData = $excelSpreadSheetData[0];

        $finalData = [];
        $countries = $userData;
        foreach ($countries as $index => $country) {
            if ($index < count($country)) {
                $finalData['countries'][$index] = $country[0];
            }
        }
        for ($i = 0; $i <= count($finalData['countries']); $i++) {
            foreach ($countries as $ind => $state) {
                if ($i < count($state) - 1) {
                    $finalData[$finalData['countries'][$i]][$ind] = $state[$i + 1];
                }
            }
        }
        foreach ($finalData['countries'] as $countryName) {
            $country = Country::create([
                'name' => $countryName
            ]);
            foreach ($finalData[$countryName] as $state) {
                if (!is_null($state)) {
                    $state = State::create([
                        'countryId' => $country->id,
                        'name' => $state
                    ]);
                }
            }
        }

    }
}

