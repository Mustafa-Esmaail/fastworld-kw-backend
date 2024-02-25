<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('site.statue')</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/home')? 'active':''}}"><a href="{{ route('dashboard.home') }}"><i
                class="fa fa-dashboard"></i><span>@lang('site.dashboard')</span></a></li>

            @if (auth()->user()->hasPermission('read-users'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/users*')? 'active':''}}"><a href="{{ route('dashboard.users.index') }}"><i
                        class="fa fa-users"></i><span>@lang('site.users')</span></a></li>
            @endif

            @if (auth()->user()->can('read-roles'))
                <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/roles*')? 'active':''}}"><a href="{{ route('dashboard.roles.index') }}"><i
                        class="fa fa-hourglass-half"></i><span>@lang('site.roles')</span></a></li>
            @endif

            {{-- @if (auth()->user()->hasPermission('read-owners'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/owners*')? 'active':''}}"><a href="{{ route('dashboard.owners.index') }}"><i
                        class="fa fa-user"></i><span>@lang('site.owners')</span></a></li>
            @endif --}}

            {{-- @if (auth()->user()->hasPermission('read-teachers'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/teachers*')? 'active':''}}"><a href="{{ route('dashboard.teachers.index') }}"><i
                        class="fa fa-money"></i><span>@lang('site.teachers')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read-messages'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/messages*')? 'active':''}}"><a href="{{ route('dashboard.messages.index') }}"><i
                        class="fa fa-envelope"></i><span>@lang('site.messages')</span></a></li>
            @endif --}}
            {{-- @if (auth()->user()->hasPermission('read-notifications'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/notifications*')? 'active':''}}"><a href="{{ route('dashboard.notifications.index') }}"><i
                        class="fa fa-bell"></i><span>@lang('site.notifications')</span></a></li>
            @endif --}}
            {{-- @if (auth()->user()->hasPermission('read-settings'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/settings*')? 'active':''}}"><a href="{{ route('dashboard.settings.edit',\App\Models\Setting::first()) }}"><i
                        class="fa fa-bell"></i><span>@lang('site.settings')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-lessons'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/lessons*')? 'active':''}}"><a href="{{ route('dashboard.lessons.index') }}"><i
                        class="fa fa-bell"></i><span>@lang('site.lessons')</span></a></li>
            @endif
           
            @if (auth()->user()->hasPermission('read-lives'))
            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/lives*')? 'active':''}}"><a href="{{ route('dashboard.lives.index') }}"><i
                        class="fa fa-bell"></i><span>@lang('site.lives')</span></a></li>
            @endif --}}
        </ul>

    </section>

</aside>
