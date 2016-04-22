@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if($isAdministrator == 1)
                        <a href="{{URL::to('/branches')}}">Branches</a>
                        <a href="{{URL::to('/roles')}}">Roles</a>
                        <a href="{{URL::to('/users')}}">Users</a>
                    @endif
                    @if($isAdministrator != 1)
                        <a href="{{URL::to('/structure')}}">Structure</a>
                    @endif
                    @if(in_array(7,$activities))
                        <a href="{{URL::to('/upload')}}">Upload</a>
                    @endif
                    @if(in_array(6,$activities))
                        <a href="{{URL::to('/clusters')}}">Clusters</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

