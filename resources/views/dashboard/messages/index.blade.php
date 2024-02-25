@extends('dashboard.layouts.app')

@section('title', __('site.' . $module_name_plural))


@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.' . $module_name_plural)</h1>

            <ol class="breadcrumb">
                <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><i class="fa fa-category"></i> @lang('site.' . $module_name_plural)</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h1 class="box-title"> @lang('site.' . $module_name_plural) <small>{{ count($rows) }}</small></h1>

                    <form action="{{ route('dashboard.' . $module_name_plural . '.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                                    placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                                    @lang('site.search')</button>

                            </div>
                        </div>
                    </form>
                </div> {{-- end of box header --}}

                <div class="box-body">
                    
                <div class="row">
                    <div class="col-md-4">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="box box-primary direct-chat direct-chat-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title">Direct Chat</h3>
              
                            <div class="box-tools pull-right">
                              <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                <i class="fa fa-comments"></i></button>
                              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                              <!-- Message. Default to the left -->
                              <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                  <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  Is this template really for free? That's unbelievable!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
              
                              <!-- Message to the right -->
                              <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                  <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  You better believe it!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
                            </div>
                            <!--/.direct-chat-messages-->
              
                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                              <ul class="contacts-list">
                                <li>
                                  <a href="#">
                                    <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">
              
                                    <div class="contacts-list-info">
                                          <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date pull-right">2/28/2015</small>
                                          </span>
                                      <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                  </a>
                                </li>
                                <!-- End Contact Item -->
                              </ul>
                              <!-- /.contatcts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer">
                            <form action="#" method="post">
                              <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-primary btn-flat">Send</button>
                                    </span>
                              </div>
                            </form>
                          </div>
                          <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                      <!-- /.col -->
                      <div class="col-md-4">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="box box-primary direct-chat direct-chat-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title">Direct Chat</h3>
              
                            <div class="box-tools pull-right">
                              <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                <i class="fa fa-comments"></i></button>
                              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                              <!-- Message. Default to the left -->
                              <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                  <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  Is this template really for free? That's unbelievable!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
              
                              <!-- Message to the right -->
                              <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                  <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  You better believe it!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
                            </div>
                            <!--/.direct-chat-messages-->
              
                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                              <ul class="contacts-list">
                                <li>
                                  <a href="#">
                                    <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">
              
                                    <div class="contacts-list-info">
                                          <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date pull-right">2/28/2015</small>
                                          </span>
                                      <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                  </a>
                                </li>
                                <!-- End Contact Item -->
                              </ul>
                              <!-- /.contatcts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer">
                            <form action="#" method="post">
                              <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-primary btn-flat">Send</button>
                                    </span>
                              </div>
                            </form>
                          </div>
                          <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                      <!-- /.col -->
                      <div class="col-md-4">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="box box-primary direct-chat direct-chat-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title">Direct Chat</h3>
              
                            <div class="box-tools pull-right">
                              <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                              {{-- <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                <i class="fa fa-comments"></i></button> --}}
                              {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                              <!-- Message. Default to the left -->
                              <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                  <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  Is this template really for free? That's unbelievable!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
              
                              <!-- Message to the right -->
                              <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                  <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="{{asset('uploads/students/default.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  You better believe it!
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
                            </div>
                            <!--/.direct-chat-messages-->
              
                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                              <ul class="contacts-list">
                                <li>
                                  <a href="#">
                                    <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">
              
                                    <div class="contacts-list-info">
                                          <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date pull-right">2/28/2015</small>
                                          </span>
                                      <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                  </a>
                                </li>
                                <!-- End Contact Item -->
                              </ul>
                              <!-- /.contatcts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer">
                            <form action="#" method="post">
                              <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-primary btn-flat">Send</button>
                                    </span>
                              </div>
                            </form>
                          </div>
                          <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                      <!-- /.col -->
                </div>


                    {{-- @if ($rows->count() > 0) --}}

                        {{-- <div class="table-responsive">

                            <table class="table table-hover" id="example">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.investor')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.message')</th>
                                        <th>@lang('site.file')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($rows as $index => $row)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $row->investor->first_name ?? '-' }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->investor->phone ?? '-' }}</td>
                                            <td>
                                                @if ($row->file != null)
                                                    <a href="{{ $row->file_path }}" target="_blank"> <i
                                                            class="fa fa-download"></i> </a>
                                                @else
                                                    <p class="text-center"></p>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="" data-toggle="modal"
                                                    href='#myModal{{ $row->id }}'><i class="fa fa-eye"></i> </button>
                                            </td>
                                            <div class='container'>
                                                <div class="modal fade" id="myModal{{ $row->id }}">
                                                    <div class="modal-dialog" role="dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">@lang('site.elements')</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $row->message }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">@lang('site.Close')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            </td>
                                            <td>
                                                @if (auth()->user()->hasPermission('delete-' . $module_name_plural))
                                                    @include('dashboard.buttons.delete')
                                                @else
                                                    <input type="submit" value="delete" disabled>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div> --}}
                        {{-- {{$rows->appends(request()->query())->links()}} --}}
                    {{-- @else
                        <tr>
                            <h4>@lang('site.no_records')</h4>
                        </tr>
                    @endif --}}

                </div> {{-- end of box body --}}

            </div> {{-- end of box --}}

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
