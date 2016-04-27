@extends('layouts.app')

@section('title')
    CommonClusters - Roles
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/scrollabletable.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Roles</div>

                <div class="panel-body">
                    @if ($errors->has('company_role_id'))
                        <div class="alert alert-danger">  
                            <a class="close" data-dismiss="alert">×</a>  
                            <strong>Role Addition Unsuccessful!</strong> Role already exists.
                        </div> 
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/addRole') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('role_name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Role Name</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="role_name" value="{{ old('role_name') }}">

                                @if ($errors->has('role_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('role_activities') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Activities Allowed</label>

                            <div class="col-md-8">
                                @foreach($activities as $activity)
                                    <input type="checkbox" name="{{ $activity->id }}" value="true">   {{ $activity->name }}<br>
                                @endforeach

                                @if ($errors->has('role_activities'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_activities') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-pencil"></i>Add Role
                                </button>
                            </div>
                        </div>
                    </form>
                    <h1> Roles: </h1>
                    <div id="roles-div">
                        <table id="roles-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    @foreach($activities as $activity)
                                        <td>{{$activity->name}}</td>
                                    @endforeach
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        @if($role->name != "Administrator")
                                            <td>{{ $role->name }}</td>
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/editRole') }}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="company_role_id" value="{{$role->pivot->id}}"/>
                                            @foreach($activities as $activity)
                                                <td>
                                                    <input type="checkbox" name="{{ $activity->id }}" value="true"
                                                        @if(\App\CompanyRoleActivity::where([["company_role_id", $role->pivot->id], ["activity_id", $activity->id]])->first() != null)
                                                            checked="checked"
                                                        @endif
                                                    />
                                                    
                                                </td>
                                            @endforeach
                                                <td>
                                                    <div class="form-group">
                                                        <div>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-btn fa-pencil"></i>Edit Role
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </form>
                                        @else
                                            <td colspan='9'>{{ $role->name }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection