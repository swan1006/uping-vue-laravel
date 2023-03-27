<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartProfileController extends Controller
{
    public function index()
    {

        $id = Auth::id();
        $user = User::find($id);

        $partner = User::find($id)->partner;

        return view('partner.profile.profile', compact('partner', 'user'));
    }
}
