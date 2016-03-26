<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    /**
     * Toggle Dummy Mode.
     *
     * @return \Illuminate\Http\Response
     */
    public function switchDummyMode(Request $request)
    {
        $user = Auth::user();

        $user->dummy_mode = !($user->dummy_mode);
        $user->save();

        return redirect("/home");
    }

    /**
     * Display structure page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStructure()
    {
        $branch = Auth::user()->branch;

        return view('normaluser.structure')->with('branch', $branch);
    }

    /**
     * Get Centers for the Branch.
     *
     * @return JSON
     */
    public function getCenters($branch_id, Request $request)
    {
        //if($request->ajax()){
            $branch = \App\Branch::find($branch_id);
            $centers = $branch->centers;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $centers->toJson();
        //}
    }

    /**
     * Add a center to the branch.
     *
     * @return JSON
     */
    public function addCenter(Request $request)
    {
        //if($request->ajax()){

            $data = $request->all();

            \App\Center::create([
                'branch_id' => $data['branch_id'],
                'name' => $data['center_name'],
            ]);
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return response()->json($data);
        //}
    }

    /**
     * Get Groups for the Center.
     *
     * @return JSON
     */
    public function getGroups($center_id, Request $request)
    {
        //if($request->ajax()){
            $center = \App\Center::find($center_id);
            $groups = $center->groups;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $groups->toJson();
        //}
    }

    /**
     * Add a group to the center.
     *
     * @return JSON
     */
    public function addGroup(Request $request)
    {
        //if($request->ajax()){

            $data = $request->all();

            \App\Group::create([
                'center_id' => $data['center_id'],
                'name' => $data['group_name'],
            ]);
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return response()->json($data);
        //}
    }

    /**
     * Get Clients for the Group.
     *
     * @return JSON
     */
    public function getClients($group_id, Request $request)
    {
        //if($request->ajax()){
            $group = \App\Group::find($group_id);
            $clients = $group->clients;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $clients->toJson();
        //}
    }
}