@php
  $cities_collection = collect($cities);
  $userss = collect($admin_users);
  $str = array();
  if (!empty(request('year'))) {
    $str[] = "year=".request('year');
  }
  if (!empty(request('panel'))) {
    $str[] = "panel=".request('panel');
  }
  if (!empty(request('date_from'))) {
    $str[] = "date_from=".request('date_from');
  }
  if (!empty(request('date_to'))) {
    $str[] = "date_to=".request('date_to');
  }
  if (!empty($str)) {
    $query_querystr = "?".implode('&', $str);
  }else{
    $query_querystr = "";
  }
@endphp
@include('admin.province.layouts.header')
<style>
  .security label{
    display: inline-block;
     width: 45px;
    height: 45px;
    margin: 7px;
    /*margin: 6px 14px 6px;*/
  }
  .security label > input:checked + i{
    border: 3px solid #b212e6;
    color: #b212e6;
  }
  .security label > input {
    visibility: hidden;
    position: absolute;
  }
  .security label > i {
    vertical-align: middle;
    font-size: 28px;
    color: green;
  }
  .security label > input + i {
    cursor: pointer;
    border: 2px solid rgb(0, 128, 0);
    margin: 0px 5px 0px 0px;
    padding: 3px;
    border-radius: 5px;
    box-shadow: 0 0 black;
    width: 100%;
    text-align: center;
  }
</style>
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Fund Requests Report</h6>
        </div>
        <div class="text-right">
          <a href="{{ route('fund-pdf').$query_querystr }}" class="btn btn-sm btn-danger">Generate PDF</a>
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
          <table class="table table-bordered table-hover">
            <thead class="bg-info text-white">
              <tr>
                <th>#</th>
                <th>Request From</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @foreach($record as $key => $value)
                @php
                  $_c = $cities_collection->where('id',$value->district)->first();
                  $_u = $userss->where('id',$value->user_id)->first();
                @endphp
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ ($_c) ? $_c->name : "" }}</td>
                  <td>{{ ($_u) ? $_u->name : "" }}</td>
                  <td>{{ $value->amount }}</td>
                  <td>{{ (!empty($value->date))?date('d/m/y',strtotime($value->date)):"" }}</td>
                  <td>{{ ucfirst($value->status) }}</td>
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
  <style>
    @media only screen(max-width: 768px){
      .custom-modal {
          max-width: 858px;
          margin: 1.75rem auto;
      }
    }
  </style>
@include('admin.province.layouts.footer')