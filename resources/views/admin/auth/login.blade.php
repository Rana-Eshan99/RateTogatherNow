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
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email"  name="email" value="{{old('email')}}" class="form-control"
                           placeholder="Email">
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
                    <input type="password" id="password" required name="password" class="form-control"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="input-group-addon"><i id="PassShowHide" toggle="#password" class="fa fa-eye toggle-password"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
                        <p class="mb-1">
                            <a href="">I forgot my password</a>
                        </p>
            <p class="mb-1">
                <a href="{{ route('register') }}">Register a new users</a>
            </p>

        </div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
