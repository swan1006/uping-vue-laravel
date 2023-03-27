<?php

namespace App\Http\Controllers\Partner;

use App\Lmsleadlog;
use App\Models\ClickTracker\ClickTracker;
use App\Models\ConversionTracker;
use App\Models\Creatives;
use App\Models\Invoice;
use App\Models\Lander;
use App\Models\Lead\UKLead;
use App\Models\Metrics;
use App\Models\OfferLogs;
use App\Models\Partner\Partner;
use App\Models\PostbackLog;
use App\Models\PostbackTracker\PostbackTracker;
use App\Models\User;
use App\Models\Offer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class PartDashboardController extends Controller
{

    public function getDashboardLeadDataPartner($id)
    {

        $partner = Partner::where('id', '=', $id)->first();
        $vendor_id = $partner->vendor_id;

        $dashboard_data = [];
        // CARDS
        $dashboard_data['todayMetrics'] = $this->todayMetrics($vendor_id);
        $dashboard_data['weekMetrics'] = $this->weekMetrics($vendor_id);
        $dashboard_data['monthMetrics'] = $this->monthMetrics($vendor_id);

//        $dashboard_data['redirectionMetrics'] = $this->redirectionMetrics();


        // CHART DATA
//        $dashboard_data['affiliate_table_data'] = $this->affiliateChartData();

        // LIST
        $dashboard_data['affiliate_table_data'] = $this->affiliateLeadList($vendor_id);

        return Response::json(['dashboard_data' => $dashboard_data], 200);

    }

    public function todayMetrics($vendor_id)
    {
        $daily = DB::table('uk_leads');

        $daily
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
            ->where('vendor_id', $vendor_id)
            ->count();

        $vid_lead_price_total = $daily->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $daily->pluck('buyerLeadPrice')->sum();
        $revenue['today_revenue'] = $buyer_lead_price_total;
        $revenue['today_cost'] = $buyer_lead_price_total;
        $revenue['today_profit'] = $buyer_lead_price_total - $vid_lead_price_total;
//        $revenue['series'] = [$revenue['today_profit'], $revenue['today_cost'], $revenue['today_revenue'] ];
        $revenue['series'] = [50, 50, 70];

        return $revenue;
    }
    public function weekMetrics($vendor_id)
    {
        $weekly = DB::table('uk_leads');

        $weekly
            ->where('created_at', '>=', date('Y-m-d', strtotime("-7 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->where('vendor_id', $vendor_id)
            ->count();


        $vid_lead_price_total = $weekly->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $weekly->pluck('buyerLeadPrice')->sum();
        $revenue['week_revenue'] = $buyer_lead_price_total;
        $revenue['week_cost'] = $buyer_lead_price_total;
        $revenue['week_profit'] = $buyer_lead_price_total - $vid_lead_price_total;

        return $revenue;
    }
    public function monthMetrics($vendor_id)
    {
        $month = DB::table('uk_leads');

        $month
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")
            ->where('vendor_id', $vendor_id)
            ->count();


        $vid_lead_price_total = $month->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $month->pluck('buyerLeadPrice')->sum();
        $revenue['month_revenue'] = $buyer_lead_price_total;
        $revenue['month_cost'] = $buyer_lead_price_total;
        $revenue['month_profit'] = $buyer_lead_price_total - $vid_lead_price_total;

        return $revenue;
    }
    public function redirectionMetrics($vendor_id)
    {

        $redirected_lead_count = UKLead::whereDate('created_at', Carbon::today())
            ->where('isRedirected', 1)
            ->where('vendor_id', $vendor_id)
            ->count();
        $non_redirected_lead_count = UKLead::whereDate('created_at', Carbon::today())
            ->where('isRedirected', 0)
            ->where('vendor_id', $vendor_id)
            ->count();
        $lead_count = UKLead::whereDate('created_at', Carbon::today())
            ->where('vendor_id', $vendor_id)
            ->count();



        if (empty($redirected_lead_count)) {
            $redirected_ratio = 0;
        } else {
            try {
                $redirected_ratio = $redirected_lead_count / $lead_count * 100;
                $redirected_ratio = round($redirected_ratio);
            }
            catch (\Exception $e){
                $redirected_ratio = 0;
            }
        }


        $redirection_stats = [];
        $redirection_stats['redirected_leads'] = $redirected_lead_count;
//        $redirection_stats['redirected_leads'] = [$redirected_lead_count];
        $redirection_stats['non_redirected_leads'] = $non_redirected_lead_count;
        $redirection_stats['redirected_ratio'] = [$redirected_ratio];


        return $redirection_stats;
    }
    public function affiliateLeadList($vendor_id)
    {

       $leads =  UKLead::where('vid', $vendor_id)->get();

        return $leads;
    }
    public function affiliateChartData($vendor_id)
    {


    }



    // OFFER
    public function getDashboardOfferDataPartner($id)
    {
        $dashboard_data = [];
        // CARDS
        $dashboard_data['todayMetrics'] = $this->todayOfferMetrics($id);
//        $dashboard_data['redirectionMetrics'] = $this->clickOfferMetrics($id);


        // CHART DATA
//        $dashboard_data['affiliate_table_data'] = $this->affiliateOfferChartData($id);

        // LIST
        $dashboard_data['click_table_data'] = $this->clickSubList($id);
        $dashboard_data['conversion_table_data'] = $this->conversionSubList($id);

        return Response::json(['dashboard_data' => $dashboard_data], 200);

    }
    public function todayOfferMetrics($id)
    {
        $daily = DB::table('click_trackers');

        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d'))
                ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
                ->where('partner_id', $id)
                ->get();

        $converison_query =
            DB::table('postback_trackers')
                ->where('created_at', '>=', date('Y-m-d'))
                ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
                ->where('partner_id', $id)
                ->get();

        $conversion_query_two = $converison_query;

        $today_metrics = [];
        $today_metrics['clicks'] = $click_query->count();
        $today_metrics['conversions'] = $conversion_query_two->count();
        $today_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $today_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $today_metrics['profit'] = 0;
        }

        return Response::json(['today_metrics' => $today_metrics], 200);
    }



    // TODO - loop
    public function clickSubList($id)
    {

        $partner = Partner::where('user_id', $id)->first();


        $click_data = ClickTracker::where('partner_id', $partner->id)
            ->groupBy('aff_sub')
            ->select(
                'aff_click_id',
                'aff_sub',
                'aff_sub2',
                'aff_sub3',
                'aff_sub4',
                'aff_sub5',
            )
        ->get();

//        foreach ()



        return $click_data;

    }
    public function conversionSubList($id)
    {
        $partner = Partner::where('user_id', $id)->first();


        $conversion_data = PostbackTracker::where('partner_id', $partner->id)->groupBy('offer_id')->get();

//        foreach ()


        return $conversion_data;
    }


    public function affiliateOfferChartData($id)
    {
        //
    }












//    public function index()
//    {
//
//        $partner = Partner::where('user_id', '=', Auth::user()->id)->get();
//
//        if ($partner->isEmpty()) {
//            return view('auth.verify');
//        }
//        $id = Auth::id();
//
//        $revenue = Metrics::partner_counts_uk();
//        $revenue['redirection_rate'] = Metrics::redirection_rate_uk();
//
//        $revenue['conversion_rate'] = (new Metrics)->GetPartnerConversionRatioUK($id);
//        if ($revenue['conversion_rate'] === 0) {
//            $revenue['epl'] = 0;
//        } else {
//            $revenue['epl'] = (new Metrics)->GetPartnerEPLUK($revenue['conversion_rate'], $id);
//        }
//
//        $offers = Offer::all();
//
//        $leads = LmsPaydayUK::where('vid', $id)->limit(25)->get();
//        $subids = LmsPaydayUK::where('subid', $id)->groupBy('subid')->whereNotNull('subid')->get(['subid']);
//
//        return view('partner.offer_dashboard.uk-dashboard',
//            compact('leads', 'subids', 'revenue', 'offers'));
//
//    }
//
//    public function index_us()
//    {
//        $u_id = Auth::id();
//        $partner = DB::table('partners')->where('user_id', '=', $u_id)->first();
//        $partner_id = $partner->id;
//        $vendor_id = $partner->id;
//
//        $revenue = Metrics::partner_counts_us();
//        $redirectionrate = Metrics::partner_redirection_rate_us($partner_id);
//
//        $offers = Offer::all();
//        $leads = LmsPaydayUS::where('vid', $vendor_id)->limit(25)->get();
//
//        if (isset($revenue)) {
//            $epl_ratio = $this->epl_ratio($revenue);
//            $conversion_ratio = $this->conversion_ratio($revenue);
//        } else {
//            $epl_ratio = 0;
//            $conversion_ratio = 0;
//        }
//
//
//        return view('partner.offer_dashboard.us-dashboard',
//            compact('leads', 'revenue', 'redirectionrate', 'epl_ratio', 'offers', 'conversion_ratio'));
//
//    }
//
//    public function index_ca()
//    {
//        $u_id = Auth::id();
//        $partner = DB::table('partners')->where('user_id', '=', $u_id)->get()->toArray();
//        $id = $partner[0]->id;
//
//        $revenue = Metrics::partner_counts_ca();
//        $redirectionrate = Metrics::redirection_rate_ca();
//
//        $offers = Offer::all();
//        $leads = LmsPaydayCA::where('vid', $id)
//            ->limit(25)->get();
//        $sources = LmsPaydayCA::where('vid', $id)
//            ->groupBy('creationUrl')->whereNotNull('creationUrl')->get(['creationUrl']);
//        $subids = LmsPaydayCA::where('vid', $id)
//            ->groupBy('subid')->whereNotNull('subid')->get(['subid']);
//
//        return view('partner.offer_dashboard.ca-dashboard',
//            compact('leads','sources', 'subids', 'revenue', 'redirectionrate', 'offers'));
//
//    }

    public function offer_index()
    {
        $id = Auth::id();
        $partner = User::find($id)->partner;

        $click_count = Metrics::partner_click_counts();
        $conversion_counts = Metrics::partner_conversion_counts();

        $conversion_counts_us = Metrics::partner_conversion_counts_us();
        $conversions_all = Metrics::conversion_total_daily();

        if ($click_count->today && $conversion_counts->daily_total != null) {
            $conversion_ratio = ($click_count->today / $conversion_counts->daily_total) * 100;
            $conversion_ratio = round($conversion_ratio, 2);
        } else {
            $conversion_ratio = 0;
        }

        $notifications = auth()->user()->unreadNotifications;

        return view('partner.offer_dashboard.offer-dashboard',
            compact('notifications', 'conversion_counts', 'conversion_counts_us', 'conversions_all',
                'click_count', 'conversion_ratio', 'partner'));
    }


    public function conversion_ratio($revenue)
    {
//        Log::debug('REV::', (array) $revenue);


        if ($revenue['todayConversions'] === 0) {
            return $conversion_ratio = 0;
        } else {
            try {
                $conversion_ratio = $revenue['todayConversions'] / count($revenue['todayClicks']);
                $conversion_ratio = round($conversion_ratio, 2);
            } catch (Exception $e) {
                Log::debug($e);
                $conversion_ratio = 0;
            }
            $conversion_ratio = round($conversion_ratio, 2);

        }

        return $conversion_ratio;

    }

    /**
     * @param $revenue
     * @return float
     */
    public function epl_ratio($revenue)
    {
        if ($revenue['todayVidRevenue'] === 0) {
            return $epl_ratio = 0;
        } else {
            Log::debug('REV::', (array)$revenue['todayLead']);
            try {
                $epl_ratio = $revenue['todayVidRevenue'] / count((array)$revenue['todayLead']);
                $epl_ratio = round($epl_ratio, 2);
            } catch (Exception $e) {
                Log::debug($e);
                $epl_ratio = 0;
            }
            $epl_ratio = round($epl_ratio, 2);
        }


        return $epl_ratio;

    }

    /**
     * @param Request $request
     */
    public function GetPartnerDataUK(Request $request)
    {
        $subid = $request->input("subid");
        $source = $request->input("source");
        $status = $request->input("status");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }
        if ($subid != null) {
            $wherelist[] = ['subid', '=', $subid];
        }
        if ($source != null) {
            $wherelist[] = ['creationUrl', '=', $source];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $user_id = Auth::id();
        $partner = Partner::where('user_id', '=', $user_id)->first();
        $vendor_id = $partner->vendor_id;

        $datas = LmsPaydayUK::where($wherelist)->with(['source'])
            ->where('vid', '=', $vendor_id)
            ->orderBy('created_at', 'desc')
            ->get();


        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerDataUS(Request $request)
    {
        $subid = $request->input("subid");
        $source = $request->input("source");
        $status = $request->input("status");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }
        if ($subid != null) {
            $wherelist[] = ['subid', '=', $subid];
        }
        if ($source != null) {
            $wherelist[] = ['creationUrl', '=', $source];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $user_id = Auth::id();
        $partner = Partner::where('user_id', '=', $user_id)->first();
        $vendor_id = $partner->vendor_id;


        $datas = LmsPaydayUS::where($wherelist)->with(['source'])
            ->where('vid', '=', $vendor_id)
            ->orderBy('created_at', 'desc')
            ->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerDataCA(Request $request)
    {
        $subid = $request->input("subid");
        $conversion = $request->input("conversion");
        $source = $request->input("source");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }
        if ($subid != null) {
            $wherelist[] = ['subid', '=', $subid];
        }
        if ($source != null) {
            $wherelist[] = ['creationUrl', '=', $source];
        }
        if ($conversion != null) {
            $wherelist[] = ['leadStatus', '=', $conversion];
        }

        $u_id = Auth::id();
        $partner = DB::table('partners')->where('user_id', '=', $u_id)->get()->toArray();
        $id = $partner[0]->id;

        $datas = LmsPaydayCA::where($wherelist)->where('vid', $id)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerDataOffer(Request $request)
    {

        $partner_id = Auth::user()->partner->id;

        $offer_id = $request->input("offer_id");
        $conversion = $request->input("conversion");
        $source = $request->input("source");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($partner_id != null) {
            $wherelist[] = ['partner_id', '=', $partner_id];
        }
        if ($offer_id != null) {
            $wherelist[] = ['offer_id', '=', $offer_id];
        }
        if ($conversion != null) {
            $wherelist[] = ['conversion', '=', $conversion];
        }
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }


        $datas['postback_log'] = PostbackLog::where($wherelist)->where('partner_id', $partner_id)
            ->get();
        $datas['click_log'] = ClickTracker::where($wherelist)->where('partner_id', $partner_id)
            ->get();

        echo json_encode(['data' => $datas]);
    }


    /**
     * @param Request $request
     */
    public function GetPartnerClickLogData(Request $request)
    {
        $user_id = Auth::id();
        $partner = Partner::where('user_id', '=', $user_id)->first();
        $partner_id = $partner->id;

        $click_log = ClickTracker::where('aff_id', '=', $partner_id)
            ->get();

        echo json_encode(['data' => $click_log]);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function GetPartnerViewClickLogData(Request $request, $id)
    {
        $click_log = ClickTracker::find($id);

        echo json_encode(['data' => $click_log]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerPostbackData(Request $request)
    {
        $id = Auth::id();
        $partner = Partner::where('user_id', $id)->first();
        $partner_id = $partner->id;

        $datas = PostbackTracker::where('partner_id', $partner_id)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerRevenueData(Request $request)
    {
        $id = Auth::id();
        $partner = Partner::where('user_id', $id)->first();
        $partner_id = $partner->id;

        $datas = PostbackLog::where('partner_id', '=', $partner_id)
//            ->where('partner_id', '=', $vid)
            ->where('totalCost', '!=', '')
            ->where('conversion', '=', '1')
            ->get();

        echo json_encode(['data' => $datas]);
    }


    /**
     * @param Request $request
     */
    public function GetPartnerReferralData(Request $request)
    {
        $user = Auth::user();

        $datas = User::where('referrer_id', '=', $user->id)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerOfferData(Request $request)
    {
        $offers = Offer::with(
            [
                'trackings',
                'campaigns',
                'advertiser',
                'target_group',
                'traffic_sources',
                'landers',
                'offer_caps',
                'offer_metrics',
                'payout'

            ])
            ->get();

        echo json_encode(['data' => $offers]);
    }

    /**
     * @param Request $request
     */
    public function GetCreativeData(Request $request)
    {
        $creatives = Creatives::all();

        echo json_encode(['data' => $creatives]);
    }

    /**
     * @param Request $request
     */
    public function GetCreativeByOfferId(Request $request, $id)
    {
        $creatives = Creatives::where('offer_id', $id)->get();


//        return Response::json($creatives);
        echo json_encode(['data' => $creatives]);
    }

    public function ViewCreativeData(Request $request, $id)
    {
        $creatives = Creatives::find($id);

        echo json_encode(['data' => $creatives]);

//        return Response::json($creatives);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerLanderData(Request $request, $id)
    {
        $datas = Lander::where('offer_id', $id)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerConversionData(Request $request)
    {
        $vid = $request->input("vid");
        $subid = $request->input("subid");
        $conversion = $request->input("conversion");
        $source = $request->input("source");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($subid != null) {
            $wherelist[] = ['subid', '=', $subid];
        }
        if ($conversion != null) {
            $wherelist[] = ['leadStatus', '=', $conversion];
        }
        if ($source != null) {
            $wherelist[] = ['creationUrl', '=', $source];
        }
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }


        $id = Auth::id();
        $partner = User::find($id)->partner;
        $vid = $partner->id;

        $datas = PostbackLog::where($wherelist)->where('aff_id', $vid)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerPostbackLogData(Request $request)
    {
        $vid = $request->input("vid");
        $subid = $request->input("subid");
        $conversion = '1';
        $source = $request->input("source");

        if ($request->input("start") != null) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input("start"));
        } else {
            $start = null;
        }
        if ($request->input("end") != null) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input("end"));
        } else {
            $end = null;
        }

        $wherelist = array();
        if ($conversion != null) {
            $wherelist[] = ['conversion', '=', $conversion];
        }
        if ($start != null) {
            $wherelist[] = ['created_at', '>=', $start];
        }
        if ($end != null) {
            $wherelist[] = ['created_at', '<=', $end];
        }


        $vid = Auth::user()->partner->id;

        $datas = PostbackLog::where($wherelist)
            ->where('partner_id', '=', $vid)
            ->where('totalCost', '!=', '')
            ->where('conversion', '=', '1')
            ->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     */
    public function GetPartnerPostbackLogByID(Request $request, $id)
    {
        $vid = Auth::user()->partner->id;

        $datas = PostbackLog::where('partner_id', $vid)
            ->where('totalCost', '!=', '')
            ->where('conversion', '=', '1')
            ->get();


        echo json_encode(['data' => $datas]);
    }
}
