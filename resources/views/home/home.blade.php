@extends('layouts.app')

@section('title')
    CommonClusters - Home
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/home.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body col-md-offset-1">
                    @if($isAdministrator == 1)
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{URL::to('/branches')}}"><button><i class="glyphicon glyphicon-tree-conifer"></i>Branches</button></a>
                            </div>
                            <div class="col-md-9 alert alert-info">
                                <strong>Create or edit branch</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{URL::to('/roles')}}"><button><i class="glyphicon glyphicon-link"></i>Roles</button></a>
                            </div>
                            <div class="col-md-9 alert alert-info">
                                <strong>Create or edit roles in order to authorize users to access certain modules</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{URL::to('/users')}}"><button><i class="glyphicon glyphicon-user"></i>Users</button></a>
                            </div>
                            <div class="col-md-9 alert alert-info">
                                <strong>Approve users and edit company information</strong>
                            </div>
                        </div>
                    @endif
                    @if($isAdministrator != 1)
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{URL::to('/structure')}}"><button><i class="glyphicon glyphicon-folder-open"></i>Structure</button></a>
                            </div>
                            <div class="col-md-9 alert alert-info">
                                <strong>Organize, add, and edit client information</strong>
                            </div>
                        </div>
                        @if(in_array(7,$activities))
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{URL::to('/upload')}}"><button><i class="glyphicon glyphicon-circle-arrow-up"></i>Upload</button></a>
                                </div>
                                <div class="col-md-9 alert alert-info">
                                    <strong>Upload client, loan, and transaction information using a CSV file.</strong>
                                </div>
                            </div>
                        @endif
                        @if(in_array(6,$activities))
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{URL::to('/clusters')}}"><button><i class="glyphicon glyphicon-globe"></i>Clusters</button></a>
                                </div>
                                <div class="col-md-9 alert alert-info">
                                    <strong>Join or create clusters where you can share client information</strong>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

