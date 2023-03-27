<?php

namespace App\Http\Controllers\Admin\Postback;

use App\Http\Controllers\Controller;
use App\Lmsoffermap;
use App\Models\Partner\Partner;
use App\Models\Postback\Postback;
use App\Models\PostbackLog;
use App\Models\Offer;
use App\Models\PostbackTracker\PostbackTracker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class PostbackController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $aff_id = $request->input("vendor_id");
        $status = $request->input("status");
        $query = $request->input("q");



        $wherelist = array();
        if ($aff_id != null) {
            $wherelist[] = ['vendor_id', '=', $aff_id];
        }
        if ($query != null) {
//            $wherelist[] = ['leadtype', 'LIKE', '%{$query}%'];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $postbacks = Partner::with('company', 'postback_trackers')->where($wherelist)->paginate($perPage);

        return Response::json(['postbacks' => $postbacks]);
    }

    public function getPostbackMapping($id)
    {
        $postback = PostbackTracker::where('id', $id)->first();



        return Response::json(['postback' => $postback], 200);
    }

    public function store(Request $request)
    {
//
//        $request->validate([
//            'partner_id' => 'required',
//            'postback_name' => 'required',
//            'global' => 'required',
//            'affiliatePostbackUrl' => 'required'
//        ]);

        $postback = new PostbackTracker();
        $postback->partner_id = $request['postback']['partner_id'];
        $postback->postback_name = $request['postback']['postback_name'];
        $postback->global = $request['postback']['global'];
        $postback->affiliatePostbackUrl = $request['postback']['affiliatePostbackUrl'];
        $res = $postback->save();


        return Response::json($postback);
    }

    public function show($id)
    {
        $postback = Partner::with(['postbacks', 'company'])->where('id', $id)->first();



        return Response::json(['postback' => $postback], 200);
    }

    public function edit($id)
    {
        $postback = Partner::with(['postback', 'company'])->where('id', $id)->first();



        return Response::json(['postback' => $postback], 200);
    }

    public function update(Request $request, $id)
    {
        $post = PostbackTracker::find($id);
        $post->postback_name = $request['postback_name'];
        $post->global = $request['global'];
        $post->affiliatePostbackUrl = $request['affiliatePostbackUrl'];

        $data = $post->toArray();
        $res = $post->save($data);

        return response()->json('Postback updated successfully.');

    }


    // TODO: change for destroy api resource.
    public function destroy($id)
    {
        $postback = PostbackTracker::find($id);
        $postback->delete();

        return response()->json('Postback Mapping deleted successfully.');

    }


    public function deletePostback($id)
    {
        $postback = Postback::find($id);
        $postback->delete();

        return response()->json('Postback deleted successfully.');
    }

    public function post_lms_logs()
    {
        $postback_lms = Postback::all();

        return Response::json($postback_lms);

    }
}
