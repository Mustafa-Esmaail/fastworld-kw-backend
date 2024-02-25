@extends('dashboard.layouts.app')

@section('title', __('site.'.$module_name_plural))


@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.'.$module_name_plural)</h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
            </li>
            <li class="active"><i class="fa fa-globe"></i> @lang('site.'.$module_name_plural)</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h1 class="box-title"> @lang('site.'.$module_name_plural) <small>{{count($rows)}}</small></h1>

                <form action="{{route('dashboard.'.$module_name_plural.'.index')}}" method="get">

                    <div class="row">

                        <div class="col-md-2">
                            <input type="text" name="search" value="{{request()->search}}" class="form-control"
                                placeholder="@lang('site.search')">
                        </div>

                        <div class="col-md-2">
                            <select name="block" class="form-control">
                                <option value="">@lang('site.choese_block')</option>
                                <option value="1" {{  request()->block=='1' ? 'selected' : '' }}>@lang('site.yes')</option>
                                <option value="0" {{   request()->block=='0' ? 'selected' : '' }}>@lang('site.no')</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="gender" class="form-control">
                                <option value="">@lang('site.chooese_gender')</option>
                                <option value="male" {{  request()->gender=='male' ? 'selected' : '' }}>@lang('site.male')</option>
                                <option value="female" {{   request()->gender=='female' ? 'selected' : '' }}>@lang('site.female')</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                                @lang('site.search')</button>

                        </div>
                        <div class="col-md-1">
                            @if (auth()->user()->hasPermission('create-' . $module_name_plural))
                                <a href="{{ route('dashboard.' . $module_name_plural . '.create') }}"
                                    class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                                <button disabled>add </button>
                            @endif
                        </div>
                    </div>
                    <!--printTable-->
                </form>
            </div> {{--end of box header--}}

            <div class="box-body">

                @if($rows->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover display" id="example">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.verify_account')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $index=>$row)
                                <tr @if($row->parent_id != null) style='background-color:#ccc;' @endif>
                                    <td>{{++$index}}</td>
                                    <td>{{$row->fullname}}</td>
                                    <td>{{$row->phone }}</td>
                                    <td>{{$row->email }}</td>
                                    <td>
                                        <select name="verify_account_index_student" data-id="{{$row->id}}" >
                                            <option value="" disabled>@lang('site.choose_verify_account')</option>
                                            <option  value="1"  @if(isset($row) && $row->verify_account=="1" ) selected  @endif>@lang('site.Yes')</option>
                                            <option  value="0"  @if(isset($row) && $row->verify_account=="0" )selected  @endif>@lang('site.No')</option>
                                          </select>

                                    </td>
                                    <td>

                                        @if (auth()->user()->hasPermission('update-'.$module_name_plural))
                                            @include('dashboard.buttons.edit')

                                        @else
                                            <input type="submit" value="edit" disabled>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete-'.$module_name_plural))
                                            @include('dashboard.buttons.delete')
                                        @else
                                            <input type="submit" value="delete" disabled>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table> {{--end of table--}}
                </div>
                {{-- {{$rows->appends(request()->query())->links()}} --}}

                @else
                <tr>
                    <h4>@lang('site.no_records')</h4>
                </tr>
                @endif

            </div> {{--end of box body--}}

        </div> {{--  end of box--}}

    </section><!-- end of content -->

</div><!-- end of content wrapper -->
@endsection
