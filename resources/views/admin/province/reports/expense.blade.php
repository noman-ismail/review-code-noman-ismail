@php
  $str = array();
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
@if(auth('admin')->user()->type == 'district')
  @include('admin.district.layouts.header')
@elseif(auth('admin')->user()->type == 'national')
  @include('admin.national.layouts.header')
@elseif(auth('admin')->user()->type == 'province')
  @include('admin.province.layouts.header')
@endif
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Expense Sheet Report</h6>
        </div>
        <div class="text-right">
          <a href="{{ route('expense-pdf').$query_querystr }}" class="btn btn-sm btn-danger">Generate PDF</a>
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
                <th>Title</th>
                <th>Amount</th>
                <th>Entry Date</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @foreach($record as $key => $value)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $value->title }}</td>
                  <td>{{ $value->amount }}</td>
                  <td>{{ date('d/m/Y',strtotime($value->entry_date)) }}</td>
                </tr>
              @endforeach
            @else
              <tr class="text-center bg-default">
                <td colspan="4">There is no record</td>
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
@if(auth('admin')->user()->type == 'district')
  @include('admin.district.layouts.footer')
@elseif(auth('admin')->user()->type == 'national')
  @include('admin.national.layouts.footer')
@elseif(auth('admin')->user()->type == 'province')
  @include('admin.province.layouts.footer')
@endif