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
                                    <td>Edit</td>  <!-- Change depending on role in cluster -->
                                    <td>Delete</td>  <!-- Change depending on role in cluster -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cluster_users as $user)
                                    @if($user->pivot->isApproved == 1)
                                        <tr>
                                            <td>{{ $user->company->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-info btn-sm">
                                                        <i class="fa fa-btn fa-pencil"></i>Edit User
                                                    </button>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fa fa-btn fa-trash-o"></i>Delete User
                                                    </button>
                                                </a>
                                            </td>
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
                                    <td>Approve</td>  <!-- Change depending on role in cluster -->
                                    <td>Disapprove</td>  <!-- Change depending on role in cluster -->
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
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fa fa-btn fa-pencil"></i>Approve User
                                                    </button>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class=" fa fa-btn glyphicon glyphicon-ban-circle"></i>Disapprove User
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    <div id="search-clients-clusters" class="row">
                        <h1> Search Clients: </h1>
                            
                        <br />
                    </div>
                    <div class="row">
                        <div id="add-clients-clusters" class="col-md-6">
                            <h3>Add Clients: </h3>
                                <div id="add-clients-panel">
                                    <div id="structure-breadcrumb">
                                        <ol class = "breadcrumb">
                                           <li class="title-breadcrumb" id="branch-breadcrumb" data-id="{{ $branch->id }}">{{ $branch->name }}</li>
                                           <li class="title-breadcrumb" id="center-breadcrumb" data-id=""></li>
                                           <li class="title-breadcrumb" id="group-breadcrumb" data-id=""></li>
                                        </ol>
                                    </div>
                                    <!-- <div id="structure-buttons">
                                        <button id='add-center-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addCenterModal'>Add Center</button>
                                        <button id='add-group-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addGroupModal'>Add Group</button>
                                        <button id='add-client-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addClientModal'>Add Client</button>
                                    </div> -->
                                    <div id="structure-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/specificcluster.js') }}"></script>
@endsection
