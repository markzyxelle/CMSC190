@extends('layouts.app')

@section('title')
    CommonClusters - Cluster
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/structure.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ URL::asset('assets/css/specificcluster.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ URL::asset('assets/css/scrollabletable.css') }}" rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <link rel="stylesheet" href="/resources/demos/style.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cluster Page</div>

                <div id="cluster-body" class="panel-body" data-id="{{ $cluster_id }}">
                    <div id="accordion">
                        @if(in_array(2,$allowed_actions))
                            <h1> Search Clients Information From Cluster </h1>
                            <div class="row">
                                <div id="search-clients-clusters" class="row">
                                    <div class="alert alert-info">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        Fill up search fields below and click search client button
                                    </div>
                                    <div class="col-md-1 col-md-offset-11" style="margin-bottom: 1%">
                                        <button id="search-client-submit" class="btn btn-primary pull-right">
                                            <i class="fa fa-btn fa-search"></i>Search Client
                                        </button>
                                    </div>
                                    <form id="search-client-cluster-form" class="form-horizontal" role="form" data-url="{{URL::to('/searchClientCluster')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="cluster_id" id="cluster-id-modal" value="{{$cluster_id}}"/>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Cluster Setting (Required)</label>
                                            <div class="col-md-8">
                                                <select required class="form-control required-select" name="cluster_setting" value="">
                                                    @for ($i = 1; $i < $setting; $i++)
                                                        <option value="{{ $i }}">Search Option {{ $i }}</option>
                                                    @endfor 
                                                    <option value="{{ $setting }}" selected>Search Option {{ $setting }}</option>
                                                </select>
                                                <span class="help-block required">
                                                    <strong>This field is required</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input id="last-name" type="text" class="form-control required-text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name (Required)">

                                                <span class="help-block required">
                                                    <strong>This field is required</strong>
                                                </span>
                                                <span class="help-block max">
                                                    <strong>Please limit number of characters to 255</strong>
                                                </span>
                                            </div>
                                            <div class="col-md-4">
                                                <input id="first-name" type="text" class="form-control required-text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name (Required)">

                                                <span class="help-block required">
                                                    <strong>This field is required</strong>
                                                </span>
                                                <span class="help-block max">
                                                    <strong>Please limit number of characters to 255</strong>
                                                </span>
                                            </div>
                                            <div class="col-md-3">
                                                <input id="middle-name" type="text" class="form-control check-length" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle Name">

                                                <span class="help-block max">
                                                    <strong>Please limit number of characters to 255</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input id="birthplace" type="text" class="form-control check-length" name="birthplace" value="{{ old('birthplace') }}" placeholder="Birthplace">
                                            </div>

                                            <span class="help-block max">
                                                <strong>Please limit number of characters to 255</strong>
                                            </span>
                                            <div class="col-md-4">
                                                <input id="birthdate" type="date" class="form-control required-date" name="birthdate" value="{{ old('birthdate') }}" placeholder="Birthdate">

                                                <span class="help-block wrong-format">
                                                    <strong>The date has a wrong format (MM/DD/YYYY)</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                    <br />
                                </div>
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
                            <h1>Share Client Information To Cluster </h1>
                            <div class="row">
                                <div id="add-clients-clusters" class="col-md-6">
                                        <div id="add-clients-panel">
                                            <div id="structure-breadcrumb">
                                                <ol class = "breadcrumb row">
                                                   <li class="title-breadcrumb" id="branch-breadcrumb" data-id="{{ $branch->id }}">{{ $branch->name }}</li>
                                                   <li class="title-breadcrumb" id="center-breadcrumb" data-id=""></li>
                                                   <li class="title-breadcrumb" id="group-breadcrumb" data-id=""></li>
                                                </ol>
                                            </div>
                                            <div id="structure-tag" class="row">
                                                <div class="form-vertical">
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label">Tag</label>
                                                        <div class="col-md-4">
                                                            <select id="tag-id" class="form-control">
                                                                <option value="0">None</option>  
                                                                @foreach($tags as $tag)
                                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                                @endforeach   
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <span id="search-div">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Search</label>
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" id="search-textbox">
                                                            </div>
                                                        </div>
                                                    </span>
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
                            <h1>View Clients Shared In Cluster </h1>
                            <div id="view-clients" class="row">
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
                                                    <td><input type='checkbox' name='client' value='{{ $client->id }}'/> {{$client->last_name}}, {{ $client->first_name }} {{$client->middle_name}}<td>
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
                        <h1> Approved Users </h1>
                        <div>
                            <div id="view-approved-users" class="row">
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
                            </div>
                        </div>
                        <h1> Pending Users </h1>
                        <div>
                            <div id="view-pending-users" class="row">
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
                            </div>
                        </div>
                        @if(in_array(1,$allowed_actions))
                            <h1> Add User </h1>
                            <div id="add-user" class="row">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/addUser') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="cluster_id" id="cluster-id-add-user" value="{{$cluster_id}}"/>
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}{{ session('cluster_user_exists', false) ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label">Username</label>

                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                                            @if ($errors->has('username'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @endif
                                            @if (session('cluster_user_exists', false))
                                                <span class="help-block">
                                                    <strong>User is already a member of the cluster</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-offset-1 col-md-11">
                                        @foreach($actions as $action)
                                            <input type="checkbox" name="{{ $action->name }}" value="true">   {{ $action->name }}<br>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2 col-md-offset-9">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-plus"></i>Add User
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h1> Edit Cluster </h1>
                            <div id="edit-cluster" class="row">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/editCluster') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="cluster_id" id="cluster-id-add-user" value="{{$cluster_id}}"/>
                                    <div class="form-group{{ $errors->has('cluster_setting') ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label">Cluster Setting</label>

                                        <div class="col-md-8">
                                            <input type="radio" name="cluster_setting" value="1" {{ $setting == '1' ? 'checked' : '' }}> Setting 1<br>
                                            <input type="radio" name="cluster_setting" value="2" {{ $setting == '2' ? 'checked' : '' }}> Setting 2<br>
                                            <input type="radio" name="cluster_setting" value="3" {{ $setting == '3' ? 'checked' : '' }}> Setting 3<br>
                                            <input type="radio" name="cluster_setting" value="4" {{ $setting == '4' ? 'checked' : '' }}> Setting 4<br>

                                            @if ($errors->has('cluster_setting'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cluster_setting') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4 col-md-offset-8">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit Cluster
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
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
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
    $( "#accordion" ).accordion({
        heightStyle: "content"
    });
    </script>
@endsection
