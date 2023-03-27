<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Buyer\Buyer;
use App\Models\Invoice\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Lead\UKLead;
use App\Models\PostbackLog;
use App\Models\PostbackTracker\PostbackTracker;
use App\Models\User\Company;
use App\Models\User\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");

        $invoices = Invoice::all()->paginate($perPage);

        return Response::json(['invoices' => $invoices]);
    }

    public function getBuyerInvoices(Request $request, $id)
    {
        $invoices = Invoice::where('buyer_id', $id)->get();

        return Response::json(['invoices' => $invoices], 200);
    }

    public function getPartnerInvoices(Request $request, $id)
    {
        $invoices = Invoice::where('partner_id', $id)->get();
        $invoices = Company::where('id', $invoices[0]->company_id)->with('invoices')->get();

        return Response::json(
            [
                'invoices' => $invoices,
            ]
        );
    }


    public function getTierInvoices(Request $request, $id)
    {
        $invoices = Invoice::where('buyer_setup_id', $id)->get();
//        dd($invoices);
        $invoices = Company::where('id', $invoices[0]->company_id)->with('invoices')->get();

        return Response::json(
            [
                'invoices' => $invoices,
            ]
        );
    }













    public function getAdvertiserInvoices(Request $request, $id)
    {
        $invoices = Invoice::where('advertiser_id', $id)->get();
//        dd($invoices);

        return Response::json(['invoices' => $invoices,  200]);
    }
    public function getCompanyInvoices(Request $request, $id)
    {
        $invoices = Invoice::where('company_id', $id)->get();
//        dd($invoices);

        return Response::json(['invoices' => $invoices,  200]);
    }
    public function show($id)
    {
        $invoice = Invoice::where('id', $id)->first();
//        dd();
//        $company_id = $invoice->company_id;
        $invoice['company'] = Company::where('id', $invoice->company_id)->first();
        $invoice['payment'] = Payment::where('user_id', $invoice['company']['user_id'])->first();
        $invoice['products'] = InvoiceProduct::where('invoice_id', $invoice['id'])->get();
        $vendor_id = 'AFF_11111';
        $invoice['commissions'] = $this->getBuyerInvoiceMetrics($vendor_id);



        return Response::json(['invoice' => $invoice], 200);
    }


    public function getBuyerInvoiceMetrics($buyer_id)
    {

        $metrics = [];

        $commission_uk = DB::table('uk_leads')->where('buyer_id', $buyer_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();

        $metrics['uk_lead_count'] = $commission_uk->count();
        $metrics['uk_buyer_invoice'] = $commission_uk->pluck('buyerLeadPrice')->sum();
        $metrics['uk_vendor_invoice']  = $commission_uk->pluck('vidLeadPrice')->sum();

        $commission_us = DB::table('us_leads')->where('buyer_id', $buyer_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();


        $metrics['us_lead_count'] = $commission_us->count();
        $metrics['us_buyer_invoice'] = $commission_us->pluck('buyerLeadPrice')->sum();
        $metrics['us_vendor_invoice'] = $commission_us->pluck('vidLeadPrice')->sum();


        return $metrics;

    }
    public function getPartnerInvoiceMetrics($vendor_id)
    {
        $metrics = [];

        $commission_uk = DB::table('uk_leads')->where('vid', $vendor_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();

        $metrics['uk_lead_count'] = $commission_uk->count();
        $metrics['uk_buyer_invoice'] = $commission_uk->pluck('buyerLeadPrice')->sum();
        $metrics['uk_vendor_invoice']  = $commission_uk->pluck('vidLeadPrice')->sum();

        $commission_us = DB::table('us_leads')->where('vid', $vendor_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();

//        $commission_offer = PostbackLog::where('partner_id', $vendor_id) // get partner id
//            ->where('created_at', '>=', date('Y-m-d'))
//            ->where('created_at', '<=', date('Y-m-d') . "23:53:53");
//        $totalCost = $daily->pluck('totalCost')->sum();


        $metrics['us_lead_count'] = $commission_us->count();
        $metrics['us_buyer_invoice'] = $commission_us->pluck('buyerLeadPrice')->sum();
        $metrics['us_vendor_invoice'] = $commission_us->pluck('vidLeadPrice')->sum();


        return $metrics;

    }
    public function getAdvertiserInvoiceMetrics($advertiser_id)
    {
        $metrics = [];

        // Advertiser
        $commission_offer = PostbackTracker::where('advertiser_id', $advertiser_id) // get partner id
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('created_at', '<=', date('Y-m-d') . "23:53:53");

        $totalRevenue = $commission_offer->pluck('totalRevenue')->sum();

        $metrics['advertiser_total'] = $totalRevenue; // Advertiser


        return $metrics;
    }
    public function getBuyerTierInvoiceMetrics($tier_id)
    {
        $metrics = [];

        $commission_uk = DB::table('uk_leads')
            ->where('buyer_setup_id', $tier_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();

        $metrics['uk_lead_count'] = $commission_uk->count();
        $metrics['uk_buyer_tier_invoice'] = $commission_uk->pluck('buyerLeadPrice')->sum();

        $commission_us = DB::table('us_leads')
            ->where('buyer_setup_id', $tier_id )
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->get();


        $metrics['us_lead_count'] = $commission_us->count();
        $metrics['us_buyer_tier_invoice'] = $commission_us->pluck('buyerLeadPrice')->sum();


        return $metrics;
    }

    public function sendInvoice($id)
    {
        Mail::send(['text' => 'mail'],['name', 'David'], function($message){
            $message->to('test123@gmail.com')->subject('Test Email');
            $message->from('testmail@gmail.com', 'David');
        });

        return Response::json('Invoice Sent', 200);
    }
    public function downloadInvoice($id)
    {
        Mail::send(['text' => 'mail'],['name', 'David'], function($message){
            $message->to('test123@gmail.com')->subject('Test Email');
            $message->from('testmail@gmail.com', 'David');
        });

        return Response::json('Invoice Sent', 200);
    }



















    public function store(Request $request) {


        $invoice = new Invoice();
        $invoice->name = $request['invoice']['name'];
//        $invoice->company = $request['invoice']['company'];
        $invoice->account_contact1 = $request['invoice']['account_contact1'];
        $invoice->account_contact2 = $request['invoice']['account_contact2'];
        $invoice->invoice_type = $request['invoice']['invoice_type'];
        $res = $invoice->save();

        $company = new Company();
        $company->user_id = $request['invoice']['user_id'] ?? 1;
        $company->invoice_id = $invoice->id;
        $company->name = $request['invoice']['company'];
        $company->email = $request['invoice']['email'];
        $company->phone = $request['invoice']['phone'];
        $company->skype = $request['invoice']['skype'] ?? '';
        $company->address1 = $request['invoice']['address'] ?? '';;
        $company->city = $request['invoice']['city'] ?? '';;
        $company->state = $request['invoice']['state'] ?? '';;
        $company->country = $request['invoice']['country'] ?? '';;
        $company->website = $request['invoice']['website'] ?? '';;
        $res = $company->save();
        return $invoice;
    }


    public function edit($id)
    {
        $invoice = Invoice::with(['company'])->where('id', $id)->first();



        return Response::json(['invoice' => $invoice]);
    }
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return Response::json(['Invoice deleted successfully', 200]);
    }
    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));

        $invoice = Invoice::find($id);
        $invoice->user_id = $request->invoice->user_id2;
        $invoice->firstName = $request->invoice->firstName2;
        $invoice->lastName = $request->invoice->lastName2;
        $invoice->email = $request->invoice->email2;
        $invoice->phone = $request->invoice->phone2;
        $invoice->company = $request->invoice->company2;
        $invoice->address = $request->invoice->address2;
        $invoice->city = $request->invoice->city2;
        $invoice->state = $request->invoice->firstName2;
        $invoice->country = $request->invoice->country2;
        $invoice->postcode = $request->invoice->postcode2;
        $invoice->status = $request->invoice->status2;

        $data = $invoice->toArray();
        $invoice->save($data);

        return Response::json([$invoice, 200]);


    }

}
