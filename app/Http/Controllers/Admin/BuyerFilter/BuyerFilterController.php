<?php

namespace App\Http\Controllers\Admin\BuyerFilter;

use App\Http\Controllers\Controller;
use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerFilter;
use App\Models\Buyer\BuyerSetup;
use App\Models\Partner\Partner;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerFilterController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $leadType = $request->input("leadType");
        $status = $request->input("status");
        $query = $request->input("searchQuery");



        $wherelist = array();
        if ($leadType != null) {
            $wherelist[] = ['leadtype', '=', $leadType];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $buyerFilter = BuyerSetup::with(['buyer_filters'])->where($wherelist)->paginate($perPage);

        return Response::json(['buyerFilters' => $buyerFilter]);
    }

    public function show(Request $request, $id){
//        dd('here1');
        $buyerFilter = BuyerSetup::with(['buyer_filters'])->where('id',$id)->first();
        $buyerFilter['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id', 'buyername']);



        return Response::json(['buyerFilter' => $buyerFilter]);
    }

    public function fetchIndividualFilter(Request $request, $id){
        $filter = BuyerFilter::where('id',$id)->first();
        $filter->object = json_decode($filter['conditions']);


        return Response::json(['filter' => $filter]);
    }

    public function fetchSelectOptions()
    {
        $selectOptions = [];
        $selectOptions['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id', 'buyername', 'buyer_id']);
        $selectOptions['partner_ids'] = Partner::groupBy('id')->whereNotNull('id')->get(['id', 'vendor_id']);

        return Response::json(['selectOptions' => $selectOptions]);

    }

    public function getFilterList(Request $request, $id) {
        $filters = BuyerFilter::where('buyer_setup_id',$id)->get();


        return Response::json(['filters' => $filters]);
    }

    public function getFilter(Request $request, $id){
        $filter = BuyerFilter::where('id',$id)->first();


        return Response::json(['filter' => $filter]);
    }







    function store(Request $request)
    {
//        dd($request->input());

        $buyerfilter = new BuyerFilter;
        $buyerfilter->buyer_setup_id = $request['filter']['tier_id'];
        $buyerfilter->buyer_id =  BuyerSetup::where('id', $buyerfilter->buyer_setup_id)->first()->buyer_id;
        $buyerfilter->filter_type = $request['filter']['filter_type'];
        $buyerfilter->conditions = json_encode($request['filter']['conditions'], JSON_UNESCAPED_SLASHES);
        $buyerfilter->conversion_type = $request['filter']['conversion_type'];
        $buyerfilter->status = 1;
        $res = $buyerfilter->save();

        return response()->json('Successfully added filter', 200);
    }
    function update(Request $request, $id)
    {
                $buyerfilter = BuyerFilter::where('id', $id)->findOrFail($id);
                $buyerfilter->buyer_id = $request['buyer_id'];
                $buyerfilter->buyer_setup_id = $request['buyer_setup_id'];
                $buyerfilter->filter_type = $request['filter_type'];
                $buyerfilter->conditions = json_encode($request['object'], JSON_UNESCAPED_SLASHES);
                $buyerfilter->conversion_type = $request['conversion_type'];
                $buyerfilter->status = $request['status'] ?? 1;
                $buyerfilter->save();



            return Response::json('Filter updated successfully', 200);

    }
    function destroy($id)
    {
        $buyerfilter = BuyerFilter::find($id);
        $buyerfilter->delete();


        return response()->json([
            'message' => 'Filter deleted successfully!'
        ]);
    }

    function get_filter($filter_type)
    {
        $display = '';

        return view('buyerfilters.uk.conditions.' . strtolower($filter_type), compact('display'));
    }
    function get_filter_edit($filter_type, $id)
    {
        $display = '';

        $filters['row'] = BuyerFilter::where('id', $id)->get()->toArray();
//        dd($filters);

        foreach ($filters['row'] as $filter) {
//            foreach ($filter['conditions'] as $k => $v)
            foreach ($filter['conditions'] as $k => $v)
                foreach ($v['values'] as $key => $value)

                    $condition = $filter['conditions'][0]['condition'];
                    $conditionmin = $filter['conditions'][0]['values'][0];
                    $conditionmax = !empty($filter['conditions'][0]['values'][1]);
        }


        return view('buyerfilters.uk.conditions-edit.' . strtolower($filter_type), compact('display', 'filters'));
    }
    function create_form($filter_type)
    {
        $buyersetups = Buyersetup::all();
        $buyers = Buyer::all();

        return view('admin.buyer-filters.uk.buyer-filters-create-form',
            compact('filter_type', 'buyersetups', 'buyers'));
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function FetchBuyerFilterData(Request $request)
    {

        $offer_id = $request->input("offer_id");
        $partner_id = $request->input("partner_id");
        $block = $request->input("block");
        $status = $request->input("status");

        if($request->input("date")!=null){
            $date = Carbon::createFromFormat('d/m/Y', $request->input("date"));
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
        if ($partner_id != null) {
            $wherelist[] = ['partner_id', '=', $partner_id];
        }
        if ($block != null) {
            $wherelist[] = ['block', '=', $block];
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

        $datas = BuyerFilter::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function FetchBuyerFilter(Request $request, $id)
    {

        $filter = BuyerFilter::where('id', $id)->get()->first();


        return

        $offer_id = $request->input("offer_id");
        $partner_id = $request->input("partner_id");
        $block = $request->input("block");
        $status = $request->input("status");

        if($request->input("date")!=null){
            $date = Carbon::createFromFormat('d/m/Y', $request->input("date"));
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
        if ($partner_id != null) {
            $wherelist[] = ['partner_id', '=', $partner_id];
        }
        if ($block != null) {
            $wherelist[] = ['block', '=', $block];
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

        $datas = BuyerFilter::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }


}


