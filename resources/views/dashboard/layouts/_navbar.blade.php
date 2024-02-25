<header class="main-header">

    {{--<!-- Logo -->--}}
    <a href="{{route('dashboard.home')}}" class="logo">
        {{--<!-- mini logo for sidebar mini 50x50 pixels -->--}}
        <span class="logo-mini">@lang('site.accounting_system')</span>
        <span class="logo-lg">@lang('site.accounting_system')</span>
    </a>

    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src=" {{auth()->user()->image_path}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">

                        {{--<!-- User image -->--}}
                        <li class="user-header">
                            <img src="{{ auth()->user()->image_path }}" class="img-circle" alt="User Image">

                            <p>
                                {{auth()->user()->name }}
                            </p>
                        </li>

                        {{--<!-- Menu Footer-->--}}
                        <li class="user-footer">


                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">@lang('site.logout')</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

</header>
