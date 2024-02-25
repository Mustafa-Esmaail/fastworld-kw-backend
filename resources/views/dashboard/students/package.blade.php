{{-- update package --}}
<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal{{ $row->id }}">@lang('site.packageStatus')</button>
<div class="row">
    <!-- Modal -->
    <div class="modal fade" id="myModal{{ $row->id }}" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang('site.up_package_id')</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.updatePackage') }}" method='post'>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" value="{{ $row->id }}" name="id">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('site.package')</label>
                                    <select class="form-control" name="package_id">
                                        @foreach ( App\Models\Package::get() as $Package)
                                            <option {{ (isset($row) && $row->up_package_id == $Package->id) ? 'selected style=color:red ': '' }} value="{{$Package->id}}"> {{$Package->name ?? '-'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>@lang('site.ustatus')</label>
                                <select name="ustatus" class="form-control">
                                    <option value="">@lang('site.chooese_status')</option>
                                    <option value="pending" {{  $row->ustatus=='pending' ? 'selected' : '' }}>@lang('site.pending')</option>
                                    <option value="accept" {{  $row->ustatus=='accept' ? 'selected' : '' }}>@lang('site.accept')</option>
                                    <option value="reject" {{  $row->ustatus=='reject' ? 'selected' : '' }}>@lang('site.reject')</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">@lang('site.description')</label>
                                <textarea name="description" id=""  class="form-control ckeditor">{{ $row->ureplay }}</textarea>
                            </div>
                            <div class="col-md-6">
                                    <button type="submit" class="btn btn-md btn-info">@lang('site.submit')</button>
                                </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('site.Close')</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end update package --}}
