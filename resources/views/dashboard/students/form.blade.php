{{ csrf_field() }}


<div class="col-md-4">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.fullname')</label>
        <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="name" name="fullname"   value="{{ isset($row) ? $row->fullname : old('fullname') }}">
        @error('fullname')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.phone')</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"   value="{{ isset($row) ? $row->phone : old('phone') }}">
        @error('phone')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="email">@lang('site.email')</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ isset($row) ? $row->email : old('email') }}">
        @error('email')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="password">@lang('site.password')</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"  name="password">
        @error('password')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="password">@lang('site.password_confirmation')</label>
        <input type="password" class="form-control" id="password_confirmation"  name="password_confirmation" @error('password_confirmation') is-invalid @enderror">
        @error('password_confirmation')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.verify_account')</label>
        <select class="form-control @error('verify_account') is-invalid @enderror" id="exampleFormControlSelect1" name="verify_account">
            <option {{ (isset($row) && $row->verify_account == true) ? 'selected style=color:red ': '' }} value="1" >
                @lang('site.yes')
            </option>
            <option {{ (isset($row) && $row->verify_account == false) ? 'selected style=color:red ': '' }} value="0" >
                @lang('site.no')
            </option>
        </select>
        @error('verify_account')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.block')</label>
        <select class="form-control  @error('block') is-invalid @enderror" id="exampleFormControlSelect1" name="block">
            <option {{ (isset($row) && $row->block == "1") ? 'selected style=color:red ': '' }} value='1' >
                @lang('site.yes')
            </option>
            <option {{ (isset($row) && $row->block == "0") ? 'selected style=color:red ': '' }} value="0" >
                @lang('site.no')
            </option>
        </select>
        @error('block')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.gender')</label>
        <select class="form-control  @error('gender') is-invalid @enderror" id="exampleFormControlSelect1" name="gender">
            <option {{ (isset($row) && $row->gender == "male") ? 'selected style=color:red ': '' }} value='male' >
                @lang('site.male')
            </option>
            <option {{ (isset($row) && $row->gender == "female") ? 'selected style=color:red ': '' }} value="female" >
                @lang('site.female')
            </option>
        </select>
        @error('gender')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.block_reason')</label>
        <input type="text" class="form-control @error('block_reason') is-invalid @enderror" id="name" name="block_reason"   value="{{ isset($row) ? $row->block_reason : old('block_reason') }}">
        @error('block_reason')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>@lang('site.image')</label>
        <input type="file" name="avater" class="form-control image @error('avater') is-invalid @enderror">
        @error('avater')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>

<div class="form-group col-md-2">
    <img src="{{ isset($row) ? $row->image_path : asset('uploads/students/default.png') }}" style="width: 115px;height: 80px;position: relative;
                    top: 14px;" class="img-thumbnail image-preview">
</div>


