@extends('layouts.app')

@section('title')
    CommonClusters - Structure
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/structure.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Maintain Data</div>

                <div class="panel-body">
                    <div id="structure-breadcrumb" class="row">
                        <ol class = "breadcrumb">
                           <li class="title-breadcrumb" id="branch-breadcrumb" data-id="{{ $branch->id }}">{{ $branch->name }}</li>
                           <li class="title-breadcrumb" id="center-breadcrumb" data-id=""></li>
                           <li class="title-breadcrumb" id="group-breadcrumb" data-id=""></li>
                        </ol>
                    </div>
                    <div id="structure-buttons" class="row">
                        <span class="form-horizontal" id="search-div">
                            <div class="form-group pull-left">
                                <label class="col-md-3 control-label">Search</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="search-textbox">
                                </div>
                            </div>
                        </span>
                        @if(in_array(1,$activities))
                            <button id='add-center-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addCenterModal'>Add Center</button>
                            <button id='add-group-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addGroupModal'>Add Group</button>
                        @endif
                        @if(in_array(2,$activities))
                            <button id='add-client-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addClientModal'>Add Client</button>
                        @endif
                    </div>
                    <div id="structure-body" class="row">
                        <table id="structure-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    @if(in_array(2,$activities))
                        <button id='restart-branch-button' type='button' class='btn btn-danger btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#restart-branch-modal'>Restart Branch</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Center Modal -->
<div id="addCenterModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Center</h4>
            </div>
            <div class="modal-body">
                <form id="add-center-form" class="form-horizontal" role="form" data-url="{{URL::to('/addCenter')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="branch_id" id="branch-id-modal" value="{{ $branch->id }}"/>
                    <div id="center-name-form" class="form-group">
                        <label class="col-md-4 control-label">Center Name</label>

                        <div class="col-md-8">
                            <input id="center-name" type="text" class="form-control" name="center_name" value="{{ old('center_name') }}" required>
                            <span hidden id="center-required-span" class="help-block">
                                <strong hidden id="center-required-strong">Center Name is Required</strong>
                            </span>
                            <span hidden id="center-unique-span" class="help-block">
                                <strong hidden id="center-unique-strong">Center Name has already been used</strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-center-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Add Group Modal -->
<div id="addGroupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Group</h4>
            </div>
            <div class="modal-body">
                <form id="add-group-form" class="form-horizontal" role="form" data-url="{{URL::to('/addGroup')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="center_id" id="center-id-modal" value=""/>
                    <div id="group-name-form" class="form-group">
                        <label class="col-md-4 control-label">Group Name</label>
                        <div class="col-md-8">
                            <input id="group-name" type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required>
                            <span hidden id="group-required-span" class="help-block">
                                <strong hidden id="group-required-strong">Group Name is Required</strong>
                            </span>
                            <span hidden id="group-unique-span" class="help-block">
                                <strong hidden id="group-unique-strong">Group Name has already been used</strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-group-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Add Client Modal -->
<div id="addClientModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Client</h4>
            </div>
            <div class="modal-body">
                <form id="add-client-form" class="form-horizontal" role="form" data-url="{{URL::to('/addClient')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="group_id" id="group-id-modal" value=""/>
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">First Name</label>
                        <div class="col-md-7">
                            <input id="first-name" type="text" class="form-control required-text" name="first_name" value="{{ old('first_name') }}">

                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                            <span class="help-block max">
                                <strong>Please limit number of characters to 255</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Middle Name</label>
                        <div class="col-md-7">
                            <input id="middle-name" type="text" class="form-control required-text" name="middle_name" value="{{ old('middle_name') }}">

                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                            <span class="help-block max">
                                <strong>Please limit number of characters to 255</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Last Name</label>
                        <div class="col-md-7">
                            <input id="last-name" type="text" class="form-control required-text" name="last_name" value="{{ old('last_name') }}">

                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                            <span class="help-block max">
                                <strong>Please limit number of characters to 255</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('suffix_name') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Suffix</label>
                        <div class="col-md-7">
                            <input id="suffix-name" type="text" class="form-control" name="suffix_name" value="{{ old('suffix_name') }}">

                            @if ($errors->has('suffix_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('suffix_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('mother_maiden_last_name') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Mother's Maiden Middle Name</label>
                        <div class="col-md-7">
                            <input id="mother_maiden_last-name" type="text" class="form-control" name="mother_maiden_last_name" value="{{ old('mother_maiden_last_name') }}">

                            @if ($errors->has('mother_maiden_last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_maiden_last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('region_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Region</label>
                        <div class="col-md-7">
                            <select id="region-select" class="form-control" name="region_id" value="{{ old('region_id') }}">
                                <option value="">None</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
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
                        <label class="col-md-5 control-label">Province</label>
                        <div class="col-md-7">
                            <select id="province-select" class="form-control" name="province_id" value="{{ old('province_id') }}">
                                <option value="">None</option>  
                            </select>
                            @if ($errors->has('province_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('province_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('municipality_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Municipality</label>
                        <div class="col-md-7">
                            <select id="municipality-select" class="form-control" name="municipality_id" value="{{ old('municipality_id') }}">
                                <option value="">None</option>  
                            </select>
                            @if ($errors->has('municipality_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('municipality_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('barangay_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Barangay</label>
                        <div class="col-md-7">
                            <select id="barangay-select" class="form-control" name="barangay_id" value="{{ old('barangay_id') }}">
                                <option value="">None</option>  
                            </select>
                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('house_address') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">House Address</label>
                        <div class="col-md-7">
                            <input id="house-address" type="text" class="form-control required-text" name="house_address" value="{{ old('house_address') }}">

                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                            <span class="help-block max">
                                <strong>Please limit number of characters to 255</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Status</label>
                        <div class="col-md-7">
                            <select required class="form-control required-select" name="status_id" value="{{ old('status_id') }}">
                                <option value="">None</option>
                                @foreach($client_statuses as $client_status)
                                    <option value="{{ $client_status->id }}">{{ $client_status->name }}</option>
                                @endforeach  
                            </select>
                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('gender_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Gender</label>
                        <div class="col-md-7">
                            <select required class="form-control required-select" name="gender_id" value="{{ old('gender_id') }}">
                                <option value="">None</option> 
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                @endforeach   
                            </select>
                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('civil_status_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Civil Status</label>
                        <div class="col-md-7">
                            <select required class="form-control required-select" name="civil_status_id" value="{{ old('civil_status_id') }}">
                                <option value="">None</option>  
                                @foreach($civil_statuses as $civil_status)
                                    <option value="{{ $civil_status->id }}">{{ $civil_status->name }}</option>
                                @endforeach   
                            </select>
                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('beneficiary_type_id') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Beneficiary Type</label>
                        <div class="col-md-7">
                            <select required class="form-control required-select" name="beneficiary_type_id" value="{{ old('beneficiary_type_id') }}">
                                <option value="">None</option>  
                                @foreach($beneficiary_types as $beneficiary_type)
                                    <option value="{{ $beneficiary_type->id }}">{{ $beneficiary_type->name }}</option>
                                @endforeach  
                            </select>
                            <span class="help-block required">
                                <strong>This field is required</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birthplace') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Birthplace</label>
                        <div class="col-md-7">
                            <input id="birthplace" type="text" class="form-control" name="birthplace" value="{{ old('birthplace') }}">

                            @if ($errors->has('birthplace'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthplace') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Birthdate</label>
                        <div class="col-md-7">
                            <input id="birthdate" type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}">

                            <span class="help-block wrong-format">
                                <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Mobile Number</label>
                        <div class="col-md-7">
                            <input id="mobile-number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}">

                            <span class="help-block wrong-format">
                                <strong>Please put a valid number</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('cutoff_date') ? ' has-error' : '' }}">
                        <label class="col-md-5 control-label">Data as of</label>
                        <div class="col-md-7">
                            <input id="cutoff-date" type="date" class="form-control required-date" name="cutoff_date" value="{{ old('cutoff_date') }}">

                            <span class="help-block wrong-format">
                                <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-client-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div id="delete-client-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Client</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default raised pull-right" data-dismiss="modal">Close</button>
                <form action="/deleteClient" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="client_id" id="delete-client-id-modal" value=""/>
                    <button class="btn btn-danger raised pull-right">
                        <i class="fa fa-btn fa-trash-o"></i>Delete Client
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Restart Branch Modal -->
<div id="restart-branch-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Restart Branch</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete all the clients in this branch?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default raised pull-right" data-dismiss="modal">Close</button>
                <form action="/restartBranch" method="post">
                    {!! csrf_field() !!}
                    <button class="btn btn-danger raised pull-right">
                        <i class="fa fa-btn fa-trash-o"></i>Restart Branch
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/structure.js') }}"></script>
    <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
    <script>
        webshims.setOptions('forms-ext', {types: 'date'});
        webshims.polyfill('forms forms-ext');
    </script>
@endsection