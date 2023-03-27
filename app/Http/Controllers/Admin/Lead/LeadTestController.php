<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Buyersetup;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeadPostRequest;
use App\Models\LmsPaydayUK;
use App\Pubbuyermapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadTestController extends Controller
{


    public function getTestBuyer()
    {
        $query = DB::table('buyer_setups')
            ->select(
                'buyer_setups.*',
                'buyers.*',
//                'lms_buyer_leadtype.*'
            )
            ->leftJoin(
                'buyers',
                'buyer_setups.buyer_id',
                '=',
                'buyers.id'
            )
            ->where('buyername', '=', 'testmodeuk')
            ->get()
            ->toArray();

        return $query;

    }
    public function getTestBuyerUS()
    {
        $query = DB::table('buyer_setups')
            ->select(
                'buyer_setups.*',
                'buyers.*',
//                'lms_buyer_leadtype.*'
            )
            ->leftJoin(
                'buyers',
                'buyer_setups.buyer_id',
                '=',
                'buyers.id'
            )
            ->where('buyername', '=', 'testmodeus')
            ->get()
            ->toArray();

        return $query;

    }

    /**
     * This function is the endpoint for the testing parameter defined in PaydayUK Table.
     *
     *
     * @param Request $request
     */
    public function testMode(Request $request)
    {
        sleep(1);

        $final_res = $this->sendResponse();

        return $final_res;
    }

    /**
     * Send stimulated response back to client for testing.
     *
     * @return string
     */
    public function sendResponse()
    {
        header("Content-type: text/xml; charset=utf-8");
        $response = '<?xml version="1.0" encoding="utf-8"?>';
        $response .= '<Payout>0.01</Payout><Result>1</Result><RedirectURL>http://www.google.com</RedirectURL>';

        echo $response;
        return $response;


    }
}

/**
 * [2021-12-12 12:54:48] production.DEBUG: GET BUYERS:: {"timestamps":true,"incrementing":false,"\u0000*\u0000guarded":[],"\u0000*\u0000table":"lmspaydayuks","\u0000*\u0000keyType":"string","\u0000*\u0000primaryKey":"id","\u0000*\u0000connection":"mysql","\u0000*\u0000with":[],"\u0000*\u0000withCount":[],"preventsLazyLoading":false,"\u0000*\u0000perPage":15,"exists":true,"wasRecentlyCreated":false,"\u0000*\u0000attributes":{"id":"586f4de5-72a7-423a-993e-a36642671f14","uuid":null,"source_id":16,"loan_id":15,"applicant_id":15,"residence_id":14,"employer_id":13,"expense_id":12,"bank_id":13,"consent_id":13,"additional_id":null,"transaction_id":null,"vid":"AFF_1","subid":"12345","oid":1,"tier":0,"minCommissionAmount":"0.00","maxCommissionAmount":"0.00","timeout":null,"istest":1,"response_type":"json","buyerid":null,"buyerTierID":null,"vidLeadPrice":null,"buyerLeadPrice":null,"leadStatus":3,"model_type":null,"quality_score":null,"isRedirected":null,"redirectUrl":null,"created_at":"2021-12-12 12:54:47","updated_at":"2021-12-12 12:54:47","search":{"stdClass":{"tier":0,"vid":"AFF_1","leadtype":"paydayus"}},"buyer_list":[{"stdClass":{"id":1,"leadtype":"testmodeuk","buyer_id":1,"buyername":"testmodeuk","tier_price":10.0,"model_type":"1","posting_order":1,"parameter1":"testmodeuk","parameter2":"testmodeuk","parameter3":"testmodeuk","ping_url_test":"https://www.google.com","post_url_test":"https://www.google.com","ping_url_live":"https://www.google.com","post_url_live":"https://www.google.com","timeout":120,"mode":1,"status":1,"rotate":0,"notes":null,"created_at":null,"updated_at":null,"user_id":1,"firstName":"testmodeus","lastName":"testmodeus","email":"testmodeus","company":"testmodeus","phone":"0777777","birthdate":"testmodeus","address":"testmodeus","jobTitle":"testmodeus","city":"testmodeus","state":"testmodeus","country":"testmodeus","postcode":"testmodeus","website":"testmodeus","fcaLicense":null,"icoLicense":null}}]},"\u0000*\u0000original":{"id":"586f4de5-72a7-423a-993e-a36642671f14","uuid":null,"source_id":16,"loan_id":15,"applicant_id":15,"residence_id":14,"employer_id":13,"expense_id":12,"bank_id":13,"consent_id":13,"additional_id":null,"transaction_id":null,"vid":"AFF_1","subid":"12345","oid":1,"tier":0,"minCommissionAmount":"0.00","maxCommissionAmount":"0.00","timeout":null,"istest":1,"response_type":"json","buyerid":null,"buyerTierID":null,"vidLeadPrice":null,"buyerLeadPrice":null,"leadStatus":3,"model_type":null,"quality_score":null,"isRedirected":null,"redirectUrl":null,"created_at":"2021-12-12 12:54:47","updated_at":"2021-12-12 12:54:47"},"\u0000*\u0000changes":[],"\u0000*\u0000casts":[],"\u0000*\u0000classCastCache":[],"\u0000*\u0000dates":[],"\u0000*\u0000dateFormat":null,"\u0000*\u0000appends":[],"\u0000*\u0000dispatchesEvents":[],"\u0000*\u0000observables":[],"\u0000*\u0000relations":{"source":null,"loan":null,"applicant":null,"employer":null,"residence":null,"bank":null,"consent":null,"expense":null,"additional":null},"\u0000*\u0000touches":[],"\u0000*\u0000hidden":[],"\u0000*\u0000visible":[],"\u0000*\u0000fillable":[]}
[2021-12-12 12:54:48] production.DEBUG: BUYER:: {"row":[{"stdClass":{"id":1,"leadtype":"testmodeuk","buyer_id":1,"buyername":"testmodeuk","tier_price":10.0,"model_type":"1","posting_order":1,"parameter1":"testmodeuk","parameter2":"testmodeuk","parameter3":"testmodeuk","ping_url_test":"https://www.google.com","post_url_test":"https://www.google.com","ping_url_live":"https://www.google.com","post_url_live":"https://www.google.com","timeout":120,"mode":1,"status":1,"rotate":0,"notes":null,"created_at":null,"updated_at":null,"user_id":1,"firstName":"testmodeus","lastName":"testmodeus","email":"testmodeus","company":"testmodeus","phone":"0777777","birthdate":"testmodeus","address":"testmodeus","jobTitle":"testmodeus","city":"testmodeus","state":"testmodeus","country":"testmodeus","postcode":"testmodeus","website":"testmodeus","fcaLicense":null,"icoLicense":null}}]}
[2021-12-12 12:54:48] production.ERROR: Undefined property: stdClass::$buyersetup_id {"exception":"[object] (ErrorException(code: 0): Undefined property: stdClass::$buyersetup_id at /home/forge/portal.uping.co.uk/app/Models/BuyerFilter.php:313)

 */
