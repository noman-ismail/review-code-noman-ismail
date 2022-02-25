@include("admin.province.layouts.header")
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
          <h6 class="fs-17 font-weight-600 mb-0">Death Claims Request</h6>
        </div>
        <div class="text-right">
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
          @if(session()->has("warning"))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              {!! session("warning") !!}
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
                <th>User Name</th>
                <th>Death Reason</th>
                <th>Death Place</th>
                <th>Death Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="text-dark">
            @if(count($record) > 0)
              @php
                $i=1;
              @endphp
              @foreach($record as $value)
                @php
                  $get_user_info = get_user_detail($value->user_id);
                @endphp
                <tr class="" >
                  <td>{{ ($get_user_info)?$get_user_info['name']:"" }}</td>
                  <td>{{ $value->death_reason }}</td>
                  <td>{{ $value->death_place }}</td>
                  <td>{{ date('d/m/Y',strtotime($value->death_date)) }}</td>
                  <td>{{ $value->status }}</td>
                  <td>

                    @if ($value->status == 'pending')
                      <a href="#" data-id = '{{ $value->id }}' data-toggle="modal" data-target="#ApproveModal" class="text-success fa fa-check " title="Approve"></a>&nbsp;&nbsp;
                      <a href="#" class="text-danger fa fa-times" data-id = '{{ $value->id }}' title="Reject" data-toggle="modal" data-target="#RejectModal"></a>
                    @elseif($value->status == 'approved')
                      <a href="#" data-id = '{{ $value->id }}' class="text-success fas fa-dollar-sign " title="Payment" data-toggle="modal" data-target="#viewModal"></a>
                    @endif
                    &nbsp;&nbsp;
                    <a href="#" data-id = '{{ $value->id }}' data-toggle="modal" data-target="#viewModal" class="text-info fa fa-eye view" title="View"></a>
                    {{-- <a href="{{ route('death-claim').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
                      <i class="fa fa-trash"></i>
                    </a> --}}
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
          <h5 class="modal-title" id="RejectModalLabel">Death Claim Request Rejection</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body viewmodalbody2">
          <input type="hidden" class="hid-id" value="">
          <span class="success-msg" style="color:green"></span>
          <span class="eror-msg" style="color:red"></span>
          <div class="form-group">
            <label for="">Please enter reeson for rejection of death claim</label>
            <input type="text" class="reason form-control">
          </div>
          <div class="text-right mt-2">
            <button class="btn btn-primary rej-btn">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ApproveModal" tabindex="-1" role="dialog" aria-labelledby="ApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ApproveModalLabel">Death Claim Request Approval </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body viewmodalbody3">
          <input type="hidden" class="hid-id" value="">
          <span class="success-msg" style="color:green"></span>
          <span class="eror-msg" style="color:red"></span>
          <div class="form-group">
            <label for="">Please enter price for death claim</label>
            <input type="number" class="price-amount form-control">
          </div>
          <div class="text-right mt-2">
            <button class="btn btn-primary appr-btn">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $('.fa-dollar-sign').click(function(){
        $('#viewModalLabel').html('Death Claim Payment');
        $('.viewmodalbody').html('');
        var id = $(this).attr('data-id');
        $.ajax({
          url:baseURL+"death-claim-requests",
          method:'POST',
          dataType:'html',
          data:{
            action:'payment',
            id:id,
            _token:_token,
          }, success:function(res){
            $('#viewModalLabel').html('Death Claim Payment');
            $('.viewmodalbody').html(res);
          }, error:function(e){
            console.log(e);
            alert('Failed to view detail. Please refresh page and try again');
          }
        });
      });
      $('.appr-btn').click(function(){
        var t = $(this);
        t.attr('disabled',true);
        var id = $('.hid-id').val();
        var reason = $('.price-amount').val().trim();
        if(parseInt(reason) > 0){
          $.ajax({
            url:baseURL+"death-claim-requests",
            method:'POST',
            dataType:'json',
            data:{
              action:'approve',
              id:id,
              reason:reason,
              _token:_token,
            }, success:function(res){
              if(res == 'success'){
                $('.eror-msg').html('');
                $('.success-msg').html('Death claim request is approved successfully');
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
          $('.eror-msg').html('Please enter valid amount for death claim');
          $('.success-msg').html('');          
        }
      })
      $('.rej-btn').click(function(){
        var t = $(this);
        t.attr('disabled',true);
        var id = $('.hid-id').val();
        var reason = $('.reason').val().trim();
        if(reason != ''){
          $.ajax({
            url:baseURL+"death-claim-requests",
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
                $('.success-msg').html('Death claim request is rejected successfully');
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
      $('.fa-check').click(function(){
        var id = $(this).attr('data-id');
        $('.hid-id').val(id);
      });
      $('.fa-times').click(function(){
        var id = $(this).attr('data-id');
        $('.hid-id').val(id);
      });
      $('.view').click(function(){
        $('#viewModalLabel').html('Death Claim Payment');
        $('.viewmodalbody').html('');
        var id = $(this).attr('data-id');
        $.ajax({
          url:baseURL+"death-claim-requests",
          method:'POST',
          dataType:'html',
          data:{
            action:'view',
            id:id,
            _token:_token,
          }, success:function(res){
            $('#viewModalLabel').html('Death claim Request Detail');
            $('.viewmodalbody').html(res);
          }, error:function(e){
            alert('Failed to view detail. Please refresh page and try again');
          }
        });
      });
    })
  </script>
@include("admin.province.layouts.footer")