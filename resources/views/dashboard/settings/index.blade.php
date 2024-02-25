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
                <form action="{{route('dashboard.'.$module_name_plural.'.update',$row)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.phone')</label>
                                <input type="text" name="phone" class="form-control  @error('phone') is-invalid @enderror" value="{{ $row->phone }}">
                                @error('phone')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.phone2')</label>
                                <input type="text" name="phone2" class="form-control  @error('phone2') is-invalid @enderror" value="{{ $row->phone2 }}">
                                @error('phone2')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.email')</label>
                                <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ $row->email }}">
                                @error('email')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.whatsapp')</label>
                                <input type="text" name="whatsapp" class="form-control  @error('whatsapp') is-invalid @enderror" value="{{ $row->whatsapp }}">
                                @error('whatsapp')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.facebook')</label>
                                <input type="text" name="facebook" class="form-control  @error('facebook') is-invalid @enderror" value="{{ $row->facebook }}">
                                @error('facebook')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.linkedin')</label>
                                <input type="text" name="linkedin" class="form-control  @error('linkedin') is-invalid @enderror" value="{{ $row->linkedin }}">
                                @error('linkedin')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.twitter')</label>
                                <input type="text" name="twitter" class="form-control   @error('twitter') is-invalid @enderror" value="{{ $row->twitter }}">
                                @error('twitter')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('site.tel')</label>
                                <input type="text" name="tel" class="form-control  @error('tel') is-invalid @enderror" value="{{ $row->tel }}">
                                @error('tel')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">@lang('site.website')</label>
                                <input type="url" name="website" class="form-control  @error('website') is-invalid @enderror" value="{{ $row->website }}">
                                @error('website')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class=""></i>
                                @lang('site.save')</button>
                        </div>

                    </div>
                </form>

            </div> {{--end of box body--}}

        </div> {{--  end of box--}}

    </section><!-- end of content -->

</div><!-- end of content wrapper -->

@endsection
