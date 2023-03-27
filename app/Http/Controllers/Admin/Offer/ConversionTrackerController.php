<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Controllers\Controller;
use App\Lmscallcenter;
use App\Models\ConversionTracker;
use App\Models\LmsPaydayUK;
use App\Models\Offer;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ConversionTrackerController extends Controller
{
    /**
     * @param Request $request
     */
    public function conversion(Request $request)
    {
        $data = new ConversionTracker;
        $data->amount = $request->amount;
        $data->transaction_id = $request->transaction_id;
        $data->offer_id = $request->offer_id;
        $data->aff_id = $request->aff_id;
//        dd($data);

//        if (!$data['transaction_id']) {
//            $res = Offer::conversion_log($data);
//        }
//        dd($res);

        Log::debug('DEBUG: Firing postback for details: $_GET = ' . print_r($request->input(), true));

        $res = Offer::getpostback($data);
//        dd($res);


        $postbackUrl = $res[0]['postbackUrl'] ?? '';
        $postbackUrl = str_replace("{oid}", $res[0]['oid'], $postbackUrl);
        $postbackUrl = str_replace("{vid}", $res[0]['vid'], $postbackUrl);
        $postbackUrl = str_replace("{aff_sub1}", $res['aff_sub1'], $postbackUrl);
        $postbackUrl = str_replace("{aff_sub2}", $res['aff_sub2'], $postbackUrl);
        $postbackUrl = str_replace("{aff_sub3}", $res['aff_sub3'], $postbackUrl);
        $postbackUrl = str_replace("{aff_sub4}", $res['aff_sub4'], $postbackUrl);
        $postbackUrl = str_replace("{aff_sub5}", $res['aff_sub5'], $postbackUrl);
        $postbackUrl = str_replace("{transactionId}", $res['transaction_id'], $postbackUrl);

        if (isset($res['amount'])) {
            $postbackUrl = str_replace("{amount}", $res['amount'], $postbackUrl ?? '');
        }
//        dd($postbackUrl);

        Log::debug('Postback URL: ' . $postbackUrl);


        // echo $postbackUrl; // die;
        $data['affiliatePostbackUrl'] = $postbackUrl;
//        dd($data['affiliatePostbackUrl']);
        $header = array();
        $post_res = (new CurlHelper)->curl_post($postbackUrl, '', $header);
//        dd($postbackUrl);

        Log::debug('DEBUG: Postback Response: ' . print_r($post_res, TRUE));

//        print_r($post_res);//die;
        echo 'success';

        $this->partner_detail = Partner::get_callcenter_fulldetail($res[0]['vid'], $this->leadtype);
        if ($this->partner_detail->currencyType != 1) {
            $rate = LmsPaydayUK::getdailyrate();
            $data['convertedAmount'] = $rate['usd'];
        }
//        dd($data);

        $res = Offer::AddRevenue($data);
//        dd($res->get());

    }

    public function show($id)
    {
        $conversions = ConversionTracker::find($id);

        return Response::json($conversions);
    }



}
