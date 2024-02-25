{{ csrf_field() }}
<div class="row" style="margin: 0 !important;">

<div class="col-md-12">
    <div class="form-group">
        <label>@lang('site.name')</label>
        <input type="name" class="form-control  @error('name') is-invalid @enderror" name="name"
            value="{{ isset($row) ? $row->name : old('name') }}">
        @error('name')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label>@lang('site.description')</label>
        <input type="description" class="form-control  @error('description') is-invalid @enderror" name="description"
            value="{{ isset($row) ? $row->description : old('description') }}">
        @error('description')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>
</div>
@php
$models = [
    'users',
    'roles',
    'messages',
    'notifications',
];
$maps = ['create', 'read', 'update', 'delete'];
$models1 = [
    'students',
    'teachers',
    'settings',
];
$maps1 = ['read', 'update', 'delete'];

@endphp



@foreach ($models as $index => $model)
<div class="list-group col-md-3" style="padding-left: 15px !important; padding-right: 15px !important;">
    <a href="#" class="list-group-item active">
        @lang('site.'.$model)
    </a>
    @foreach ($maps as $map)
    <label><input type="checkbox" name="permissions[]"
            {{ isset($row) && $row->hasPermission($map . '-' . $model) ? 'checked' : '' }}
            value="{{ $map . '-' . $model }}"> @lang('site.'.$map)</label>
    <hr>
    @endforeach
</div>

@endforeach

@foreach ($models1 as $index1 => $model1)
<div class="list-group col-md-3" style="padding-left: 15px !important; padding-right: 15px !important;">
    <a href="#" class="list-group-item active">
        @lang('site.'.$model1)
    </a>
    @foreach ($maps1 as $map1)
    <label><input type="checkbox" name="permissions[]"
            {{ isset($row) && $row->hasPermission($map1 . '-' . $model1) ? 'checked' : '' }}
            value="{{ $map1 . '-' . $model1 }}"> @lang('site.'.$map1)</label>
    <hr>
    @endforeach
</div>

@endforeach
