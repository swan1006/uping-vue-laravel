<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\Mapping\Mapping;
use App\Models\Partner\Partner;
use App\Models\User;
use App\Models\User\Company;
use App\Models\User\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index(Request $request) {

        $perPage = $request->input("perPage");
        $role = $request->input("role");
        $status = $request->input("status");


        $wherelist = array();
        if ($role != null) {
            $wherelist[] = ['is_admin', '=', $role];
        }
        if ($status != null) {
            $wherelist[] = ['status', '=', $status];
        }

        $users = User::with(['partner', 'company', 'payment'])->where($wherelist)->paginate($perPage);

        return Response::json(['users' => $users]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::with(['partner', 'company',  'payment'])->where('id',$id)->first();


        return Response::json(['user' => $user]);
    }
    public function update(Request $request, $id)
    {
//        dd($request->input());
        $user = User::find($id);
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->avatar = $request['avatar'] ?? 'default.jpg';
        $user->email = $request['email'];
        $user->is_admin = $request['is_admin'] ?? 0;
        $user->status = $request['status'];
        $user->role = $request['role'] ?? 1;

        $data = $user->toArray();
        $res = $user->save($data);
//        dd($res);

        return response()->json('User updated successfully.');
    }
    public function store(Request $request) {


        $user = new User();
        $user->name = $request['user']['name'];
        $user->username = $request['user']['username'];
        $user->email = $request['user']['email'];
        $user->password = Hash::make('12345');
        $user->is_admin = '0';
        $user->status =  1;
        $user->role = $request['user']['role']  ?? 1;;
        $user->save();

        $company = new Company();
        $company->user_id = $user->id;
        $company->name = $request['user']['company_name'];
        $res = $company->save();

        $payment = new Payment();
        $payment->user_id =$user->id;
        $payment->save();

        return $user;
    }
    public  function show(Request $request, $id){
        $user = User::with(['partner', 'company', 'payment'])->where('id',$id)->first();


        return Response::json(['user' => $user]);

    }
    public function destroy($id){

        $user = User::find($id);

        $res = $user->delete();

        return response()->json('User deleted successfully.');

    }


}
