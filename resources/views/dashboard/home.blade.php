@extends('dashboard.layouts.app')

@section('content')
    <div class="content-wrapper" style="min-height: 0">

        <section class="content-header">

            <h1>@lang('site.dashboard')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">
            {{-- users --}}
            <div class="row">
                @if (auth()->user()->can('read-users'))
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box">
                            <div class="inner">
                                <h3>{{ count(App\User::get()) }}</h3>

                                <p>@lang('site.users')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->can('read-roles'))
                    {{-- roles --}}
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box">
                            <div class="inner">
                                <h3>{{ count(App\Role::get()) }}</h3>

                                <p>@lang('site.roles')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-hourglass-half"></i>
                            </div>
                            <a href="{{ route('dashboard.roles.index') }}" class="small-box-footer">@lang('site.read') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    {{-- categories --}}
                @endif
                @if (auth()->user()->can('read-owners'))
                    {{-- students --}}
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box">
                            <div class="inner">
                                <h3>{{ count(App\Models\Owner::get()) }}</h3>

                                <p>@lang('site.owners')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{ route('dashboard.owners.index') }}" class="small-box-footer">@lang('site.read') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    {{-- categories --}}
                @endif
              
               

            </div><!-- end of row -->




        </section><!-- end of content -->
        {{-- @include('dashboard.layouts._char') --}}

    </div><!-- end of content wrapper -->
@endsection


@push('script')
@endpush
