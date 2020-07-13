<div class="container-fluid">
    <div class="row">
        <div class="col-sm-1 text-center" style="padding:0;margin:0">
               <div class="h-logo" style="padding:20px;background:#9399A6">
                    <img src="/images/umerinayat-full-stack-web-developer.jpg" width="90%" height="90%" alt="">
               </div>
        </div>
        <div class="col-sm-11" style="padding:0;margin:0">
            
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel"  style="padding:20px;height:100%;">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline" >
                            <input  class="form-control mr-sm-2" style="width:400px"  type="search" placeholder="Search" aria-label="Search">
                            <button class="btn new-client-btn">Search</button>
                        </form>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    
                                </div>
                            </li>

                          
                               
                           

                        @endguest
                    </ul>
                </div>
                    

            </nav>

        </div>
    </div>
</div>





