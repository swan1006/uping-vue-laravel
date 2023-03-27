<?php

namespace App\Http\Controllers\Admin\Mapping;

use App\Models\Buyer\BuyerSetup;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Buyer;
use App\Models\Partner;

use App\Models\Mapping\Mapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PubBuyerMappingController extends Controller
{

    public function index()
    {
        $buyers = Buyer::all();
        $pubbuyers = Mapping::all();
        $buyersetups = Buyersetup::all();
        $partners = Partner::all();

        return view('admin.pubbuyer.pubbuyer', compact('pubbuyers', 'buyers', 'partners', 'buyersetups'));

    }
    public function create()
    {
        $pubbuyers = Mapping::all();
        $partners = Partner::all();
        $buyers = Buyer::all();
        $buyersetups = Buyersetup::all();


        return view('admin.pubbuyer.pubbuyer-create', compact('pubbuyers', 'partners', 'buyers', 'buyersetups'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'leadtype' => 'required',
            'vid' => 'required',
            'buyer_id' => 'required',
            'buyersetup_id' => 'required',
            'status' => 'required',
        ]);

        $pubbuyer = new Mapping;
        $pubbuyer->leadtype =  $request->get('leadtype');
        $pubbuyer->vid = $request->get('vid');
        $pubbuyer->buyer_id = $request->get('buyer_id');
        $pubbuyer->buyersetup_id = $request->get('buyersetup_id');
        $pubbuyer->status = $request->get('status');
        $pubbuyer->save();

        // redirect
        return Response::json($pubbuyer);


    }
    public function show($id)
    {
        $mapping = Mapping::find($id);

        return Response::json($mapping);
    }
    public function destroy($id)
    {
        $mapping = Mapping::find($id);
        $mapping->delete();

        return response()->json([
            'message' => 'Pubbuyermapping deleted successfully!'
        ]);
    }
    public function edit($id)
    {
        $datas = Mapping::find($id);

        echo json_encode(['data' => $datas]);
    }
    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));

        $pubbuyer = Mapping::find($id);
        $pubbuyer->leadtype =  $request->mapping->leadtype2;
        $pubbuyer->vid = $request->mapping->vid2;
        $pubbuyer->buyer_id = $request->mapping->buyer_id2;
        $pubbuyer->buyersetup_id = $request->mapping->buyersetup_id2;
        $pubbuyer->status = $request->mapping->status2;
        $pubbuyer->save();

        $data = $pubbuyer->toArray();
        $pubbuyer->save($data);

        return Response::json($pubbuyer);
    }

    /**
     *
     * @param Request $request
     */
    public function FetchPubBuyerData(Request $request)
    {
        $vid = $request->input("vid");
        $buyer_id= $request->input("buyer_id");
        $tier_id = $request->input("tier_id");
        $lead_type = $request->input("lead_type");
        $status = $request->input("status");

        $wherelist = array();
        if ($vid != null) {
            $wherelist[] = ['vid', '=', $vid];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($buyer_id != null) {
            $wherelist[] = ['buyer_id', '=', $buyer_id];
        }
        if ($tier_id != null) {
            $wherelist[] = ['buyersetup_id', '=', $tier_id];
        }
        if ($lead_type != null) {
            $wherelist[] = ['leadype', '=', $lead_type];
        }
        $datas = Mapping::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }

}
