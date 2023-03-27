<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Controllers\Controller;
use App\Models\Offer\Campaign;
use App\Models\Advertiser\Advertiser;
use App\Models\Offer\Creatives;
use App\Models\Offer\Landers;
use App\Models\Offer\Offer;
use App\Models\Offer\OfferCap;
//use App\Models\Offer\Offer\Metrics;
use App\Models\Offer\Payout;
use App\Models\Offer\TargetGroup;
use App\Models\Offer\Tracking;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{




//    var $leadtype = 'paydayuk' || 'paydayus';


    public function getAllOffers() {
        $offers = Offer::with([
            'tracking',
            'campaign',
            'advertiser',
            'target_group',
            'landers',
            'payout',
            'offer_cap',
            'target_group',
            'creatives'
        ]);
        dd($offers);

        return Response::json(['offers' => $offers]);
    }

    /**
     * @param $imagePath
     * @return string
     * @throws FileNotFoundException
     */
    public static function getImage($imagePath)
    {
        if (Storage::exists($imagePath)) {
            return Storage::disk('s3')->get($imagePath);
        } else {
            return 'No Image';
        }
    }

    public function privacy_level()
    {
        // Make offer private / public / paused
    }

    public function index(Request $request)
    {
        $perPage = $request->input("perPage");

        $offers = Offer::with(
            [
                'tracking',
                'campaign',
                'advertiser',
                'target_group',
                'landers',
                'payout',
                'offer_cap',
                'target_group',
                'creatives'

            ])
        ->get()->all();

        $offer_count = count(Offer::all())->paginate($perPage);
//        $offers['advertisers'] = Advertiser::all();

        return Response::json(['offers' => $offers, 'offer_count' => $offer_count]);
    }
    public function store(Request $request)
    {
//        $request->validate([
//            'advertiser_id' => 'required',
//            'offerName' => 'required',
//            'description' => 'required',
//            'restrictions' => 'required',
//            'privacy_level' => 'required',
//            'offerStatus' => 'required',
//            'top_offer' => 'required',
//            'conversion_action' => 'required',
//            'terms' => 'required',
//            'trafficSource' => 'required',
//            'category' => 'required',
//            'internal' => 'required',
//            'geos' => 'required',
//
//            'lander_name' => 'required',
//            'lander_tracking_url' => 'required',
//            'lander_para_tracking_url' => 'required',
//            'lander_preview_url' => 'required',
//
//            'payoutType' => 'required',
//            'payoutAmount' => 'required',
//            'revenueType' => 'required',
//            'revenueAmount' => 'required',
//            'currency' => 'required',
//            'payment_terms' => 'required',
//
////            'daylimit' => 'required',
////            'weeklimit' => 'required',
////            'monthlimit' => 'required',
////            'daycredit' => 'required',
////            'weekcredit' => 'required',
////            'monthcredit' => 'required',
////
////            'target_group_name' => 'required',
//////            'all_devices' => 'required',
////            'countries' => 'required',
////            'states' => 'required',
////            'cities' => 'required',
////            'connection_type' => 'required',
////            'target_group_status' => 'required',
//        ]);

        $offer = new Offer;
        $offer->advertiser_id = $request['offer']['advertiser_id'] ?? 1;
        $offer->name = $request['offer']['name'];
        $offer->description = $request['offer']['description'];
        $offer->expiresDate = $request['offer']['expiresDate'];
        $offer->privacy_level = $request['offer']['privacy_level'];
        $offer->status = $request['offer']['status'];
        $offer->restrictions = $request['offer']['restrictions'];
        $offer->conversion_action = $request['offer']['conversion_action'];
        $offer->conversion_type = $request['offer']['conversion_type'];
        $offer->category = $request['offer']['category'];
        $offer->multiple_conversions = $request['offer']['multiple_conversions'] ?? 0;
        $offer->terms = $request['offer']['terms'];
        $offer->internal = $request['offer']['internal'];
        $offer->geos = $request['offer']['geos'];
//        $offer->trafficSource = $request['offer']['trafficSource'];
        $offer->save();

        // Lander
        $lander = new Landers;
        $lander->offer_id = $lander->id;
        $lander->lander_name = $request['offer']['lander_name'];
        $lander->lander_tracking_url = $request['offer']['lander_tracking_url'];
        $lander->lander_para_tracking_url = $request['offer']['lander_para_tracking_url'];
        $lander->lander_preview_url = $request['offer']['lander_preview_url'];
        $lander->status = 1;
        $lander->save();

        // Payout
        $payout = new Payout;
        $payout->offer_id = $offer->id;
        $payout->payoutType = $request['offer']['payout_type'];
        $payout->payoutAmount = $request['offer']['payout_amount'];
        $payout->revenueType = $request['offer']['revenue_type'];
        $payout->revenueAmount = $request['offer']['revenue_amount'];
        $payout->currency = $request['offer']['currency'];
        $payout->payment_terms = $request['offer']['payment_terms'];
        $payout->status = 1;
        $payout->save();

        // Offer Caps
        $offer_caps = new OfferCap;
        $offer_caps->offer_id = $offer->id;
        $offer_caps->daylimit = $request['offer']['daylimit'];
        $offer_caps->weeklimit = $request['offer']['weeklimit'];
        $offer_caps->monthlimit = $request['offer']['monthlimit'];
        $offer_caps->daycredit = $request['offer']['daycredit'];
        $offer_caps->weekcredit = $request['offer']['weekcredit'];
        $offer_caps->monthcredit = $request['offer']['monthcredit'];
        $offer_caps->status = 1;
        $offer_caps->save();

        // Tracking
        $tracking = new Tracking;
        $tracking->offer_id = $offer->id;
        $tracking->tracking_url = $request['offer']['tracking_url'];
        $tracking->parallel_tracking_url = $request['offer']['parallel_tracking_url'];
        $tracking->preview_url = $request['offer']['preview_url'];
        $tracking->tracking_domain_url = $request['offer']['tracking_domain_url'];
        $tracking->session_lifespan = $request['offer']['session_lifespan'];
        $tracking->status = 1;
        $tracking->save();

        // Target Group
        $target_group = new TargetGroup;
        $target_group->offer_id = $offer->id;
        $target_group->target_group_name = $request['offer']['target_group_name'];
        $target_group->all_devices = $request['offer']['all_devices'];
        $target_group->countries = $request['offer']['countries'];
        $target_group->regions = $request['offer']['regions'];
        $target_group->cities = $request['offer']['cities'];
        $target_group->connection_type = $request['offer']['connection_type'];
        $target_group->status = 1;
        $target_group->save();


        $offer_update = Offer::find($offer->id);

//        $uploadedLogoFileName = $this->uploadOfferLogo($request, $offer_id);
//        $offer->offer_logo = $uploadedLogoFileName;

        $offer_update->lander_id = $lander->id;
        $offer_update->tracking_id = $tracking->id;
        $offer_update->target_group_id = $target_group->id;
        $offer_update->payout_id = $payout->id;
        $offer_update->offer_cap_id = $offer_caps->id;

        $data = $offer_update->toArray();
        $offer_update->save($data);
//        dd($offer_update);


        return Response::json($offer);

    }
    public function show($id)
    {
        $offer = Offer::where('id', $id)->with(
            [
                'tracking',
                'campaign',
                'advertiser',
                'target_group',
                'landers',
                'payout',
                'offer_cap',
                'target_group',
                'creatives',
                'advertiser'
            ])
            ->get()->first();
//        dd($offer->offer_caps);

//        $files = Storage::allFiles('logo/'.$offer->id . '/');
//
//        $vid = Auth::user()->partner->id;
//        $partners = Partner::all();
//
//        $trafficSource = $offer->trafficSource;
//        dd($trafficSource);
//        if (is_array($trafficSource)) {
//            $trafficSource = implode(',', $trafficSource);
//        }
//        dd($trafficSource);
//        $geos = $offer->geos;
//
//        $postback_trackers = PostbackTracker::where('offer_id', $id)->get();
//        $landers = Landers::where('offer_id', $id)->get();
//        $creatives = Creatives::where('offer_id', $id)->get();
//

        return Response::json(['offer' => $offer], 200);

    }
    public function update(Request $request, $id)
    {
//        dd($request->input());

        $offer = Offer::find($id);
        $offer->advertiser_id = $request['advertiser_id'];

        $offer->name = $request['name'];
        $offer->logo = $request['logo'];
        $offer->description = $request['description'];
        $offer->expiresDate = $request['expiresDate'];
        $offer->privacy_level = $request['privacy_level'];
        $offer->status = $request['status'];
        $offer->top_offer = $request['top_offer'];
        $offer->restrictions = $request['restrictions'];
        $offer->conversion_action = $request['conversion_action'];
        $offer->conversion_type = $request['conversion_type'];
        $offer->category = $request['category'];
        $offer->multiple_conversions = $request['multiple_conversions'];
        $offer->terms = $request['terms'];
        $offer->internal = $request['internal'];
        $offer->geos = $request['geos'];
        $offer->trafficSource = $request['trafficSource'];
        $offer_data = $offer->toArray();
        $res = $offer->save($offer_data);

        // Lander
        // TODO loop
        $lander_id = $request['landers'][0]['id'];
        if (isset($lander_id)) {
            $lander = Landers::find($lander_id);
            $lander->lander_name = $request['landers'][0]['lander_name'];
            $lander->lander_tracking_url = $request['landers'][0]['lander_tracking_url'];
            $lander->lander_para_tracking_url = $request['landers'][0]['lander_para_tracking_url'];
            $lander->lander_preview_url = $request['landers'][0]['lander_preview_url'];
            $lander->status = 1;
            $data = $lander->toArray();
            $lander->save($data);
        }

        // Payout
        $payout_id = $request['payout']['id'];
        if (isset($payout_id)) {
            $payout = Payout::find($payout_id);
            $payout->payoutType = $request['payout']['payoutType'];
            $payout->payoutAmount = $request['payout']['payoutAmount'];
            $payout->revenueType = $request['payout']['revenueType'];
            $payout->revenueAmount = $request['payout']['revenueAmount'];
            $payout->currency = $request['payout']['currency'];
            $payout->payment_terms = $request['payout']['payment_terms'];
            $payout->status = '1';
            $data = $payout->toArray();
            $payout->save($data);
        }

        // Offer Caps
        $offer_cap_id = $request['offer_cap']['id'];
        if (isset($offer_cap_id)) {
            $offer_caps = OfferCap::find($offer_cap_id);
            $offer_caps->daylimit = $request['offer_cap']['daylimit'];
            $offer_caps->weeklimit = $request['offer_cap']['weeklimit'];
            $offer_caps->monthlimit = $request['offer_cap']['monthlimit'];
            $offer_caps->daycredit = $request['offer_cap']['daycredit'];
            $offer_caps->weekcredit = $request['offer_cap']['weekcredit'];
            $offer_caps->monthcredit = $request['offer_cap']['monthcredit'];
            $offer_caps->status = 1;
            $data = $offer_caps->toArray();
            $offer_caps->save($data);
        }

        $tracking_id = $request['tracking']['id'];
        if (isset($tracking_id)) {
            $tracking = Tracking::find($tracking_id);
            $tracking->tracking_url = $request['tracking']['tracking_url'];
            $tracking->parallel_tracking_url = $request['tracking']['parallel_tracking_url'];
            $tracking->preview_url = $request['tracking']['preview_url'];
            $tracking->tracking_domain_url = $request['tracking']['tracking_domain_url'];
            $tracking->session_lifespan = $request['tracking']['session_lifespan'];
            $tracking->status = '1';
            $data = $tracking->toArray();
            $tracking->save($data);
        }

        // Target Group
        $target_group_id = $request['target_group']['id'];
        if (isset($target_group_id)) {
            $target_group = TargetGroup::find($target_group_id);
            $target_group->target_group_name = $request['target_group']['target_group_name'];
            $target_group->all_devices = $request['target_group']['all_devices'];
            $target_group->countries = $request['target_group']['countries'];
            $target_group->regions = $request['target_group']['regions'];
            $target_group->cities = $request['target_group']['cities'];
            $target_group->connection_type = $request['target_group']['connection_type'];
            $target_group->status = $request['target_group']['status'];

            $data = $target_group->toArray();
            $target_group->save($data);
        }

        $offer_update = Offer::find($id);

        $offer_update->lander_id = $lander_id;
        $offer_update->tracking_id = $tracking_id;
        $offer_update->target_group_id = $target_group_id;
        $offer_update->payout_id = $payout_id;
        $offer_update->offer_cap_id = $offer_cap_id;

        $data = $offer_update->toArray();
        $res = $offer_update->save($data);


        return Response::json($offer);

    }
    public function destroy($id)
    {
        $offer = Offer::find($id);
        $offer->delete();

        return response()->json([
            'message' => 'Offer deleted successfully!'
        ]);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function showOffer($id)
    {
        $offer = Offer::where('id', $id)->with(
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
            ->get()->first();

        return Response::json($offer);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function editOffer($id)
    {
        $offer = Offer::where('id', $id)->with(
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
            ->get()->first();

        $offer['advertisers'] = Advertiser::all();

        return Response::json($offer);

    }


    /**
     * @param Request $request
     * @param $offer_id
     * @return string|void
     */
    public function uploadOfferLogo(Request $request, $offer_id)
    {
        if($request->hasFile('offer_logo')){

            $uploadedLogoFile = $request->file('offer_logo');
            $uploadedLogoFileName = time() . '/' . $uploadedLogoFile->getClientOriginalName();
            $path = $uploadedLogoFile->storePubliclyAs('logo/', $offer_id . '/' . $uploadedLogoFileName, 's3');
//            Image::make($request->file('offer_logo'))->resize(300, 300);

            return $uploadedLogoFileName;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function updateOfferLogo(Request $request)
    {

        $id = $request->input('id2');
        if($request->hasFile('offer_logo')){

            $uploadedLogoFile = $request->file('offer_logo');
            $uploadedLogoFileName = time() . '/' . $uploadedLogoFile->getClientOriginalName();
            $path = $uploadedLogoFile->storePubliclyAs('logo/' . $id . '/', $uploadedLogoFileName, 's3');

            $offer = Offer::find($id);
            $offer->offer_logo = $uploadedLogoFileName;
            $offer->save();

            return redirect()->back()
                ->with('success', 'Avatar Updated!');
        }
    }
}
