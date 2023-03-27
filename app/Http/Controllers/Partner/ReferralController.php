<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    public function index()
    {
        return view('partner.referral.reports-referral');
    }

    public static function add_commission( $referrer_data )
    {
        $query = DB::table('referrals')->insert($referrer_data);
        Log::debug('REFERRER::', (array)$query);

         return $query;
    }



}
