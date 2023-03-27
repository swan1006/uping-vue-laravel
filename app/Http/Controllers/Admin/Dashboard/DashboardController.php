<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser\Advertiser;
use App\Models\Buyer\BuyerSetup;
use App\Models\ClickTracker\ClickTracker;
use App\Models\Lead\UKLead;
use App\Models\Offer\Offer;
use App\Models\Partner\Partner;
use App\Models\PostbackTracker\PostbackTracker;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;


class DashboardController extends Controller
{
    public function getDashboardDataUK(Request $request)
    {
        $dashboard_data = [];
        $dashboard_data['todayEarnings'] = $this->todayEarnings();
        $dashboard_data['weekEarnings'] = $this->weekEarnings();
        $dashboard_data['monthEarnings'] = $this->monthEarnings();
        $dashboard_data['profitEarnings'] = $this->profitEarnings();

        $dashboard_data['lead_count'] = $this->leadCounts();
        $dashboard_data['affiliate_table_data'] = $this->affiiliateLeadCounts();
        $dashboard_data['lender_table_data'] = $this->lenderLeadCounts();

        $dashboard_data['affiliate_redirection'] = $this->affiliateRedirectionRates();
        $dashboard_data['lender_redirection'] = $this->lenderRedirectionRates();

        return Response::json(['dashboard_data' => $dashboard_data], 200);
    }



    public function  getDashboardDataOffer()
    {
        $dashboard_data = [];
        $dashboard_data['todayMetrics'] = $this->todayMetrics();
        $dashboard_data['weekMetrics'] =  $this->weekMetrics();
        $dashboard_data['monthMetrics'] =  $this->monthMetrics();
        $dashboard_data['affiliate_table_data'] = $this->affiiliateOfferCounts();
        $dashboard_data['adv_table_data'] = $this->advertiserOfferCounts();

        return Response::json(['dashboard_data' => $dashboard_data], 200);

    }

    public function revenueChartData(Request $request)
    {

        $date1 = $request->input('start_date');
        $date2 = $request->input('end_date');
        if ($date1 != null && !empty($date1)) {
            $dates = $this->getInBetweenDays($date1, $date2, 'Y-m-d');
        } else {
            $dates = $this->getLastNDays(14, 'Y-m-d');
        }
        $data = [];
        $data['dates'] = array();
        $data['accepted'] = array();
        $data['rejected'] = array();
        $data['pending'] = array();
        foreach ($dates as $date) {
            $data['dates'][] = Carbon::createFromFormat('Y-m-d', $date)->format('d M');
            $data['accepted'][] = $this->getLeadStatusForDate(1, $date);
            $data['rejected'][] = $this->getLeadStatusForDate(2, $date);
            $data['pending'][] = $this->getLeadStatusForDate(3, $date);
        }
        return response()->json($data);

    }

    /**
     * Get In Between Days
     *
     * @param $start
     * @param $end
     * @param string $format
     * @return array
     */
    function getInBetweenDays($start, $end, $format = 'd/m')
    {

        $dateArray = array();
        $start = Carbon::createFromFormat('d/m/Y', $start);
        $end = Carbon::createFromFormat('d/m/Y', $end);
        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $dateArray[] = $date->format($format);
        }
        return $dateArray;
    }

    /**
     * Get Last N Days
     *
     * @param $days
     * @param string $format
     * @return array
     */
    function getLastNDays($days, $format = 'd/m')
    {
        $period = CarbonPeriod::create(Carbon::today()->subDays($days), Carbon::today());
        $dateArray = array();
        foreach ($period as $date) {
            $dateArray[] = $date->format($format);
        }
        return $dateArray;
    }

    /**
     * Get the Lead Status For Date's requested
     *
     * @param $leadStatus
     * @param $date
     * @return int
     */
    public function getLeadStatusForDate($leadStatus, $date)
    {
        $result = DB::select("select leadStatus,
        substring(created_at,1,10) as date, count(*) as result_count
        from uk_leads
        where substring(created_at,1,10) = '$date' and leadStatus = $leadStatus
        group by leadStatus, substring(created_at,1,10)");


        if ($result == null) {
            return 0;
        } else {
            return $result[0]->result_count;
        }
    }




    //Offer
    public function todayMetrics()
    {
        $daily = DB::table('click_trackers');

        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d'))
                ->where('created_at', '<=', date('Y-m-d') . "23:53:53")->get();

        $converison_query =
            DB::table('postback_trackers')
                ->where('created_at', '>=', date('Y-m-d'))
                ->where('created_at', '<=', date('Y-m-d') . "23:53:53")->get();

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
    private function weekMetrics()
    {
        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $converison_query =
            DB::table('postback_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $conversion_query_two = $converison_query;

        $week_metrics = [];
        $week_metrics['clicks'] = $click_query->count();
        $week_metrics['conversions'] = $conversion_query_two->count();
        $week_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $week_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $week_metrics['profit'] = 0;
        }

        return Response::json(['week_metrics' => $week_metrics], 200);

    }
    private function monthMetrics()
    {
        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $converison_query =
            DB::table('postback_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $conversion_query_two = $converison_query;


        $month_metrics = [];
        $month_metrics['clicks'] = $click_query->count();
        $month_metrics['conversions'] = $conversion_query_two->count();
        $month_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $month_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $month_metrics['profit'] = 0;
        }

        return Response::json(['today_metrics' => $month_metrics], 200);

    }
    private function affiiliateOfferCounts()
    {

        $vendor_ids = PostbackTracker::groupBy('partner_id')->whereNotNull('partner_id')->get(['partner_id']);

        foreach ($vendor_ids as $vendor) {
            foreach ($vendor as $k => $v) {


                $revenue = PostbackTracker::where('partner_id', $vendor['partner_id'])->pluck('totalCost')->sum();
                $clicks = ClickTracker::where('partner_id', $vendor['partner_id'])->count();
                $conversions = PostbackTracker::where('partner_id', $vendor['partner_id'])->count();

                $cost = PostbackTracker::where('partner_id', $vendor['partner_id'])->pluck('totalRevenue')->sum();
                $leads = PostbackTracker::where('partner_id', $vendor['partner_id'])->count();

                $vid = Partner::where('id', $vendor->partner_id)->first();

                $vendor->vid = $vid->vendor_id;
                $vendor->clicks = $clicks;
                $vendor->conversions = $conversions;
                $vendor->leads = $leads;
                $vendor->revenue =  $revenue;

                try {
                    $profit = $revenue - $cost;
                } catch (\Exception $e) {
                    $profit = 0;
                }
                $vendor->profit =  $profit;
            }
        }
        return $vendor_ids;
    }
    private function advertiserOfferCounts()
    {

        $offer_ids = PostbackTracker::groupBy('offer_id')->whereNotNull('offer_id')->get(['offer_id']);
//        dd($offer_ids);

        foreach ($offer_ids as $offer) {
            foreach ($offer as $k => $v) {


                $revenue = PostbackTracker::where('offer_id', $offer['offer_id'])->pluck('totalCost')->sum();
                $cost = PostbackTracker::where('offer_id', $offer['offer_id'])->pluck('totalRevenue')->sum();
                $clicks = ClickTracker::where('offer_id', $offer['offer_id'])->count();
                $conversions = PostbackTracker::where('offer_id', $offer['offer_id'])->count();

                $offer_obj = Offer::where('id', $offer->offer_id)->first();

                $offer->name = $offer_obj->name;
                $offer->clicks = $clicks;
                $offer->conversions = $conversions;
                $offer->revenue =  $revenue;

                try {
                    $profit = $revenue - $cost;
                } catch (\Exception $e) {
                    $profit = 0;
                }
                $offer->profit =  $profit;
            }
        }
//        dd($offer_ids);
        return $offer_ids;
    }
    //Leads
    public function todayEarnings()
    {
        $daily = DB::table('uk_leads');

        $daily
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
            ->count();

        $vid_lead_price_total = $daily->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $daily->pluck('buyerLeadPrice')->sum();
        $revenue['today_revenue'] = $buyer_lead_price_total;
        $revenue['today_cost'] = $buyer_lead_price_total;
        $revenue['today_profit'] = $buyer_lead_price_total - $vid_lead_price_total;
        $revenue['redirection'] = $this->redirectionToday();
//        $revenue['series'] = [$revenue['today_profit'], $revenue['today_cost'], $revenue['today_revenue'] ];
//        $revenue['series'] = [50, 50, 70];

        return $revenue;
    }
    public function weekEarnings()
    {
        $weekly = DB::table('uk_leads');

        $weekly
            ->where('created_at', '>=', date('Y-m-d', strtotime("-7 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");


        $vid_lead_price_total = $weekly->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $weekly->pluck('buyerLeadPrice')->sum();
        $revenue['week_revenue'] = $buyer_lead_price_total;
        $revenue['week_cost'] = $buyer_lead_price_total;
        $revenue['week_profit'] = $buyer_lead_price_total - $vid_lead_price_total;
        $revenue['redirection'] = $this->redirectionWeek();

        return $revenue;
    }


    public function monthEarnings()
    {
        $month = DB::table('uk_leads');

        $month
            ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");


        $vid_lead_price_total = $month->pluck('vidLeadPrice')->sum();
        $buyer_lead_price_total = $month->pluck('buyerLeadPrice')->sum();
        $revenue['month_revenue'] = $buyer_lead_price_total;
        $revenue['month_cost'] = $buyer_lead_price_total;
        $revenue['month_profit'] = $buyer_lead_price_total - $vid_lead_price_total;
        $revenue['redirection'] = $this->redirectionMonth();

        return $revenue;
    }
    public function redirectionToday()
    {
        $redirected_lead_count = UKLead::whereDate('created_at', Carbon::today())
            ->where('isRedirected', 1)
            ->count();
        $non_redirected_lead_count = UKLead::whereDate('created_at', Carbon::today())
            ->where('isRedirected', 0)
            ->count();
        $lead_count = UKLead::whereDate('created_at', Carbon::today())
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
        $redirection_stats['non_redirected_leads'] = $non_redirected_lead_count;
        $redirection_stats['redirected_ratio'] = [$redirected_ratio];


        return $redirection_stats;
    }
    public function redirectionWeek()
    {
        $redirected_lead_count = UKLead::whereDate('created_at', Carbon::today()->subWeek())
            ->where('isRedirected', 1)
            ->count();
        $non_redirected_lead_count = UKLead::whereDate('created_at', Carbon::today()->subWeek())
            ->where('isRedirected', 0)
            ->count();
        $lead_count = UKLead::whereDate('created_at', Carbon::today()->subWeek())
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
        $redirection_stats['non_redirected_leads'] = $non_redirected_lead_count;
        $redirection_stats['redirected_ratio'] = [$redirected_ratio];


        return $redirection_stats;
    }
    public function redirectionMonth()
    {
        $redirected_lead_count = UKLead::whereDate('created_at', Carbon::today()->subMonth())
            ->where('isRedirected', 1)
            ->count();
        $non_redirected_lead_count = UKLead::whereDate('created_at', Carbon::today()->subMonth())
            ->where('isRedirected', 0)
            ->count();
        $lead_count = UKLead::whereDate('created_at', Carbon::today()->subMonth())
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
        $redirection_stats['non_redirected_leads'] = $non_redirected_lead_count;
        $redirection_stats['redirected_ratio'] = [$redirected_ratio];


        return $redirection_stats;
    }
    public function profitEarnings()
    {
        $buyerLeadPrice = UKLead::where('created_at', Carbon::today())->pluck('buyerLeadPrice')->sum();
        $vidLeadPrice = UKLead::where('created_at', Carbon::today())->pluck('vidLeadPrice')->sum();
        $profit= [];

        try {
            $profit['profit'] = $vidLeadPrice - $buyerLeadPrice;
        } catch (\Exception $e) {
            $profit['profit']  = 0;
        }

        $profit['lead_count'] = UKLead::where('created_at', Carbon::today())->count();
        return $profit;


    }

    public function leadCounts()
    {
        $lead_counts = [];
        $lead_counts['today'] =  UKLead::whereDate('created_at', Carbon::today())
            ->count();
        $lead_counts['week'] =  UKLead::whereDate('created_at', Carbon::today()->subWeek(1))
            ->count();
        $lead_counts['month'] =  UKLead::whereDate('created_at', Carbon::today()->subMonth(1))
            ->count();

        return $lead_counts;
    }
    public function affiiliateLeadCounts()
    {

        $vendor_ids = UKLead::groupBy('vid')->whereNotNull('vid')->get(['vid'])->take(5);;

        foreach ($vendor_ids as $vendor) {
            foreach ($vendor as $k => $v) {


                $revenue_today = UKLead::where('vid', $vendor['vid'])->pluck('vidLeadPrice')->sum();
                $cost_today = UKLead::where('vid', $vendor['vid'])->pluck('buyerLeadPrice')->sum();
                $leads_today = UKLead::where('vid', $vendor['vid'])->count();
                $leads_redirected_today = UKLead::where('vid', $vendor['vid'])->where('isRedirected', 1)->count();

                try {
                    $profit_today = $revenue_today - $cost_today;
                } catch (\Exception $e) {
                    $profit_today = 0;
                }

                try {
                    $redirected_ratio = $leads_redirected_today / $leads_today * 100;
                    $redirected_ratio = round($redirected_ratio);
                } catch (\Exception $e) {
                    $redirected_ratio = 0;
                }
                $vendor->leads_today = $leads_today;
                $vendor->revenue_today =  $revenue_today;
                $vendor->profit_today = $profit_today;
                // TODO : Conversion Ratio
                $vendor->ratio_today = $redirected_ratio;
            }
        }
//        dd($vendor_ids);
        return $vendor_ids;
    }
    public function lenderLeadCounts()
    {

        $tier_ids = UKLead::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID'])->take(5);

        foreach ($tier_ids as $tier) {
            foreach ($tier as $k => $v) {

//                dd($tier);

                $revenue_today = UKLead::where('buyer_setup_id', $tier['buyer_setup_id'])->pluck('vidLeadPrice')->sum();
                $cost_today = UKLead::where('buyer_setup_id', $tier['buyer_setup_id'])->pluck('buyerLeadPrice')->sum();
                $leads_today = UKLead::where('buyer_setup_id', $tier['buyer_setup_id'])->count();
                $leads_redirected_today = UKLead::where('buyer_setup_id', $tier['buyer_setup_id'])->where('isRedirected', 1)->count();

                try {
                    $profit_today = $revenue_today - $cost_today;
                } catch (\Exception $e) {
                    $profit_today = 0;
                }

//                dd($leads_redirected_today);
                if ($leads_redirected_today === 0 || $leads_today === 0 ) {
                    $redirected_ratio = 0;
                } else {
                    try {
                        $redirected_ratio = $leads_redirected_today / $leads_today * 100;
                        $redirected_ratio = round($redirected_ratio);
                    } catch (\Exception $e) {
                        $redirected_ratio = 0;
                    }
                }

                $tier_id = BuyerSetup::where('id', $tier->buyerTierID)->first();

                $tier->tier_name = $tier_id->buyername;
                $tier->leads_today = $leads_today;
                $tier->revenue_today =  $revenue_today;
                $tier->profit_today = $profit_today;
                // TODO : Conversion Ratio
                $tier->ratio_today = $redirected_ratio;
            }
        }
//        dd($tier_ids);
        return $tier_ids;
    }
    public function affiliateRedirectionRates()
    {

        $vendor_ids = UKLead::groupBy('vid')->whereNotNull('vid')->get(['vid'])->take(5);

        foreach ($vendor_ids as $vendor) {
            foreach ($vendor as $k => $v) {


                $redirected_lead_count_today = UKLead::where('vid', $vendor['vid'])->where('isRedirected', 1)->pluck('isRedirected')->count();
                $lead_count_today = UKLead::where('vid', $vendor['vid'])->pluck('isRedirected')->count();


                if ($redirected_lead_count_today === 0 || $lead_count_today === 0 ) {
                    $redirected_ratio = 0;
                } else {
                    try {
                        $redirected_ratio = $redirected_lead_count_today / $lead_count_today * 100;
                        $redirected_ratio = round($redirected_ratio);
                    } catch (\Exception $e) {
                        $redirected_ratio = 0;
                    }
                }

                $vendor->redirect_ratio =  $redirected_ratio;
            }
        }
        return $vendor_ids;
    }
    public function lenderRedirectionRates()
    {

        $tier_ids = UKLead::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID'])->take(5);

        foreach ($tier_ids as $tier) {
            foreach ($tier as $k => $v) {



                $redirected_lead_count_today = UKLead::where('buyerTierID', $tier->buyerTierID)->where('isRedirected', 1)
                    ->where('created_at', '>=', date('Y-m-d'))
                    ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
                    ->count();
//                dd($redirected_lead_count_today);
                $lead_count_today = UKLead::where('buyerTierID', $tier->buyerTierID)
                    ->where('created_at', '>=', date('Y-m-d'))
                    ->where('created_at', '<=', date('Y-m-d') . "23:53:53")
                    ->count();
//                dd($lead_count_today);


                if ($redirected_lead_count_today == 0 || $lead_count_today == 0 ) {
                    $redirected_ratio = 0;
                } else {
                    try {
                        $redirected_ratio = $redirected_lead_count_today / $lead_count_today * 100;
                        $redirected_ratio = round($redirected_ratio);
                    } catch (\Exception $e) {
                        $redirected_ratio = 0;
                    }
                }
                $buyersetup = BuyerSetup::where('id', $tier->buyerTierID)->first();
                $tier->tier_name = $buyersetup->buyername;
                $tier->redirect_ratio =  $redirected_ratio;
            }
        }
        return $tier_ids;
    }
























    public function indexUS()
    {
        $leads = LmsPaydayUS::orderBy('id', 'DESC')->get();

        $revenue = Metrics::lead_counts_us();
        $redirectionrate = Metrics::redirection_rate_us();

        $buyer_activity = $this->buyer_activity_us();
        $partner_activity = $this->partner_activity_us();

        if ($revenue['todayRevenue'] === 0) {
            $epa_today = 0;
        } else {
            try {
                $epa_today = $revenue['todayRevenue'] / count($revenue['todayLead']);
            } catch (\Exception $e) {
                $epa_today = 0;
            }
            try {
                $epa_week = $revenue['weeklyRevenue'] / count($revenue['weeklyLead']);
            } catch (\Exception $e) {
                $epa_week = 0;
            }
        }

        if(isset($epa_week)) {
            $epa_week = round($epa_week, 2);
        } else {
            $epa_week = 0;
        }
        if(isset($epa_week)) {
            $epa_today = round($epa_today, 2);
        } else {
            $epa_today = 0;

        }


        $vids = LmsPaydayUS::groupBy('vid')->get(['vid']);
        $buyerids = LmsPaydayUS::groupBy('buyerid')->whereNotNull('buyerid')->get(['buyerid']);
        $buyersetups = LmsPaydayUS::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID']);
        $subids = LmsPaydayUS::groupBy('subid')->whereNotNull('subid')->get(['subid']);

        $notifications = auth()->user()->unreadNotifications;

        return view('admin.dashboard.dashboard-admin-us',
            compact('notifications', 'vids', 'buyerids', 'buyersetups',
                'subids', 'revenue', 'buyer_activity', 'partner_activity', 'redirectionrate', 'leads', 'epa_week', 'epa_today'
            ));
    }

    public function indexCA()
    {
        $leads = LmsPaydayCA::orderBy('id', 'DESC')->get();
        $revenue = Metrics::lead_counts_ca();
        $redirectionrate = Metrics::redirection_rate_ca();
        $buyer_activity = $this->buyer_activity();
        $partner_activity = $this->partner_activity();

        try {
            $epa_today = $revenue['todayRevenue'] / count($revenue['todayLead']);
        } catch (\Exception $e) {
            $epa_today = 0;
        }
        try {
            $epa_week = $revenue['weeklyRevenue'] / count($revenue['weeklyLead']);
        } catch (\Exception $e) {
            $epa_week = 0;
        }
        $epa_week = round($epa_week, 2);
        $epa_today = round($epa_today, 2);


        $vids = LmsPaydayCA::groupBy('vid')->get(['vid']);
        $buyerids = LmsPaydayCA::groupBy('buyerid')->whereNotNull('buyerid')->get(['buyerid']);
        $buyersetups = LmsPaydayCA::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID']);
        $subids = LmsPaydayCA::groupBy('subid')->whereNotNull('subid')->get(['subid']);



        $notifications = auth()->user()->unreadNotifications;

        return view('admin.dashboard.dashboard-admin-ca',
            compact('notifications', 'vids', 'buyerids', 'buyersetups', 'subids', 'revenue',
                'redirectionrate', 'leads', 'epa_week', 'epa_today', 'buyer_activity', 'partner_activity'
            ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
