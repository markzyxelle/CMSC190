@extends('layouts.app')

@section('title')
    CommonClusters - Cluster Home
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/scrollabletable.css') }}" rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <link rel="stylesheet" href="/resources/demos/style.css">
    
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cluster</div>

                <div id="accordion" class="panel-body">
                    <h1> Approved Clusters </h1>
                    <div id="view-approved-clusters" class="row">
                        
                        <table id="approved-clusters-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Cluster Code</td>
                                    <td>Setting</td>
                                    <td>View</td>
                                    <td>Delete</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approved as $cluster)
                                    <tr>
                                        <td>{{ $cluster->name }}</td>
                                        <td>{{ $cluster->cluster_code }}</td>
                                        <td>
                                            @if($cluster->setting == "1")
                                                Setting 1
                                            @elseif($cluster->setting == "2")
                                                Setting 2
                                            @elseif($cluster->setting == "3")
                                                Setting 3
                                            @elseif($cluster->setting == "4")
                                                Setting 4
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/viewCluster/{{ $cluster->id }}">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fa fa-btn fa-eye"></i>View Cluster
                                                </button>
                                            </a>
                                        </td>
                                        <td><button type='button' class='btn btn-danger btn-sm modal-button raised leave-cluster-button' data-toggle='modal' data-target='#leave-cluster-modal' data-id='{{$cluster->id}}'>Leave Cluster</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    <h1> Pending Clusters </h1>
                    <div id="view-pending-clusters" class="row">
                        
                        <table id="pending-clusters-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Cluster Code</td>
                                    <td>Setting</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending as $cluster)
                                    <tr>
                                        <td>{{ $cluster->name }}</td>
                                        <td>{{ $cluster->cluster_code }}</td>
                                        <td>
                                            @if($cluster->setting == "1")
                                                Setting 1
                                            @elseif($cluster->setting == "2")
                                                Setting 2
                                            @elseif($cluster->setting == "3")
                                                Setting 3
                                            @elseif($cluster->setting == "4")
                                                Setting 4
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    <h1> Create Cluster </h1>
                    <div id="create-cluster" class="row">
                        
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addCluster') }}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('cluster_name') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Cluster Name</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="cluster_name" value="{{ old('cluster_name') }}">

                                    @if ($errors->has('cluster_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cluster_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cluster_setting') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Cluster Setting</label>

                                <div class="col-md-8">
                                    <input type="radio" name="cluster_setting" value="1" {{ session('setting', '1') == '1' ? 'checked' : '' }}> Setting 1<br>
                                    <input type="radio" name="cluster_setting" value="2" {{ session('setting', '1') == '2' ? 'checked' : '' }}> Setting 2<br>
                                    <input type="radio" name="cluster_setting" value="3" {{ session('setting', '1') == '3' ? 'checked' : '' }}> Setting 3<br>
                                    <input type="radio" name="cluster_setting" value="4" {{ session('setting', '1') == '4' ? 'checked' : '' }}> Setting 4<br>

                                    @if ($errors->has('cluster_setting'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cluster_setting') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cluster_actions') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Actions Allowed</label>

                                <div class="col-md-8">
                                    @foreach($actions as $action)
                                        <input type="checkbox" name="{{ $action->name }}" value="true">   {{ $action->name }}<br>
                                    @endforeach

                                    @if ($errors->has('cluster_action'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cluster_action') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-8">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-pencil"></i>Create Cluster
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h1> Join Cluster </h1>
                    <div id="join-cluster" class="row">
                        
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/joinCluster') }}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('cluster_code') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Cluster Code</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="cluster_code" value="{{ old('cluster_code') }}">

                                    @if ($errors->has('cluster_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cluster_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-8">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-plus"></i>Join Cluster
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leave Cluster Modal -->
<div id="leave-cluster-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Leave Cluster</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to leave this cluster?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default raised pull-right" data-dismiss="modal" style="margin-left:1%">Close</button>
                <form action="/leaveCluster" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="cluster_id" id="leave-cluster-id-modal" value=""/>
                    <button class="btn btn-danger raised pull-right">
                        <i class="fa fa-btn fa-trash-o"></i>Leave Cluster
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/cluster.js') }}"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#accordion" ).accordion();
        });
    </script>
@endsection