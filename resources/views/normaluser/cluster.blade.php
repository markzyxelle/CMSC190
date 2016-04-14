@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cluster</div>

                <div class="panel-body">
                    <div id="create-cluster" class="row">
                        <h1> Create Cluster </h1>
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
                    <div id="join-cluster" class="row">
                        <h1> Join Cluster </h1>
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
                    <div id="view-approved-clusters" class="row">
                        <h1> Approved Clusters: </h1>
                        <table id="approved-clusters-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Cluster Code</td>
                                    <td>Setting</td>
                                    <td>Action</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                    <div id="view-approved-clusters" class="row">
                        <h1> Pending Clusters: </h1>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@endsection