<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodingService
{
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
    protected $apiKey = 'AIzaSyCHRfgU4LTFg08XRlc-_RY45MIMo7lCuVc';
    //protected $apiKey;

    /*public function __construct()
    {
        $this->apiKey = env('GEOCODING_API_KEY');
    }*/

    public function geocode($address)
    {
        $cleanAddress = str_replace(' ', '+', str_replace('#', 'N+', $address));

        $response = Http::get($this->baseUrl, [
            'address' => $cleanAddress,
            'key' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $coordinates = $data['results'][0]['geometry']['location'];
            if ($coordinates) {
                return [
                    'lat' => $coordinates['lat'],
                    'lng' => $coordinates['lng'],
                ];
            }
        }

        return [
            'error' => 'No se pudo obtener la ubicación',
            'status' => $response->status(),
        ];
    }

    public function reverseGeocode($lat, $lng)
    {
        $response = Http::get($this->baseUrl, [
            'latlng' => "$lat,$lng",
            'key' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $address = $data['results'][0]['formatted_address'];
            if ($address) {
                return [
                    'address' => $address,
                ];
            }
        }

        return [
            'error' => 'No se pudo obtener la dirección',
            'status' => $response->status(),
        ];
    }
}
