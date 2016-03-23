@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

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
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-pencil"></i>Add Role
                                </button>
                            </div>
                        </div>
                    </form>
                    <h1> Roles: </h1>
                    <table id="roles-table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection