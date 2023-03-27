<?php
//
namespace App\Http\Controllers\Partner;
//
//use App\Exports\conversionsDisputeExport;
//use App\Exports\conversionsExport;
//use App\Exports\conversionsPostbackExport;
//use App\Exports\conversionsUSExport;
//use App\Exports\revenueDisputeExport;
//use App\Exports\revenueExport;
//use App\Exports\revenuePostbackExport;
//use App\Exports\revenueUSExport;
//use App\Models\LmsPaydayUK;
//use App\Models\LmsOffersLog;
//use App\Models\Metrics;
//use App\Offer;
//use App\Partner;
//use Carbon\Carbon;
//use Carbon\CarbonPeriod;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Facades\Excel;
//
use App\Http\Controllers\Controller;
use App\Models\ClickTracker\ClickTracker;
use App\Models\Lead\UKLead;
use App\Models\Lead\USLead;
use App\Models\Partner\Partner;
use App\Models\PostbackTracker\PostbackTracker;
use Illuminate\Support\Facades\Response;

class PartReportController extends Controller
{

    public function getPartnerReports($id)
    {
        $report_data = [];
//        $report_data['uk_reports'] = $this->getUKReports($id);
//        $report_data['usa_reports'] = $this->getUSAReports($id);
//        $report_data['offer_reports'] = $this->getOfferReports($id);
//        $report_data['referral_reports'] = $this->getReferralReports($id);
//        $report_data['postback_reports'] = $this->getPostbackReports($id);

        return Response::json(['report_data' => $report_data], 200);
    }


    public function getUKReports($id)
    {
        $partner = Partner::where('user_id', '=', $id)->first();
        $vendor_id = $partner->vendor_id;

        $reports = UKLead::where('vid', $vendor_id)
            ->select('subid', 'vidLeadPrice', 'isRedirected', 'tier', 'leadStatus')
            ->get();


        return Response::json(['reports' => $reports], 200);
    }
    public function getUSReports($id)
    {
        $partner = Partner::where('user_id', '=', $id)->first();
        $vendor_id = $partner->vendor_id;

        $reports = USLead::where('vid', $vendor_id)
            ->select('subid', 'vidLeadPrice', 'isRedirected', 'tier', 'leadStatus')
            ->get();


        return Response::json(['reports' => $reports], 200);

    }
    public function getOfferReports($id)
    {
        $reports = ClickTracker::where('id', $id)
            ->select(
                'aff_click_id',
                'aff_sub',
                'aff_sub2',
                'aff_sub3',
                'aff_sub4',
                'aff_sub5',
            )
            ->get();

        return Response::json(['reports' => $reports], 200);


    }
    public function getReferralReports($id)
    {
//        Referral::where()

//        return $report;

    }
    public function getPostbackReports($id)
    {

        $partner = Partner::where('user_id', $id)->first();

        $reports = PostbackTracker::where('id', $partner->id)
            ->select('affiliatePostbackUrl', 'conversion', 'totalCost', 'offer_id')
            ->get();

        return Response::json(['reports' => $reports], 200);



    }






















}
//    public function index()
//    {
//        $partner_id = Auth::user()->partner->id;
//
//        $revenue = Metrics::partner_counts_uk();
//        $redirectionrate = Metrics::redirection_rate_uk();
//
//        $offers = Offer::all();
//
//        $leads = LmsPaydayUK::where('vid', $partner_id)->limit(25)->get();
//        $subids = LmsPaydayUK::where('subid', $partner_id)->groupBy('subid')->whereNotNull('subid')->get(['subid']);
////        $leads = LmsPaydayUK::where('vid', '=', $partner_id)->get();
//
//        $notifications = auth()->user()->unreadNotifications;
//
//        return view('partner.reports.uk.reports-leads',
//            compact('revenue', 'leads', 'subids', 'revenue', 'redirectionrate', 'offers'));
//
//    }
//
//    public function view($id)
//    {
//        $user = Auth::user();
//        $offer = Offer::findOrFail($id);
//
//
//        return view('partner.offers.offers-view', compact('user', 'offer'));
//    }
//
//    public function finance_index()
//    {
//        $u_id = Auth::id();
//        $partner = Partner::where('user_id', '=', $u_id)->get()->toArray();
////        dd($partner[0]['id']);
//        $id = $partner[0]['id'];
////        dd($id);
//        $revenue = Metrics::partner_counts_uk();
//        $redirectionrate = Metrics::redirection_rate_uk();
//
//        $offers = Offer::all();
//        $leads = LmsPaydayUK::where('vid', $id)
//            ->limit(25)->get();
//        $sources = LmsPaydayUK::where('vid', $id)
//            ->groupBy('creationUrl')->whereNotNull('creationUrl')->get(['creationUrl']);
//        $subids = LmsPaydayUK::where('vid', $id)
//            ->groupBy('subid')->whereNotNull('subid')->get(['subid']);
//
//
//        $notifications = auth()->user()->unreadNotifications;
//
//        return view('partner.reports.uk.reports',
//            compact('revenue', 'leads','sources', 'subids', 'revenue', 'redirectionrate', 'offers'));
//
//    }
//
//    public function finance_view($id)
//    {
//        $user = Auth::user();
//        $offer = Offer::findOrFail($id);
//
//
//        return view('partner.offers.offers-view', compact('user', 'offer'));
//    }
//
//
//    /**
//     * Partner Conversions Page.
//     */
//    public function partner_conversions()
//    {
//        $u_id = Auth::id();
//        $partner = DB::table('partners')->where('user_id', '=', $u_id)->get()->toArray();
//        $id = $partner[0]->id;
//
//        $offerlogs = LmsOffersLog::where('vid', $id)
//            ->where('oid', '=', '1')
//            ->where('created_at', '=', Carbon::today())
//            ->limit(25)->get(); // change later TODO
//
//
//
//        return view('partner.reports..uk.reports-conversions', compact('offerlogs'));
//
//    }
//
//    /**
//    * Partner Revenue Page.
//     */
//    public function partner_revenue()
//    {
//        $id = Auth::id();
//        $partner = DB::table('partners')->where('user_id', '=', $id)
//            ->get()->toArray();
//        $vid = $partner[0]->id;
//
//        $leads = LmsPaydayUK::where('vid', $vid)
//            ->where('created_at', '=', Carbon::today())
//            ->limit(25)->get();
//
//        return view('partner.reports.uk.reports-revenue', compact('leads'));
//
//    }
//
//    /**
//     * @param $start
//     * @param $end
//     * @param string $format
//     * @return array
//     */
//    function getInBetweenDays($start, $end, $format = 'd/m')
//    {
//
//        $dateArray = array();
//        $start = Carbon::createFromFormat('d/m/Y', $start);
//        $end = Carbon::createFromFormat('d/m/Y', $end);
//        $period = CarbonPeriod::create($start, $end);
//        foreach ($period as $date) {
//            $dateArray[] = $date->format($format);
//        }
//        return $dateArray;
//    }
//
//    /**
//     * @param $days
//     * @param string $format
//     * @return array
//     */
//    function getLastNDays($days, $format = 'd/m')
//    {
//        $period = CarbonPeriod::create(Carbon::today()->subDays($days), Carbon::today());
//        $dateArray = array();
//        foreach ($period as $date) {
//            $dateArray[] = $date->format($format);
//        }
//        return $dateArray;
//    }
//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function partner_chart_data(Request $request)
//    {
//        $date1 = $request->input('start_date');
//        $date2 = $request->input('end_date');
//        if ($date1 != null && !empty($date1)) {
//            $dates = $this->getInBetweenDays($date1, $date2, 'Y-m-d');
//        } else {
//            $dates = $this->getLastNDays(14, 'Y-m-d');
//        }
//        $data = [];
//        $data['dates'] = array();
//        $data['accepted'] = array();
//        $data['rejected'] = array();
//        $data['pending'] = array();
//        foreach ($dates as $date) {
//            $data['dates'][] = Carbon::createFromFormat('Y-m-d', $date)->format('d M');
//            $data['accepted'][] = $this->getLeadStatusForDate(1, $date);
//            $data['rejected'][] = $this->getLeadStatusForDate(2, $date);
//            $data['pending'][] = $this->getLeadStatusForDate(3, $date);
//        }
//        return response()->json($data);
//    }
//
//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function partner_offer_chart_data(Request $request)
//    {
//        $date1 = $request->input('start_date');
//        $date2 = $request->input('end_date');
//        if ($date1 != null && !empty($date1)) {
//            $dates = $this->getInBetweenDays($date1, $date2, 'Y-m-d');
//        } else {
//            $dates = $this->getLastNDays(14, 'Y-m-d');
//        }
//        $data = [];
//        $data['dates'] = array();
//        $data['clicks'] = array();
//        $data['conversions'] = array();
//        $data['profit'] = array();
//        foreach ($dates as $date) {
//            $data['dates'][] = Carbon::createFromFormat('Y-m-d', $date)->format('d M');
//            $data['clicks'][] = $this->getLeadStatusForDate(1, $date);
//            $data['conversions'][] = $this->getLeadStatusForDate(2, $date);
//            $data['profit'][] = $this->getLeadStatusForDate(3, $date);
//        }
//        return response()->json($data);
//    }
//
//
//    /**
//     * @param $leadStatus
//     * @param $date
//     * @return int
//     */
//    public function getLeadStatusForDate($leadStatus, $date)
//    {
//        $id = Auth::id();
//        $partner = DB::table('partners')->where('user_id', '=', $id)->get()->toArray();
//        $vid = $partner[0]->id;
//
//        $result = DB::select("select leadStatus,
//        substring(created_at,1,10) as date, count(*) as result_count
//        from lmspaydayuks
//        where substring(created_at,1,10) = '$date'
//        and leadStatus = $leadStatus and vid = '$vid'
//        group by leadStatus, substring(created_at,1,10)");
//
//        // I will see it with my brother after a few min
//
//        if ($result == null) {
//            return 0;
//        } else {
//            return $result[0]->result_count;
//        }
//    }
//
//
//    public function leads_report()
//    {
//
//        return view('partner.reports.uk.reports-leads');
//    }
//
//
//    /*** Export  Functionality starts ***/
////    public function exportConversionsToExcelUK()
////    {
////        return Excel::download(new conversionsExport, 'conversions-report' . now() . '.xlsx');
////    }
////    public function exportRevenueToExcelUK()
////    {
////        return Excel::download(new revenueExport, 'revenue-report' . now() . '.xlsx');
////    }
////    public function exportConversionsToExcelUS()
////    {
////        return Excel::download(new conversionsUSExport, 'conversions' . now() . '.xlsx');
////    }
////    public function exportRevenueToExcelUS()
////    {
////        return Excel::download(new revenueUSExport, 'revenue' . now() . '.xlsx');
////    }
////    public function exportConversionsPostbackToExcel()
////    {
////        return Excel::download(new conversionsPostbackExport, 'revenue' . now() . '.xlsx');
////    }
////    public function exportRevenuePostbackToExcel()
////    {
////        return Excel::download(new revenuePostbackExport, 'revenue' . now() . '.xlsx');
////    }
////    public function exportConversionsDisputeToExcel()
////    {
////        return Excel::download(new conversionsDisputeExport, 'revenue' . now() . '.xlsx');
////    }
////    public function exportRevenueDisputeToExcel()
////    {
////        return Excel::download(new revenueDisputeExport, 'revenue' . now() . '.xlsx');
////    }
//    /*** Export  Functionality end ***/
//
//
//
//
//    public function offerReports()
//    {
//        return view('partners.reports.offer.reports');
//    }
//
//    public function offerReportsView()
//    {
//        return view('partners.reports.offers-view');
//    }
//
//    public function offerReportsClicks()
//    {
//        return view('partners.reports.offer.reports-clicks');
//
//    }
//
//    public function offerReportsRev()
//    {
//        return view('partners.reports.offer.reports-revenue');
//    }
//
//
//}
