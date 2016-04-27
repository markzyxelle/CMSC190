<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class AdminController extends Controller
{
    /**
     * Show the users approved or has pending requests. For admin
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $company = Auth::user()->company;
        $approved = Auth::user()->company->users()->where('isApproved', 1)->count() / 10;
        $pending = Auth::user()->company->users()->where('isApproved', 0)->count() / 10;
        $branches = Auth::user()->company->branches;
        $roles = Auth::user()->company->roles;
        $activities = \App\Activity::all();

        // $temp = Auth::user()->company->users;
        // foreach ($temp as $key => $value) {
        //     if($value['isApproved']) $approved++;
        //     else $pending++;
        // }
        // echo $approved;
        // echo $pending;
        // dd(Auth::user()->company->users->where('username', 'mark'));

        return view('admin.users')->with('company', $company)
                            ->with('approved', $approved)
                            ->with('pending', $pending)
                            ->with('branches', $branches)
                            ->with('roles', $roles)
                            ->with('activities', $activities);

        // return view('users')->with('code', $code);
    }

    /**
     * Get Approved users for AJAX.
     *
     * @return JSON
     */
    public function getApprovedUsers($start, Request $request)
    {
        if($request->ajax()){
            $users = Auth::user()->company->users()->where('isApproved', 1)->skip($start*10)->take(10)->get();
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $users->toJson();
        }
    }

    /**
     * Get Pending users for AJAX.
     *
     * @return JSON
     */
    public function getPendingUsers($start, Request $request)
    {
        if($request->ajax()){
            $users = Auth::user()->company->users()->where('isApproved', 0)->skip($start*10)->take(10)->get();
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $users->toJson();
        }
    }

    /**
     * Display branches page.
     *
     * @return \Illuminate\Http\Response
     */
    public function branches()
    {
        $branches = Auth::user()->company->branches;

        return view('admin.branches')->with('branches', $branches);
    }

    /**
     * Add Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBranch(Request $request)
    {
        $data = $request->all();
        $company_id = Auth::user()->company->id;

        $validator = Validator::make($data, [
            'branch_name' => 'required|max:255|unique:branches,name,NULL,NULL,company_id,' . $company_id,
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        \App\Branch::create([
            'company_id' => $company_id,
            'name' => $data['branch_name'],
        ]);

        return redirect('/branches');
    }     


    /**
     * Approve User.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveUser(Request $request)
    {
        $data = $request->all();

        $customNames = array(
            'branch_id' => 'branch name',
            'role_id' => 'role',
        );

        $validator = Validator::make($data, [
            'role_id' => 'required',
        ])->setAttributeNames($customNames);

        $validator->sometimes('branch_id', 'required', function($input) {
            return $input->role_id > 1;
        });

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = \App\User::find($data['user_id']);
        $user->company_role_id = $data['role_id'];
        $user->branch_id = ($data['role_id'] == 1) ? NULL : $data['branch_id'];
        $user->isApproved = 1;
        $user->save();

        //auto-join to unversal clusters
        $cluster = \App\Cluster::where("cluster_code", "a1")->first();
        $cluster_user = \App\ClusterUser::firstOrCreate([
            'cluster_id' => $cluster->id,
            'user_id' => $user->id,
            'isApproved' => 1,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 2,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 3,
        ]);

        $cluster = \App\Cluster::where("cluster_code", "a2")->first();
        $cluster_user = \App\ClusterUser::firstOrCreate([
            'cluster_id' => $cluster->id,
            'user_id' => $user->id,
            'isApproved' => 1,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 2,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 3,
        ]);

        $cluster = \App\Cluster::where("cluster_code", "a3")->first();
        $cluster_user = \App\ClusterUser::firstOrCreate([
            'cluster_id' => $cluster->id,
            'user_id' => $user->id,
            'isApproved' => 1,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 2,
        ]);

        \App\ActionClusterUser::firstOrCreate([
            'cluster_user_id' => $cluster_user->id,
            'action_id' => 3,
        ]);

        return redirect('/users');
    }   

    /**
     * Display roles page.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        $roles = Auth::user()->company->roles;
        $activities = \App\Activity::all();

        return view('admin.roles')->with('roles', $roles)
                                ->with('activities', $activities);
    }     

    /**
     * Add Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request)
    {
        $data = $request->all();
        $company_id = Auth::user()->company->id;

        $role = \App\Role::where('name', $data["role_name"])->first();
        $role_id = ($role == null) ? null : $role->id;

        //dd($role_id);

        //to check if the role is already used by the company
        //to take advantage of "accepted" feature of laravel
        $data['company_role_id'] = (\App\CompanyRole::where('company_id', $company_id)->where('role_id', $role_id)->first() == null) ? true : false;

        $validator = Validator::make($data, [
            'role_name' => 'required|max:255',
            'company_role_id' => 'accepted'
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if($role_id == null){
            $role_id = \App\Role::create([
                'name' => $data['role_name'],
            ])->id;
        }

        $company_role_id = \App\CompanyRole::create([
            'company_id' => $company_id,
            'role_id' => $role_id,
        ])->id;

        $activities = \App\Activity::all();

        foreach ($activities as $activity) {
            if(array_key_exists($activity->id, $data)){
                \App\CompanyRoleActivity::create([
                    'activity_id' => $activity->id,
                    'company_role_id' => $company_role_id,
                ]);
            }
        }
        // \App\Branch::create([
        //     'company_id' => $company_id,
        //     'name' => $data['branch_name'],
        // ]);
        return redirect('/roles');
    }

    /**
     * Unapprove User.
     *
     * @return \Illuminate\Http\Response
     */
    public function unapproveUser(Request $request)
    {
        $data = $request->all();
        
        $user = \App\User::find($data['user_id']);
        $user->company_role_id = NULL;
        $user->branch_id = NULL;
        $user->isApproved = 0;
        $user->save();

        return redirect('/users');
    } 

    /**
     * Edit Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function editBranch(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'branch_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $branch = \App\Branch::find($data["branch_id"]);
        $branch->name = $data["branch_name"];
        $branch->save();

        return redirect('/branches');
    }     

    /**
     * Edit Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function editRole(Request $request)
    {
        $data = $request->all();
        
        foreach (\App\Activity::all() as $activity) {
            if(array_key_exists(str_replace(" ", "_", $activity->id), $data)){
                \App\CompanyRoleActivity::firstOrCreate(['activity_id' => $activity->id, 'company_role_id' => $data["company_role_id"]]);
            }
            else{
                $company_role_activity = \App\CompanyRoleActivity::where([
                                                ['activity_id',$activity->id],
                                                ['company_role_id',$data["company_role_id"]],
                                            ])->first();
                if($company_role_activity != null) $company_role_activity->delete();
            }
        }

        return redirect('/roles');
    }   

    /**
     * Edit Company.
     *
     * @return \Illuminate\Http\Response
     */
    public function editCompany(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'company_name' => 'required|max:255',
            'company_shortname' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $company = Auth::user()->company;
        $company->name = $data["company_name"];
        $company->shortname = $data["company_shortname"];
        $company->save();

        return redirect('/users');
    }     
}
