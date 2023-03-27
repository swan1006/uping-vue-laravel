<?php

namespace App\Jobs;

use App\Helpers\CurlHelper;
use App\Helpers\CurlNetworkHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NetworkOfferSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
//     * @param $data
     */
    public function __construct()
    {
//        $this->data = $data;
//        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $networks = DB::table('affiliate_networks')->get();

        foreach ($networks as $network) {
            $network_id = $network->network_id;
            $network_api_key = $network->network_api_key;
            $network_platform = $network->network_platform;
            $network_status = $network->network_status;
            $method = 'findAllFeaturedOfferIds';


            if ($network_status === "1") {
                try {

                    switch ($network_platform) {
                        case 'HasOffers':
                            $response = (new \App\Helpers\CurlNetworkHelper)->has_offers_data_fetch($network_id, $network_api_key);
                            break;
                        case 'Affise':
                            $response = (new \App\Helpers\CurlNetworkHelper)->affise_data_fetch($network_id, $network_api_key);
                            break;
                        case 'Cake':
                            $response = (new \App\Helpers\CurlNetworkHelper)->cake_data_fetch($network_id, $network_api_key);
                            break;
                        case 'Offer18':
                            $response = (new \App\Helpers\CurlNetworkHelper)->offer18_data_fetch($network_id, $network_api_key);
                            break;
                        case 'Hitcell':
                            $response = (new \App\Helpers\CurlNetworkHelper)->hitcell_data_fetch($network_id, $network_api_key);
                            break;

                    }
                } catch (\Exception $e) {
                    Log::debug('NETWORK API ERROR::', (array)$network);

                }
            } else {
                Log::debug('NETWORK STATUS INACTIVE::', (array)$network);
            }
        }

//        if (!empty(is_array($response))) {
            // store/update offer data.

//            return $response;

//        }


    }


    public function feilds_sync()
    {
        $fields = [];

//        $fields
    }

}
