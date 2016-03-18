@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Company Code : {{ $code }}
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

<!-- Modal -->
<div id="branchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/addBranch') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="user-id-modal" value=""/>
                    <select name="branch_name">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ URL::asset('assets/js/users.js') }}"></script>
@endsection
