<?php

namespace App\Http\Controllers\Admin\Advertiser;

use App\Models\Advertiser\Advertiser;
use App\Http\Controllers\Partner\Controller;
use App\Models\User;
use App\Models\Offer\Offer;
use App\Models\Partner\Partner;
use App\Models\User\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AdvertiserController extends Controller
{

    public function fetchUserIds(Request $request)
    {
        $user_ids = User::with(['company'])->groupBy('id')->whereNotNull('id')->get(['id', 'name']);

        return Response::json(['user_ids' => $user_ids]);

    }

    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $status = $request->input("status");
        $query = $request->input("q");



        $wherelist = array();
        if ($query != null) {
            $wherelist[] = ['leadtype', 'LIKE', '%{$query}%']; // 'LIKE', "%{$searchTerm}%") TODO
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $advertisers = Advertiser::with(['company'])->where($wherelist)->paginate($perPage);


        return Response::json(['advertisers' => $advertisers]);
    }

    public function getAdvertiser(Request $request, $id){
        $advertiser = Advertiser::with('company')->where('id',$id)->first();


        return Response::json(['advertiser' => $advertiser]);
    }

    public function store(Request $request) {

        $advertiser = new Advertiser();
        $advertiser->user_id = $request['advertiser']['user_id'];
//        $advertiser->username = $request['advertiser']['username'];
        $advertiser->role = $request['user']['role'];
        $res = $advertiser->save();
        dd($res);

        $company = new Company();
        $company->name = $request['company']['company'];
        $company->email = $request['company']['email'];
        $company->phone = $request['company']['phone'];
        $company->skype = $request['company']['skype'] ?? '';
        $company->address1 = $request['company']['address'] ?? '';;
        $company->city = $request['company']['city'] ?? '';;
        $company->state = $request['company']['state'] ?? '';;
        $company->country = $request['company']['country'] ?? '';;
        $company->website = $request['company']['website'] ?? '';;
        $res = $company->save();

        $company_update = Advertiser::findOrFail($advertiser->id);
        $company_update->company_id = $company->id;
        $data = $company_update->toArray();
        $res = $company_update->save($data);


        return Response::json('User saved successfully', 200);


    }
    public function update(Request $request, $id) {


//        dd($request['company']);
        $advertiser = Advertiser::findOrFail($id);
//        $advertiser->user_id =  $request->user_id;
//        $advertiser->company =  $request->company;
        $advertiser->status =  $request->status;
        $data = $advertiser->toArray();
        $res = $advertiser->save($data);

        // TODO Refactor
        $company = Company::find($id);
        $company->name = $request['company']['name'];
        $company->email = $request['company']['email'];
        $company->phone = $request['company']['phone'];
        $company->skype = $request['company']['skype'] ?? '';
        $company->address1 = $request['company']['address'] ?? '';;
        $company->city = $request['company']['city'] ?? '';;
        $company->state = $request['company']['state'] ?? '';;
        $company->country = $request['company']['country'] ?? '';;
        $company->website = $request['company']['website'] ?? '';;
        $data = $company->toArray();
        $res = $company->save($data);
//        dd($res);


        return Response::json('Advertiser updated successfully', 200);

    }









    public function show($id)
    {
        $advertiser = Advertiser::find($id)->with(['company'])->first();

        return Response::json(['advertiser' => $advertiser]);


    }
    public function edit($id)
    {
        $advertiser = Advertiser::find($id);

        echo json_encode(['data' => $advertiser]);

    }
    public function destroy($id)
    {
        $advertiser = Advertiser::find($id);
        $advertiser->delete();

        return response()->json([
            'message' => 'Advertiser deleted successfully!'
        ]);
    }


    /**
     * @param Request $request
     * @return array|mixed
     */
    public function FetchAdvData(Request $request)
    {

        $offer_id = $request->input("offer_id");
        $partner_id = $request->input("partner_id");
        $block = $request->input("block");
        $status = $request->input("status");

        if($request->input("date")!=null){
            $date = Carbon::createFromFormat('d/m/Y', $request->input("date"));
        }else{
            $date = null;
        }
        if($request->input("enddate")!=null){
            $enddate = Carbon::createFromFormat('d/m/Y', $request->input("enddate"));
        }else{
            $enddate = null;
        }

        $wherelist = array();
        if ($offer_id != null) {
            $wherelist[] = ['offer_id', '=', $offer_id];
        }
        if ($partner_id != null) {
            $wherelist[] = ['partner_id', '=', $partner_id];
        }
        if ($block != null) {
            $wherelist[] = ['block', '=', $block];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($date != null) {
            $wherelist[] = ['created_at', '>=', $date];
        }
        if ($enddate != null) {
            $wherelist[] = ['created_at', '<=', $enddate];
        }

        $datas = Advertiser::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }
}
