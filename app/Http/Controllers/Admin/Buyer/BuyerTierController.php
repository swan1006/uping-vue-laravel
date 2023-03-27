<?php

namespace App\Http\Controllers\Admin\Buyer;


use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Http\Controllers\Controller;
use App\Models\Buyer\BuyerRotation;
use App\Models\LmsOffersLog;
use App\Models\Mapping\Mapping;
use App\Models\User;
use App\Models\User\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class BuyerTierController extends Controller
{



    public function getTier(Request $request, $id){
        $buyertier = BuyerSetup::where('id', $id)->first();


        return Response::json(['buyertier' => $buyertier]);
    }
    public function index(Request $request)
    {

        $perPage = $request->input("perPage");

        $leadType = $request->input("leadType");
        $modelType = $request->input("modelType");
        $status = $request->input("status");


        $wherelist = array();
        if ($leadType != null) {
            $wherelist[] = ['leadtype', '=', $leadType];
        }
        if ($modelType != null) {
            $wherelist[] = ['model_type', '=', $modelType];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $buyertiers = BuyerSetup::where($wherelist)->paginate($perPage);


        return Response::json(['buyertiers' => $buyertiers]);
    }
    public function store(Request $request) {

//        dd($request->all());

        $tier = new BuyerSetup();
        $tier->leadtype = $request['buyerTier']['leadtype'];
        $tier->buyername = $request['buyerTier']['buyername'];
        $tier->tier_price = $request['buyerTier']['tier_price'];
        $tier->model_type = $request['buyerTier']['model_type'];
        $tier->posting_order = $request['buyerTier']['posting_order'];
        $tier->parameter1 = $request['buyerTier']['parameter1'];
        $tier->parameter2 = $request['buyerTier']['parameter2'];
        $tier->parameter3 = $request['buyerTier']['parameter3'];
        $tier->ping_url_test = $request['buyerTier']['ping_url_test'];
        $tier->post_url_test = $request['buyerTier']['post_url_test'];
        $tier->ping_url_live = $request['buyerTier']['ping_url_live'];
        $tier->post_url_live = $request['buyerTier']['post_url_live'];
        $tier->timeout = $request['buyerTier']['timeout'];
        $tier->mode = $request['buyerTier']['mode'];
        $tier->status = $request['buyerTier']['status'] ?? 1;
        $tier->rotate = $request['buyerTier']['rotate'];

        $res = $tier->save();
//        dd($res);
        return Response::json('Mapping saved successfully', 200);

    }
    public function show($id)
    {
        $buyertier = BuyerSetup::find($id);


        return Response::json(['buyertier' => $buyertier], 200);
    }
    public function edit($id)
    {
//        $buyer_setup = BuyerSetup::find($id);
        $buyertier = BuyerSetup::with(['company'])->where('id', $id)->first();


        return Response::json(['buyertier' => $buyertier], 200);

    }
    public function destroy($id)
    {
        $buyer_setup = BuyerSetup::find($id);
        $buyer_setup->delete();

        return response()->json([
            'message' => 'Buyer deleted successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
//        dd($request->input());
//        $request = json_decode(json_encode($request->input()));

        $tier = Buyersetup::find($id);
        $tier->leadtype =  $request['leadtype'];
        $tier->buyername = $request['buyername'];
        $tier->tier_price = $request['tier_price'];
        $tier->model_type = $request['model_type'];
        $tier->posting_order = $request['posting_order'];
        $tier->parameter1 = $request['parameter1'];
        $tier->parameter2 = $request['parameter2'];
        $tier->parameter3 = $request['parameter3'];
        $tier->ping_url_test = $request['ping_url_test'];
        $tier->post_url_test = $request['post_url_test'];
        $tier->ping_url_live = $request['ping_url_live'];
        $tier->post_url_live = $request['post_url_live'];
        $tier->timeout = $request['timeout'];
        $tier->mode = $request['mode'];
        $tier->status = $request['status'];
        $tier->rotate = $request['rotate'];
        $tier->buyer_id = $request['buyer_id'];

        $data = $tier->toArray();
        $res = $tier->save($data);
//        dd($res);



        return Response::json('Tier updated successfully', 200);


    }

    /**
     *
     * @param Request $request
     */
    public function FetchBuyerSetupData(Request $request)
    {
        $buyer_name = $request->input("buyername");
        $tier_price= $request->input("tier_price");
        $lead_type = $request->input("leadtype");
        $mode = $request->input("mode");
        $status = $request->input("status");

        $wherelist = array();
        if ($lead_type != null) {
            $wherelist[] = ['leadtype', '=', $lead_type];
        }
        if ($buyer_name != null) {
            $wherelist[] = ['buyername', '=', $buyer_name];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($mode != null) {
            $wherelist[] = ['mode', '=', $mode];
        }
        if ($tier_price != null) {
            $wherelist[] = ['tier_price', '=', $tier_price];
        }

        $datas = Buyersetup::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }

}


