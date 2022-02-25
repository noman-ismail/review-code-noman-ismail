@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if ($__userType == 'admin')
  @include('admin.layout.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Notifications And Downloads List</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{ route('create-download') }}" class="btn {{ Request::segment(2)=='download'  &&  Request::segment(3)=='new'  ? 'btn-inverse' : 'btn-info' }} pull-right">Create New</a>
                <a href="{{ route('download-list') }}" class="btn {{ Request::segment(2)=='downloads'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Document List</a>
                @if ($__userType == 'province' || $__userType == 'national')
                  <a href="{{ route('district-notifications-meta') }}" class="btn {{ Request::segment(3)=='notifications-meta' ? 'btn-inverse' : 'btn-info' }} pull-right">Notification Meta</a>
                @endif
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
            <div class="col-md-12">
              <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                <thead>
                  <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Title</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>Action</strong></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $key)
                  <tr>
                    <td>{{$key->id}}</td>
                    <td> {{$key->title}}</td>
                    <td>{{ date("d M Y", strtotime($key->date) )}}</td>
                  <td>
                    <a href="{{url('/'.admin.'/download/new?edit='.$key->id)}}" class="btn-primary-soft  mr-1 fa fa-edit" title="Edit"></a>
                    <a href="{{url('/'.admin.'/download/new?delete='.$key->id)}}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
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
                  <a class="page-link" href="{{ $data->url($data->currentPage()+1) }}" ><i class="fa fa-chevron-right"></i></a>
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
@if ($__userType == 'admin')
  @include('admin.layout.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif