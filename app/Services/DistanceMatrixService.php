<?php

namespace App\Services;

use Log;
use GuzzleHttp\Client;

class DistanceMatrixService
{
    protected $client;
    protected $apiKey;
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GOOGLE_MAPS_API_KEY');
    }
    /**
     * Calculate the distance between two points
     *
     * @param string $origin
     * @param string $destination
     * @param string $unit
     * @return float
     */
    public function calculatedDistanceWithApi($origin, $destination, $unit = 'km')
    {
        try {
            $response = $this->client->get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destination&key=$this->apiKey");
            $data = json_decode($response->getBody(), true);

            $distanceInMeters = $data['rows'][0]['elements'][0]['distance']['value'];

            $distanceInKm = $distanceInMeters / 1000;

            if ($unit === 'miles') {
                return $distanceInKm * 0.621371;
            }

            return $distanceInKm;
        } catch (\Exception $e) {
            return 'User Location Does Not Exist' . $e->getMessage();
        }
    }
    public function calculatedDistance($origin, $destination, $unit = 'miles')
    {
        try {
            // Parse latitude and longitude from origin and destination
            list($originLat, $originLng) = explode(',', $origin);
            list($destLat, $destLng) = explode(',', $destination);
            
            // Convert parsed latitude and longitude to float before passing to deg2rad
            $originLatRad = deg2rad((float)$originLat);
            $originLngRad = deg2rad((float)$originLng);
            $destLatRad = deg2rad((float)$destLat);
            $destLngRad = deg2rad((float)$destLng);

            // Differences in coordinates
            $dlat = $destLatRad - $originLatRad;
            $dlon = $destLngRad - $originLngRad;

            // Earth radius in miles
            $earthRadiusMiles = 3959;

            // Haversine formula
            $a = sin($dlat / 2) ** 2 + cos($originLatRad) * cos($destLatRad) * sin($dlon / 2) ** 2;
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadiusMiles * $c;

            // Convert distance to kilometers if required
            if ($unit === 'km') {
                $distance *= 1.60934; // 1 mile = 1.60934 kilometers
            }

            return $distance;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    /**
     * Get the location name from lat and lng
     *
     * @param string $latLng
     * @return string
     */
    public function getLocationName($latLng)
    {
        $response = $this->client->get("https://maps.googleapis.com/maps/api/geocode/json?latlng=$latLng&key=$this->apiKey");
        $data = json_decode($response->getBody(), true);

        if (!empty($data['results'])) {
            return $data['results'][0]['formatted_address'];
        }

        return 'Location not found';
    }

    public function getLocationCityName($latLng)
    {
        $response = $this->client->get("https://maps.googleapis.com/maps/api/geocode/json?latlng=$latLng&key=$this->apiKey");
        $data = json_decode($response->getBody(), true);

        if (!empty($data['results'])) {
            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('locality', $component['types'])) {
                    return $component['long_name'];
                }
            }

            // Fall back to administrative_area_level_2 if locality is not found
            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('administrative_area_level_2', $component['types'])) {
                    return $component['long_name'];
                }
            }
        }

        return 'City not found';
    }
}
