@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if($__userType == 'district')
  @include('admin.district.layouts.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
@php
  if(request()->has('pending') and request('pending') == 'true'){
    $vll = 'pending';
  }elseif(request()->has('approved') and request('approved') == 'true'){
    $vll = 'approved';
  }elseif(request()->has('delivered') and request('delivered') == 'true'){
    $vll = 'delivered';
  }elseif(request()->has('rejected') and request('rejected') == 'true'){
    $vll = 'rejected';
  }else{
    $vll = 'all';
  }
  $str = array();
  if (!empty(request('pending'))) {
    $str[] = "pending=".request('pending');
  }
  if (!empty(request('approved'))) {
    $str[] = "approved=".request('approved');
  }
  if (!empty(request('delivered'))) {
    $str[] = "delivered=".request('delivered');
  }
  if (!empty(request('rejected'))) {
    $str[] = "rejected=".request('rejected');
  }
  if (!empty(request('search'))) {
    $str[] = "search=".request('search');
  }
  if (!empty(request('date_to'))) {
    $str[] = "date_to=".request('date_to');
  }
  if (!empty(request('date_from'))) {
    $str[] = "date_from=".request('date_from');
  }
  if (!empty(request('panel'))) {
    $str[] = "panel=".request('panel');
  }
  if (!empty($str)) {
    $query_querystr = "?".implode('&', $str);
  }else{
    $query_querystr = "";
  }
@endphp
<div class="body-content">
  <div class="card border-info mb-4">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Budget List</h6>
        </div>
        <div class="text-right">
          <a class="btn btn-sm {{ ($vll == 'all')?'btn-secondary':'btn-success' }}" href="{{ route('budget-list') }}">All</a>
          <a class="btn btn-sm {{ ($vll == 'pending')?'btn-secondary':'btn-success' }}" href="{{ route('budget-list')."?pending=true" }}">Pending</a>
          <a class="btn btn-sm {{ ($vll == 'delivered')?'btn-secondary':'btn-success' }}" href="{{ route('budget-list')."?delivered=true" }}">Delivered</a>
          <a class="btn btn-sm {{ ($vll == 'approved')?'btn-secondary':'btn-success' }}" href="{{ route('budget-list')."?approved=true" }}">Approved</a>
          <a class="btn btn-sm {{ ($vll == 'rejected')?'btn-secondary':'btn-success' }}" href="{{ route('budget-list')."?rejected=true" }}">Rejected</a>
          <a class="btn btn-sm btn-danger" href="{{ route('budget-list-pdf').$query_querystr }}">Generate PDF</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          @if(session()->has("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {!! session("success") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <div class="_msgtop"></div>
        </div>
        <div class="col-md-12">
          <form action="{{ route('budget-list') }}">
            @if (request()->has('approved'))
              <input type="hidden" name="approved" value="{{ request('approved') }}">
            @elseif(request()->has('pending'))
              <input type="hidden" name="pending" value="{{ request('pending') }}">
            @elseif(request()->has('delivered'))
              <input type="hidden" name="delivered" value="{{ request('delivered') }}">
            @elseif(request()->has('rejected'))
              <input type="hidden" name="rejected" value="{{ request('rejected') }}">
            @endif
            <div class="form-row">
              @if($__userType == 'national')
                <div class="form-group col-md-3">
                  <select class="form-control form-control-chosen" name="panel">
                    <option value="">Choose Requested Panal</option>
                    @if (count($province))
                      @foreach ($province as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              @endif
              <div class="form-group col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Title">
              </div>
              <div class="form-group col-md-2">
                <input type="text" name="date_from" class="form-control" id="date-picker" data-toggle="datepicker" autocomplete="off" placeholder="Date From">
              </div>
              <div class="form-group col-md-2">
                <input type="text" name="date_to" class="form-control" id="date-picker1" data-toggle="datepicker" autocomplete="off" placeholder="Date To">
              </div>
              <div class="form-group col-md-2">
                <button class="btn btn-info w-100">Search</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead class="bg-info text-white">
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Status</th>
                @if ($__userType == 'national')
                  <th>Request To</th>
                @endif
                <th>Request Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @foreach($record as $key => $value)
                <tr class="" >
                  <td>{{ ++$key }}</td>
                  <td>{{ $value->title }}</td>
                  <td>{{ $value->amount }}</td>
                  <td>{{ $value->status }}</td>
                  @if ($__userType == 'national')
                    @php
                      $provvv = $province_collection->where('id',$value->reqst_to)->first();
                    @endphp
                    <td>{{ ($provvv) ? $provvv->name : "" }}</td>
                  @endif
                  <td>{{ date('d/m/Y',strtotime($value->created_at)) }}</td>
                  <td>
                    @if ($value->status == 'pending' || $value->status == 'reject')
                      <a href="{{ route('add-budget').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('add-budget').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
                        <i class="fa fa-trash"></i>
                      </a>
                      <a href="#"  data-toggle="modal" data-target="#viewModal" title="View">
                        <i class="fa fa-eye view" data-id = '{{ $value->id }}'></i>
                      </a>
                    @else
                      <a href="#"  data-toggle="modal" data-target="#viewModal" title="View">
                        <i class="fa fa-eye view" data-id = '{{ $value->id }}'></i>
                      </a>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr class="text-center bg-default">
                <td colspan="6">There is no record</td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalLabel">Budget Request Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body viewmodalbody">
          ...
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $('.dropdown-toggle').click(function(){
        if($('.dropdown-menu').hasClass('show')){
          $('.dropdown-menu').removeClass('show');
        }else{
          $('.dropdown-menu').addClass('show');
        }
      })
      $('.view').click(function(){
        var id = $(this).attr('data-id');
        $.ajax({
          url:baseURL+"budget-request",
          method:'POST',
          dataType:'html',
          data:{
            action:'view',
            id:id,
            _token:_token,
          }, success:function(res){
            $('#viewModalLabel').html('Budget Request Detail');
            $('.viewmodalbody').html(res);
          }, error:function(e){
            alert('Failed to view detail. Please refresh page and try again');
          }
        });
      });
    })
  </script>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif