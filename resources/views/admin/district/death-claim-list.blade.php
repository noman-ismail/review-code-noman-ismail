@include("admin.district.layouts.header")
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
          <h6 class="fs-17 font-weight-600 mb-0">Death Claims List</h6>
        </div>
        <div class="text-right">
          <a href="{{ route('death-claim-list') }}" class="btn btn-sm btn-secondary">Death Claims List</a>
          <a href="{{ route('death-claim') }}" class="btn btn-sm btn-success">Add New</a>
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
                <tr class="" >
                  <td>{{ GetLoginUserName($value->user_id) }}</td>
                  <td>{{ $value->death_reason }}</td>
                  <td>{{ $value->death_place }}</td>
                  <td>{{ date('d/m/Y',strtotime($value->death_date)) }}</td>
                  <td>{{ $value->status }}</td>
                  <td>
                    @if ($value->status == 'pending')
                      <a href="{{ route('death-claim').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('death-claim').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    @else
                      <span class="text-success">{{ ucfirst($value->status) }}</span>
                      {{-- expr --}}
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
  <script>
    if ($(window).width() < 540) {
      $('table').addClass('table-responsive');
    }else{
      $('table').removeClass('table-responsive');
    }
    $(window).resize(function(){
        var w = $(window).width();
        if (w < 540){
        $('table').addClass('table-responsive');
        }else{
        $('table').removeClass('table-responsive');
      }
    });
  </script>
@include("admin.district.layouts.footer")