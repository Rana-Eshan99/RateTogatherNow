<?php

namespace App\Repositories\Repositories\User\State;

use App\Models\State;
use App\Models\Country;
use App\Services\ErrorLogService;
use App\Repositories\Interfaces\User\State\StateInterface;

class StateRepository implements StateInterface{

    /**
     * Get states of respective countries
     */
    public function getStates($countryId){
        try {
            $country = Country::find($countryId);
            if(!($country)){
                throw new \ErrorException(__('messages.error.countryNotFound'));
            }
            else{
                $states = State::where('countryId', $country->id)->orderBy('name', 'asc')->get();
                return $states;
            }
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            throw new \ErrorException($e->getMessage());
        }
    }

}
