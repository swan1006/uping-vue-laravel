<?php

namespace App\Http\Controllers\Partner;

use App\LmsPartnerLeadType;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PartUpdateCurrencyController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user_id = $id;
        $partner_id = Partner::where('user_id', $user_id)->first()->id;

        $id = LmsPartnerLeadType::where('vid', $partner_id)->get()->first()->id;

        $request = json_decode(json_encode($request->input()));

        $partner = LmsPartnerLeadType::find($id);
        if (isset($request->account->GBP)) {
            if ($request->account->GBP != null) {
                $partner->currencyType = 'GBP';
            }
        }
        if (isset($request->account->USD)) {
            if ($request->account->USD != null) {
                $partner->currencyType = 'USD';
            }
        }
        $data = $partner->toArray();
        $partner->save($data);

        return Response::json($partner);
    }
}
