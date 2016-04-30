@extends('layouts.app')

@section('title')
    CommonClusters - Users
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                    <div class="panel-body">
                        <br>
                        @if ($errors->has('branch_id'))
                            <div class="alert alert-danger">  
                                <a class="close" data-dismiss="alert">×</a>  
                                <strong>Approval Unsuccessful!</strong> {{ $errors->first('branch_id') }}
                            </div> 
                        @endif
                        @if ($errors->has('role_id'))
                            <div class="alert alert-danger">  
                                <a class="close" data-dismiss="alert">×</a>  
                                <strong>Approval Unsuccessful!</strong> {{ $errors->first('role_id') }}
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/editCompany') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-md-3 control-label">Company Code</label>

                                <div class="col-md-8" style="margin-top:0.5%; margin-left:1.2%">
                                    {{ $company->company_code }}
                                    <!-- <input type="text" class="form-control" value="{{ $company->company_code }}" disabled> -->
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Company Name</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="company_name" value="{{ $company->name }}">

                                    @if ($errors->has('company_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('company_shortname') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Company Shortname</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="company_shortname" value="{{ $company->shortname }}">

                                    @if ($errors->has('company_shortname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company_shortname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3 col-md-offset-9">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-pencil"></i>Edit Company
                                    </button>
                                </div>
                            </div>
                        </form>
                        <br />
                        <h1> Approved Users: </h1>
                        <ul id="approved-users-pagination" class="pagination">
                            @for ($i = 0; $i < $approved; $i++)
                                @if ($i == 0)
                                    <li class="active"><a href="#">{{$i+1}}</a></li>
                                @else
                                    <li class=""><a href="#">{{$i+1}}</a></li>
                                @endif
                            @endfor
                        </ul>
                        <table id="approved-users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td>Email</td>
                                    <td>Unapprove</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        <br />
                        <h1> Pending Requests: </h1>
                        <ul id="pending-users-pagination" class="pagination">
                            @for ($i = 0; $i < $pending; $i++)
                                @if ($i == 0)
                                    <li class="active"><a href="#">{{$i+1}}</a></li>
                                @else
                                    <li class=""><a href="#">{{$i+1}}</a></li>
                                @endif
                            @endfor
                        </ul>
                        <table id="pending-users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td>Email</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="branchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approve User</h4>
            </div>
            <div class="modal-body">
                <form id="approve-user-form" class="form-horizontal" role="form" method="POST" action="{{ url('/approveUser') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="user-id-modal" value=""/>
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Role</label>
                        <div class="col-md-6">
                            <select required id="role-form" class="form-control" name="role_id" value="{{ old('role_id') }}">
                                <option value="">None</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->pivot->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div id="branch-div" class="form-group{{ $errors->has('branch_id') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Branch Name</label>
                        <div class="col-md-6">
                            <select required class="form-control" name="branch_id" value="{{ old('branch_id') }}">
                                <option value="">None</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('branch_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('branch_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="approve-user-submit">
                    <i class="fa fa-btn fa-thumbs-up"></i>  Approve
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Unapprove User Modal -->
<div id="unapprove-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Unapprove User</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to unapprove this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default raised pull-right" data-dismiss="modal">Close</button>
                <form action="/unapproveUser" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="unapprove-user-id-modal" value=""/>
                    <button class="btn btn-danger raised pull-right" style="margin-right:1%">
                        <i class="fa fa-btn fa-trash-o"></i>Unapprove User
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/users.js') }}"></script>
@endsection
