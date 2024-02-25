   
<button type="button" class="btn btn-warning btn-xs" data-toggle="modal"   href='#myModalstatus{{ $row->id }}'>@lang('site.status')</button></td>
<div   class='container'>
    <div class="modal fade" id="myModalstatus{{ $row->id }}" >
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{$row->title}}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('dashboard.approve')}}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{$module_name_plural}}">
                        <input type="hidden" name="id" value="{{$row->id}}">
                        <div class="form-group">
                            <select name="admin_status" class='form-control' id="">
                                <option value="">@lang('site.choose_status')</option>
                                <option value="pending" {{ $row->admin_status='pending' ? 'selected' : ''}}>@lang('site.pending')</option>
                                <option value="reject" {{ $row->admin_status='reject' ? 'selected' : ''}}>@lang('site.reject')</option>
                                <option value="accept" {{ $row->admin_status='accept' ? 'selected' : ''}}>@lang('site.accept')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="reason"  class="form-control">{{$row->reason}}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit">@lang('site.edit')</button>
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
{{-- end modal --}}