<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\URL;

class ClusterController extends Controller
{
    /**
     * Display cluster page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCluster()
    {
        $approved = Auth::user()->clusters()->where("isApproved", true)->get();
        $pending = Auth::user()->clusters()->where("isApproved", false)->get();
        $actions = \App\Action::all();

        return view('normaluser.cluster')->with('approved', $approved)
                            ->with('pending', $pending)
                            ->with('actions', $actions);
    }

    /**
     * Add a cluster for the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCluster(Request $request)
    {
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

    /**
     * Join a cluster.
     *
     * @return \Illuminate\Http\Response
     */
    public function joinCluster(Request $request)
    {
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

    /**
     * Display specific cluster page.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCluster($cluster_id)
    {
        $branch = Auth::user()->branch;
        $cluster = \App\Cluster::find($cluster_id);

        $user = $cluster->users->where("id", Auth::user()->id)->first();

        if($user == null) return redirect('/home');

        if($user->pivot->isApproved == 0) return redirect('/clusters');

        $cluster_users = $cluster->users;

        $clients = $cluster->clients()->where("branch_id", $branch->id)->get();

        return view('normaluser.specificcluster')->with("cluster_users", $cluster_users)
                                                    ->with("branch", $branch)
                                                    ->with("cluster_id", $cluster_id)
                                                    ->with("clients", $clients);

    }

    /**
     * Get Clients given a center.
     *
     * @return JSON
     */
    public function getClientsFromCenter($center_id)
    {
        //if($request->ajax()){
            $center = \App\Center::find($center_id);

            $groups = $center->groups;

            $clients = array();

            foreach ($groups as $group) {
                foreach ($group->clients as $client) {
                    array_push($clients, $client);
                }
            }
            return json_encode($clients);
        //}
    }

    /**
     * Get Clients given a id.
     *
     * @return JSON
     */
    public function getClient($client_id)
    {
        //if($request->ajax()){
            $clients = array();

            array_push($clients, \App\Client::find($client_id));
            return json_encode($clients);
        //}
    }

    /**
     * Add Clients to Cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function addClientToCluster(Request $request)
    {
        $data = $request->all();
        $clients = json_decode($data["clients"]);

        foreach($clients as $client){
            $client_cluster = \App\ClientCLuster::firstOrCreate(['client_id' => $client, 
                                                                'cluster_id' => $data["cluster_id"],
                                                                'branch_id' => Auth::user()->branch->id]);
        }


        return redirect(URL::previous());
    }

    /**
     * Remove Clients from Cluster
     *
     * @return \Illuminate\Http\Response
     */
    public function removeClientFromCluster(Request $request)
    {
        $data = $request->all();
        $clients = json_decode($data["clients"]);
        $temp = array();

        foreach($clients as $client){
            \App\ClientCLuster::where(['client_id' => $client,
                                        'cluster_id' => $data["cluster_id"],
                                        'branch_id' => Auth::user()->branch->id])->delete(); 
            // $client_cluster = \App\ClientCLuster::firstOrCreate(['client_id' => $client, 
            //                                                     'cluster_id' => $data["cluster_id"],
            //                                                     'branch_id' => Auth::user()->branch->id]);
        }

        return redirect(URL::previous());
    }
    
}
