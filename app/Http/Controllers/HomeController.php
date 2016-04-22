<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        return view('home.home')->with("activities", $activities)
                                ->with("isAdministrator", $companyrole->role_id);
    }

    /**
     * Show the unapproved page.
     *
     * @return \Illuminate\Http\Response
     */
    public function unapproved()
    {
        return view('home.unapproved');
    }
}
