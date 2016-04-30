<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\URL;
use DB;

class ClusterController extends Controller
{
    /**
     * Display cluster page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCluster()
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $approved = Auth::user()->clusters()->where("isApproved", true)->get();
            $pending = Auth::user()->clusters()->where("isApproved", false)->get();
            $actions = \App\Action::all();

            return view('normaluser.cluster')->with('approved', $approved)
                                ->with('pending', $pending)
                                ->with('actions', $actions);
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Add a cluster for the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCluster(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();

            $validator = Validator::make($data, [
                'cluster_name' => 'required|max:255',
                'cluster_setting' => 'required|between:1,4'
            ]);

            if ($validator->fails()) {
                $request->session()->flash('setting', $data['cluster_setting']);
                $this->throwValidationException(
                    $request, $validator
                );
            }

            do
            {
                $code = str_random(8);
                $cluster = \App\Cluster::where('cluster_code', $code)->first();
            }
            while(!empty($cluster));

            $cluster_id = \App\Cluster::create([
                'name' => $data['cluster_name'],
                'cluster_code' => $code,
                'setting' => $data['cluster_setting'],
            ])->id;

            $cluster_user_id = \App\ClusterUser::create([
                'cluster_id' => $cluster_id,
                'user_id' => Auth::user()->id,
                'isApproved' => 1,
            ])->id;

            $actions = \App\Action::all();

            foreach ($actions as $action) {
                if(array_key_exists(str_replace(" ", "_", $action->name), $data)){
                    \App\ActionClusterUser::create([
                        'action_id' => $action->id,
                        'cluster_user_id' => $cluster_user_id,
                    ]);
                }
            }

            return redirect('/clusters');
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Join a cluster.
     *
     * @return \Illuminate\Http\Response
     */
    public function joinCluster(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();

            $validator = Validator::make($data, [
                'cluster_code' => 'required|max:8|exists:clusters,cluster_code',
            ]);

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }


            $data["cluster_code"] = \App\Cluster::where("cluster_code", $data["cluster_code"])->first()->id;

            $messages = [
                'unique' => 'You have already requested to be in this group',
            ];

            $validator = Validator::make($data, [
                'cluster_code' => 'unique:cluster_users,cluster_id,NULL,NULL,user_id,' . Auth::user()->id,
            ], $messages);

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            \App\ClusterUser::create([
                'cluster_id' => $data["cluster_code"],
                'user_id' => Auth::user()->id,
                'isApproved' => 0,
            ]);

            return redirect('/clusters');
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Display specific cluster page.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCluster($cluster_id)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $cluster_id,
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            $branch = Auth::user()->branch;
            $cluster = \App\Cluster::find($cluster_id);

            $user = $cluster->users->where("id", Auth::user()->id)->first();

            if($user == null) return redirect('/home');

            if($user->pivot->isApproved == 0) return redirect('/clusters');


            $cluster_users = $cluster->users;

            $clients = $cluster->clients()->where(["branch_id" => $branch->id, "isDummy" => Auth::user()->dummy_mode])->get();

            $actions = \App\Action::all();
            $genders = \App\Gender::all();
            $regions = \App\Region::all();
            $civil_statuses = \App\CivilStatus::all();
            $tags = $branch->tags;


            return view('normaluser.specificcluster')->with("cluster_users", $cluster_users)
                                                        ->with("branch", $branch)
                                                        ->with("cluster_id", $cluster_id)
                                                        ->with("clients", $clients)
                                                        ->with("actions", $actions)
                                                        ->with("allowed_actions", $allowed_actions)
                                                        ->with("genders", $genders)
                                                        ->with("regions", $regions)
                                                        ->with("civil_statuses", $civil_statuses)
                                                        ->with("tags", $tags)
                                                        ->with("setting", $cluster->setting);
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Get Clients given a center.
     *
     * @return JSON
     */
    public function getClientsFromCenter($center_id, $tag_id, Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(6,$activities)){
                if($tag_id == 0){
                    $center = \App\Center::find($center_id);

                    $groups = $center->groups;

                    $clients = array();

                    foreach ($groups as $group) {
                        foreach ($group->clients as $client) {
                            if($client->isDummy == Auth::user()->dummy_mode) array_push($clients, $client);
                        }
                    }
                }
                else{
                    $tag = \App\Tag::find($tag_id);

                    $clients = array();

                    foreach ($tag->clients as $client) {
                        if($client->group->center->id == $center_id){
                            if($client->isDummy == Auth::user()->dummy_mode) array_push($clients, $client);
                        }
                    }
                }
                return json_encode($clients);
            }
        }
    }

    /**
     * Get Clients given a group.
     *
     * @return JSON
     */
    public function getClientsFromGroup($group_id, $tag_id, Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(6,$activities)){
                if($tag_id == 0){
                    $group = \App\Group::find($group_id);

                    $clients = array();

                    foreach ($group->clients as $client) {
                        if($client->isDummy == Auth::user()->dummy_mode) array_push($clients, $client);
                    }
                }
                else{
                    $tag = \App\Tag::find($tag_id);

                    $clients = array();

                    foreach ($tag->clients as $client) {
                        if($client->group->id == $group_id){
                            if($client->isDummy == Auth::user()->dummy_mode) array_push($clients, $client);
                        } 
                    }
                }

                return json_encode($clients);
            }
        }
    }

    /**
     * Get Clients given a id.
     *
     * @return JSON
     */
    public function getClient($client_id, $tag_id, Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(6,$activities)){
                $client = \App\Client::find($client_id);
                $tags = $client->tags->lists('id')->toArray();

                $clients = array();

                if(in_array($tag_id,$tags) || $tag_id == 0) {
                    if($client->isDummy == Auth::user()->dummy_mode) array_push($clients, $client);
                }
                return json_encode($clients);
            }
        }
    }

    /**
     * Add Clients to Cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function addClientToCluster(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();

            $cluster_user = \App\ClusterUser::where(['cluster_id' => $data["cluster_id"],
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(3,$allowed_actions)){


                $clients = json_decode($data["clients"]);

                foreach($clients as $client){
                    $client_cluster = \App\ClientCluster::firstOrCreate(['client_id' => $client, 
                                                                        'cluster_id' => $data["cluster_id"],
                                                                        'branch_id' => Auth::user()->branch->id]);
                }

                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Remove Clients from Cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function removeClientFromCluster(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $data["cluster_id"],
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(3,$allowed_actions)){
                $clients = json_decode($data["clients"]);
                $temp = array();

                foreach($clients as $client){
                    \App\ClientCluster::where(['client_id' => $client,
                                                'cluster_id' => $data["cluster_id"],
                                                'branch_id' => Auth::user()->branch->id])->delete(); 
                    // $client_cluster = \App\ClientCLuster::firstOrCreate(['client_id' => $client, 
                    //                                                     'cluster_id' => $data["cluster_id"],
                    //                                                     'branch_id' => Auth::user()->branch->id]);
                }

                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Get Actions allowed to a user in a cluster.
     *
     * @return JSON
     */
    public function getActions($cluster_user_id, Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(6,$activities)){
                $actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user_id)->lists('action_id')->toArray();
                return json_encode($actions);
            }
        }
    }
    
    /**
     * Edit user's actions in a cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function editClusterUser(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();

            $cluster_user = \App\ClusterUser::find($data["cluster_user_id"]);
            $cluster = \App\Cluster::find($cluster_user->cluster_id);
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $cluster->id,
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(1,$allowed_actions)){
                foreach (\App\Action::all() as $action) {
                    if(array_key_exists(str_replace(" ", "_", $action->name), $data)){
                        \App\ActionClusterUser::firstOrCreate(['action_id' => $action->id, 'cluster_user_id' => $data["cluster_user_id"]]);
                    }
                    else{
                        $action_cluster_user = \App\ActionClusterUser::where([
                                                        ['action_id',$action->id],
                                                        ['cluster_user_id',$data["cluster_user_id"]],
                                                    ])->first();
                        if($action_cluster_user != null) $action_cluster_user->delete();
                    }
                }
                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Delete user from the cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteClusterUser($cluster_user_id, Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $cluster_user = \App\ClusterUser::find($cluster_user_id);
            $cluster = \App\Cluster::find($cluster_user->cluster_id);
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $cluster->id,
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(1,$allowed_actions)){

                $action_cluster_users = \App\ActionClusterUser::where([
                                                        ['cluster_user_id',$cluster_user_id],
                                                    ])->lists('id')->toArray();
                // dd($action_cluster_users);
                \App\ActionClusterUser::destroy($action_cluster_users);

                //delete cluster_user
                $cluster_user = \App\ClusterUser::find($cluster_user_id);
                $cluster_user->delete();

                //delete clients in cluster if there is no users in the cluster that is a member of a branch
                $branch_id = \App\User::find($cluster_user->user_id)->branch_id;
                $cluster = \App\Cluster::find($cluster_user->cluster_id);

                //fix
                if($cluster->users->where("branch_id", $branch_id)->first() == null){
                    $client_clusters = \App\ClientCluster::where([["branch_id", $branch_id], ["cluster_id", $cluster->id]])->lists('id')->toArray();
                    \App\ClientCluster::destroy($client_clusters);
                }

                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Approve user to join the cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function approveClusterUser(Request $request)
    {
        $cluster_id = explode("/", URL::previous());
        $cluster_id = $cluster_id[sizeof($cluster_id)-1];

        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){

            $cluster_user = \App\ClusterUser::where(['cluster_id' => $cluster_id,
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(1,$allowed_actions)){
                $data = $request->all();

                $cluster_user = \App\ClusterUser::find($data["cluster_user_id"]);
                $cluster_user->isApproved = true;

                $cluster_user->save();

                foreach (\App\Action::all() as $action) {
                    if(array_key_exists(str_replace(" ", "_", $action->name), $data)){
                        \App\ActionClusterUser::Create(['action_id' => $action->id, 'cluster_user_id' => $data["cluster_user_id"]]);
                    }
                }
                
                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Disapprove user to join the cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function disapproveClusterUser($cluster_user_id, Request $request)
    {
        $cluster_id = explode("/", URL::previous());
        $cluster_id = $cluster_id[sizeof($cluster_id)-1];

        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $cluster_id,
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(1,$allowed_actions)){
                $cluster_user = \App\ClusterUser::where([
                                                        ['id',$cluster_user_id],
                                                        ['isApproved',0],
                                                    ])->first();
                $cluster_user->delete();
                
                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * search user in cluster.
     *
     * @return JSON
     */
    public function searchClientCluster(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(6,$activities)){
                $data = $request->all();

                $cluster_user = \App\ClusterUser::where(['cluster_id' => $data["cluster_id"],
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

                if($cluster_user == null) return redirect("/clusters");

                $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();
                if(in_array(2,$allowed_actions)){
                    $parameters = [];

                    array_push($parameters, ['first_name', $data["first_name"]]);
                    array_push($parameters, ['last_name', $data["last_name"]]);
                    array_push($parameters, ['isDummy', Auth::user()->dummy_mode]);
                    if($data["middle_name"] != "") array_push($parameters, ['middle_name', $data["middle_name"]]);
                    if($data["birthplace"] != "") array_push($parameters, ['birthplace', $data["birthplace"]]);
                    if($data["birthdate"] != "") array_push($parameters, ['birthdate', $data["birthdate"]]);

                    $cluster = \App\Cluster::find($data["cluster_id"]);
                    $clients["setting"] = $data["cluster_setting"];
                    switch($data["cluster_setting"]){
                        case 1: $clients["data"] = ($cluster->clients()->where($parameters)->count() > 0) ? true : false;
                            break;
                        case 2: $temp = array();
                            foreach ($cluster->clients()->where($parameters)->get() as $client) {
                                if(!array_key_exists ( $client->group->center->branch->company->id , $temp )){
                                    $temp[$client->group->center->branch->company->id]["count"] = 0;
                                    $temp[$client->group->center->branch->company->id]["name"] = $client->group->center->branch->company->name;
                                } 
                                $temp[$client->group->center->branch->company->id]["count"] = $temp[$client->group->center->branch->company->id]["count"] + $client->loans()->count();
                            }
                            $clients["data"] = $temp;
                            break;
                        case 3: $temp = array();
                            foreach ($cluster->clients()->where($parameters)->get() as $client) {
                                if(!array_key_exists ( $client->group->center->branch->company->name , $temp )) $temp[$client->group->center->branch->company->name] = array();
                                $loans = $client->loans()->get()->toArray();
                                foreach ($loans as $loan) {
                                    $loan["loan_type_id"] = \App\LoanType::find($loan["loan_type_id"])->name;
                                    $temp[$client->group->center->branch->company->name][] = $loan;
                                }
                                // $temp[$client->group->center->branch->company->name] = $temp[$client->group->center->branch->company->name] + $loans;
                            }
                            $clients["data"] = $temp;
                            break;
                        case 4: $temp = array();
                            foreach ($cluster->clients()->where($parameters)->get() as $client) {
                                $name = $client->group->center->branch->company->name;
                                if(!array_key_exists ( $name , $temp )) $temp[$name] = array();
                                foreach ($client->loans()->get() as $loan) {
                                    if(!array_key_exists ( $loan->id , $temp[$name] )) $temp[$name][$loan->id] = array();
                                    $temp[$name][$loan->id] = $loan;
                                    // array_push($temp[$client->group->center->branch->company->name], $loan);
                                    $temp[$name][$loan->id]["transactions"] = $loan->transactions->toArray();
                                }
                                // $temp[$client->group->center->branch->company->name] = $temp[$client->group->center->branch->company->name] + $client->loans()->get()->toArray();
                                // $temp[$client->group->center->branch->company->name]["transactions"] = 
                            }
                            $clients["data"] = $temp;
                            break;
                        // $temp
                    }
                    // $clients = $cluster->clients()->where($parameters)->get();

                    return json_encode($clients);
                }
            }
        }
    }

    /**
     * Add user to cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();
            $cluster_user = \App\ClusterUser::where(['cluster_id' => $data["cluster_id"],
                                            'user_id' => Auth::user()->id,
                                            'isApproved' => 1])->first();

            if($cluster_user == null) return redirect("/clusters");

            $allowed_actions = \App\ActionClusterUser::where('cluster_user_id', $cluster_user->id)->lists('action_id')->toArray();

            if(in_array(1,$allowed_actions)){
                $validator = Validator::make($data, [
                    'username' => 'required|max:255|exists:users,username,isApproved,1,branch_id,!NULL',
                ]);

                if ($validator->fails()) {
                    $this->throwValidationException(
                        $request, $validator
                    );
                }

                $user = \App\User::where("username", $data["username"])->first();
                $new_cluster_user = \App\ClusterUser::where(['user_id' => $user->id, 
                                                                        'cluster_id' => $data["cluster_id"],
                                                                        'isApproved' => 1])->first();

                if($new_cluster_user != null){ 
                    $request->session()->flash('cluster_user_exists', true);
                    return redirect(URL::previous());
                }

                $new_cluster_user = \App\ClusterUser::Create(['user_id' => $user->id, 
                                                                        'cluster_id' => $data["cluster_id"],
                                                                        'isApproved' => 1]);

                foreach (\App\Action::all() as $action) {
                    if(array_key_exists(str_replace(" ", "_", $action->name), $data)){
                        \App\ActionClusterUser::Create(['action_id' => $action->id, 'cluster_user_id' => $new_cluster_user->id]);
                    }
                }
                
                return redirect(URL::previous());
            }
            else{
                return redirect("/home");
            }
        }
        else{
            return redirect("/home");
        }
    }

    /**
     * Leave a Cluster.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaveCluster(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(6,$activities)){
            $data = $request->all();

            $cluster_user = \App\ClusterUser::where(['user_id' => Auth::user()->id, 
                                                                        'cluster_id' => $data["cluster_id"]])->first();
            $action_cluster_users = \App\ActionClusterUser::where([
                                                    ['cluster_user_id',$cluster_user->id],
                                                ])->lists('id')->toArray();
            // dd($action_cluster_users);
            \App\ActionClusterUser::destroy($action_cluster_users);

            //delete cluster_user
            $cluster_user->delete();

            //delete clients in cluster if there is no users in the cluster that is a member of a branch
            $branch_id = \App\User::find($cluster_user->user_id)->branch_id;
            $cluster = \App\Cluster::find($cluster_user->cluster_id);

            //fix
            if($cluster->users->where("branch_id", $branch_id)->first() == null){
                $client_clusters = \App\ClientCluster::where([["branch_id", $branch_id], ["cluster_id", $cluster->id]])->lists('id')->toArray();
                \App\ClientCluster::destroy($client_clusters);
            }

            return redirect(URL::previous());
        }
        else{
            return redirect("/home");
        }
    }
}
