<?php

namespace App\Http\Controllers;

use App\Models\BuyerAccessToken;
use App\Models\PingtreeTracker;
use App\Models\PingtreeTrackerCA;
use App\Models\PingtreeTrackerUS;
use Illuminate\Http\Request;

class PingtreeTrackerController extends Controller
{


    public function index()
    {
        $metrics = PingtreeTracker::all();


        return view('admin.pingtree-tracker.pingtree-tracker', compact('metrics'));

    }
    /**
     * @param Request $request
     */
    public function FetchPingtreeTrackerData(Request $request)
    {
        $buyer_id = $request->input("buyer_id");
        $buyersetup_id = $request->input("buyersetup_id");

        $wherelist = array();
        if ($buyersetup_id != null) {
            $wherelist[] = ['buyersetup_id', '=', $buyersetup_id];
        }

        $datas = PingtreeTracker::where($wherelist)->with('buyersetup')->get();

        echo json_encode(['data' => $datas]);
    }





}
