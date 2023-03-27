<?php

namespace App\Http\Controllers\Partner;

use App\Models\Partner\Partner;
use App\Models\Postback\Postback;
use App\Models\PostbackTracker\PostbackTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PartPostbackController extends Controller
{


    public function getPostbacks($id)
    {

        $postbacks = PostbackTracker::where('partner_id', $id)
            ->get();

        return Response::json(['postbacks' => $postbacks], 200);


    }
    public function getPostback($id)
    {

        $postback = PostbackTracker::find($id)
            ->first();

        return Response::json(['postback' => $postback], 200);


    }
    public function store(Request $request)
    {
        $partner = Partner::where('user_id', $request['postback']['user_id'])->first();

        $postback = new PostbackTracker();
        $postback->partner_id = $partner->id;
        $postback->postback_name = $request['postback']['postback_name'];
        $postback->global = $request['postback']['global'];
        $postback->affiliatePostbackUrl = $request['postback']['affiliatePostbackUrl'];
        $res = $postback->save();

        return Response::json($postback);
    }
    public function destroy($id)
    {
        $postback = PostbackTracker::find($id);
        $postback->delete();

        return Response::json($postback);

    }
    public function update(Request $request, $id)
    {
        $partner = Partner::where('user_id', $id)->first();

        $postback = PostbackTracker::find($partner->id);
        $postback->offer_id = $request['offer_id'];
        $postback->partner_id = $request['partner_id'];
        $postback->postback_name = $request['postback_name'];
        $postback->affiliatePostbackUrl = $request['affiliatePostbackUrl'];
        $postback->global = $request['global'];

        $data = $postback->toArray();
        $res = $postback->save($data);

        return Response::json($postback);
    }


    public function post_lms_logs()
    {
        $postback_lms = Postback::all();

        return Response::json($postback_lms);

    }
}
