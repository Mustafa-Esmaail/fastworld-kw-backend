 {{ csrf_field() }}

 @foreach (config('translatable.locales') as $index => $locale)
 <div class="col-md-6">
     <div class="form-group">
         <label>@lang('site.' . $locale . '.title')</label>
         <input type="text" class="form-control @error($locale . ' .title') is-invalid
     @enderror " name=" {{ $locale }}[title]"
             value="{{ isset($row) ? $row->translate($locale)->title : old($locale . '.title') }}">

         @error($locale . '.title')
             <small class=" text text-danger" role="alert">
                 <strong>{{ $message }}</strong>
             </small>
         @enderror
     </div>
 </div>
@endforeach
@foreach (config('translatable.locales') as $locale)
 <div class="col-md-6">
     <div class="form-group">
         <label>@lang('site.' . $locale . '.description')</label>
         <textarea  class="form-control ckeditor  @error($locale . ' .description') is-invalid  @enderror " name=" {{ $locale }}[description]" cols="30" rows="10">{{ isset($row) ? $row->translate($locale)->description : old($locale . '.description') }}</textarea>
         @error($locale .'.description')
             <small class=" text text-danger" role="alert">
                 <strong>{{ $message }}</strong>
             </small>
         @enderror
     </div>
 </div>
@endforeach
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.url')</label>
        <input type="url" class="form-control" id="" name="url"  @error('url') is-invalid @enderror"  value="{{ isset($row) ? $row->url : old('url') }}">
        @error('url')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>

</div>
<div class="col-md-6">
    <div class="form-group">
        <label>@lang('site.image')</label>
        <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
        @error('image')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="form-group col-md-3">
    <img src="{{ isset($row) ? $row->image_path : asset('uploads/posts/default.png') }}" style="width: 115px;height: 80px;position: relative;
                    top: 14px;" class="img-thumbnail image-preview">
</div>



