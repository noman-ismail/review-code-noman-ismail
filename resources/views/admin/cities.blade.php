@include("admin.layout.header")
@php
  $procinces = DB::table('province')->select('id')->orderby('sort','asc')->get();
  if(count($procinces) > 0){
    foreach ($procinces as $value) {
      $custom_order[] = $value->id;
    }
    $collection = collect($record);
    // $new_record = $collection->sort(function ($a, $b) use ($custom_order) {
    //   $pos_a = array_search($a->province, $custom_order);
    //   $pos_b = array_search($b->province, $custom_order);
    //   return $pos_a - $pos_b;
    // });
  }else{
    $new_record = $record;
  }
    $new_record = $record;
@endphp
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Cities List</h6>
        </div>
        <div class="text-right">
        </div>
      </div>
    </div>
    <form action="{{ (isset($get_data) and !empty($get_data))?route('cities').'?id='.request('id'):route('cities') }}" method="POST">
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
        </div>
        <div class="col-md-5">
          <fieldset>
            <legend>Add New City</legend>
            @if(session()->has("success"))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session("success") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="form-group">
              <label for="" class="font-weight-600">Province Name <span class="required">*</span></label>
              <select name="province" class="form-control form-control-chosen">
                @if (count($province) > 0)
                  @foreach ($province as $value)
                    <option value="{{ $value->id }}" {{ ((old('province') == $value->id)?"selected":(isset($get_data) and !empty($get_data) and $get_data->province == $value->id))?"selected":"" }}>{{ $value->name }}</option>
                  @endforeach
                @endif
              </select>
                @if(count($errors) > 0)
                  @foreach($errors->get('province') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <div class="form-group">
              @php
                if (old('full_name')) {
                  $full_name = old('full_name');
                }elseif(isset($get_data) and !empty($get_data)){
                  $full_name = $get_data->name;
                }else{
                  $full_name = "";
                }
              @endphp
              <label for="" class="font-weight-600">City Full Name <span class="required">*</span></label>
              <input type="text" name="full_name" class="form-control" value="{{ $full_name }}" placeholder="Enter City Name"> 
                @if(count($errors) > 0)
                  @foreach($errors->get('full_name') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <div class="form-group">
              @php
                if (old('short_name')) {
                  $short_name = old('short_name');
                }elseif(isset($get_data) and !empty($get_data)){
                  $short_name = $get_data->short_name;
                }else{
                  $short_name = "";
                }
              @endphp
              <label for="" class="font-weight-600">City Short Name <span class="required">*</span></label>
              <input type="text" name="short_name" class="form-control" value="{{ $short_name }}" placeholder="Enter City Name"> 
                @if(count($errors) > 0)
                  @foreach($errors->get('short_name') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <button class="btn btn-info" name="{{ (isset($get_data) and !empty($get_data))?'edit':'add' }}">Submit</button>
          </fieldset>
        </div>
        <div class="col-md-7">
          <table class="table table-striped">
            <thead class="bg-info text-white">
              <tr>
                <th>Sr. No</th>
                <th>Province Name</th>
                <th>Full Name</th>
                <th>Short Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="">
            @if(count($new_record) > 0)
              @php $i = 0; @endphp
              @foreach($new_record as $value)
                <tr data-index = '{{ $value->id }}' data-position=''>
                  <td>{{ ++$i }}</td>
                  <td>{{ get_province_name($value->province) }}</td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->short_name }}</td>
                  <td>
                    <a href="{{ route('cities').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                    {{-- <a href="{{ route('cities').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');"><i class="fa fa-trash"></i></a> --}}
                  </td>
                </tr>
              @endforeach
            @else
              <tr class="text-center bg-info">
                <td colspan="5">There is no record</td>
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
@include("admin.layout.footer")