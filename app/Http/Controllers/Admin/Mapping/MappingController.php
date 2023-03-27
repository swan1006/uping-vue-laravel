<?php


namespace App\Http\Controllers\Admin\Mapping;


use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\Lead\UKLead;
use App\Models\LmsPaydayUK;
use App\Models\Mapping\Mapping;
use App\Models\Partner\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MappingController
{

    public function getMappings(Request $request, $id)
    {
        $mappings = Partner::with(['mappings'])->where('id', $id)->get();


        return Response::json(['mappings' => $mappings]);
    }
    public function getMapping(Request $request, $id){
        $mapping = Partner::with(['mappings'])->where('id', $id)->first();
        $mapping['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id', 'buyername']);
        $mapping['partner_ids'] = Partner::groupBy('id')->whereNotNull('id')->get(['id', 'vendor_id']);


        return Response::json(['mapping' => $mapping]);
    }

    public function fetchFilterDataOptions(Request $request)
    {
        $filterTierData= [];
        $filterTierData['vendor_ids'] = UKLead::groupBy('vid')->whereNotNull('vid')->get(['id', 'vid']);
        $filterTierData['sub_ids'] = UKLead::groupBy('subid')->whereNotNull('subid')->get(['id','subid']);
        $filterTierData['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id','buyername']);
        $filterTierData['buyer_ids'] = Buyer::groupBy('id')->whereNotNull('id')->get(['id','name']);
        $filterTierData['vidLeadPrice_ids'] = UKLead::groupBy('vidLeadPrice')->whereNotNull('vidLeadPrice')->get(['vidLeadPrice']);
        $filterTierData['buyerLeadPrice_ids'] = UKLead::groupBy('buyerLeadPrice')->whereNotNull('buyerLeadPrice')->get(['buyerLeadPrice']);


        return Response::json(['filterTierData' => $filterTierData], 200);

    }

    /*
     * MAPPING LIST
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $aff_id = $request->input("vendor_id");
        $status = $request->input("status");
        $query = $request->input("searchQuery");



        $wherelist = array();
        if ($aff_id != null) {
            $wherelist[] = ['vendor_id', '=', $aff_id];
        }
        if ($query != null) {
            $wherelist[] = ['leadtype', '%LIKE', $query];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $mappings = [];
        $mappings['mappings'] = Partner::with(['mappings', 'company'])->where($wherelist)->paginate($perPage);
        $mappings['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id', 'buyername']);
        $mappings['partner_ids'] = Partner::groupBy('id')->whereNotNull('id')->get(['id', 'vendor_id']);

        return Response::json(['mappings' => $mappings]);
    }
    public function viewMapping($vendor_id)
    {
        $partner = Partner::where('vendor_id', $vendor_id)->first();


        $mapping = [];
        $mapping['mapping'] = Mapping::where('partner_id', $partner->id)->first();
//        $mapping['partner'] = $this->getIndividualMappings($partner->id);
        $mapping['partner'] = Partner::with(['mappings', 'company'])->where('id', $partner->id)->get();
        $mapping['buyer'] = Buyer::with('mappings')->where('id', $mapping['mapping']['buyer_id'])->get();
        $mapping['buyer_setup'] = BuyerSetup::with('mappings')->where('id', $mapping['mapping']['buyer_setup_id'])->get();


        $mapping['tier_ids'] = BuyerSetup::groupBy('id')->whereNotNull('id')->get(['id', 'buyername', '']);
        $mapping['partner_ids'] = Partner::groupBy('id')->whereNotNull('id')->get(['id', 'vendor_id']);
        $mapping['mappings_count'] = Mapping::where('partner_id', $mapping['partner'][0]['id'])->where('status', 1)->count();




        return Response::json(['mapping' => $mapping], 200);
    }

    public function getIndividualMappings($partner_id)
    {
        $partner = Partner::with(['mappings', 'company'])->where('id', $partner_id)->get();
//        dd($partner[0]['mappings']);

        foreach ($partner[0]['mappings'] as $index) {
                $tier_ids[] = $index['buyer_setup_id'];
            }
        $mappings = BuyerSetup::whereIn('id', $tier_ids)->select('id', 'buyername', 'tier_price', 'posting_order')->get();

        foreach ($mappings as $k => $v) {
            foreach ($index as $tier) {
                dump($index);
                    if ($v['id'] === $tier['buyer_setup_id']) {
                        $index->buyername = $v['buyername'];
                        $index->tier_price = $v['tier_price'];
                        $index->posting_order = $v['posting_order'];
                    }
                }
            }

        dd($partner);




        }

    public function store(Request $request) {


        $mapping = new Mapping();
        $buyer_setup = BuyerSetup::where('id', $request['mappingTier']['tier_id'])->first();

        $mapping->leadtype =  $request['mappingTier']['lead_type'];
        $mapping->buyer_setup_id = $request['mappingTier']['tier_id'];
        $mapping->partner_id = $request['mappingTier']['partner_id'];
        $mapping->buyer_id = $buyer_setup['buyer_id'];
        $mapping->status = $request['mappingTier']['status'];

        $res = $mapping->save();
//        dd($res);

        return Response::json('Mapping saved successfully', 200);

    }
    public function edit($id)
    {
        $mapping = Mapping::with(['company'])->where('id', $id)->first();


        return Response::json(['mapping' => $mapping], 200);

    }
    public function destroy($id)
    {
        $mapping = Mapping::find($id);
        $mapping->delete();

        return response()->json([
            'message' => 'Buyer deleted successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {

//        dd($request->input());
        $mapping = Mapping::findOrFail($id);
        $buyer_setup = BuyerSetup::where('id', $request['tier_id'])->first();
        $mapping->buyer_id = $buyer_setup->buyer_id;
        $mapping->leadtype =  $request['leadtype'];
        $mapping->buyer_setup_id = $request['tier_id'];
        $mapping->partner_id = $request['partner_id'];
        $mapping->status = $request['status'];

        $data = $mapping->toArray();
//        dd($data);
        $res = $mapping->save($data);


        return Response::json('Mapping updated successfully', 200);


    }



}
