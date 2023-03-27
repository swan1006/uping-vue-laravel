<?php

namespace App\Models\ClickTracker;

use App\Models\PostbackTracker\PostbackTracker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ClickTracker extends Model
{
    use HasFactory;

    public function postback_tracker()
    {
        return $this->hasOne(PostbackTracker::class);

    }

    /**
     * Get Click Tracker ID
     * @param $request
     * @return mixed
     */
    public function get_click_tracker_log($request)
    {
//        dd($request->input());
        if (isset($request->aff_click_id)) {
            $click_log = ClickTracker::where('aff_click_id', $request->aff_click_id)->get()->first();
        } elseif (isset($request->aff_sub)) {
            $click_log = ClickTracker::where('aff_click_id', $request->aff_sub)->get()->first();
        } elseif (isset($request->aff_sub2)) {
            $click_log = ClickTracker::where('aff_click_id', $request->aff_sub2)->get()->first();
        } elseif (isset($request->transaction_id)) {
            $click_log = ClickTracker::where('transaction_id', $request->transaction_id)->get()->first();
        } else {
            $click_log = ClickTracker::where('aff_click_id', $request->aff_sub3)->get()->first();
        }

        return $click_log;
    }

    /**
     * @param Request $request
     */
    public function track(Request $request)
    {
        dd($request);

        $data = $request->input();
        $vid = $request->input('vid');
        $data['oid'] = $offerid;
        $data['vid'] = $vid;
        $data['aff_sub1'] = $request->input('aff_sub1');
        $data['aff_sub2'] = $request->input('aff_sub2');
        $data['aff_sub3'] = $request->input('aff_sub3');
        $data['aff_sub4'] = $request->input('aff_sub4');
        $data['aff_sub5'] = $request->input('aff_sub5');

        $data['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        $data['created_at'] = date('Y-m-d H:i:s');

        $res = Offer::OfferLog($data);

        if (isset($res['transactionId'])) {
            $transaction_id = $res['transactionId'];
        }

        $offer_data = Offer::get($offerid);
//        $affiliate_data = Lmscallcenter::find($vid);

        $offer_data = (array)json_decode(json_encode($offer_data), true);

        $offerStatus = $offer_data[0]['offerStatus'];
        $expiresDate = $offer_data[0]['expiresDate'];
    }


    /**
     * This function checks if the affiliate is blocked from the offer.
     * If so, return Blank Page
     * @param Request $request
     */
    public function block_affiliates(Request $request)
    {
        $block = false;

        $offer_id = $request->input('offer_id');
        $aff_id = $request->input('aff_id');
        $vendor_id = Partner::where('id', '=', $aff_id)->first();



//        dd($request->input('aff_id'));

        $affiliate_block_list = PubAdvertiser::where('partner_id', '=', $vendor_id)
            ->where('offer_id', $offer_id)
            ->where('block', 1)
            ->get();

        if (!count($affiliate_block_list) > 0) {
            return $request;
        } else {
            $block = true;
            echo '<h1></h1>';
            die;
        }
    }
}
