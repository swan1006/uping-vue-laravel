<?php

namespace App\Http\Controllers\Partner;

use App\Models\User;
use App\Models\User\Company;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class PartController extends Controller
{

    public function getUserData($id)
    {
        $user = User::findOrFail($id)->with(['company'])->first();


        return Response::json(['user' => $user], 200);

    }

    public function updateAccountInfo(Request $request, $id)
    {

        $user = User::find($id);
        $user->name = $request['user']['name'];
        $user->username = $request['user']['username'];
        $user->email = $request['user']['email'];
        $user->is_admin = $request['user']['is_admin'] ?? 0;
        $user->status = $request['user']['status'];

        $data = $user->toArray();
        $res = $user->save($data);


        return Response::json('Account updated successfully.', 200);
    }

    public function UpdateAccountPassword(Request $request, $id)
    {
        dd('here');
        dd($request);

//
//            $request->validate([
//                'current_password' => ['required', new MatchOldPassword],
//                'new_password' => ['required'],
//                'new_confirm_password' => ['same:new_password'],
//            ]);
//
//            User::find($id)->update(['password' => Hash::make($request->new_password)]);
//
////            return back();
//
//        return Response::json('Password updated successfully.', 200);

    }


    public function updateCompany(Request $request, $id)
    {

        $company_info = Company::find($id);
        $company_info->phone = $request['phone'] ?? '';
        $company_info->birth_date = $request['birth_date'] ?? '';
        $company_info->website = $request['website'] ?? '';
        $company_info->skype = $request['skype'] ?? '';
        $company_info->contact_options = $request['contact_options'] ?? '';
        $company_info->address1 = $request['address1'] ?? '';
        $company_info->address2 = $request['address2'] ?? '';
        $company_info->postcode = $request['postcode'] ?? '';
        $company_info->city = $request['city'] ?? '';
        $company_info->state = $request['state'] ?? '';
        $company_info->country = $request['country'] ?? '';

        $data = $company_info->toArray();
        $res = $company_info->save($data);
//        dd($res);

        return response()->json('User Information updated successfully.');

    }

}
