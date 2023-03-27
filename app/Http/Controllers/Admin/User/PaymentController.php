<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice\Invoice;
use App\Models\User;
use App\Models\User\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{


    public function index()
    {
        $payments = Payment::all();

        return Response::json(['payments' => $payments]);
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

        $user = Payment::where('user_id', $id)->first();
        $user->bank_name = $request['payment']['bank_name'];
        $user->bank_iban = $request['payment']['bank_iban'];
        $user->bank_account_number = $request['payment']['bank_account_number'];
        $user->bank_swift = $request['payment']['bank_swift'];
        $user->bank_sortcode = $request['payment']['bank_sortcode'];
        $user->bank_country = $request['payment']['bank_country'];
        $user->bank_phone = $request['payment']['bank_phone'];

        $data = $user->toArray();
        $res = $user->save($data);

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
}
