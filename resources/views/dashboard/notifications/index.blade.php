@extends('dashboard.layouts.app')

@section('title', __('site.'.$module_name_plural))


@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.'.$module_name_plural)</h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
            </li>
            <li class="active"><i class="fa fa-bell"></i> @lang('site.'.$module_name_plural)</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h1 class="box-title"> @lang('site.'.$module_name_plural) <small></small></h1>


            </div> {{--end of box header--}}

            <div class="box-body">
                <form action="{{route('dashboard.'.$module_name_plural.'.store')}}" method="post">
                    @csrf
                    <div class="row">
                       
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">@lang('site.country')</label>
                                <select class="form-control @error('country_id') is-invalid @enderror" id="country_id" name="country_id">
                                    <option value="">@lang('site.choose_country_id')</option>
                                    @foreach ( App\Models\Country::get() as $country)
                                     <option {{ (isset($row) && $row->country_id == $country->id) ? 'selected style=color:red ': '' }} value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">@lang('site.city')</label>
                                <select class="form-control  @error('city_id') is-invalid @enderror" id="city_id" name="city_id">
                        
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">@lang('site.category')</label>
                                <select class="form-control  @error('category_id') is-invalid @enderror" id="exampleFormControlSelect1" name="category_id">
                                    <option value="">@lang('site.chooese_category_id')</option>
                                    @foreach ( App\Models\Category::get() as $Category)
                                     <option {{ (isset($row) && $row->category_id == $Category->id) ? 'selected style=color:red ': '' }} value="{{$Category->id}}">{{$Category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">@lang('site.package')</label>
                                <select class="form-control @error('package_id') is-invalid @enderror" id="exampleFormControlSelect1" name="package_id">
                                    <option value="">@lang('site.chooese_package_id')</option>
                                    @foreach ( App\Models\Package::get() as $Package)
                                     <option {{ (isset($row) && $row->package_id == $Package->id) ? 'selected style=color:red ': '' }} value="{{$Package->id}}">{{$Package->name}}</option>
                                    @endforeach
                                </select>
                        
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >@lang('site.investor')</label>
                                <select class="form-control" id="exampleFormControlSelect1"  name="investor_id">
                                    <option value="">@lang('site.chooese_investor')</option>
                                    @foreach ( App\Models\Investor::get() as $Investor)
                                      <option {{ old('investor_id') == $Investor->id ? 'selected style=color:red ': '' }} value="{{$Investor->id}}">{{$Investor->first_name . ' ' . $Investor->last_name. '-' . $Investor->phone}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.body_ar')</label>
                                <textarea name="body_ar" class="form-control ckeditor" >{{ old('body_ar') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.body_en')</label>
                                <textarea name="body_en" class="form-control ckeditor" >{{ old('body_en') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class=""></i>
                                @lang('site.send')</button>
                        </div>

                    </div>
                </form>

            </div> {{--end of box body--}}

        </div> {{--  end of box--}}

    </section><!-- end of content -->

</div><!-- end of content wrapper -->

@endsection
