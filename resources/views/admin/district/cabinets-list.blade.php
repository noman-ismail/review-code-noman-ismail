@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if($__userType == 'admin')
  @include('admin.layout.header')
@else
  @php
    $url = route("404");
    echo "<script>
    window.location = '$url';
    </script>";
  @endphp
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
  <div class="card border-info mb-4">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Cabinets Members List</h6>
        </div>
        <div class="text-right">
          <a href="{{ route('cabinets') }}" class="btn btn-sm btn-secondary">Cabinets User List</a>
          <a href="{{ route('add-cabinets') }}" class="btn btn-sm btn-success">Add New</a>
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
          <form action="{{ route('cabinets') }}" class="cabinets-form">
            <div class="form-row">
              <div class="form-group col-md-3">
                @php
                  if(request()->has('type')){
                    $type = request('type');
                  }else{
                    $type = '';
                  }
                @endphp
                <select name="type" class="form-control form-control-chosen type_drop">
                  <option value="">Choose Search Type</option>
                  <option value="national" {{ ($type == 'national')?"selected":"" }}>National</option>
                  <option value="province" {{ ($type == 'province')?"selected":"" }}>Province</option>
                  <option value="district" {{ ($type == 'district')?"selected":"" }}>District</option>
                </select>
              </div>
              <div class="form-group col-md-3 pro-detail" style="display: {{ ($type == 'province')?"block":"none" }}">
                @php
                  if(request()->has('province')){
                    $pr = request('province');
                  }else{
                    $pr = '';
                  }
                @endphp
                <select name="province" class="form-control form-control-chosen province_drop">
                  <option value="">Choose Province</option>
                  @if(count($province) > 0)
                    @foreach($province as $value)
                      <option value="{{ $value->id }}" {{ ($pr == $value->id)?"selected":"" }}>{{ $value->name }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group col-md-3 dis-detail" style="display:{{ ($type == 'district')?"block":"none"  }};">
                @php
                  if(request()->has('district')){
                    $dist = request('district');
                  }else{
                    $dist = '';
                  }
                @endphp
                <select name="district" class="form-control form-control-chosen city_drop">
                  <option value="">Choose District</option>
                  @if(count($cities) > 0)
                    @foreach($cities as $value)
                      <option value="{{ $value->id }}" {{ ($dist == $value->id)?"selected":"" }}>{{ $value->name }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group col-md-3 dis-detail teh-detail" style="display:{{ ($type == 'district')?"block":"none"  }};">
                @php
                  if(request()->has('tehsil')){
                    $tehs = request('tehsil');
                  }else{
                    $tehs = '';
                  }
                @endphp
                <select name="tehsil" class="form-control form-control-chosen tehsil_drop">
                  <option value="">Choose Tehsil</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <button class="btn btn-info search_btn w-100">Search</button>
              </div>
            </div>
          </form>
          <table class="table">
            <thead class="bg-info text-white">
              <tr>
                <th>Name</th>
                <th>Society Designation</th>
                <th>Official Designation</th>
                <th>Cabinet</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="text-dark" id="{{ ($sortType == 'yes')?"sort":"" }}">
            @if(count($record) > 0)
              @php
                $i=1;
              @endphp
              @foreach($record as $value)
                @php
                  $user_info = get_user_detail($value->name);
                  if ($value->district == 'yes') {
                    if (!empty($value->tehsil)) {
                      $cab_get = $tehsil->where('id',$value->tehsil)->first();
                      $cab_name = ($cab_get) ? $cab_get->name : "";
                    }else{
                      $cab_get = $cities->where('id',$value->dept_id)->first();
                      $cab_name = ($cab_get) ? $cab_get->name : "";
                    }
                  }elseif($value->province == 'yes'){
                    $cab_get = $province->where('id',$value->dept_id)->first();
                    $cab_name = ($cab_get) ? $cab_get->name : "";                    
                  }elseif($value->national == 'yes'){
                    $cab_name = 'National';
                  }else{
                    $cab_name = "";
                  }
                @endphp
                <tr  data-index = '{{ $value->id }}' data-position='{{ $value->sort }}'  class="sort-tr" >
                  <td style="max-width: 250px;">{{ ($user_info)?$user_info['name']:"" }}</td>
                  <td style="max-width: 250px;">{{ get_user_designation($value->society_designation) }}</td>
                  <td style="max-width: 250px;">{{ get_user_off_dsg($value->official_designation) }}</td>
                  <td>{{ $cab_name }}</td>
                  <td>{{ date('d/m/Y',strtotime($value->joining_date)) }}</td>
                  <td>
                    <a href="{{ route('add-cabinets').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('add-cabinets').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
                      <i class="fa fa-trash"></i>
                    </a>
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
    $(document).ready(function(){
      var t_name = "{{ $tehs }}";
      var c_name = "{{ $dist }}";
      if (t_name != "") 
      {
        tehsil(c_name);
      }
      $('.city_drop').on('change',function(){
        var cityID = $(this).val().trim();
        if (cityID != '') {
          $('.tehsil_drop').html("");
          tehsil(cityID);
        }
      });
      function tehsil(cityID="") {
        var url = '{{ route('remaining-budget') }}';
        $.ajax({
          url:url,
          method:'POST',
          dataType:'json',
          data:{
            action:'find-tehsil',
            cityID:cityID,
            _token:_token,
          }, success:function(e){
            if(e == ""){
              $('.tehsil_drop').append(new Option("Choose Tehsil", "", "selected"));
              $('.tehsil_drop').chosen();
              $('.tehsil_drop').trigger("chosen:updated");
            }else{
                $('.tehsil_drop').append(new Option("Choose Tehsil Name", "",));
                var rt = "";
                $.each( e, function( key, value ) {
                  if (t_name == e[key]['id']) {
                    rt = 'selected';
                  }else{
                    rt = "";
                  }
                    var op = "<option value="+e[key]['id']+" "+rt+">"+e[key]['name']+"</option>";
                    $('.tehsil_drop').append(op);
                });
                $('.tehsil_drop').chosen();
                $('.tehsil_drop').trigger("chosen:updated");
            }
          }, error:function(e){
            alert('Error on fetching Tehsil list. Refresh page and try again.');
          }
        })
      }
      $('.type_drop').on('change',function(){
        var type = $(this).val().trim();
        $('.province_drop').val("");
        $('.province_drop').chosen();
        $('.province_drop').trigger("chosen:updated");
        $('.city_drop').val("");
        $('.city_drop').chosen();
        $('.city_drop').trigger("chosen:updated");
        $('.tehsil_drop').val("");
        $('.tehsil_drop').chosen();
        $('.tehsil_drop').trigger("chosen:updated");
        if (type == '') {
          $('.pro-detail').css('display','none');
          $('.dis-detail').css('display','none');
        }else{
          if (type == 'national') {
            $('.pro-detail').css('display','none');
            $('.dis-detail').css('display','none');
          }else if(type == 'province'){
            $('.pro-detail').css('display','block');
            $('.dis-detail').css('display','none');
          }else if(type == 'district'){
            $('.pro-detail').css('display','none');
            $('.dis-detail').css('display','block');
          }
        }
      });
    })
    $( "#sort" ).sortable({
      update:function(event,ui){
        $(this).children().each(function (index){
          if ($(this).attr('data-position')!= (index+1)) {
            $(this).attr('data-position',(index+1)).addClass('updated');
          }
        });
        var url = base_url+admin+"/positions";
        savenewposition(url,'cabinets');
      }
    });
  </script>
@if($__userType == 'admin')
  @include('admin.layout.footer')
@endif