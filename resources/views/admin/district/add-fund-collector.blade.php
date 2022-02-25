@include("admin.district.layouts.header")
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Fund Collectors List</h6>
        </div>
        <div class="text-right">
        </div>
      </div>
    </div>
    <form action="{{ route('fund-collector') }}" method="POST">
    @csrf
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if(session()->has("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {!! session("success") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        </div>
        <div class="col-md-5">
          <fieldset>
            <legend>Add New Fund Collector</legend>
            <div class="form-group">
              <label for="" class="font-weight-600">Choose Collector Name<span class="required">*</span></label>
              <select name="name" class="form-control form-control-chosen">
                <option value="">Choose an Option</option>
                @if(count($users) > 0)
                  @foreach ($users as $value)
                    @php
                      $get_user_info = get_userinfo_detail($value->id);
                      $dsg = get_user_off_dsg($value->designation);
                    @endphp
                    <option value="{{ $value->id }}">{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?$get_user_info['personnel_no']." - ":"" }}{{ $value->name." - ".$dsg." - ".$value->cnic }}</option>
                    {{-- <option value="{{ $value->id }}">{{ $value->name }}{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?" - ".$get_user_info['personnel_no']:"" }}</option> --}}
                  @endforeach
                @endif
              </select>
                @if(count($errors) > 0)
                  @foreach($errors->get('name') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <button class="btn btn-success">Submit</button>
          </fieldset>
        </div>
        <div class="col-md-7">
          <table class="table table-striped">
            <thead class="bg-info text-white">
              <tr>
                <th>Sr. No</th>
                <th>Collector Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="">
              @if(count($record) > 0)
                @php
                  $i = 0;
                @endphp
                @foreach($record as $value)
                  @php
                    $user_detail = get_user_detail($value->user_id);
                    $dsg =  ($user_detail) ? " - ".get_user_off_dsg($user_detail['designation']) : "";
                    $cnic = ($user_detail) ? " - ".$user_detail['cnic'] : "";
                    $name = ($user_detail) ? $user_detail['name'] : "";
                  @endphp
                  <tr data-index = '{{ $value->id }}' data-position=''>
                    <td>{{ ++$i }}</td>
                    <td>
                      {{ (!empty($value->personnel_no))?$value->personnel_no." - ":"" }}{{ $name.$dsg }}
                    </td>
                    <td>
                      @if ($value->status == 'off')
                        <a href="{{ route('fund-collector').'?del='.$value->id }}" title="Un-Ban">
                          <i class="fa fa-check-circle"></i>
                        </a>
                      @else
                        <a href="{{ route('fund-collector').'?del='.$value->id }}" title="Ban">
                          <i class="fa fa-ban"></i>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr class="text-center bg-info">
                  <td colspan="3">There is no record</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </form>
  </div>
</div><!--/.body content-->
@include("admin.district.layouts.footer")