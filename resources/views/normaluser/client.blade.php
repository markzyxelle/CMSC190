@extends('layouts.app')

@section('css')
    <link href="{{ URL::asset('assets/css/client.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Client</div>

                <div class="panel-body">
                    <div id="alerts">
                        <div id="edit-success" class="alert alert-success">
                            <strong>Success!</strong> Edit Successful.
                        </div>
                        <div id="edit-fail" class="alert alert-danger">
                            <strong>Fail!</strong> Edit Failed.
                        </div>
                    </div>
                    <div id="view-client-information" class="row" data-id="{{ $client->id }}">
                        <h3>View Clients</h3>
                        <form id="edit-client-form" class="form-horizontal" role="form" data-url="{{URL::to('/editClient')}}/{{$client->id}}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-7">
                                    <input id="first-name" type="text" class="form-control required-text" name="first_name" value="{{ $client->first_name }}" disabled>

                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                    <span class="help-block max">
                                        <strong>Please limit number of characters to 255</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Middle Name</label>
                                <div class="col-md-7">
                                    <input id="middle-name" type="text" class="form-control required-text" name="middle_name" value="{{ $client->middle_name }}" disabled>

                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                    <span class="help-block max">
                                        <strong>Please limit number of characters to 255</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-7">
                                    <input id="last-name" type="text" class="form-control required-text" name="last_name" value="{{ $client->last_name }}" disabled>

                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                    <span class="help-block max">
                                        <strong>Please limit number of characters to 255</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('suffix_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Suffix</label>
                                <div class="col-md-7">
                                    <input id="suffix-name" type="text" class="form-control" name="suffix_name" value="{{ $client->suffix }}" disabled>

                                    @if ($errors->has('suffix_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('suffix_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('mother_maiden_last_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Mother's Maiden Middle Name</label>
                                <div class="col-md-7">
                                    <input id="mother_maiden_last-name" type="text" class="form-control" name="mother_maiden_last_name" value="{{ $client->mother_middle_name }}" disabled>

                                    @if ($errors->has('mother_maiden_last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('mother_maiden_last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('region_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Region</label>
                                <div class="col-md-7">
                                    <select required id="region-select" class="form-control" name="region_id" value="{{ old('region_id') }}" disabled>
                                        <option value="">None</option>
                                        @foreach($regions as $region)
                                            @if($client->barangay_id != null)
                                                @if($region->id == $selected_region->id)
                                                    <option value="{{ $region->id }}" selected>{{ $region->name }}</option>
                                                @else
                                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endif
                                            @else
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('region_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('region_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Province</label>
                                <div class="col-md-7">
                                    <select required id="province-select" class="form-control" name="province_id" value="{{ old('province_id') }}" disabled>
                                        <option value="">None</option>
                                        @if($client->barangay_id != null)  
                                            @foreach($selected_region->provinces as $province)
                                            
                                                @if($province->id == $selected_province->id)
                                                    <option value="{{ $province->id }}" selected>{{ $province->name }}</option>
                                                @else
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('province_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('province_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('municipality_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Municipality</label>
                                <div class="col-md-7">
                                    <select required id="municipality-select" class="form-control" name="municipality_id" value="{{ old('municipality_id') }}" disabled>
                                        <option value="">None</option>
                                        @if($client->barangay_id != null)  
                                            @foreach($selected_province->municipalities as $municipality)
                                            
                                                @if($municipality->id == $selected_municipality->id)
                                                    <option value="{{ $municipality->id }}" selected>{{ $municipality->name }}</option>
                                                @else
                                                    <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif  
                                    </select>
                                    @if ($errors->has('municipality_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('municipality_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('barangay_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Barangay</label>
                                <div class="col-md-7">
                                    <select required id="barangay-select" class="form-control required-select" name="barangay_id" value="{{ old('barangay_id') }}" disabled>
                                        <option value="">None</option>
                                        @if($client->barangay_id != null)  
                                            @foreach($selected_municipality->barangays as $barangay)
                                            
                                                @if($barangay->id == $selected_barangay->id)
                                                    <option value="{{ $barangay->id }}" selected>{{ $barangay->name }}</option>
                                                @else
                                                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif    
                                    </select>
                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('house_address') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">House Address</label>
                                <div class="col-md-7">
                                    <input id="house-address" type="text" class="form-control required-text" name="house_address" value="{{ $client->house_address }}" disabled>

                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                    <span class="help-block max">
                                        <strong>Please limit number of characters to 255</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-7">
                                    <select required class="form-control required-select" name="status_id" value="{{ old('status_id') }}" disabled>
                                        <option value="">None</option>
                                        @foreach($client_statuses as $client_status)
                                            @if($client_status->id == $client->status_id)
                                                <option value="{{ $client_status->id }}" selected>{{ $client_status->name }}</option>
                                            @else
                                                <option value="{{ $client_status->id }}">{{ $client_status->name }}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('gender_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Gender</label>
                                <div class="col-md-7">
                                    <select required class="form-control required-select" name="gender_id" value="{{ old('gender_id') }}" disabled>
                                        <option value="">None</option> 
                                        @foreach($genders as $gender)
                                            @if($gender->id == $client->gender_id)
                                                <option value="{{ $gender->id }}" selected>{{ $gender->name }}</option>
                                            @else
                                                <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                            @endif
                                        @endforeach   
                                    </select>
                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('civil_status_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Civil Status</label>
                                <div class="col-md-7">
                                    <select required class="form-control required-select" name="civil_status_id" value="{{ old('civil_status_id') }}" disabled>
                                        <option value="">None</option>  
                                        @foreach($civil_statuses as $civil_status)
                                            @if($civil_status->id == $client->civil_status_id)
                                                <option value="{{ $civil_status->id }}" selected>{{ $civil_status->name }}</option>
                                            @else
                                                <option value="{{ $civil_status->id }}">{{ $civil_status->name }}</option>
                                            @endif
                                        @endforeach   
                                    </select>
                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('beneficiary_type_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Beneficiary Type</label>
                                <div class="col-md-7">
                                    <select required class="form-control required-select" name="beneficiary_type_id" value="{{ old('beneficiary_type_id') }}" disabled>
                                        <option value="">None</option>  
                                        @foreach($beneficiary_types as $beneficiary_type)
                                            @if($beneficiary_type->id == $client->beneficiary_type_id)
                                                <option value="{{ $beneficiary_type->id }}" selected>{{ $beneficiary_type->name }}</option>
                                            @else
                                                <option value="{{ $beneficiary_type->id }}">{{ $beneficiary_type->name }}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <span class="help-block required">
                                        <strong>This field is required</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('birthplace') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Birthplace</label>
                                <div class="col-md-7">
                                    <input id="birthplace" type="text" class="form-control" name="birthplace" value="{{ $client->birthplace }}" disabled>

                                    @if ($errors->has('birthplace'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('birthplace') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Birthdate</label>
                                <div class="col-md-7">
                                    <input id="birthdate" type="date" class="form-control required-date" name="birthdate" value="{{ $client->birthdate }}" disabled>

                                    <span class="help-block wrong-format">
                                        <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Mobile Number</label>
                                <div class="col-md-7">
                                    <input id="mobile-number" type="text" class="form-control" name="mobile_number" value="{{ $client->mobile_number }}" disabled>

                                    <span class="help-block wrong-format">
                                        <strong>Please put a valid number</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cutoff_date') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Data as of</label>
                                <div class="col-md-7">
                                    <input id="cutoff-date" type="date" class="form-control required-date" name="cutoff_date" value="{{ $client->cutoff_date }}" disabled>

                                    <span class="help-block wrong-format">
                                        <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                    </span>
                                </div>
                            </div>
                            @if(in_array(3,$activities))
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-9">
                                        <button type="submit" class="btn btn-primary" id="edit-client-submit">
                                            <i class="fa fa-btn fa-pencil"></i>  Submit
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </form>
                        @if(in_array(3,$activities))
                            <div class="col-md-4 col-md-offset-9">
                                <button class="btn btn-info btn-md" id="edit-client-enable">
                                    <i class="fa fa-btn fa-pencil"></i>  Edit
                                </button>
                            </div>
                         @endif
                    </div>
                    <div id="modal-buttons" class="row">
                        <button id='view-loans-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#view-loans-modal'>View Loans</button>
                        <button id='view-tags-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#view-tags-modal'>View Tags</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Loans -->
<div id="view-loans-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <h3>Loans</h3>
                <div id="view-loans-information" data-id="{{ $client->id }}">
                    <table id="view-loans-table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Type</td>
                                <td>Cycle Number</td>
                                <td>Release Date</td>
                                <td>Princpal Amount</td>
                                <td>Interest Amount</td>
                                <td>Principal Balance</td>
                                <td>Interest Balance</td>
                                <td>Active</td>
                                <td>Released</td>
                                <td>Status</td>
                                <td>Maturity Date</td>
                                <td>Cutoff Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr class="loan-structure" data-id="{{$loan->id}}">
                                    <td>{{\App\LoanType::find($loan->loan_type_id)->name}}</td>
                                    <td>{{$loan->loan_cycle}}</td>
                                    <td>{{$loan->released_date}}</td>
                                    <td>{{$loan->principal_amount}}</td>
                                    <td>{{$loan->interest_amount}}</td>
                                    <td>{{$loan->principal_balance}}</td>
                                    <td>{{$loan->interest_balance}}</td>
                                    <td>{{$loan->isActive == 0 ? "False" : "True"}}</td>
                                    <td>{{$loan->isReleased == 0 ? "False" : "True"}}</td>
                                    <td>{{$loan->status}}</td>
                                    <td>{{$loan->maturity_date}}</td>
                                    <td>{{$loan->cutoff_date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(in_array(4,$activities))
                    <div class="row">
                        <button id='add-loans-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#add-loans-modal'>Add Loan</button>
                    </div>
                @endif
                <h3>Transactions</h3>
                <div id="view-transactions-information" data-id="">
                    <table id="view-transactions-table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Princpal Amount</td>
                                <td>Interest Amount</td>
                                <td>Payment Date</td>
                                <td>Due Date</td>
                                <td>Status</td>
                                <td>Cutoff Date</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                @if(in_array(5,$activities))
                <div class="row">
                    <button id='add-transactions-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#add-transactions-modal'>Add Transaction</button>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Loans -->
<div id="add-loans-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="add-loan-div">
                    <form id="add-loan-form" class="form-horizontal" role="form" data-url="{{URL::to('/addLoan')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="client_id" id="client-id-modal" value="{{$client->id}}"/>
                        <div class="form-group{{ $errors->has('loan_type_id') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Loan Type</label>
                            <div class="col-md-7">
                                <select required class="form-control required-select" name="loan_type_id" value="">
                                    <option value="">None</option>  
                                    @foreach($loan_types as $loan_type)
                                        <option value="{{ $loan_type->id }}">{{ $loan_type->name }}</option>
                                    @endforeach   
                                </select>
                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cycle_number') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Cycle Number</label>
                            <div class="col-md-7">
                                <input id="cycle-number" type="text" class="form-control required-text required-number" name="cycle_number" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Release Date</label>
                            <div class="col-md-7">
                                <input id="release-date" type="date" class="form-control required-date" name="release_date" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('principal_amount_loan') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Principal Amount</label>
                            <div class="col-md-7">
                                <input id="principal-amount-loan" type="text" class="form-control required-text required-number" name="principal_amount_loan" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('interest_amount_loan') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Interest Amount</label>
                            <div class="col-md-7">
                                <input id="interest-amount-loan" type="text" class="form-control required-text required-number" name="interest_amount_loan" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('principal_balance') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Principal Balance</label>
                            <div class="col-md-7">
                                <input id="principal-balance" type="text" class="form-control required-text required-number" name="principal_balance" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('interest_balance') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Interest Balance</label>
                            <div class="col-md-7">
                                <input id="interest-balance" type="text" class="form-control required-text required-number" name="interest_balance" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('isActive') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Active</label>
                            <div class="col-md-7">
                                <select required class="form-control required-select" name="isActive" value="">
                                    <option value="">None</option>  
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('isReleased') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Released</label>
                            <div class="col-md-7">
                                <select required class="form-control required-select" name="isReleased" value="">
                                    <option value="">None</option>  
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-7">
                                <input id="status" type="text" class="form-control required-text" name="status" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block max">
                                    <strong>Please limit number of characters to 255</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('maturity_date') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Maturity Date</label>
                            <div class="col-md-7">
                                <input id="maturity-date" type="date" class="form-control required-date" name="maturity_date" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cutoff_date_loan') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Data as of</label>
                            <div class="col-md-7">
                                <input id="cutoff-date-loan" type="date" class="form-control required-date" name="cutoff_date_loan" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-loan-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Submit
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Transactions -->
<div id="add-transactions-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="add-transaction-div">
                    <form id="add-transaction-form" class="form-horizontal" role="form" data-url="{{URL::to('/addTransaction')}}">
                        {!! csrf_field() !!}
                        <h1> Transaction </h1>
                        <input type="hidden" name="loan_id" id="loan-id-modal" value=""/>
                        <div class="form-group{{ $errors->has('principal_amount_transaction') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Principal Amount</label>
                            <div class="col-md-7">
                                <input id="principal-amount-transaction" type="text" class="form-control required-text required-number" name="principal_amount_transaction" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('interest_amount_transaction') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Interest Amount</label>
                            <div class="col-md-7">
                                <input id="interest-amount-transaction" type="text" class="form-control required-text required-number" name="interest_amount_transaction" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Payment Date</label>
                            <div class="col-md-7">
                                <input id="payment-date" type="date" class="form-control required-date" name="payment_date" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Due Date</label>
                            <div class="col-md-7">
                                <input id="due-date" type="date" class="form-control required-date" name="due_date" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cutoff_date_transaction') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Data as of</label>
                            <div class="col-md-7">
                                <input id="cutoff-date-transaction" type="date" class="form-control required-date" name="cutoff_date_transaction" value="">

                                <span class="help-block wrong-format">
                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                </span>
                            </div>
                        </div>
                        <h1> Loan </h1>
                        <div class="form-group{{ $errors->has('principal_amount_loan_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Principal Amount</label>
                            <div class="col-md-7">
                                <input id="principal-amount-loan-transaction-form" type="text" class="form-control required-text required-number" name="principal_amount_loan_transaction_form" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('interest_amount_loan_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Interest Amount</label>
                            <div class="col-md-7">
                                <input id="interest-amount-loan-transaction-form" type="text" class="form-control required-text required-number" name="interest_amount_loan_transaction_form" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('principal_balance_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Principal Balance</label>
                            <div class="col-md-7">
                                <input id="principal-balance-transaction-form" type="text" class="form-control required-text required-number" name="principal_balance_transaction_form" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('interest_balance_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Interest Balance</label>
                            <div class="col-md-7">
                                <input id="interest-balance-transaction-form" type="text" class="form-control required-text required-number" name="interest_balance_transaction_form" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block number">
                                    <strong>Please put a valid number</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('isActive_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Active</label>
                            <div class="col-md-7">
                                <select required id="isActive-select" class="form-control required-select" name="isActive_transaction_form" value="">
                                    <option value="">None</option>  
                                    <option class="True" value="1">True</option>
                                    <option class="False"value="0">False</option>
                                </select>
                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status_transaction_form') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-7">
                                <input id="status-transaction-form" type="text" class="form-control required-text" name="status_transaction_form" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block max">
                                    <strong>Please limit number of characters to 255</strong>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-transaction-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Submit
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Tags -->
<div id="view-tags-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <h3>Tags</h3>
                <div id="add-tags-div">
                    <form id="add-tag-form" class="form-horizontal" role="form" data-url="{{URL::to('/addTag')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="client_id" id="client-id-tag-modal" value="{{$client->id}}"/>
                        <div id="tag-name-div" class="form-group{{ $errors->has('tag_name') ? ' has-error' : '' }}">
                            <label class="col-md-offset-1 col-md-1 control-label">Name</label>
                            <div class="col-md-9">
                                <input id="tag-name" type="text" class="form-control required-text" name="tag_name" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block max">
                                    <strong>Please limit number of characters to 255</strong>
                                </span>
                                <span class="help-block unique">
                                    <strong>Tag already exists for this client</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-9">
                                <button type="submit" class="btn btn-primary" id="add-tag-button">
                                    <i class="fa fa-btn fa-pencil"></i>  Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br/>
                <div id="view-tags-information" data-id="{{ $client->id }}">
                    <table id="view-tags-table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <!-- <td>Remove</td> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{$tag->name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/structure.js') }}"></script>
    <script src="{{ URL::asset('assets/js/client.js') }}"></script>
    <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
    <script>
        webshims.setOptions('forms-ext', {types: 'date'});
        webshims.polyfill('forms forms-ext');
    </script>
@endsection