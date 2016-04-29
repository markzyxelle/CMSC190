<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        $genders = \App\Gender::all();
        $client_statuses = \App\ClientStatus::all();
        $civil_statuses = \App\CivilStatus::all();
        $beneficiary_types = \App\BeneficiaryType::all();

        // dd(\App\CompanyRole::find(9));
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        // dd(in_array(1,$activities));
        // foreach ($activities as $activity) {
        //     dd($activity);
        // }

        // dd(Auth::user()->companyrole()->activities);

        return view('normaluser.structure')->with('branch', $branch)
                                            ->with('regions', $regions)
                                            ->with('genders', $genders)
                                            ->with('client_statuses', $client_statuses)
                                            ->with('civil_statuses', $civil_statuses)
                                            ->with('beneficiary_types', $beneficiary_types)
                                            ->with('activities', $activities);
    }

    /**
     * Get Province for the Region.
     *
     * @return JSON
     */
    public function getProvinces($region_id, Request $request)
    {
        if($request->ajax()){
            $region = \App\Region::find($region_id);
            $provinces = $region->provinces;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $provinces->toJson();
        }
    }

    /**
     * Get Municipalities for the Province.
     *
     * @return JSON
     */
    public function getMunicipalities($province_id, Request $request)
    {
        if($request->ajax()){
            $province = \App\Province::find($province_id);
            $municipalities = $province->municipalities;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $municipalities->toJson();
        }
    }

    /**
     * Get Barangays for the Municipality.
     *
     * @return JSON
     */
    public function getBarangays($municipality_id, Request $request)
    {
        if($request->ajax()){
            $municipality = \App\Municipality::find($municipality_id);
            $barangays = $municipality->barangays;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $barangays->toJson();
        }
    }

    /**
     * Get Centers for the Branch.
     *
     * @return JSON
     */
    public function getCenters($branch_id, Request $request)
    {
        if($request->ajax()){
            $branch = \App\Branch::find($branch_id);
            $centers = $branch->centers;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $centers->toJson();
        }
    }

    /**
     * Add a center to the branch.
     *
     * @return JSON
     */
    public function addCenter(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(1,$activities)){
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
            }
        }
    }

    /**
     * Get Groups for the Center.
     *
     * @return JSON
     */
    public function getGroups($center_id, Request $request)
    {
        if($request->ajax()){
            //put if to check if they own the center
            $center = \App\Center::find($center_id);
            $groups = $center->groups;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $groups->toJson();
        }
    }

    /**
     * Add a group to the center.
     *
     * @return JSON
     */
    public function addGroup(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(1,$activities)){
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
            }
        }
    }

    /**
     * Get Clients for the Group.
     *
     * @return JSON
     */
    public function getClients($group_id, Request $request)
    {
        if($request->ajax()){
            $group = \App\Group::find($group_id);
            $clients = $group->clients()->where("isDummy", Auth::user()->dummy_mode)->get();
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $clients->toJson();
        }
    }

    /**
     * Add a client to the group.
     *
     * @return JSON
     */
    public function addClient(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(2,$activities)){

                $data = $request->all();

                $client = new \App\Client;

                $client->group_id = $data['group_id'];
                $client->barangay_id = (($data['barangay_id'] != "") ? $data['barangay_id'] : NULL);
                $client->status_id = $data['status_id'];
                $client->gender_id = $data['gender_id'];
                $client->civil_status_id = $data['civil_status_id'];
                $client->beneficiary_type_id = $data['beneficiary_type_id'];
                $client->birthplace = $data['birthplace'];
                $client->first_name = $data['first_name'];
                $client->middle_name = $data['middle_name'];
                $client->last_name = $data['last_name'];
                $client->mother_middle_name = $data['mother_maiden_last_name'];
                $client->suffix = $data['suffix_name'];
                $client->birthdate = (strtotime($data['birthdate']) ? date("Y-m-d", strtotime($data['birthdate'])) : strtotime("00/00/0000"));
                $client->house_address = $data['house_address'];
                $client->mobile_number = $data['mobile_number'];
                $client->cutoff_date = $data['cutoff_date'];

                $client->save();

                // $client = \App\Client::create([
                //     'barangay_id' => $data['barangay_id'],
                //     'group_id' => $data['group_id'],
                //     'status_id' => $data['status_id'],
                //     'gender_id' => $data['gender_id'],
                //     'civil_status_id' => $data['civil_status_id'],
                //     'beneficiary_type_id' => $data['beneficiary_type_id'],
                //     'barangay_id' => $data['barangay_id'],
                //     'birthplace' => $data['birthplace'],
                //     'first_name' => $data['first_name'],
                //     'middle_name' => $data['middle_name'],
                //     'last_name' => $data['last_name'],
                //     'mother_middle_name' => $data['mother_maiden_last_name'],
                //     'birthdate' => ($data['birthdate'] != "" ? date("Y-m-d", strtotime($data['birthdate'])) : date("Y-m-d", strtotime("00/00/0000"))),
                //     'house_address' => $data['house_address'],
                //     'mobile_number' => (($data['mobile_number'] != "") ? $data['mobile_number'] : 0),
                //     'cutoff_date' => date("Y-m-d", strtotime($data['cutoff_date'])),
                //     'isDummy' => Auth::user()->dummy_mode,
                // ]);

                // $client = \App\Client::create([
                //     'client_id' => $data['client_id'],
                //     'loan_type_id' => $loan_type->id,
                //     'loan_cycle' => $data['cycle_number'],
                //     'released_date' => date("Y-m-d", strtotime($data['release_date'])),
                //     'principal_amount' => $data['principal_amount_loan'],
                //     'interest_amount' => $data['interest_amount_loan'],
                //     'principal_balance' => $data['principal_balance'],
                //     'interest_balance' => $data['interest_balance'],
                //     'isActive' => $data['isActive'],
                //     'isReleased' => $data['isReleased'],
                //     'status' => $data['status'],
                //     'maturity_date' => date("Y-m-d", strtotime($data['maturity_date'])),
                //     'cutoff_date' => date("Y-m-d", strtotime($data['cutoff_date_loan'])),
                // ]);
                // $approved = Auth::user()->company->users->where('isApproved', 1);
                // $pending = Auth::user()->company->users->where('isApproved', 0);
                // return view('users')->with('code', $code)
                //                     ->with('approved', $approved)
                //                     ->with('pending', $pending);

                return response()->json($client);
            }
        }
    }

    /**
     * Display upload page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUpload()
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(7,$activities)){
            $branch = Auth::user()->branch;

            return view('normaluser.upload')->with("branch", $branch);
        }
        else{
            return redirect("/home");
        }
    }


    /**
     * Upload Clients CSV file for validation
     *
     * @return \Illuminate\Http\Response
     */
    public function clientsCSV(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(7,$activities)){
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
                        if($row == 0){
                            if(strtotime($data[0])){
                                $client[$row][] = $data[0];
                            }  
                            else{
                                $client[$row][] = "Cutoff Date has a wrong format";
                                break;
                            }
                            if(strtolower($data[1]) != strtolower(Auth::user()->branch->name)){
                                $client[$row][] = "Branch name in file did not match branch name in the site";
                                break;
                            } 
                            if(strtolower($data[2]) != strtolower(Auth::user()->branch->company->name)){
                                $client[$row][] = "Company name in file did not match company name in the site";
                                break;
                            }
                        }
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

                        $client[$row][] = is_numeric($data[1]) ? true : false;
                        $client[$row][] = $data[1];
                        $client[$row][] = strlen($data[2]) > 255 ? false : true;
                        $client[$row][] = $data[2];
                        $client[$row][] = strlen($data[3]) > 255 ? false : true;
                        $client[$row][] = $data[3];
                        $client[$row][] = strlen($data[4]) > 255 ? false : true;
                        $client[$row][] = $data[4];
                        $client[$row][] = (strtotime($data[5]) || $data[5] == "") ? true : false;       //change
                        $client[$row][] = $data[5];
                        $client[$row][] = strlen($data[6]) > 255 ? false : true;
                        $client[$row][] = $data[6];
                        $client[$row][] = $data[7] > 2 ? false : true;
                        $client[$row][] = $data[7];
                        $client[$row][] = $data[8] > 4 ? false : true;
                        $client[$row][] = $data[8];
                        $client[$row][] = strlen($data[9]) > 255 ? false : true;
                        $client[$row][] = $data[9];
                        // $client[$row][] = (\App\Barangay::find($data[10]) != null || $data[10] == "-1") ? true : false;
                        $client[$row][] = is_numeric($data[10]) ? true : false;     //change
                        $client[$row][] = $data[10];//19
                        $client[$row][] = (strlen($data[11]) > 255 || $data[11] == "") ? false : true;
                        $client[$row][] = $data[11];
                        $client[$row][] = (strlen($data[12]) > 255 || $data[12] == "") ? false : true;
                        $client[$row][] = $data[12];
                        $client[$row][] = $data[13] > 3 ? false : true;     //change
                        $client[$row][] = $data[13];
                        $client[$row][] = $data[14] > 3 ? false : true;     //change
                        $client[$row][] = $data[14];
                        $client[$row][] = in_array(false, $client[$row], true) ? false : true;
                        $current_client = \App\Client::where("uploaded_id", $data[1])->first();
                        if($current_client == null){
                            $client[$row][] = true;
                        }
                        else{
                            $client[$row][] = (strtotime($current_client->cutoff_date) > strtotime($client[0][0])) ? false : true;
                        }

                        // $client[$row] = array_slice($data, 1, 18);
                        // $client[$row][] = "reserved";
                       

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
        }
    }

    /**
     * Save Clients CSV data to database
     *
     * @return \Illuminate\Http\Response
     */
    public function approveClientsCSV(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(7,$activities)){
            set_time_limit(0);
            $data = $request->all();

            $clients = json_decode($data["clients"]);

            $branch_id = Auth::user()->branch->id;

            // dd($clients);

            foreach($clients as $client){
                // echo date("Y-m-d", strtotime($client[5])) . "<br />";
                if(sizeof($client) == 1){
                    $cutoff_date = $client[0];
                    continue;
                } 
                if($client[28] == false || $client[29] == false) continue;

                $center = \App\Center::firstOrCreate(['branch_id' => $branch_id, 'name' => $client[23]]);
                $group = \App\Group::firstOrCreate(['center_id' => $center->id, 'name' => $client[21]]);

                $client_detail = \App\Client::where('uploaded_id', $client[1])->first();
                if($client_detail == null){
                    $client_detail = new \App\Client;
                }

                $client_detail->uploaded_id = $client[1];
                $client_detail->last_name = $client[3];
                $client_detail->first_name = $client[5];
                $client_detail->middle_name = $client[7];
                if($client[9] != "") $client_detail->birthdate = date("Y-m-d", strtotime($client[9]));
                // else $client_detail->birthdate = date("Y-m-d", strtotime("0000-00-00"));
                else $client_detail->birthdate = NULL;
                $client_detail->birthplace = $client[11];
                if($client[13] < 1) $client_detail->gender_id = 3;
                else $client_detail->gender_id = $client[13];
                if($client[15] < 1) $client_detail->civil_status_id = 5;
                else $client_detail->civil_status_id = $client[15];
                $client_detail->house_address = $client[17];
                $barangay = \App\Barangay::find($client[19]);
                if($barangay != null) $client_detail->barangay_id = $barangay->id;
                $client_detail->group_id = $group->id;
                $client_detail->beneficiary_type_id = $client[25];
                $client_detail->status_id = $client[27];
                $client_detail->mobile_number = "0";
                $client_detail->cutoff_date = date("Y-m-d", strtotime($cutoff_date));
                $client_detail->isDummy = Auth::user()->dummy_mode;
                //barangay_id,status_id,beneficiary_type_id
                //missing:suffix,mother_middle_name,mobile_number,cutoff_date
                //client_history
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
            return redirect("/upload");
        }
    }

    /**
     * Upload Loans CSV file for validation
     *
     * @return \Illuminate\Http\Response
     */
    public function loansCSV(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(7,$activities)){
                $data = $request->all();

                // // $handle = fopen($data["fileToUpload"], "r");
                // // while ($userinfo = fscanf($handle, "%s\t%s\t%s\n")) {
                // //     list ($name, $profession, $countrycode) = $userinfo;
                // //     //... do something with the values
                // // }
                // // fclose($handle);

                // $handle = fopen($data["fileToUpload"], "r");
                // $approved;
                // $disapproved;

                $row = 0;
                if (($handle = fopen($data["fileToUpload"], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
                        if($row == 0){
                            if(strtotime($data[0])){
                                $loan[$row][] = $data[0];
                            }  
                            else{
                                $loan[$row][] = "Cutoff Date has a wrong format";
                                break;
                            }
                            if(strtolower($data[1]) != strtolower(Auth::user()->branch->name)){
                                $loan[$row][] = "Branch name in file did not match branch name in the site";
                                break;
                            } 
                            if(strtolower($data[2]) != strtolower(Auth::user()->branch->company->name)){
                                $loan[$row][] = "Company name in file did not match company name in the site";
                                break;
                            }
                        }
                        if($row < 2) {
                            $row++;
                            continue;
                        }

                        array_walk_recursive($data, function(&$value, $key) {
                            if (is_string($value)) {
                                $value = iconv('windows-1252', 'utf-8', $value);
                            }
                        });

                        if(is_numeric($data[1])){
                            $client = \App\Client::where("uploaded_id", $data[1])->first();
                            $loan[$row]["loan"][] = ($client != null) ? true : false;
                            $loan[$row]["loan"][] = $data[1];
                        }
                        else{
                            $loan[$row]["loan"][] = false;
                            $loan[$row]["loan"][] = $data[1];
                        }
                        $loan[$row]["loan"][] = is_numeric($data[2]) ? true : false;
                        $loan[$row]["loan"][] = $data[2];
                        $loan[$row]["loan"][] = strlen($data[3]) > 255 ? false : true;
                        $loan[$row]["loan"][] = $data[3];
                        $loan[$row]["loan"][] = is_numeric($data[4]) ? true : false;
                        $loan[$row]["loan"][] = $data[4];
                        $loan[$row]["loan"][] = (strtotime($data[5]) || $data[5] == "") ? true : false;
                        $loan[$row]["loan"][] = $data[5];
                        $loan[$row]["loan"][] = is_numeric($data[6]) ? true : false;
                        $loan[$row]["loan"][] = $data[6];
                        $loan[$row]["loan"][] = is_numeric($data[7]) ? true : false;
                        $loan[$row]["loan"][] = $data[7];
                        $loan[$row]["loan"][] = is_numeric($data[8]) ? true : false;
                        $loan[$row]["loan"][] = $data[8];
                        $loan[$row]["loan"][] = is_numeric($data[9]) ? true : false;
                        $loan[$row]["loan"][] = $data[9];
                        $loan[$row]["loan"][] = ($data[10] == "true" || $data[10] == "false" || $data[10] == "True" || $data[10] == "False") ? true : false;
                        $loan[$row]["loan"][] = $data[10];
                        $loan[$row]["loan"][] = ($data[11] == "true" || $data[11] == "false" || $data[11] == "True" || $data[11] == "False") ? true : false;
                        $loan[$row]["loan"][] = $data[11];
                        $loan[$row]["loan"][] = strlen($data[12]) > 255 ? false : true;
                        $loan[$row]["loan"][] = $data[12];
                        $loan[$row]["loan"][] = (strtotime($data[13]) || $data[13] == "") ? true : false;
                        $loan[$row]["loan"][] = $data[13];
                        $loan[$row]["loan"][] = in_array(false, $loan[$row]["loan"], true) ? false : true;
                        $current_loan = \App\Loan::where("uploaded_id", $data[2])->first();
                        if($current_loan == null){
                            $loan[$row]["loan"][] = true;
                        }
                        else{
                            $loan[$row]["loan"][] = (strtotime($current_loan->cutoff_date) > strtotime($loan[0][0])) ? false : true;
                        }


                        $temp = array_slice($data, 14);
                        $temp = array_filter($temp, create_function('$a','return $a!=="";'));

                        $transactions = [];

                        $num = count($temp);

                        for ($c=0; $c < $num; $c+=5) {
                            $transactions[$c/5][0] = is_numeric($temp[$c]) ? true : false;
                            $transactions[$c/5][1] = $temp[$c];
                            $transactions[$c/5][2] = is_numeric($temp[$c+1]) ? true : false;
                            $transactions[$c/5][3] = $temp[$c+1];
                            $transactions[$c/5][4] = is_numeric($temp[$c+2]) ? true : false;
                            $transactions[$c/5][5] = $temp[$c+2];
                            $transactions[$c/5][6] = strtotime($temp[$c+3]) ? true : false;
                            $transactions[$c/5][7] = $temp[$c+3];
                            $transactions[$c/5][8] = strtotime($temp[$c+4]) ? true : false;
                            $transactions[$c/5][9] = $temp[$c+4];
                            $transactions[$c/5][10] = (!(in_array(false, $transactions[$c/5], true)) && $loan[$row]["loan"][26]) ? true : false;
                            $current_transaction = \App\Transaction::where("uploaded_id", $temp[$c])->first();
                            if($current_transaction == null){
                                $transactions[$c/5][11] = true;
                            }
                            else{
                                $transactions[$c/5][11] = (strtotime($current_transaction->cutoff_date) > strtotime($loan[0][0])) ? false : true;
                            }
                        }

                        $loan[$row]["transactions"] = $transactions;

                        // $data = array_slice($data, 1, 13);
                        

                        // array_walk_recursive($data, function(&$value, $key) {
                        //     if (is_string($value)) {
                        //         $value = iconv('windows-1252', 'utf-8', $value);
                        //     }
                        // });
                        // // $num = count($data);
                        // // for ($c=0; $c < $num; $c++) {
                        // //     echo $data[$c] . "<br />\n";
                        // // }

                        // // if(\App\Client::where('uploaded_id', 'like', $data[1]) != null){
                        // //     $row++;
                        // //     $disapproved++;
                        // //     continue;
                        // // }
                        // // $approved++;

                        // $loan[$row]["loan"] = $data;
                        // $loan[$row]["loan"][] = "reserved";
                        // // $whole[$row]["loan"] = array_slice($data, 18, 10);

                        // // $client = array_slice($data, 1, 17);
                        // // $loan = array_slice($data, 18, 10);
                        // $transactions = [];

                        // $num = count($temp);

                        // for ($c=0; $c < $num; $c++) {
                        //     $transactions[$c/5][$c%5] = $temp[$c];
                        // }

                        // $loan[$row]["transactions"] = $transactions;

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
                return response()->json($loan);
            }
        }
    }

    /**
     * Save Loans CSV data to database
     *
     * @return \Illuminate\Http\Response
     */
    public function approveLoansCSV(Request $request)
    {
        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        if(in_array(7,$activities)){
            $loantemp = 0;
            $trantemp = 0;
            set_time_limit(0);
            $data = $request->all();

            $loans = json_decode($data["loans"], true);

            foreach ($loans as $loan) {
                if(sizeof($loan) == 1){
                    $cutoff_date = $loan[0];                    
                    continue;
                }
                $client = \App\Client::where('uploaded_id', $loan["loan"][1])->first();
                if($client == NULL) continue;
                $loan_detail = \App\Loan::where('uploaded_id', $loan["loan"][3])->first(); 
                if(!($loan["loan"][26] == false || $loan["loan"][27] == false)){
            
                    if($loan_detail == null){
                        $loan_detail = new \App\Loan;
                    }
                    $loan_detail->client_id = $client->id;
                    $loan_type = \App\LoanType::firstOrCreate(['name' => $loan["loan"][5]]);
                    $loan_detail->loan_type_id = $loan_type->id;
                    $loan_detail->loan_cycle = $loan["loan"][7];
                    if($loan["loan"][9] != "") $loan_detail->released_date = date("Y-m-d", strtotime($loan["loan"][9]));
                    else $loan_detail->released_date = null;

                    $loan_detail->principal_amount = $loan["loan"][11];
                    $loan_detail->interest_amount = $loan["loan"][13];
                    $loan_detail->principal_balance = $loan["loan"][15];
                    $loan_detail->interest_balance = $loan["loan"][17];
                    $loan_detail->isActive = ($loan["loan"][19] == "True" || $loan["loan"][19] == "true") ? true : false;
                    $loan_detail->isReleased = ($loan["loan"][21] == "True" || $loan["loan"][21] == "true") ? true : false;
                    $loan_detail->status = $loan["loan"][23];
                    $loan_detail->uploaded_id = $loan["loan"][3];
                    if($loan["loan"][25] != "") $loan_detail->maturity_date = date("Y-m-d", strtotime($loan["loan"][12]));
                    else $loan_detail->maturity_date = null;
                    $loan_detail->cutoff_date = date("Y-m-d", strtotime($cutoff_date));
                    dd($loan_detail);
                    //loan_history,client_history
                    $loan_detail->save();
                    $loantemp++;
                }

                if($loan_detail != null){
                    foreach ($loan["transactions"] as $transaction) {           //change here for uploaded id
                        if(!($transaction[10] == false || $transaction[11] == false)){
                            $transaction_detail = \App\Transaction::where('uploaded_id', $transaction[1])->first();
                            if($transaction_detail == null){
                                $transaction_detail = new \App\Transaction;
                            }
                            
                            $transaction_detail->loan_id = $loan_detail->id;
                            $transaction_detail->principal_amount = $transaction[3];
                            $transaction_detail->interest_amount = $transaction[5];
                            $transaction_detail->payment_date = date("Y-m-d", strtotime($transaction[7]));
                            $transaction_detail->due_date = date("Y-m-d", strtotime($transaction[9]));
                            $transaction_detail->uploaded_id = $transaction[1];
                            $transaction_detail->cutoff_date = date("Y-m-d", strtotime($cutoff_date));
                            $transaction_detail->save();
                            $trantemp++;
                        }
                        //loan_history,client_history
                    }
                }
            }
            return redirect("/upload");
        }
    }

    /**
     * Display specific cluster page.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewClient($client_id)
    {
        $client = \App\Client::find($client_id);

        if($client == null) return redirect("/structure");
        if($client->group->center->branch->id != Auth::user()->branch->id) return redirect("/structure");
        if($client->isDummy != Auth::user()->dummy_mode) return redirect("/structure");

        $loans = $client->loans;
        $regions = \App\Region::all();
        $selected_barangay = null;
        $selected_municipality = null;
        $selected_province = null;
        $selected_region = null;
        if($client->barangay_id){
            $selected_barangay = \App\Barangay::find($client->barangay_id);
            $selected_municipality = $selected_barangay->municipality;
            $selected_province = $selected_municipality->province;
            $selected_region = $selected_province->region;
        }
        $genders = \App\Gender::all();
        $client_statuses = \App\ClientStatus::all();
        $civil_statuses = \App\CivilStatus::all();
        $beneficiary_types = \App\BeneficiaryType::all();
        $loan_types = \App\LoanType::all();

        $companyrole = Auth::user()->companyrole;
        $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
        
        $tags = $client->tags;

        return view('normaluser.client')->with("client", $client)
                                        ->with("loans", $loans)
                                        ->with("regions", $regions)
                                        ->with("genders", $genders)
                                        ->with("client_statuses", $client_statuses)
                                        ->with("civil_statuses", $civil_statuses)
                                        ->with("beneficiary_types", $beneficiary_types)
                                        ->with("selected_barangay", $selected_barangay)
                                        ->with("selected_municipality", $selected_municipality)
                                        ->with("selected_province", $selected_province)
                                        ->with("selected_region", $selected_region)
                                        // ->with("loan_types", $loan_types)
                                        ->with("activities", $activities)
                                        ->with("tags", $tags);
    }

    /**
     * Edit Client.
     *
     * @return JSON
     */
    public function editClient(Request $request, $client_id)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(3,$activities)){
                $data = $request->all();
                //check here
                $client = \App\Client::find($client_id);

                $client->barangay_id = (($data['barangay_id'] != "") ? $data['barangay_id'] : NULL);
                $client->status_id = $data['status_id'];
                $client->gender_id = $data['gender_id'];
                $client->civil_status_id = $data['civil_status_id'];
                $client->beneficiary_type_id = $data['beneficiary_type_id'];
                $client->birthplace = $data['birthplace'];
                $client->first_name = $data['first_name'];
                $client->middle_name = $data['middle_name'];
                $client->last_name = $data['last_name'];
                $client->mother_middle_name = $data['mother_maiden_last_name'];
                if(strtotime($data['birthdate'])) $client->birthdate = date("Y-m-d", strtotime($data['birthdate']));
                $client->house_address = $data['house_address'];
                $client->mobile_number = $data['mobile_number'];
                $client->cutoff_date = $data['cutoff_date'];

                $client->save();

                // $approved = Auth::user()->company->users->where('isApproved', 1);
                // $pending = Auth::user()->company->users->where('isApproved', 0);
                // return view('users')->with('code', $code)
                //                     ->with('approved', $approved)
                //                     ->with('pending', $pending);

                return response()->json($client);
            }
        }
    }

    /**
     * Get Transacations for the Loan.
     *
     * @return JSON
     */
    public function getTransactions($loan_id, Request $request)
    {
        if($request->ajax()){
            $loan = \App\Loan::find($loan_id);
            $transactions = $loan->transactions;
            
            // $approved = Auth::user()->company->users->where('isApproved', 1);
            // $pending = Auth::user()->company->users->where('isApproved', 0);
            // return view('users')->with('code', $code)
            //                     ->with('approved', $approved)
            //                     ->with('pending', $pending);

            return $transactions->toJson();
        }
    }

    /**
     * Add a loan to the client.
     *
     * @return JSON
     */
    public function addLoan(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(4,$activities)){
                $data = $request->all();

                $loan_type = \App\LoanType::firstOrCreate(['name' => $data['loan_type']]);

                $loan = \App\Loan::create([
                    'client_id' => $data['client_id'],
                    'loan_type_id' => $loan_type->id,
                    'loan_cycle' => $data['cycle_number'],
                    'released_date' => date("Y-m-d", strtotime($data['release_date'])),
                    'principal_amount' => $data['principal_amount_loan'],
                    'interest_amount' => $data['interest_amount_loan'],
                    'principal_balance' => $data['principal_balance'],
                    'interest_balance' => $data['interest_balance'],
                    'isActive' => $data['isActive'],
                    'isReleased' => $data['isReleased'],
                    'status' => $data['status'],
                    'maturity_date' => date("Y-m-d", strtotime($data['maturity_date'])),
                    'cutoff_date' => date("Y-m-d", strtotime($data['cutoff_date_loan'])),
                ]);

                // \App\LoanHistory::create([
                //     'loan_id' => $loan->id,
                //     'status' => $loan->status,
                //     'date' => $loan->cutoff_date,
                // ]);

                $loan->loan_type_id = \App\LoanType::find($loan->loan_type_id)->name;
                // $approved = Auth::user()->company->users->where('isApproved', 1);
                // $pending = Auth::user()->company->users->where('isApproved', 0);
                // return view('users')->with('code', $code)
                //                     ->with('approved', $approved)
                //                     ->with('pending', $pending);

                return response()->json($loan);
            }
        }
    }

    /**
     * Add a transaction to the loan.
     *
     * @return JSON
     */
    public function addTransaction(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            if(in_array(5,$activities)){
                $data = $request->all();

                $transaction = \App\Transaction::create([
                    'loan_id' => $data['loan_id'],
                    'principal_amount' => $data['principal_amount_transaction'],
                    'interest_amount' => $data['interest_amount_transaction'],
                    'payment_date' => date("Y-m-d", strtotime($data['payment_date'])),
                    'due_date' => date("Y-m-d", strtotime($data['due_date'])),
                    'cutoff_date' => date("Y-m-d", strtotime($data['cutoff_date_transaction'])),
                ]);

                $loan = \App\Loan::find($data['loan_id']);
                //check here
                $loan->principal_amount = $data["principal_amount_loan_transaction_form"];
                $loan->interest_amount = $data["interest_amount_loan_transaction_form"];
                $loan->principal_balance = $data["principal_balance_transaction_form"];
                $loan->interest_balance = $data["interest_balance_transaction_form"];
                $loan->isActive = $data["isActive_transaction_form"];
                $loan->status = $data["status_transaction_form"];
                $loan->cutoff_date = $data["cutoff_date_loan"];

                $loan->save();

                $output = [];

                $output["transaction"] = $transaction;
                $output["loan"] = $loan;

                return response()->json($output);
            }
        }
    }

    /**
     * Add a tag to the client.
     *
     * @return JSON
     */
    public function addTag(Request $request)
    {
        if($request->ajax()){
            $companyrole = Auth::user()->companyrole;
            $activities = \App\CompanyRoleActivity::where('company_role_id', $companyrole->id)->lists('activity_id')->toArray();
            // if(in_array(3,$activities)){
                $data = $request->all();

                $tag = \App\Tag::firstOrCreate(['name' => $data["tag_name"]]);

                \App\BranchTag::firstOrCreate(['branch_id' => Auth::user()->branch_id,
                                                'tag_id' => $tag->id]);

                $client_tag = \App\ClientTag::firstOrCreate(['client_id' => $data["client_id"],
                                                'tag_id' => $tag->id]);

                $whole["tag"] = $tag;
                $whole["client_tag"] = $client_tag;

                return response()->json($whole);
            // }
        }
    }

    /**
     * Delete a Client.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteClient(Request $request)
    {
        $data = $request->all();
        
        $client = \App\Client::find($data["client_id"]);

        foreach ($client->loans as $loan) {
            foreach ($loan->transactions as $transaction) {
                $transaction->delete();
            }
            $loan->delete();
        }

        foreach ($client->clusters as $cluster) {
            $cluster->pivot->delete();
        }

        foreach ($client->tags as $tag) {
            $tag->pivot->delete();
        }

        $client->delete();

        return redirect("/structure");
    }

    /**
     * Delete a Loan.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteLoan(Request $request)
    {
        $data = $request->all();
        
        $loan = \App\Loan::find($data["loan_id"]);

        foreach ($loan->transactions as $transaction) {
            $transaction->delete();
        }
        $loan->delete();

        return redirect(URL::previous());
    }

    /**
     * Delete a Transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTransaction(Request $request)
    {
        $data = $request->all();

        \App\Transaction::destroy($data["transaction_id"]);

        return redirect(URL::previous());
    }

    /**
     * Delete a Tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTag(Request $request)
    {
        $data = $request->all();

        \App\ClientTag::destroy($data["tag_id"]);

        return redirect(URL::previous());
    }

    /**
     * Edit a Loan.
     *
     * @return \Illuminate\Http\Response
     */
    public function editLoan(Request $request)
    {
        $data = $request->all();

        $loan = \App\Loan::find($data["loan_id"]);

        $loan_type = \App\LoanType::firstOrCreate(['name' => $data['loan_type']]);

        //check here
        $loan->loan_type_id = $loan_type->id;
        $loan->loan_cycle = $data['cycle_number'];
        $loan->released_date = date("Y-m-d", strtotime($data['release_date']));
        $loan->principal_amount = $data['principal_amount_loan'];
        $loan->interest_amount = $data['interest_amount_loan'];
        $loan->principal_balance = $data['principal_balance'];
        $loan->interest_balance = $data['interest_balance'];
        $loan->isActive = $data['isActive'];
        $loan->isReleased = $data['isReleased'];
        $loan->status = $data['status'];
        $loan->maturity_date = date("Y-m-d", strtotime($data['maturity_date']));
        $loan->cutoff_date = date("Y-m-d", strtotime($data['cutoff_date_loan']));

        $loan->save();

        return redirect(URL::previous());
    }

    /**
     * Edit a Transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function editTransaction(Request $request)
    {
        $data = $request->all();

        $transaction = \App\Transaction::find($data["transaction_id"]);
        //check here
        $transaction->principal_amount = $data['principal_amount_transaction'];
        $transaction->interest_amount = $data['interest_amount_transaction'];
        $transaction->payment_date = date("Y-m-d", strtotime($data['payment_date']));
        $transaction->due_date = date("Y-m-d", strtotime($data['due_date']));
        $transaction->cutoff_date = date("Y-m-d", strtotime($data['cutoff_date_transaction']));

        $transaction->save();

        $loan = \App\Loan::find($transaction->loan_id);
        //check here
        $loan->principal_amount = $data["principal_amount_loan_transaction_form"];
        $loan->interest_amount = $data["interest_amount_loan_transaction_form"];
        $loan->principal_balance = $data["principal_balance_transaction_form"];
        $loan->interest_balance = $data["interest_balance_transaction_form"];
        $loan->isActive = $data["isActive_transaction_form"];
        $loan->status = $data["status_transaction_form"];
        $loan->cutoff_date = $data["cutoff_date_loan"];

        $loan->save();

        return redirect(URL::previous());
    }
}