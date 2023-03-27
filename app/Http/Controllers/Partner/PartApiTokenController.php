<?php

namespace App\Http\Controllers\Partner;

use App\Models\Passport\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class PartApiTokenController extends Controller
{
    /**
     * @param Request $request
     */
    public function generate_token(Request $request)
    {
        $username = Auth::user()->name;
        $token = $request->user()->createToken($username);
        $token = $token->plainTextToken;

        $id = Auth::id();
        $user = \App\Models\User::find($id);
        $partner = User::find($id)->partner;

        return view('partner.account-settings', compact('token', 'user', 'partner'));
    }

    /**
     * Generate API Token via Sanctum and return it to the account settings page.
     *
     * @param Request $request
     */
    public function generateToken2(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $token = $user->createToken($user->name);
        $partner = $user->partner;
//        dd($partner);
//        dd($token);

        return view('partner.account-settings', compact('token', 'partner'));
    }

    /**
     *
     */
    public function export_conversion_report()
    {
        //
    }

    /**
     *
     */
    public function export_revenue_report()
    {
        //
    }

}
