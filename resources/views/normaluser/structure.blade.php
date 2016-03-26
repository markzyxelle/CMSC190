@extends('layouts.app')

@section('css')
    <link href="{{ URL::asset('assets/css/structure.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Structure</div>

                <div class="panel-body">
                    <div id="structure-breadcrumb" class="row">
                        <ol class = "breadcrumb">
                           <li class="title-breadcrumb" id="branch-breadcrumb" data-id="{{ $branch->id }}">{{ $branch->name }}</li>
                           <li class="title-breadcrumb" id="center-breadcrumb" data-id=""></li>
                           <li class="title-breadcrumb" id="group-breadcrumb" data-id=""></li>
                        </ol>
                    </div>
                    <div id="structure-buttons" class="row">
                        <button id='add-center-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addCenterModal'>Add Center</button>
                        <button id='add-group-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addGroupModal'>Add Group</button>
                        <button id='add-client-button' type='button' class='btn btn-info btn-sm modal-button pull-right raised' data-toggle='modal' data-target='#addClientModal'>Add Client</button>
                    </div>
                    <div id="structure-body" class="row">
                        <table id="structure-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
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

<!-- Add Center Modal -->
<div id="addCenterModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Center</h4>
            </div>
            <div class="modal-body">
                <form id="add-center-form" class="form-horizontal" role="form" data-url="{{URL::to('/addCenter')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="branch_id" id="branch-id-modal" value="{{ $branch->id }}"/>
                    <div class="form-group{{ $errors->has('center_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Center Name</label>

                        <div class="col-md-8">
                            <input id="center-name" type="text" class="form-control" name="center_name" value="{{ old('center_name') }}">

                            @if ($errors->has('center_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('center_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-center-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Add Group Modal -->
<div id="addGroupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Group</h4>
            </div>
            <div class="modal-body">
                <form id="add-group-form" class="form-horizontal" role="form" data-url="{{URL::to('/addGroup')}}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('group_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Group Name</label>
                        <input type="hidden" name="center_id" id="center-id-modal" value=""/>
                        <div class="col-md-8">
                            <input id="group-name" type="text" class="form-control" name="group_name" value="{{ old('group_name') }}">

                            @if ($errors->has('group_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('group_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-group-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Add Client Modal -->
<div id="addClientModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Client</h4>
            </div>
            <div class="modal-body">
                <form id="add-client-form" class="form-horizontal" role="form" data-url="{{URL::to('/addClient')}}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Client Name</label>
                        <input type="hidden" name="group_id" id="group-id-modal" value=""/>
                        <div class="col-md-8">
                            <input id="client-name" type="text" class="form-control" name="client_name" value="{{ old('client_name') }}">

                            @if ($errors->has('client_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('client_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-client-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Add
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/structure.js') }}"></script>
@endsection