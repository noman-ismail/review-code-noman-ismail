@if (auth('admin')->user()->type == 'province')
    @include('admin.province.layouts.header')
@elseif(auth('admin')->user()->type == 'admin')
    @include('admin.layout.header')
@elseif(auth('admin')->user()->type == 'national')
    @include('admin.national.layouts.header')
@endif
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Authors List</h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{url('/'.admin.'/authors')}}" class="btn {{ Request::segment(2)=='authors'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                                <a href="{{url('/'.admin.'/authors/list')}}" class="btn {{ Request::segment(2)=='authors'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Authors List</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has('flash_message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session('flash_message') !!}</strong>
                    </div>
                    @endif
                    @if (Session::has('flash_message2'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session('flash_message2') !!}</strong>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-10">
                            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                                <thead>
                                    <tr>
                                        <td><strong>#</strong></td>
                                        <td><strong>Name</strong></td>
                                        <td><strong>Status</strong></td>
                                        <td><strong>Post</strong></td>
                                        <td><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key)
                                    @php
                                        
                                     $post = \App\Models\Blogs::where(['author' => $key->id])->get()->count();
                                    @endphp
                                    <tr>
                                        <td>{{$key->id}}</td>
                                        <td>{{$key->name}}</td>
                                        @if ($key->status ==="publish")
                                        @php
                                        $icon = "text-success fa fa-check";
                                        $title = "Publish";
                                        $url = url('/'.admin.'/authors?draft='.$key->id)
                                        @endphp
                                        @else
                                        @php
                                        $icon = "text-danger fa fa-times";
                                        $title = "Draft";
                                        $url = url('/'.admin.'/authors?publish='.$key->id)
                                        @endphp
                                        @endif
                                        <td> <a href="{{ $url }}" class="{{ $icon }} fa-lg change-status" data-id="{{ $key->id }}" title="{{ $title }}"></a>
                                        </td>
                                        <td>{{ $post }}</td>
                                        <td>
                                            <a href="{{url('/'.admin.'/authors?edit='.$key->id)}}" class="btn-success-soft  mr-1 fa fa-edit" title="Edit"></a>
                                            <a href="{{url('/'.admin.'/authors?delete='.$key->id)}}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            @if ($data->lastPage() > 1)
                            <nav class="d-flex justify-content-center">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->url(1) }}"><i class="fa fa-chevron-left"></i></a>
                                    </li>
                                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                                        <li class="page-item {{ ($data->currentPage() == $i) ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class=" page-item">
                                        <a class="page-link" href="{{ $data->url($data->currentPage()+1) }}"><i class="fa fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (auth('admin')->user()->type == 'province')
    @include('admin.province.layouts.footer')
@elseif(auth('admin')->user()->type == 'admin')
    @include('admin.layout.footer')
@elseif(auth('admin')->user()->type == 'national')
    @include('admin.national.layouts.footer')
@endif
