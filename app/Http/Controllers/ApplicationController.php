<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('application');
    }
}
