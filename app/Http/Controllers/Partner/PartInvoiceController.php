<?php

namespace App\Http\Controllers\Partner;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PartInvoiceController extends Controller
{
    public function index()
    {

    }

    public function show()
    {

    }



    /**
     * @param Request $request
     * @return array|mixed
     */
    public function GetPartnerInvoiceData(Request $request)
    {

        $offer_id = $request->input("offer_id");
        $partner_id = $request->input("partner_id");
        $invoice_id = $request->input("invoice_id");
        $status = $request->input("status");

        if($request->input("date")!=null){
            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input("date"));
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
        if ($invoice_id != null) {
            $wherelist[] = ['invoice_id', '=', $invoice_id];
        }
        if ($partner_id != null) {
            $wherelist[] = ['partner_id', '=', $partner_id];
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

//        $currency_type = $partner_lead_type->currencyType;

        $user_id = Auth::id();
        $partner = Partner::where('user_id', $user_id)->get()->first();
        $partner_id = $partner->id;

        $datas = (object)[];
        $datas = Invoice::where($wherelist)->where('partner_id', $partner_id)->with(['partner', 'advertiser'])->get();

        echo json_encode(['data' => $datas]);
    }
}
