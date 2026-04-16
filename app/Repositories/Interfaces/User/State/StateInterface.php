<?php

namespace App\Repositories\Interfaces\User\State;

Interface StateInterface{
    /**
     * Get states of respective country
     */
    public function getStates($countryId);
}
