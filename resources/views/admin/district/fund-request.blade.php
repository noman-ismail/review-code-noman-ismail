@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if($__userType == 'province')
  @include('admin.province.layouts.header')
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
          <h6 class="fs-17 font-weight-600 mb-0">Fund Requested List <span style="font-size: 12px">(For Receiving)</span></h6>
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
                <th>Username</th>
                <th>Amount</th>
                <th>Date</th>
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
                  <td>{{ get_DeptName($value->district , 'district') }}</td>
                  <td>{{ GetUserName($value->user_id) }}</td>
                  <td>{{ $value->amount }}</td>
                  <td>{{ (!empty($value->date))?date('d/m/y',strtotime($value->date)):"" }}</td>
                  <td>
                    @if ($value->status == 'Deliver')
                      <a href="{{ route('fund-request')."?approve=".$value->id }}" onclick="return confirm('Are you sure want to approved this budget ?')" class="text-success fa fa-check " title="Accept"></a>&nbsp;&nbsp;
                      <a href="#" class="text-danger fa fa-times" data-id = '{{ $value->id }}' title="Reject" data-toggle="modal" data-target="#RejectModal"></a>
                        &nbsp;&nbsp;
                      <a href="#" data-id = '{{ $value->id }}' data-toggle="modal" data-target="#viewModal" class="text-info fa fa-eye view" title="View"></a>
                    @else
                      <a href="#" data-id = '{{ $value->id }}' data-toggle="tooltip" class="text-secondary view" data-placement="top" title="Click to View Detail">
                        <span data-toggle="modal" data-target="#viewModal">{{ $value->status }}</span>
                      </a>
                    @endif
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalLabel">Fund Request Detail</h5>
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
          <h5 class="modal-title" id="RejectModalLabel">Fund Request Rejection</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pl-3 pr-3">
          <input type="hidden" class="hid-id" value="">
          <span class="success-msg" style="color:green"></span>
          <span class="eror-msg" style="color:red"></span>
          <div class="form-group">
            <label for="">Please enter reeson for rejection of request</label>
            <input type="text" class="reason form-control">
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
      $('.view').tooltip()
      $('.rej-btn').click(function(){
        var t = $(this);
        t.attr('disabled',true);
        var id = $('.hid-id').val();
        var reason = $('.reason').val().trim();
        // alert((parseInt(reason)/parseInt(100))*parseInt(20));
        if(reason != ''){
          $.ajax({
            url:"{{ route('fund-request') }}",
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
                $('.success-msg').html('Fund request is rejected successfully');
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
              alert('Failed to generate request. Please refresh page and try again');
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
        $('.hid-id').val(id);
      });
      $('.fa-eye , .view').click(function(){
        var id = $(this).attr('data-id');
        var url = '{{ route('transfer-to-province') }}';
        $.ajax({
          url:url,
          method:'post',
          dataType:'html',
          data:{
            action:'view_detail',
            id:id,
            _token:_token,
          },success:function(e){
            $('.viewmodalbody').html(e);
          },error:function(e){
            alert('Unknown Error..!  Please refresh page and try again');
          }
        })
      })
    })
  </script>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif