<?php

namespace App\Http\Controllers\Admin\Buyer;

use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\User;
use App\Models\User\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class BuyerController extends Controller
{

    public function index(Request $request)
    {

        $perPage = $request->input("perPage");
        $buyerType = $request->input("buyerType");
        $status = $request->input("status");


        $wherelist = array();
        if ($buyerType != null) {
            $wherelist[] = ['buyer_type', '=', $buyerType];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $buyers = Buyer::where($wherelist)->with(['company'])->paginate($perPage);

        return Response::json(['buyers' => $buyers]);
    }
    public function getBuyer(Request $request, $id){

    }
    public function store(Request $request) {


        $buyer = new Buyer();
        $buyer->name = $request['buyer']['name'];
        $buyer->account_contact1 = $request['buyer']['account_contact1'];
        $buyer->account_contact2 = $request['buyer']['account_contact2'];
        $buyer->buyer_type = $request['buyer']['buyer_type'];
        $buyer->avatar = $request['buyer']['avatar'] ?? 'default.jpg';
        $res = $buyer->save();

        $company = new Company();
        $company->user_id = $request['buyer']['user_id'] ?? 1;
        $company->buyer_id = $buyer->id;
        $company->name = $request['buyer']['company'];
        $company->email = $request['buyer']['email'];
        $company->phone = $request['buyer']['phone'];
        $company->skype = $request['buyer']['skype'] ?? '';
        $company->address1 = $request['buyer']['address'] ?? '';;
        $company->city = $request['buyer']['city'] ?? '';;
        $company->state = $request['buyer']['state'] ?? '';;
        $company->country = $request['buyer']['country'] ?? '';;
        $company->website = $request['buyer']['website'] ?? '';;
        $res = $company->save();

        $buyer->company_id = $company->id;
        $data = $buyer->toArray();
        $res = $buyer->save($data);


        return Response::json('Buyer added successfully', 200);
    }
    public function show($id)
    {
        $buyer = Buyer::with(['company'])->where('id', $id)->first();
        $buyer['tiers'] = BuyerSetup::where('buyer_id', $buyer->id)->get();



        return Response::json(['buyer' => $buyer], 200);
    }
    public function edit($id)
    {
        $buyer = Buyer::with(['company'])->where('id', $id)->first();
        $buyer['tiers'] = BuyerSetup::where('buyer_id', $buyer->id)->get();



        return Response::json(['buyer' => $buyer], 200);

    }
    public function destroy($id)
    {
        $buyer = Buyer::find($id);
        $buyer->delete();

        return Response::json('Buyer deleted successfully', 200);
    }
    public function update(Request $request, $id)
    {
//        dd($request->input());
        $buyer = Buyer::findOrFail($id);
        $buyer->name = $request['name'];
        $buyer->account_contact1 = $request['account_contact1'];
        $buyer->account_contact2 = $request['account_contact2'];
        $buyer->buyer_type = $request['buyer_type'];
        $buyer->avatar = $request['avatar'];

        $data = $buyer->toArray();
        $res = $buyer->save($data);

//        dd($res);
//        $company =  Company::findOrFail($id);
//        $company->user_id = $request['user_id'] ?? 1;
//        $company->buyer_id = $buyer->id;
//        $company->name = $request['company'];
//        $company->email = $request['email'];
//        $company->phone = $request['phone'];
//        $company->skype = $request['skype'] ?? '';
//        $company->address1 = $request['address'] ?? '';;
//        $company->city = $request['city'] ?? '';;
//        $company->state = $request['state'] ?? '';;
//        $company->country = $request['country'] ?? '';;
//        $company->website = $request['website'] ?? '';;
//        $res = $company->save();

        return Response::json('Buyer added successfully', 200);

    }

    /**
     *
     * @param Request $request
     */
    public function FetchBuyerData(Request $request)
    {
        $buyer_id = $request->input("buyer_id");
        $company = $request->input("company");
        $status = $request->input("status");

        $wherelist = array();
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($buyer_id != null) {
            $wherelist[] = ['id', '=', $buyer_id];
        }
        if ($company != null) {
            $wherelist[] = ['company', '=', $company];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        $datas = Buyer::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }

    public function getBuyerSetups(Request $request, $buyerId)
    {
        $buyersetups = BuyerSetup::where('buyer_id', $buyerId)->get();

        return response()->json($buyersetups->toArray());
    }
}








