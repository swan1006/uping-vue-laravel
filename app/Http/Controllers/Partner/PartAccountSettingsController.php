<?php

namespace App\Http\Controllers\Partner;

use App\LmsPartnerLeadType;
use App\Models\User;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PartAccountSettingsController extends Controller
{

    public function index()
    {
        $id = Auth::id();
        $user = User::find($id);
        $partner = User::find($id)->partner;
//        dd($partner);

//        dd($partner->user->avatar);
        return view('partner.profile.account-settings', compact('user', 'id','partner'));
    }

    /**
     * @param Request $request
     */
    public function uploadAvatar(Request $request, $id)
    {
        $user_id = $request->input('user_id');
        $partner_id = Partner::where('user_id', $user_id)->get()->first()->id;
//        dd($user_id, $id);


        if($request->hasFile('avatar')){

            $uploadedLogoFile = $request->file('avatar');
            $uploadedLogoFileName = time() . '/' . $uploadedLogoFile->getClientOriginalName();
            $path = $uploadedLogoFile->storePubliclyAs('avatar/' . $user_id . '/', $uploadedLogoFileName, 's3');

            $partner = Partner::find($partner_id);
            $partner->user_id = $id;
            $partner->avatar = $uploadedLogoFileName;
            $partner->save();

            return redirect()->back()
                ->with('success', 'Avatar Updated!');
        }
    }


    public function update(Request $request, $id)
    {

        $request = json_decode(json_encode($request->input()));


        $partner = Partner::find($id);

        $partner->user_id = $request->account->user_id;
        $partner->firstName = $request->account->firstName;
        $partner->lastName = $request->account->lastName;
        $partner->company = $request->account->company;
        $partner->jobTitle = $request->account->jobTitle;
        $partner->phone = $request->account->phone;
        $partner->birthdate = $request->account->birthdate;
        $partner->address = $request->account->address;
        $partner->city = $request->account->city;
        $partner->state = $request->account->state;
        $partner->postcode = $request->account->postcode;
        $partner->country = $request->account->country;
        $partner->website = $request->account->website;
        $partner->fcaLicense = $request->account->fcaLicense;
        $partner->icoLicense = $request->account->icoLicense;
        $partner->status = '1';

        $data = $partner->toArray();
        $partner->save($data);


        return Response::json($partner);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCurrency(Request $request)
    {
        $partner_id = $request->input('partner_id');
        $partner_id = $request->input('GBP');
        $id = LmsPartnerLeadType::where('vid', $partner_id)->get()->first()->id;

        $request = json_decode(json_encode($request->input()));

        $partner = LmsPartnerLeadType::find($id);
        if ($request->account->GBP != null) {
        $partner->currencyType = $request->input('GBP');
        }
        if ($request->account->USD != null) {
            $partner->currencyType = $request->input('USD');
        }
        $data = $partner->toArray();
        $partner->save($data);

        return Response::json($partner);
    }


}
