<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice\Invoice;
use App\Models\User;
use App\Models\User\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CompanyController extends Controller
{


    public function index()
    {
        $companies = Company::all();

        return Response::json(['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('here store');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('here show');
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


//        dd($request['company']['phone']);
//        dd($request->input());
        $company_info = Company::where('user_id', $id)->first();
        $company_info->phone = $request['company']['phone'] ?? '';
        $company_info->birth_date = $request['company']['birth_date']  ?? '';
        $company_info->website = $request['company']['website']  ?? '';
        $company_info->skype = $request['company']['skype']  ?? '';
        $company_info->contact_options = $request['company']['contact_options']  ?? '';
        $company_info->address1 = $request['company']['address1']  ?? '';
        $company_info->address2 = $request['company']['address2']  ?? '';
        $company_info->postcode = $request['company']['postcode']  ?? '';
        $company_info->city = $request['company']['city']  ?? '';
        $company_info->state = $request['company']['state']  ?? '';
        $company_info->country = $request['company']['country']  ?? '';


        $data = $company_info->toArray();
        $res = $company_info->save($data);
//        dd($res);

        return response()->json('User Information updated successfully.');

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

    public function getAllCompanyData()
    {
        $company['clients'] = Company::groupBy('id')->whereNotNull('id')->get(['id', 'name']);


        return Response::json($company);
    }
}
