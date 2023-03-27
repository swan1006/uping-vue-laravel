<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Rules\MatchOldPassword;

class PartChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $res = User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);


        return redirect()->back()
            ->with('success', 'Password Updated!');

    }
}
