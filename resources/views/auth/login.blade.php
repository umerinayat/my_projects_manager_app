@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-4 login-bg " id="col-1">
            <div class="text-center" style="margin-top:50px;margin-bottom:50px">
                <img src="/images/umerinayat-full-stack-web-developer.jpg"  alt="logo">
            </div>
            <div class="login-form">
            <h2 style="color:white" class="text-center"><b>Sign in</b></h2>
            <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            
                            <div class="col-md-8" style="margin:0px auto">
                            <label for="email" style="color:white" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-8" style="margin:0px auto">
                            <label style="color:white" for="password" class=" col-form-label ">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8" style="margin:0px auto">
                                <button type="submit" id="ls-btn"  class="btn btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            
                             @if (Route::has('password.request'))
                                    <a style="color:white;" class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>

                        <div class="form-group text-center mt-5">
                            
                           
                             
                        </div>

                        <div class="form-group text-center">
                        @if (Route::has('register'))
                             
                            <a style="color:white;font-size:16px;" class="btn btn-link"  href="{{ route('register') }}"> Create Account</a>
                                
                            @endif
                        </div>


                    </form>
            </div>



        </div>
        <div class="col-sm-8" id="col-1" style="padding:0">
           <img src="/images/login-side-img.jpg" width="100%" height="100%" alt="logo-side-image">
        </div>
    </div>
</div>

<!-- footer -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" style="padding:0">
                <div class="footer">

                </div>
            </div>
        </div>
    </div>


@endsection
