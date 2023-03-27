<?php

namespace App\Http\Controllers\Admin\Partner;


use App\Http\Controllers\Controller;
use App\Lmscallcenter;
use App\LmsPartnerLeadType;
use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\Mapping\Mapping;
use App\Models\Partner\Partner;
use App\Models\User;
use App\Models\User\Company;
use App\Models\User\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function fetchUserIds()
    {
        $userListData = User::groupBy('id')->whereNotNull('id')->get(['id', 'username']);

        return Response::json(['userListData' => $userListData]);

    }

    public function getPartner(Request $request, $id){
        $partner = User::with(['company', 'partner', 'payment'])->where('id',$id)->first();


        return Response::json(['partner' => $partner]);
    }
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $status = $request->input("status");
        $query = $request->input("searchQuery");

        $wherelist = array();
        if ($query != null) {
            $wherelist[] = ['leadtype', 'LIKE', $query];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $partners = User::with(['company', 'partner'])->where($wherelist)->paginate($perPage);


        return Response::json(['partners' => $partners]);
    }
    public function show($id)
    {
        $partner =  User::with(['company', 'partner', 'payment'])->where('id', $id)->get();

        return Response::json(['partner' => $partner], 200);

    }
    public function edit($id)
    {
        $partner =  User::with(['company', 'partner', 'payment'])->where('id', $id)->get();


        return Response::json(['partner' => $partner], 200);

    }
    public function destroy($id)
    {
        $partner = Partner::find($id);
        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully!'
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->input());
        $partner = new Partner();
        $partner->user_id = $request['partner']['user_id'];
        $partner->company_id = User::find($partner->user_id)->first()->id;
        $partner->vendor_id = $request['partner']['vendor_id'];
//        $partner->leadtype = $request['leadtype'];
        $partner->status =1;
        $partner->icoLicense = $request['partner']['icoLicense'] ?? '';
        $partner->fcaLicense = $request['partner']['fcaLicense'] ?? '';
        $partner->save();

        $partner->lead_type = $request['partner']['lead_type'];

        $default_tiers = BuyerSetup::where('status', 1)->get();

        foreach ($default_tiers as $tier) {
                $mapping = new Mapping();
                $mapping->partner_id = $partner->id;
                $mapping->buyer_id = $tier->buyer_id;
                $mapping->buyer_setup_id = $tier->id;
                $mapping->leadtype = $partner->lead_type;
                $mapping->status = 1;
                $mapping->save();
        }
        return Response::json('Partner & Mappings created successfully', 200);
    }
    public function update(Request $request, $id)
    {
        $partner = Partner::find($id);
        $partner->vendor_id = $request['partner']['vendor_id'];
        $partner->status =  $request['partner']['status'];
        $partner->icoLicense =  $request['partner']['icoLicense'];
        $partner->fcaLicense =  $request['partner']['fcaLicense'];
        $data = $partner->toArray();
        $partner->save($data);

//        dd($request->input());
        $company = Company::findOrFail($partner->company_id);
        $company->user_id = $partner->user_id;
        $company->partner_id = $partner->id;
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


        return Response::json('Partner updated successfully', 200);


    }

    /**
     *
     * @param Request $request
     */
    public function FetchPartnerData(Request $request)
    {
        $id = $request->input("id");
        $company = $request->input("company");
        $user_id = $request->input("user_id");
        $status = $request->input("status");

        $wherelist = array();
        if ($id != null) {
            $wherelist[] = ['id', '=', $id];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($user_id != null) {
            $wherelist[] = ['user_id', '=', $user_id];
        }
        if ($company != null) {
            $wherelist[] = ['company', '=', $company];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        $datas = Partner::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePartnerPayment(Request $request, $id)
    {

        dd($request->input());
        $user = Payment::find($request['payment']['id']);
        $user->bank_name = $request['payment']['bank_name'];
        $user->bank_iban = $request['payment']['bank_iban'];
        $user->bank_account_number = $request['payment']['bank_account_number'];
        $user->bank_swift = $request['payment']['bank_swift'];
        $user->bank_sortcode = $request['payment']['bank_sortcode'];
        $user->bank_country = $request['payment']['bank_country'];
        $user->bank_phone = $request['payment']['bank_phone'];

        $data = $user->toArray();
//        dd($data);
        $res = $user->save($data);

        return response()->json('User Information updated successfully.');

    }


}

