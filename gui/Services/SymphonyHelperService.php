<?php

namespace App\Services;
use GuzzleHttp\Client;
use Session;

class SymphonyHelperService { 

    /**
     * Calling Backend Micro service Helper method
     *
     * @param String $apimethod Api method name
     * @param String $hostName Api URL
     * @param Array  $formData request data
     * @param Integer $authorization  0 means no authorized , 1 means authorized
     * 
     */
    
    public static function httpRequest($apimethod,$hostName,$formData,$authorization) 
    {

        $client = new Client([
            'base_uri' => config('config.MANAGEMENT_PATH'),
            'exceptions' => false,
            'http_errors' => false,
            'verify' => false
        ]);

        $headerData['Content-Type'] = "application/json";
        if( $authorization == 1 ) {
            $headerData['token'] = Session::get('token');
        }
        
        $response = $client->request($apimethod, $hostName, ['headers' => $headerData, 'query' => $formData])->getBody()->getContents();
        //dd($response);
        $responseArray = json_decode( $response,true );
        $responseData['response'] = $responseArray['body'];
        $responseData['type'] = $responseArray['body']['type'];
        $responseData['http_code'] = $responseArray['status'];

        return $responseData;
    }
    
}