@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/addBranch') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('branch_name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Branch Name</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="branch_name" value="{{ old('branch_name') }}">

                                @if ($errors->has('branch_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('branch_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-pencil"></i>Add Branch
                                </button>
                            </div>
                        </div>
                    </form>
                    <h1> Branches: </h1>
                    <table id="branches-table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr>
                                    <td>{{ $branch->name }}
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

@section('javascript')
    <!-- // <script src="{{ URL::asset('assets/js/users.js') }}"></script> -->
@endsection
