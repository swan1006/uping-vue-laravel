<?php

namespace App\Helpers;

use BizFellaUSA\Status;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CurlNetworkHelper
{
    // HASOFFER NETWORKS
    public function has_offers_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://'. $network_id . '.api.hasoffers.com/Apiv3/json?api_key='. $api_key . '&
                    Target=Affiliate_Offer&
                    Method=findMyApprovedOffers&
                    fields[]=payout_type&
                    fields[]=expiration_date&
                    fields[]=currency&
                    filters[id]='
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);


        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // CAKE NETWORKS
    public function cake_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://'. $network_id . '.api.hasoffers.com/Apiv3/json?api_key='. $api_key . '&
                    Target=Affiliate_Offer&
                    Method=findMyApprovedOffers&
                    fields[]=payout_type&
                    fields[]=expiration_date&
                    fields[]=currency&
                    filters[id]='
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // AFFISE NETWORKS
    public function affise_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
                'http://' . $network_id . '/3.0/offers?
                    Target=Affiliate_Offer&
                    Method=findMyApprovedOffers&
                    fields[]=payout_type&
                    fields[]=expiration_date&
                    fields[]=currency&
                    filters[id]='
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'API-Key:' . $api_key
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // EVERFLOW NETWORKS
    public function everflow_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://api.eflow.team/v1/affiliates/offersrunnable'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Eflow-API-Key:' . $api_key,
            'content-type: application/json'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // OFFER18 NETWORKS
    public function offer18_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://api.offer18.com/api/af/offers?key=' . $api_key .'&aid=1234'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Eflow-API-Key:' . $api_key,
            'content-type: application/json'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // HITCELL NETWORKS
    public function hitcell_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://api.offer18.com/api/af/offers?key=' . $api_key .'&aid=1234'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Eflow-API-Key:' . $api_key,
            'content-type: application/json'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }

    // CPALEAD NETWORKS
    public function cpalead_data_fetch($network_id, $api_key)
    {
        // Initialize cURL and make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            'https://api.offer18.com/api/af/offers?key=' . $api_key .'&aid=1234'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Eflow-API-Key:' . $api_key,
            'content-type: application/json'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response into a PHP associative array
        $response = json_decode($response, true);

        // Make sure that there wasn't a problem decoding the response
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'API response not well-formed (json error code: ' . json_last_error() . ')'
            );
        }

        // Print out the response details or, any error messages
        if (isset($response['response']['status']) && $response['response']['status'] === 1) {
            return $response['response']['data'];
//            echo 'Response Data: <pre>' . print_r($response['response']['data'], true) . '';
        } else {
            echo 'API call failed' . (isset($response['response']['errorMessage']) ? ' (' . $response['response']['errorMessage'] . ')' : '') . '';
            Log::debug('API NETWORK ERROR:: hasoffers', (array) $response['response']['errors']);
//            echo PHP_EOL;
        }
    }


}
