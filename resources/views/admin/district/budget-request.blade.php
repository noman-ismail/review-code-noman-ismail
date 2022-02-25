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
          <h6 class="fs-17 font-weight-600 mb-0">Budget Requested List </h6>
        </div>
        {{-- <div class="text-right">
          <a href="{{ route('budget-list') }}" class="btn btn-sm btn-secondary">Budget List</a>
          <a href="{{ route('add-budget') }}" class="btn btn-sm btn-info">Add New</a>
        </div> --}}
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
          <table class="table">
            <thead class="bg-info text-white">
              <tr>
                <th>Request From</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @php
                $i=1;
              @endphp
              @foreach($record as $key => $value)
                <tr class="" >
                  <td>{{ get_DeptName($value->reqst_from , $value->type) }}</td>
                  <td>{{ $value->title }}</td>
                  <td>{{ $value->amount }}</td>
                  <td>{{ (!empty($value->due_date))?date('d/m/y',strtotime($value->due_date)):"" }}</td>
                  <td>{{ date('d/m/Y',strtotime($value->created_at)) }}</td>
                  <td>{{ ucfirst($value->status) }}</td>
                  <td>
                      @if ($value->status == 'pending')
                        <a href="{{ route('budget-request')."?approve=".$value->id }}" onclick="return confirm('Are you sure to approved this budget ?')" class="text-success fa fa-check " title="Approve"></a>&nbsp;&nbsp;
                        <a href="#" class="text-danger fa fa-times" data-id = '{{ $value->id }}' title="Reject" data-toggle="modal" data-target="#RejectModal"></a>
                      @elseif($value->status == 'approved')
                        <a href="#" data-id = '{{ $value->id }}' class="text-success fas fa-dollar-sign " title="Payment" data-toggle="modal" data-target="#viewModal"></a>
                      @endif
                      &nbsp;&nbsp;
                      <a href="#" data-id = '{{ $value->id }}' data-toggle="modal" data-target="#viewModal" class="text-info fa fa-eye view" title="View"></a>
                  </td>
                </tr>
                @php
                  $i++;
                @endphp
              @endforeach
            @else
              <tr class="text-center bg-default">
                <td colspan="7">There is no record</td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div><!--/.body content-->
  <!-- Modal -->
  <style>
    @media only screen(max-width: 768px){
      .custom-modal {
          max-width: 858px;
          margin: 1.75rem auto;
      }
    }
  </style>
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
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
  <div class="modal fade" id="RejectModal" tabindex="-1" role="dialog" aria-labelledby="RejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RejectModalLabel">Budget Request Rejection</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="hid-id" value="">
          <span class="success-msg" style="color:green"></span>
          <span class="eror-msg" style="color:red"></span>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Please enter reeson for rejection of request</label>
                <input type="text" class="reason form-control">
              </div>
            </div>
          </div>
          <div class="text-right mt-2">
            <button class="btn btn-primary rej-btn">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $('.fa-dollar-sign').click(function(){
        $('.viewmodalbody').html('Loading......');
        var id = $(this).attr('data-id');
        $.ajax({
          url:baseURL+"budget-request",
          method:'POST',
          dataType:'html',
          data:{
            action:'payment',
            id:id,
            _token:_token,
          }, success:function(res){
            $('#viewModalLabel').html('Budget Payment');
            $('.viewmodalbody').html(res);
          }, error:function(e){
            console.log(e);
            alert('Failed to view detail. Please refresh page and try again');
          }
        });
      });
      $('.rej-btn').click(function(){
        var t = $(this);
        t.attr('disabled',true);
        var id = $('.hid-id').val();
        var reason = $('.reason').val().trim();
        if(reason != ''){
          $.ajax({
            url:baseURL+"budget-request",
            method:'POST',
            dataType:'json',
            data:{
              action:'reject',
              id:id,
              reason:reason,
              _token:_token,
            }, success:function(res){
              if(res == 'success'){
                $('.eror-msg').html('');
                $('.success-msg').html('Budget request is rejected successfully');
                var selector = $('a[data-id='+id+']');
                selector.prev('a').remove();
                setTimeout(function(){ location.reload(); }, 3000);
              }else{
                t.attr('disabled',false);
                $('.eror-msg').html(res);
                $('.success-msg').html('');              
              }
            }, error:function(e){
              t.attr('disabled',false);
              console.log(e);
              alert('Failed to view detail. Please refresh page and try again');
            }
          });
        }else{
          t.attr('disabled',false);
          $('.eror-msg').html('Please enter reason');
          $('.success-msg').html('');          
        }
      })
      $('.fa-times').click(function(){
        var id = $(this).attr('data-id');
        $('.reason').val('')
        $('.hid-id').val(id);
      });
      $('.view').click(function(){
        $('.viewmodalbody').html('Loading......');
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