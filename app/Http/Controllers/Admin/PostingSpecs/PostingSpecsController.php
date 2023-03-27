<?php

namespace App\Http\Controllers\Admin\PostingSpecs;

use App\Http\Controllers\Controller;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostingSpecsController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $vid = Partner::where('user_id', $id)->get();
//        dd($vid);

        return view('admin.postingspecs.posting-specs', compact('vid'));
    }

    /**
     * This function handles/shows the view for the iframe FORM for VIDs.
     *
     * @param $country_code
     * @param $vid
     */
    public function posting_specs_view($country_code)
    {

        $id = Auth::id();
        $vid = Partner::where('user_id', $id)->get();


        if ($country_code === 'uk') {
            return view('admin.postingspecs.uk', compact('country_code', 'vid'));
        } else {
            return view('admin.postingspecs.us', compact('country_code', 'vid'));

        }
    }
}
