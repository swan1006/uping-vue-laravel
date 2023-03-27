<?php

namespace App\Http\Controllers\Admin\Networks;

use App\Http\Controllers\Controller;
use App\Jobs\NetworkOfferSync;
use App\Models\Advertiser;
use App\Models\AffiliateNetwork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AffiliateNetworkController extends Controller
{
    public function index()
    {
        $users = User::all();
        $advertisers = Advertiser::all();

        return view('admin.aff_networks.aff_networks', compact('users', 'advertisers'));
    }

    public function create()
    {
        return view('admin.aff_networks-create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'network_name' => 'required',
            'network_id' => 'required',
            'network_platform' => 'required',
            'network_api_key' => 'required',
            'network_status' => 'required',
        ]);

        $aff_network = new AffiliateNetwork;
        $aff_network->network_name =  $request->network_name;
        $aff_network->network_id =  $request->network_id;
        $aff_network->network_platform = $request->network_platform;
        $aff_network->network_api_key = $request->network_api_key;
        $aff_network->network_status = $request->network_status;
        $aff_network->save();

        return Response::json($aff_network);

    }
    public function show($id)
    {
        $aff_network = AffiliateNetwork::find($id);

        return \view('admin.aff_networks.aff_networks-view', compact('aff_network'));

    }
    public function edit($id)
    {
        $aff_network = AffiliateNetwork::find($id);

        echo json_encode(['data' => $aff_network]);

    }
    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));
//        dd($request);
//        return Response::json($request);

        $aff_network = AffiliateNetwork::find($id);
        $aff_network->network_user =  $request->network->network_user2;
        $aff_network->network_advertiser =  $request->network->network_advertiser2  ;
        $aff_network->network_name =  $request->network->network_name2;
        $aff_network->network_id =  $request->network->network_id2;
        $aff_network->network_platform = $request->network->network_platform2;
        $aff_network->network_api_key = $request->network->network_api_key2;
        $aff_network->network_status = $request->network->network_status2;

        $data = $aff_network->toArray();
        $aff_network->save($data);


        return Response::json($aff_network);
    }
    public function destroy($id)
    {
        $aff_network = AffiliateNetwork::find($id);
        $aff_network->delete();

        return response()->json([
            'message' => 'AffiliateNetwork deleted successfully!'
        ]);
    }

    public function offer_sync()
    {
        NetworkOfferSync::dispatch();


    }
}
