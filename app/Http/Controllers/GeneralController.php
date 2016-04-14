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
        $regions = \App\Region::all();

        return view('normaluser.structure')->with('branch', $branch)
                                            ->with('regions', $regions);
    }

    /**
     * Get Province for the Region.
     *
     * @return JSON
     */
    public function getProvinces($region_id, Request $request)
    {
        //if($request->ajax()){
            $region = \App\Region::find($region_id);
            $provinces = $region->provinces;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $provinces->toJson();
        //}
    }

    /**
     * Get Municipalities for the Province.
     *
     * @return JSON
     */
    public function getMunicipalities($province_id, Request $request)
    {
        //if($request->ajax()){
            $province = \App\Province::find($province_id);
            $municipalities = $province->municipalities;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $municipalities->toJson();
        //}
    }

    /**
     * Get Barangays for the Municipality.
     *
     * @return JSON
     */
    public function getBarangays($municipality_id, Request $request)
    {
        //if($request->ajax()){
            $municipality = \App\Municipality::find($municipality_id);
            $barangays = $municipality->barangays;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $barangays->toJson();
        //}
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

            $center = \App\Center::create([
                'branch_id' => $data['branch_id'],
                'name' => $data['center_name'],
            ]);
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return response()->json($center);
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

            $group = \App\Group::create([
                'center_id' => $data['center_id'],
                'name' => $data['group_name'],
            ]);
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return response()->json($group);
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

    /**
     * Add a client to the group.
     *
     * @return JSON
     */
    public function addClient(Request $request)
    {
        //if($request->ajax()){

            $data = $request->all();

            $group = \App\Group::create([
                'center_id' => $data['center_id'],
                'name' => $data['group_name'],
            ]);
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return response()->json($group);
        //}
    }

    /**
     * Display upload page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUpload()
    {
        $branch = Auth::user()->branch;

        return view('normaluser.upload')->with("branch", $branch);
    }


    /**
     * Upload Clients CSV file for validation
     *
     * @return \Illuminate\Http\Response
     */
    public function clientsCSV(Request $request)
    {
        $data = $request->all();

        // $handle = fopen($data["fileToUpload"], "r");
        // while ($userinfo = fscanf($handle, "%s\t%s\t%s\n")) {
        //     list ($name, $profession, $countrycode) = $userinfo;
        //     //... do something with the values
        // }
        // fclose($handle);

        $handle = fopen($data["fileToUpload"], "r");
        $approved;
        $disapproved;

        $row = 0;
        if (($handle = fopen($data["fileToUpload"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
                if($row < 2) {
                    $row++;
                    continue;
                }
                array_walk_recursive($data, function(&$value, $key) {
                    if (is_string($value)) {
                        $value = iconv('windows-1252', 'utf-8', $value);
                    }
                });
                // $num = count($data);
                // for ($c=0; $c < $num; $c++) {
                //     echo $data[$c] . "<br />\n";
                // }

                // if(\App\Client::where('uploaded_id', 'like', $data[1]) != null){
                //     $row++;
                //     $disapproved++;
                //     continue;
                // }
                // $approved++;

                $client[$row] = array_slice($data, 1, 18);
                $client[$row][] = "reserved";
                // $whole[$row]["loan"] = array_slice($data, 18, 10);

                // $client = array_slice($data, 1, 17);
                // $loan = array_slice($data, 18, 10);
                // $transactions = [];

                // for ($c=28; $c < $num; $c++) {
                //     $transactions[($c-28)/4][($c-28)%4] = $data[$c];
                // }

                // $whole[$row]["transaction"] = $transactions;

                // echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;

                // print_r(json_encode($client));
                // echo "<br /><br />";
                // print_r($loan);
                // echo "<br /><br />";
                // print_r($transactions);
                // echo "<br /><br />";
            }
            fclose($handle);
        }
        return response()->json($client);
    }

    /**
     * Save Clients CSV data to database
     *
     * @return \Illuminate\Http\Response
     */
    public function approveClientsCSV(Request $request)
    {
        $data = $request->all();

        $clients = json_decode($data["clients"]);

        $branch_id = Auth::user()->branch->id;

        // dd($clients);

        foreach($clients as $client){
            // echo date("Y-m-d", strtotime($client[5])) . "<br />";
            $center = \App\Center::firstOrCreate(['branch_id' => $branch_id, 'name' => $client[16]]);
            $group = \App\Group::firstOrCreate(['center_id' => $center->id, 'name' => $client[14]]);

            $client_detail = \App\Client::where('uploaded_id', $client[0])->first();
            if($client_detail == null){
                $client_detail = new \App\Client;
            }

            $client_detail->uploaded_id = $client[0];
            $client_detail->last_name = $client[2];
            $client_detail->first_name = $client[3];
            $client_detail->middle_name = $client[4];
            $client_detail->birthdate = date("Y-m-d", strtotime($client[5]));
            $client_detail->birthplace = $client[6];
            $client_detail->gender_id = $client[7];
            $client_detail->civil_status_id = $client[8];
            $client_detail->personal_id = $client[9];
            $client_detail->house_address = $client[10];
            $client_detail->group_id = $group->id;
            $client_detail->mobile_number = "0";
            $client_detail->isDummy = Auth::user()->dummy_mode;

            $client_detail->save();

            // $client_detail = \App\Client::firstOrCreate(['uploaded_id' => $client[0],
            //                                              'last_name' => $client[2],
            //                                              'first_name' => $client[3],
            //                                              'middle_name' => $client[4],
            //                                              'birthdate' => date("Y-m-d", strtotime($client[5])),
            //                                              'birthplace' => $client[6],
            //                                              'gender_id' => $client[7],
            //                                              'civil_status_id' => $client[8],
            //                                              'personal_id' => $client[9],
            //                                              'house_adress' => $client[10],   
            //                                              'group_id' => $group->id,
            //                                              'mobile_number' => "0",
            //                                              'isDummy' => Auth::user()->dummy_mode
            //                                              ]);
        }

        dd("finished");
    }
}