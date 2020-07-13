@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-4 login-bg " id="col-1">
            <div class="text-center" style="margin-top:50px;margin-bottom:50px">
                <img src="/images/umerinayat-full-stack-web-developer.jpg"  alt="logo">
            </div>
            <div class="login-form">
            <h3 style="color:white" class="text-center"><b>Create New Account</b></h3>
            <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                        
                            <div class="col-md-8" style="margin:0px auto">
                            <label for="name" style="color:white" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                           

                            <div class="col-md-8" style="margin:0px auto">
                            <label for="email" style="color:white" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                          

                            <div class="col-md-8" style="margin:0px auto">
                            <label for="password" style="color:white"  class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group">
                            
                            <div class="col-md-8" style="margin:0px auto">
                            <label for="password-confirm" style="color:white" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        
                        <div class="form-check mb-2">
                            <div class="col-md-8" style="margin:0px auto">
                                <input type="checkbox" class="form-check-input" name="terms" id="terms">
                                <label style="color:white" class="form-check-label"  for="terms">I Accept <a style="color:white; text-decoration:underline"  href="#">Terms</a> </label>
                            </div>
                        </div>

                        

                    
                        <div class="form-group">
                            <div class="col-md-8" style="margin:0px auto">
                                <button type="submit" id="ls-btn"  class="btn btn-block">
                                    Create Account 
                                </button>
                            </div>
                        </div>

                        <div class="form-group text-center mt-5">
                            
                            <p style="color:white;font-size:18px;"> Already have an account? </p>
                             
                        </div>

                        <div class="form-group text-center">
                    
                            <a style="color:white" class="btn btn-link"  href="{{ route('login') }}">{{ __('Login') }}</a>   
                           
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
