<?php

namespace App\Http\Controllers\Admin\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner\PartnerLeadType;
use App\Models\User;
use App\Models\Partner\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PartnerLeadTypeController extends Controller
{

    public function index()
    {
        $partnersleadtypes = PartnerLeadType::all();
        $partners = Partner::all();


        return view('admin.partners-leadtype.partners-leadtype', compact('partnersleadtypes', 'partners'));

    }
    public function create()
    {
        $users= User::all();

        return view('admin.partners-leadtype.partners-leadtype-create', compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'vid' => 'required',
            'type' => 'required',
            'status' => 'required',
            'margin' => 'required',
            'duplicateEmail' => 'required',
            'duplicatePhone' => 'required',
            'daytotal' => 'required',
            'daylimit' => 'required',
            'weeklimit' => 'required',
            'monthlimit' => 'required',
            'daycredit' => 'required',
            'weekcredit' => 'required',
            'monthcredit' => 'required',
            'currencyType' => 'required',
        ]);

        $partnerleadtype = new PartnerLeadType;
        $partnerleadtype->vid = $request->input('vid');
        $partnerleadtype->type = $request->input('type');
        $partnerleadtype->status = $request->input('status');
        $partnerleadtype->margin =  $request->input('margin');
        $partnerleadtype->margin =  $request->input('margin');
        $partnerleadtype->duplicateEmail = $request->input('duplicateEmail');
        $partnerleadtype->duplicatePhone = $request->input('duplicatePhone');
        $partnerleadtype->daylimit = $request->input('daylimit');
        $partnerleadtype->weeklimit = $request->input('weeklimit');
        $partnerleadtype->monthlimit = $request->input('monthlimit');
        $partnerleadtype->daycredit = $request->input('daycredit');
        $partnerleadtype->weekcredit = $request->input('weekcredit');
        $partnerleadtype->monthcredit = $request->input('monthcredit');
        $partnerleadtype->currencyType = $request->input('currencyType');
        $partnerleadtype->save();



        // redirect
        return redirect()->route('partnersleadtype.index')
            ->with('success', 'Partner Lead Type is successfully saved');

    }
    public function show($id)
    {
        $leadtype = PartnerLeadType::find($id);

        return Response::json($leadtype);
    }
    public function edit($id)
    {
        $leadtype = PartnerLeadType::find($id);

        echo json_encode(['data' => $leadtype]);
    }
    public function destroy($id)
    {
        $leadtype = PartnerLeadType::find($id);
        $leadtype->delete();

        return response()->json([
            'message' => 'Partner deleted successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        $request = json_decode(json_encode($request->input()));

        $partnerleadtype = PartnerLeadType::find($id);
        $partnerleadtype->vid = $request->leadtype->vid2;
        $partnerleadtype->type = $request->leadtype->type2;
        $partnerleadtype->status = $request->leadtype->status2;
        $partnerleadtype->margin =  $request->leadtype->margin2;
        $partnerleadtype->daytotal = $request->leadtype->daytotal2;
        $partnerleadtype->duplicateEmail =  $request->leadtype->duplicateEmail2;
        $partnerleadtype->duplicatePhone =  $request->leadtype->duplicatePhone2;
        $partnerleadtype->daylimit = $request->leadtype->daylimit2;
        $partnerleadtype->weeklimit = $request->leadtype->weeklimit2;
        $partnerleadtype->monthlimit = $request->leadtype->monthlimit2;
        $partnerleadtype->daycredit = $request->leadtype->daycredit2;
        $partnerleadtype->weekcredit = $request->leadtype->weekcredit2;
        $partnerleadtype->monthcredit = $request->leadtype->monthcredit2;
        $partnerleadtype->currencyType = $request->leadtype->currencyType2;

        $data = $partnerleadtype->toArray();
        $partnerleadtype->save($data);

        return Response::json($partnerleadtype);
//        return redirect()->route('partnersleadtype.index')->with('success','Partner Lead Type updated successfully');
    }

    /**
     *
     * @param Request $request
     */
    public function FetchPartnerLeadTypeData(Request $request)
    {
        $vid = $request->input("vid");
        $lead_type = $request->input("leadtype");
        $status = $request->input("status");

        $wherelist = array();
        if ($lead_type != null) {
            $wherelist[] = ['type', '=', $lead_type];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }
        if ($vid != null) {
            $wherelist[] = ['vid', '=', $vid];
        }
        $datas = PartnerLeadType::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }



}
