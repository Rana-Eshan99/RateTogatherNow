<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechSwivel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box" >
    <!-- /.login-logo -->
    <div class="container">
        <img src="{{asset('img/logo/logo.png')}}" class="img-responsive" style="width: 100%;margin-bottom: 10px">
    </div>
    <div class="card">

        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{route('password.update')}}" method="post">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{  request()->email }}" required  autocomplete="email" readonly autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                 </span>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password"  name="password" class="form-control"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="input-group-addon"><i id="PassShowHide" toggle="#password" class="fa fa-eye toggle-password"></i></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                         </span>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off" placeholder="Confirmation password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="input-group-addon"><i toggle="#password-confirm" id="PassShowHide" class="fa fa-eye toggle-password"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">

                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary btn-block">Reset Password</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
