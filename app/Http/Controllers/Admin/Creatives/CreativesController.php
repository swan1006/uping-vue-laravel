<?php

namespace App\Http\Controllers;

use App\Exports\admin\exportBuyerLogs;
use App\Exports\admin\exportCreativeList;
use App\Lmscallcenter;
use App\LmspaydayUK;
use App\Models\Creatives;
use App\Models\Tracking;
use App\Offer;
use App\Partner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CreativesController extends Controller
{

    public function index()
    {
        $creatives = Creatives::all();
        $offers = Offer::all();

        return view('admin.creatives.creatives', compact('creatives', 'offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'creative_url' => 'required',
            'download_url' => 'required',
            'status' => 'required',

        ]);
        $creative = new Creatives();
        $creative->offer_id =  $request->offer_id;
        $creative->type = $request->type;
        $creative->name = $request->name;
        $creative->creative_url = $request->creative_url;
        $creative->download_url = $request->download_url;
        $creative->suppression_list_url = $request->suppression_list_url;
        $creative->status = $request->status;
        $creative->save();

        return Response::json($creative);
    }

    public function show($id)
    {
        $creative = Creatives::find($id);

        return Response::json($creative);
    }

    public function edit($id)
    {
        $creative = Creatives::find($id);

        echo json_encode(['data' => $creative]);
    }

    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));


        $creative = Creatives::find($id);
        $creative->offer_id =  $request->creative->offer_id2;
        $creative->type = $request->creative->type2;
        $creative->name = $request->creative->name2;
        $creative->creative_url = $request->creative->creative_url2;
        $creative->download_url = $request->creative->download_url2;
        $creative->suppression_list_url = $request->creative->suppression_list_url2;
        $creative->status = $request->creative->status2;
        $creative->save();

        return Response::json($creative);
    }

    public function destroy($id)
    {
        $company = Creatives::find($id);
        $company->delete();

        return response()->json([
            'message' => 'Creative deleted successfully!'
        ]);
    }


    /**
     * This email downloads email creatives via header.
     *
     * @param $site_name
     * @param $country_code
     */
    public function download_creative($source, $id)
    {
//        Storage::find()
//        header('Content-disposition: attachment; filename=my-loans-uk.html;
//        header('Content-type: text/html;
        return view('admin.creatives' . $source . '/' . $id);
    }

    public function creativeExport()
    {
        return Excel::download(new exportCreativeList(), 'creative-export' . now() . '.xlsx');

    }

}
