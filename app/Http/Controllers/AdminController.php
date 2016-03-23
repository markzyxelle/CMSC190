<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;

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
        $code = $company->company_code;
        $approved = Auth::user()->company->users()->where('isApproved', 1)->count() / 10;
        $pending = Auth::user()->company->users()->where('isApproved', 0)->count() / 10;
        $branches = Auth::user()->company->branches;
        $roles = $company->roles;

        return view('admin.users')->with('code', $code)
                            ->with('approved', $approved)
                            ->with('pending', $pending)
                            ->with('branches', $branches)
                            ->with('roles', $roles);

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

        return view('admin.roles')->with('roles', $roles);
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
            ]);
        }

        \App\CompanyRole::create([
            'company_id' => $company_id,
            'role_id' => $role_id,
        ]);
        // \App\Branch::create([
        //     'company_id' => $company_id,
        //     'name' => $data['branch_name'],
        // ]);

        return redirect('/roles');
    }     

    //TEST CSV ________________________________________________________________________________

    // /**
    //  * Testing
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function testCsv(Request $request)
    // {
    //     $data = $request->all();

    //     $row = 1;
    //     if (($handle = fopen($data["fileToUpload"], "r")) !== FALSE) {
    //         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //             $num = count($data);
    //             echo "<p> $num fields in line $row: <br /></p>\n";
    //             $row++;
    //             for ($c=0; $c < $num; $c++) {
    //                 echo $data[$c] . "<br />\n";
    //             }
    //         }
    //         fclose($handle);
    //     }

    //     die();
    // }
}
