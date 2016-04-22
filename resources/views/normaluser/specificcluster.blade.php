@extends('layouts.app')

@section('css')
    <link href="{{ URL::asset('assets/css/structure.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ URL::asset('assets/css/specificcluster.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cluster Page</div>

                <div id="cluster-body" class="panel-body" data-id="{{ $cluster_id }}">
                    <div id="view-approved-users" class="row">
                        <h1> Approved Users: </h1>
                        <table id="approved-users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Company</td>
                                    <td>Username</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    @if(in_array(1,$allowed_actions))
                                        <td>Edit</td>  <!-- Change depending on role in cluster -->
                                        <td>Delete</td>  <!-- Change depending on role in cluster -->
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cluster_users as $user)
                                    @if($user->pivot->isApproved == 1)
                                        <tr>
                                            <td>{{ $user->company->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            @if(in_array(1,$allowed_actions))
                                                <td>
                                                    <button type='button' class='edit-user-button btn btn-info btn-sm modal-button raised' data-toggle='modal' data-target='#edit-user-modal' data-id="{{ $user->pivot->id }}"><i class="fa fa-btn fa-pencil"></i>Edit User</button>
                                                </td>
                                                <td>
                                                    <form action="/deleteClusterUser/{{$user->pivot->id}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-btn fa-trash-o"></i>Delete User
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    <div id="view-pending-users" class="row">
                        <h1> Pending Users: </h1>
                        <table id="pending-users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Company</td>
                                    <td>Username</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    @if(in_array(1,$allowed_actions))
                                        <td>Approve</td>  <!-- Change depending on role in cluster -->
                                        <td>Disapprove</td>  <!-- Change depending on role in cluster -->
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cluster_users as $user)
                                    @if($user->pivot->isApproved == 0)
                                        <tr>
                                            <td>{{ $user->company->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}
                                            @if(in_array(1,$allowed_actions))
                                                <td>
                                                    <button type='button' class='approve-user-button btn btn-success btn-sm modal-button raised' data-toggle='modal' data-target='#approve-user-modal' data-id="{{ $user->pivot->id }}"><i class="fa fa-btn fa-thumbs-up"></i>Approve User</button>
                                                </td>
                                                <td>
                                                    <form action="/disapproveClusterUser/{{$user->pivot->id}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-btn fa-trash-o"></i>Disapprove User
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    @if(in_array(2,$allowed_actions))
                        <div id="search-clients-clusters" class="row">
                            <h1> Search Clients: </h1>
                            <form id="search-client-cluster-form" class="form-horizontal" role="form" data-url="{{URL::to('/searchClientCluster')}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="cluster_setting" id="cluster-setting-modal" value="{{$setting}}"/>
                                <input type="hidden" name="cluster_id" id="cluster-id-modal" value="{{$cluster_id}}"/>
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Middle Name</label>
                                    <div class="col-md-7">
                                        <input id="middle-name" type="text" class="form-control check-length" name="middle_name" value="{{ old('middle_name') }}">

                                        <span class="help-block max">
                                            <strong>Please limit number of characters to 255</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Suffix</label>
                                    <div class="col-md-7">
                                        <input id="suffix-name" type="text" class="form-control check-length" name="suffix_name" value="{{ old('suffix_name') }}">
                                    
                                        <span class="help-block max">
                                            <strong>Please limit number of characters to 255</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mother's Maiden Middle Name</label>
                                    <div class="col-md-7">
                                        <input id="mother_maiden_last-name" type="text" class="form-control check-length" name="mother_maiden_last_name" value="{{ old('mother_maiden_last_name') }}">
                                    
                                        <span class="help-block max">
                                            <strong>Please limit number of characters to 255</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Region</label>
                                    <div class="col-md-7">
                                        <select required id="region-select" class="form-control" name="region_id" value="{{ old('region_id') }}">
                                            <option value="">None</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Province</label>
                                    <div class="col-md-7">
                                        <select required id="province-select" class="form-control" name="province_id" value="{{ old('province_id') }}">
                                            <option value="">None</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Municipality</label>
                                    <div class="col-md-7">
                                        <select required id="municipality-select" class="form-control" name="municipality_id" value="{{ old('municipality_id') }}">
                                            <option value="">None</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Barangay</label>
                                    <div class="col-md-7">
                                        <select required id="barangay-select" class="form-control" name="barangay_id" value="{{ old('barangay_id') }}">
                                            <option value="">None</option>  
                                        </select>
                                        <span class="help-block required">
                                            <strong>This field is required</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">House Address</label>
                                    <div class="col-md-7">
                                        <input id="house-address" type="text" class="form-control check-length" name="house_address" value="{{ old('house_address') }}">

                                        <span class="help-block max">
                                            <strong>Please limit number of characters to 255</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Gender</label>
                                    <div class="col-md-7">
                                        <select required class="form-control" name="gender_id" value="{{ old('gender_id') }}">
                                            <option value="">None</option> 
                                            @foreach($genders as $gender)
                                                <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Civil Status</label>
                                    <div class="col-md-7">
                                        <select required class="form-control" name="civil_status_id" value="{{ old('civil_status_id') }}">
                                            <option value="">None</option>  
                                            @foreach($civil_statuses as $civil_status)
                                                <option value="{{ $civil_status->id }}">{{ $civil_status->name }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Birthplace</label>
                                    <div class="col-md-7">
                                        <input id="birthplace" type="text" class="form-control check-length" name="birthplace" value="{{ old('birthplace') }}">
                                    </div>

                                    <span class="help-block max">
                                        <strong>Please limit number of characters to 255</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Birthdate</label>
                                    <div class="col-md-7">
                                        <input id="birthdate" type="date" class="form-control required-date" name="birthdate" value="{{ old('birthdate') }}">

                                        <span class="help-block wrong-format">
                                            <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-2 col-md-offset-10">
                                <button id="search-client-submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-search"></i>Search Client
                                </button>
                            </div>
                            <br />
                        </div>
                        <div id="search-results-clusters" class="row">
                            <h1> Search Results: </h1>
                            <div id="search-results-body" class="row">
                                <table id="search-results-table" class="table table-striped">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if(in_array(3,$allowed_actions))
                        <div class="row">
                            <div id="add-clients-clusters" class="col-md-6">
                                <h3>Add Clients: </h3>
                                    <div id="add-clients-panel">
                                        <div id="structure-breadcrumb">
                                            <ol class = "breadcrumb row">
                                               <li class="title-breadcrumb" id="branch-breadcrumb" data-id="{{ $branch->id }}">{{ $branch->name }}</li>
                                               <li class="title-breadcrumb" id="center-breadcrumb" data-id=""></li>
                                               <li class="title-breadcrumb" id="group-breadcrumb" data-id=""></li>
                                            </ol>
                                        </div>
                                        <div id="structure-tag" class="form-group row">
                                            <label class="col-md-offset-5 col-md-1 control-label">Tag</label>
                                            <div class="col-md-6">
                                                <select id="tag-id" class="form-control">
                                                    <option value="0">None</option>  
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                    @endforeach   
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div id="structure-buttons">
                                            <button id='add-center-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addCenterModal'>Add Center</button>
                                            <button id='add-group-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addGroupModal'>Add Group</button>
                                            <button id='add-client-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addClientModal'>Add Client</button>
                                        </div> -->
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
                                    </div>
                                <br />
                            </div>
                            <div id="add-buttons-clusters" class="col-md-1">
                                <div class="row move-clients">
                                    <button id='select-button' type='button' class='btn btn-default btn-xs raised'>></button>

                                </div>
                                <div class="row move-clients">
                                    <button id='remove-button' type='button' class='btn btn-default btn-xs raised'><</button>
                                </div>
                            </div>
                            <div id="selected-clients-clusters" class="col-md-5">
                                <h3>Selected Clients: </h3>
                                    <div id="selected-clients-body">
                                        <table id="selected-clients-table" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                <br />
                                <form action="/addClientToCluster" method="post" id="add-client-form">
                                    {!! csrf_field() !!}
                                    <button class="btn btn-primary btn-sm pull-right">
                                        <i class=" fa fa-btn fa-pencil"></i>Add Clients
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div id="view-clients" class="row">
                            <h3>View Clients: </h3>
                            <div id="view-clients-body">
                                <table id="view-clients-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td><input type='checkbox' name='client' value='{{ $client->id }}'/>  {{ $client->first_name }}<td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br />
                            <form action="/removeClientFromCluster" method="post" id="remove-client-form">
                                {!! csrf_field() !!}
                                <button class="btn btn-danger btn-sm pull-right">
                                    <i class=" fa fa-btn fa-trash-o"></i>Remove Clients
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User -->
<div id="edit-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <h1>Edit User</h1>
                <div class="row">
                    <form action="/editClusterUser" method="post" id="edit-user-form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="cluster_user_id" id="cluster-user-id-edit-modal" value=""/>
                        <label class="col-md-12 control-label">Actions Allowed</label>

                        <div class="col-md-offset-1 col-md-11">
                            @foreach($actions as $action)
                                <input type="checkbox" name="{{ $action->name }}" value="true">   {{ $action->name }}<br>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="edit-user-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Edit User
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve User -->
<div id="approve-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <h1>Approve User</h1>
                <div class="row">
                    <form action="/approveClusterUser" method="post" id="approve-user-form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="cluster_user_id" id="cluster-user-id-approve-modal" value=""/>
                        <label class="col-md-12 control-label">Actions Allowed</label>

                        <div class="col-md-offset-1 col-md-11">
                            @foreach($actions as $action)
                                <input type="checkbox" name="{{ $action->name }}" value="true">   {{ $action->name }}<br>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="approve-user-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Approve User
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/specificcluster.js') }}"></script>
    <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
    <script>
        webshims.setOptions('forms-ext', {types: 'date'});
        webshims.polyfill('forms forms-ext');
    </script>
@endsection
