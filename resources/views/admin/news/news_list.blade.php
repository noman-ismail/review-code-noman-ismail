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
@elseif($__userType == 'district')
  @include('admin.district.layouts.header')
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
              <h6 class="fs-17 font-weight-600 mb-0">News List</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/news')}}" class="btn {{ Request::segment(2)=='news'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                <a href="{{url('/'.admin.'/news/list')}}" class="btn {{ Request::segment(2)=='news'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">News List</a>
                @if ($__userType == 'admin')
                  <a href="{{ route('news-meta') }}" class="btn {{ Request::segment(2)=='news-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">News Meta</a>
                @else
                  <a href="{{ route('district-news-meta') }}" class="btn {{ Request::segment(2)=='cabinet' &&  Request::segment(3)=='news-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">News Meta</a>
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
                    <td><strong>Status</strong></td>
                    <td><strong>Views</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>Action</strong></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $key)
                    @if($key->status == 'publish')
                      @php
                        $__urll = route('base_url')."/".$key->slug."-5".$key->id;
                      @endphp
                    @else
                      @php
                        $__urll = "";
                      @endphp
                    @endif
                  <tr>
                    <td>{{$key->id}}</td>
                    <td><a href='{{ (!empty($__urll))?$__urll:"#" }}' target="{{ (!empty($__urll))?"_blank":"" }}">{{$key->title}}</a></td>
                     @if ($key->status ==="publish")
                    @php
                      $icon = "text-success fa fa-check";
                      $title = "Publish";
                      $url = url('/'.admin.'/news?draft='.$key->id)
                    @endphp
                    @else
                    @php
                      $icon = "text-danger fa fa-times";
                      $title = "Draft";
                      $url = url('/'.admin.'/news?publish='.$key->id)
                    @endphp
                    @endif
                    <td class="text-center"> <a href="{{ $url }}" class="{{ $icon }} fa-lg change-status" data-id="{{ $key->id }}" title="{{ $title }}"></a>
                  </td>
                  <td class="text-center" style="width:2%;">{{ total_views( 5 , $key->id)}}</td>
                  <td class="text-center" style="width:12%;">{{ (!empty($key->date))?date("d M Y", strtotime($key->date) ):""}}</td>
                    <td>
                      <a href="{{url('/'.admin.'/news?edit='.$key->id)}}" class="-soft  mr-1 fa fa-edit" title="Edit"></a>
                      <a href="{{url('/'.admin.'/news?delete='.$key->id)}}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
<!--				{{ $data->links() }}-->
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
@elseif($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif

