@extends('layouts.app')

@section('title')
    CommonClusters - Upload
@endsection

@section('css')
    <link href="{{ URL::asset('assets/css/upload.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>

                <div class="panel-body">
                    <div class="row">
                        <div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#addClient">Add Client</a></li>
                                <li><a data-toggle="tab" href="#addLoan">Add Loan</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="addClient" class="tab-pane fade in active">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div id="client-upload-status" class="row">
                                                <!-- <div class="alert alert-success">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong id="success-number"></strong> rows were successfully processed.
                                                </div>
                                                <div class="alert alert-danger">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong id="failed-number"></strong> rows were not processed.
                                                </div> -->
                                            </div>
                                            <form id="upload-client-csv" class="form-horizontal" role="form" data-url="{{URL::to('/clientsCSV')}}">
                                                Select file to upload:
                                                {!! csrf_field() !!}
                                                <div>
                                                    <input style="margin-left:1%;" type="file" name="fileToUpload" id="client-file">
                                                    <input style="margin:1%;" class="btn btn-info btn-md" type="submit" value="Validate Client File" name="submit">
                                                </div>
                                            </form>
                                            <div id="client-display-summary" class="row">
                                                <table id="client-summary-table" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td>Client ID</td>
                                                            <td>Last Name</td>
                                                            <td>First Name</td>
                                                            <td>Middle Name</td>
                                                            <td>Birthdate</td>
                                                            <td>Birthplace</td>
                                                            <td>Gender</td>
                                                            <td>Marital Status</td>
                                                            <td>House Number and Street</td>
                                                            <td>Barangay</td>
                                                            <td>Group Name</td>
                                                            <td>Center Name</td>
                                                            <td>Client Type</td>
                                                            <td>Status</td>
                                                            <!-- <td>Action</td>    For Merging -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <form action="/approveClientsCSV" method="post" id="approve-clients-csv">
                                                {!! csrf_field() !!}
                                                <button type="submit" id="client-approve-button" class="btn btn-primary" disabled>
                                                    <i class="fa fa-btn fa-thumbs-up"></i>  Upload to Database
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="addLoan" class="tab-pane fade">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div id="loan-upload-status" class="row">
                                                <!-- <div class="alert alert-success">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong id="success-number"></strong> rows were successfully processed.
                                                </div>
                                                <div class="alert alert-danger">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong id="failed-number"></strong> rows were not processed.
                                                </div> -->
                                            </div>
                                            <form id="upload-loan-csv" class="form-horizontal" role="form" data-url="{{URL::to('/loansCSV')}}">
                                                Select file to upload:
                                                {!! csrf_field() !!}
                                                <div>
                                                    <input style="margin-left:1%;" type="file" name="fileToUpload" id="loan-file">
                                                    <input style="margin:1%;" class="btn btn-info btn-md" type="submit" value="Validate Loan File" name="submit">
                                                </div>
                                            </form>
                                            <div id="loan-display-summary" class="row">
                                                <table id="loan-summary-table" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td>Client</td>
                                                            <td>ID</td>
                                                            <td>Type</td>
                                                            <td>Cycle Number</td>
                                                            <td>Release Date</td>
                                                            <td>Princpal Amount</td>
                                                            <td>Interest Amount</td>
                                                            <td>Principal Balance</td>
                                                            <td>Interest Balance</td>
                                                            <td>Active</td>
                                                            <td>Released</td>
                                                            <td>Status</td>
                                                            <td>Maturity Date</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <form action="/approveLoansCSV" method="post" id="approve-loans-csv">
                                                {!! csrf_field() !!}
                                                <button type="submit" id="loan-approve-button" class="btn btn-primary" disabled>
                                                    <i class="fa fa-btn fa-thumbs-up"></i>  Upload to Database
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Merge Clients -->
<!-- <div id="clientModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> -->

    <!-- Modal content-->
        <!-- <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Merge Client</h4>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add-center-submit">
                    <i class="fa fa-btn fa-pencil"></i>  Merge
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div> -->
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/upload.js') }}"></script>
    <!-- // <script src="{{ URL::asset('assets/js/structure.js') }}"></script> -->
@endsection

