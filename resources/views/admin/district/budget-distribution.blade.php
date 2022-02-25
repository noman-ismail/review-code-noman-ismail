@php
  $collected_fff = get_collected_fund(auth('admin')->user()->dept_id);
  $remining_bdg = find_remaining_bdg(); 
  $consumed_bdg = find_consumed_bdg();
  // $pending_bdg = find_pending_bdg();
  $used = $collected_fff - $remining_bdg ;
  $pending_bdg = $used - $consumed_bdg ;
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
          <h6 class="fs-17 font-weight-600 mb-0">Budget Allocation List</h6>
        </div>
        <div class="text-right">
          <a href="{{ route('budget-distribution') }}" class="btn btn-sm btn-secondary">Budget List</a>
          <a href="{{ route('budget-allocate') }}" class="btn btn-sm btn-success">Allocate New Budget</a>
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
                <th colspan="2">Title</th>
                <th colspan="2">Allocate To</th>
                <th colspan="2">Amount</th>
                <th colspan="2">Date</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @php
                $i=1;
                // dd($record);
              @endphp
              @foreach($record as $key => $value)
                <tr>
                  <td colspan="2">{{ $value->title }}</td>
                  <td colspan="2">{{ get_DeptName($value->reqst_to , $value->type) }}</td>
                  <td colspan="2">{{ $value->amount }}</td>
                  <td colspan="2">{{ date('d/m/Y',strtotime($value->created_at)) }}</td>
                  {{-- <td>
                      @if ($value->status == 'pending')
                        <a href="{{ route('budget-request')."?approve=".$value->id }}" onclick="return confirm('Are you sure to approved this budget ?')" class="text-success fa fa-check " title="Approve"></a>&nbsp;&nbsp;
                        <a href="#" class="text-danger fa fa-times" data-id = '{{ $value->id }}' title="Reject" data-toggle="modal" data-target="#RejectModal"></a>
                      @elseif($value->status == 'approved')
                        <a href="#" data-id = '{{ $value->id }}' class="text-success fas fa-dollar-sign " title="Payment" data-toggle="modal" data-target="#viewModal"></a>
                      @endif
                      &nbsp;&nbsp;
                      <a href="#" data-id = '{{ $value->id }}' data-toggle="modal" data-target="#viewModal" class="text-info fa fa-eye view" title="View"></a>
                  </td> --}}
                </tr>
                @php
                  $i++;
                @endphp
              @endforeach
            @else
              <tr class="text-center bg-default">
                <td colspan="8">There is no record</td>
              </tr>
            @endif
              <tr>
                  <th class="bg-success text-white">Total Collected Fund</th>
                  <td class="bg-success text-white">{{ $collected_fff }}</td>
                  <th class="bg-danger text-white">Total Consumed</th>
                  <td class="bg-danger text-white">{{ $consumed_bdg }}</td>
                  <th class="bg-warning text-black">Total Pending</th>
                  <td class="bg-warning text-black">{{ $pending_bdg }}</td>
                  <th class="bg-info text-white">Total Remaining</th>
                  <td class="bg-info text-white">{{ $remining_bdg }}</td>       
              </tr>
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
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
      $('.view').click(function(){
        $('.viewmodalbody').html('Loading......');
        var id = $(this).attr('data-id');
        $.ajax({
          url:baseURL+"budget-distribution",
          method:'POST',
          dataType:'html',
          data:{
            action:'view',
            id:id,
            _token:_token,
          }, success:function(res){
            $('#viewModalLabel').html('Budget Allocate Detail');
            $('.viewmodalbody').html(res);
          }, error:function(e){
            alert('Failed to view detail. Please refresh page and try again');
          }
        });
      });
    })
  </script>
@include('admin.province.layouts.footer')