@extends('layouts.app')

@section('title')
    CommonClusters - Login
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div id="myCarousel" class="carousel slide col-md-5 col-md-offset-1" data-ride="carousel">
        <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <center><img src="{{ URL::asset('images/image_1.jpg') }}" alt="Chania"></center>
                </div>

                <div class="item">
                    <center><img src="{{ URL::asset('images/image_2.jpg') }}" alt="Chania"></center>
                </div>

                <div class="item">
                    <center><img src="{{ URL::asset('images/image_3.jpg') }}" alt="Chania"></center>
                </div>

                <div class="item">
                    <center><img src="{{ URL::asset('images/image_4.jpg') }}" alt="Chania"></center>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="col-md-5 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li class="{{ session('status', 'default') == 'default' ? 'active' : '' }}"><a data-toggle="tab" href="#login">Login</a></li>
                <li class="{{ session('status', 'default') == 'company' ? 'active' : '' }}"><a data-toggle="tab" href="#registerCompany">New MFI</a></li>
                <li class="{{ session('status', 'default') == 'user' ? 'active' : '' }}"><a data-toggle="tab" href="#registerUser">New User</a></li>
            </ul>

            <div class="tab-content">
                <div id="login" class="tab-pane{{ session('status', 'default') == 'default' ? ' fade in active' : ' fade' }} ">
                    <div class="panel panel-default">
                        <div class="panel-heading">Login</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                {!! csrf_field() !!}

                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Username</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Password</label>

                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i>Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="registerCompany" class="tab-pane{{ session('status', 'default') == 'company' ? ' fade in active' : ' fade' }} ">
                    <div class="panel panel-default">
                        <div class="panel-heading">Register New MFI</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">MFI Name</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">

                                        @if ($errors->has('company_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('company_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Short Name</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="shortname" value="{{ old('shortname') }}">

                                        @if ($errors->has('shortname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('shortname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('regcompname') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Name</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="regcompname" value="{{ old('regcompname') }}">

                                        @if ($errors->has('regcompname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regcompname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('regcompusername') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Username</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="regcompusername" value="{{ old('regcompusername') }}">

                                        @if ($errors->has('regcompusername'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regcompusername') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('regcompemail') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-8">
                                        <input type="email" class="form-control" name="regcompemail" value="{{ old('regcompemail') }}">

                                        @if ($errors->has('regcompemail'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regcompemail') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('regcomppassword') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Password</label>

                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="regcomppassword">

                                        @if ($errors->has('regcomppassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regcomppassword') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('regcomppassword_confirmation') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="regcomppassword_confirmation">

                                        @if ($errors->has('regcomppassword_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regcomppassword_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i>Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="registerUser" class="tab-pane{{ session('status', 'default') == 'user' ? ' fade in active' : ' fade' }} ">
                    <div class="panel panel-default">
                        <div class="panel-heading">Register New User</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register-user') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('regusercode') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Company Code</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="regusercode" value="{{ old('regusercode') }}">

                                        @if ($errors->has('regusercode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regusercode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('regusername') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Name</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="regusername" value="{{ old('regusername') }}">

                                        @if ($errors->has('regusername'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('regusername') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('reguserusername') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Username</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="reguserusername" value="{{ old('reguserusername') }}">

                                        @if ($errors->has('reguserusername'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('reguserusername') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('reguseremail') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-8">
                                        <input type="email" class="form-control" name="reguseremail" value="{{ old('reguseremail') }}">

                                        @if ($errors->has('reguseremail'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('reguseremail') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('reguserpassword') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Password</label>

                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="reguserpassword">

                                        @if ($errors->has('reguserpassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('reguserpassword') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('reguserpassword_confirmation') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="reguserpassword_confirmation">

                                        @if ($errors->has('reguserpassword_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('reguserpassword_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i>Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
