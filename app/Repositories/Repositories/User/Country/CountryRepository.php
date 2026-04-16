<?php

namespace App\Repositories\Repositories\User\Country;

use App\Models\Country;
use App\Repositories\Interfaces\User\Country\CountryInterface;

class CountryRepository implements CountryInterface
{

    /**
     * Get All Countries
     */
    public function getCountries()
    {
        try {
            $country = Country::orderBy('name', 'asc')->get();
            return $country;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
