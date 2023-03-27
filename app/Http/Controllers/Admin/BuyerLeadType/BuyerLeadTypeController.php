<?php

namespace App\Http\Controllers\Admin\BuyerLeadType;

use App\Http\Controllers\Controller;
use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\Buyer\BuyerLeadType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BuyerLeadTypeController extends Controller
{

    public function index()
    {
        $buyersleadtypes = BuyerLeadType::all();
        $buyers = Buyer::all();
        $buyersetups = Buyersetup::all();


        return view('admin.buyers-leadtype.buyers-leadtype', compact('buyersleadtypes', 'buyers', 'buyersetups'));

    }
    public function create()
    {
        $users= User::all();

        return view('admin.buyers-leadtype.buyers-leadtype-create', compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'buyer_id' => 'required',
            'buyersetup_id' => 'required',
            'type' => 'required',
            'status' => 'required',
            'margin' => 'required',
            'daytotal' => 'required',
            'daylimit' => 'required',
            'weeklimit' => 'required',
            'monthlimit' => 'required',
            'daycredit' => 'required',
            'weekcredit' => 'required',
            'monthcredit' => 'required',
            'currencyType' => 'required',
        ]);

        $buyerleadtype = new \App\Models\Buyer\BuyerLeadType;
        $buyerleadtype->buyer_id = $request->input('buyer_id');
        $buyerleadtype->buyersetup_id = $request->input('buyersetup_id');
        $buyerleadtype->type = $request->input('type');
        $buyerleadtype->status = $request->input('status');
        $buyerleadtype->margin =  $request->input('margin');
        $buyerleadtype->margin =  $request->input('margin');
        $buyerleadtype->daylimit = $request->input('daylimit');
        $buyerleadtype->weeklimit = $request->input('weeklimit');
        $buyerleadtype->monthlimit = $request->input('monthlimit');
        $buyerleadtype->daycredit = $request->input('daycredit');
        $buyerleadtype->weekcredit = $request->input('weekcredit');
        $buyerleadtype->monthcredit = $request->input('monthcredit');
        $buyerleadtype->save();



        // redirect
        return redirect()->route('buyersleadtype.index')
            ->with('success', 'Partner Lead Type is successfully saved');

    }
    public function show($id)
    {
        $leadtype = \App\Models\Buyer\BuyerLeadType::find($id);

        return Response::json($leadtype);
    }
    public function edit($id)
    {
        $leadtype = \App\Models\Buyer\BuyerLeadType::find($id);

        echo json_encode(['data' => $leadtype]);
    }
    public function destroy($id)
    {
        $leadtype = \App\Models\Buyer\BuyerLeadType::find($id);
        $leadtype->delete();

        return response()->json([
            'message' => 'Partner deleted successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));

        $buyerleadtype = \App\Models\Buyer\BuyerLeadType::find($id);
        $buyerleadtype->buyer_id = $request->leadtype->buyer_id2;
        $buyerleadtype->buyersetup_id = $request->leadtype->buyersetup_id2;
        $buyerleadtype->type = $request->leadtype->type2;
        $buyerleadtype->status = $request->leadtype->status2;
        $buyerleadtype->margin =  $request->leadtype->margin2;
        $buyerleadtype->daytotal = $request->leadtype->daytotal2;
        $buyerleadtype->daylimit = $request->leadtype->daylimit2;
        $buyerleadtype->weeklimit = $request->leadtype->weeklimit2;
        $buyerleadtype->monthlimit = $request->leadtype->monthlimit2;
        $buyerleadtype->daycredit = $request->leadtype->daycredit2;
        $buyerleadtype->weekcredit = $request->leadtype->weekcredit2;
        $buyerleadtype->monthcredit = $request->leadtype->monthcredit2;
        $buyerleadtype->currencyType = $request->leadtype->currencyType2;

        $data = $buyerleadtype->toArray();
        $buyerleadtype->save($data);

        return Response::json($buyerleadtype);
    }

    /**
     *
     * @param Request $request
     */
    public function FetchBuyerLeadTypeData(Request $request)
    {
        $vid = $request->input("vid");
        $lead_type = $request->input("lead_type");
        $status = $request->input("status");

        $wherelist = array();
        if ($lead_type != null) {
            $wherelist[] = ['type', '=', $lead_type];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($vid != null) {
            $wherelist[] = ['vid', '=', $vid];
        }
        $datas = \App\Models\Buyer\BuyerLeadType::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }



}
