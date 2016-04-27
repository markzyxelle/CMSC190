@extends('layouts.app')

@section('title')
    CommonClusters - Branches
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/scrollabletable.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Branches</div>

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
                    <div id="branches-div">
                        <table id="branches-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branches as $branch)
                                    <tr>
                                        <td>{{ $branch->name }}</td>
                                        <td><button type='button' class='btn btn-info btn-sm modal-button raised edit-branch-button' data-toggle='modal' data-target='#edit-branch-modal' data-id="{{$branch->id}}">Edit Branch</button></td>
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

<!-- Edit Branch -->
<div id="edit-branch-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Branch</h4>
            </div>
            <div class="modal-body">
                <div id="edit-branch-div">
                    <form action="/editBranch" method="post" id="edit-branch-form" class="form-horizontal" role="form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="branch_id" id="branch-id-modal" value=""/>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Branch Name</label>

                            <div class="col-md-8">
                                <input type="text" id="branch-name" class="form-control required-text" name="branch_name" value="">

                                <span class="help-block required">
                                    <strong>This field is required</strong>
                                </span>
                                <span class="help-block max">
                                    <strong>Please limit number of characters to 255</strong>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="edit-branch-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Submit
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/branches.js') }}"></script>
@endsection
