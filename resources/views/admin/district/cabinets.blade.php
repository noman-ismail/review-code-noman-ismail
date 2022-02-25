@php
	if(!empty(old())){
		$name = old('name');
		$official_designation = old('official_designation');
		$society_designation = old('society_designation');
		$joining_date = old('joining_date');
		$leaving_date = old('leaving_date');
		$province_val = old('province');
		$city = old('district');
		$tehsil = old('tehsil');
		$cabinet = old('cabinet');
 	}elseif(isset($get_data) and !empty($get_data)){
		$name = $get_data->name;
		$official_designation = $get_data->official_designation;
		$society_designation = $get_data->society_designation;
		$joining_date = date('d/m/Y',strtotime($get_data->joining_date));
		$leaving_date = (!empty($get_data->leaving_date)) ? date('d/m/Y',strtotime($get_data->leaving_date)) : "";
		$tehsil = $get_data->tehsil;
		$city = "";
		$province_val = "";
		if ($get_data->national == 'yes') {
			$cabinet = "national";
		}elseif($get_data->province == 'yes'){
			$cabinet = 'province';
			$province_val = $get_data->dept_id;
		}elseif($get_data->district == 'yes'){
			$cabinet = 'district';
			$city = $get_data->dept_id;
		}else{
			$cabinet = "";
		}
	}else{
		$name = $official_designation = $society_designation = $joining_date = $leaving_date = $province_val = $city = $tehsil = $cabinet = "";
	}
@endphp
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
<div class="body-content">
	<div class="card border-info">
	    <div class="card-header bg-info text-white">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h6 class="fs-17 font-weight-600 mb-0">Add New Cabinet Member</h6>
	        </div>
	        <div class="text-right">
	          <a href="{{ route('cabinets') }}" class="btn btn-sm btn-success">Cabinets User List</a>
	          <a href="{{ route('add-cabinets') }}" class="btn btn-sm btn-secondary">Add New</a>
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

				</div>
			</div>
			<form action="{{ (isset($get_data) and !empty($get_data))?route('add-cabinets')."?id=".request('id'):route('add-cabinets') }}" method="post">
				@csrf
				<div class="row mb-3">
						<div class="col-md-6">
							<label>Choose Cabinet Type <span class="required">*</span></label>
	            <div class="productdetail">
	              <label class="chk-st-d">
	                <input type="radio" class="width-auto national-cabinet n" value="national" name="cabinet" {{ ($cabinet == 'national')?"checked":"" }}>
	                <span>National</span>
	              </label>
	              <label class="chk-st-d">
	                <input type="radio" class="width-auto province-cabinet n" value="province" name="cabinet" {{ ($cabinet == 'province')?"checked":"" }}>
	                <span>Province</span>
	              </label>
	              <label class="chk-st-d">
	                <input type="radio" class="width-auto district-cabinet n" value="district" name="cabinet" {{ ($cabinet == 'district')?"checked":"" }}>
	                <span>District</span>
	              </label>
	            </div>
						</div>
						<div class="col-md-6 cab-detail" style="display: block">
							@php
								if ($cabinet == 'province') {
									$class_ = 'pro-detail';
								}elseif($cabinet == 'district'){
									$class_ = 'dis-detail';
								}else{
									$class_ = "";
								}
							@endphp
							<div class="row">
								<div class="col-md-12 pro-detail _detail" style="display: {{ ($class_ == 'pro-detail')?"block":"none" }}">
									<div class="form-group">
										<label for="">Choose Province <span class="required">*</span></label>
										<select class="form-control form-control-chosen province_drop" name="province">
											<option value="">Choose an Option</option>
											@if (count($province) > 0)
												@foreach ($province as $key => $value)
													<option value="{{ $value->id }}" {{ ($province_val == $value->id) ? "selected" : "" }}>{{ $value->name }}</option>
												@endforeach
											@endif
										</select>
			              @if(count($errors) > 0)
			                @foreach($errors->get('province') as $error)
			                  <div class="text-danger">{{ $error }}</div>
			                @endforeach 
			              @endif
									</div>
								</div>
								<div class="{{ ($class_ == 'dis-detail')?"col-md-6":"col-md-12" }} dis-detail _detail" style="display: {{ ($class_ == 'dis-detail')?"block":"none" }}">
									<div class="form-group">
										<label for="">Choose District <span class="required">*</span></label>
										<select class="form-control form-control-chosen city_chosen" name="district">
											<option value="">Choose an Option</option>
											@if (count($cities) > 0)
												@foreach ($cities as $key => $value)
													<option value="{{ $value->id }}" {{ ($city == $value->id) ? "selected" : "" }}>{{ $value->name }}</option>
												@endforeach
											@endif
										</select>
			              @if(count($errors) > 0)
			                @foreach($errors->get('district') as $error)
			                  <div class="text-danger">{{ $error }}</div>
			                @endforeach 
			              @endif
									</div>
								</div>
								<div class="{{ ($class_ == 'dis-detail')?"col-md-6":"col-md-6" }} teh-detail _detail" style="display: {{ ($class_ == 'dis-detail')?"block":"none" }}">
									<div class="form-group">
										<label for="">Choose Tehsil</label>
										<select class="form-control form-control-chosen tehsil-drop" name="tehsil">
											<option value="">Choose an Option</option>
										</select>
									</div>
								</div>
							</div>
						</div>

				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Cabinet Member Name <span class="required">*</span></label>
							<select class="form-control form-control-chosen name" name="name">
								<option value="">Choose an Option</option>
								@if (!empty($get_data) && count($userss) > 0)
									@foreach ($userss as $val)
                    @php
                      $get_user_info = get_userinfo_detail($val->id);
                      $_dsg = $official_dsg->where('id',$val->designation)->first();
                      $_dsg_name = ($_dsg) ? " - ".$_dsg->name : "";
                    @endphp
										<option value="{{$val->id}}" {{($val->id==$name)?'selected':''}}>
											{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?$get_user_info['personnel_no']." - ":"" }}{{ $val->name.$_dsg_name }}
										</option>
									@endforeach
								@endif
							</select>
							@error('name')
								<div class="text-danger">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Society Designation <span class="required">*</span></label>
							<select name="society_designation" class="form-control form-control-chosen society_dsg">
								<option value="">Choose an Option</option>
								@if (count($society_dsg) > 0)
									@foreach ($society_dsg as $val)
										<option value="{{ $val->id }}" {{ ($val->id == $society_designation)?"selected":"" }}>
											{{ $val->name }}
										</option>
									@endforeach
								@endif
							</select>
              @if(count($errors) > 0)
                @foreach($errors->get('society_designation') as $error)
                  <div class="text-danger">{{ $error }}</div>
                @endforeach 
              @endif
						</div>
					</div>
					<div class="col-md-12 mt-4">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Joining Date <span class="required">*</span></label>
									<input type="text" name="joining_date" data-toggle="calender" autocomplete="off" id="date-picker" placeholder="DD/MM/YYYY" class="form-control joining-date" value="{{ $joining_date }}">
									<span class="text-danger joining_erro"></span>
		                @if(count($errors) > 0)
		                  @foreach($errors->get('joining_date') as $error)
		                    <div class="text-danger">{{ $error }}</div>
		                  @endforeach
		                @endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Leaving Date</label>
									<input type="text" name="leaving_date" data-toggle="calender" autocomplete="off" id="date-picker1" placeholder="DD/MM/YYYY" class="form-control leaving-date" value="{{ $leaving_date }}">
									<span class="text-danger joining_erro"></span>
		                @if(count($errors) > 0)
		                  @foreach($errors->get('leaving_date') as $error)
		                    <div class="text-danger">{{ $error }}</div>
		                  @endforeach 
		                @endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<input type="hidden" name="">
						<button class="btn btn-primary btn-submit" type="button" data-name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}">
							Submit
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var _cid = $('.city_chosen').val();
		if (_cid != "") {
			tehsil(_cid);
		}
		var t_name = '{{ $tehsil }}';
		var u_name = '';
		$('.btn-submit').click(function(){
			$(this).prev('input').attr('name',$(this).attr('data-name'));
			$('form').submit();
		});
		$('.n').click(function(){
			var cabinet_type = $(this).val().trim();
			if (cabinet_type == 'national') 
			{
				$('.cab-detail').css('display','none');
				$('._detail').css('display','none');
	      $('.name').html("");
	      $('.name').chosen();
	      $('.name').trigger("chosen:updated");
				getting_uses('national','');
			}else if (cabinet_type == 'province') 
			{
	      $('.name').html("");
	      $('.name').chosen();
	      $('.name').trigger("chosen:updated");
	      $('.province_drop').val("");
	      $('.province_drop').chosen();
	      $('.province_drop').trigger("chosen:updated");
				$('.cab-detail').css('display','block');
				$('._detail').css('display','none');
				$('.pro-detail').css('display','block');
			}else if (cabinet_type == 'district') 
			{
	      $('.name').html("");
	      $('.name').chosen();
	      $('.name').trigger("chosen:updated");
	      $('.city_chosen').val("");
	      $('.city_chosen').chosen();
	      $('.city_chosen').trigger("chosen:updated");
	      $('.tehsil-drop').val("");
	      $('.tehsil-drop').chosen();
	      $('.tehsil-drop').trigger("chosen:updated");
				$('.cab-detail').css('display','block');
				$('._detail').css('display','none');
				$('.dis-detail').css('display','block').removeClass('col-md-12').addClass('col-md-6');
				$('.teh-detail').css('display','block').removeClass('col-md-12').addClass('col-md-6');
			}else{
				$('.cab-detail').css('display','none');
				$('._detail').css('display','none');
			}
		});
		$('.province_drop').on('change',function(){
			var provinceID = $(this).val().trim();
      $('.name').html("");
      $('.name').chosen();
      $('.name').trigger("chosen:updated");
			if (provinceID != '') {
				getting_uses('province',provinceID);
			}
		});
		$('.city_chosen').on('change',function(){
			var cityID = $(this).val().trim();
      $('.name').html("");
      $('.name').chosen();
      $('.name').trigger("chosen:updated");
			if (cityID != '') {
	      $('.tehsil-drop').html("");
	      $('.tehsil-drop').chosen();
	      $('.tehsil-drop').trigger("chosen:updated");
				$('.dis-detail').removeClass('col-md-12').addClass('col-md-6');
				$('.teh-detail').removeClass('col-md-12').addClass('col-md-6');
				getting_uses('district',cityID);
				tehsil(cityID);
			}else{
				$('.dis-detail').removeClass('col-md-6').addClass('col-md-12');
				$('.teh-detail').css('display','none');
			}
		});
		function getting_uses(type="",id="") {
			// body...
			var url = '{{ route('remaining-budget') }}';
			$.ajax({
        url:url,
        method:'POST',
        dataType:'json',
        data:{
          action:'getting-users',
          type:type,
          id:id,
          _token:_token,
        }, success:function(e){
          if(e == ""){
            $('.name').append(new Option("Choose an Option", ""));
            $('.name').chosen();
            $('.name').trigger("chosen:updated");
          }else{
              $('.name').append(new Option("Choose an Option", ""));
              var rt = "";
              $.each( e, function( key, value ) {
              	if (u_name == e[key]['id']) {
              		rt = 'selected';
              	}else{
              		rt = "";
              	}
                  var op = "<option value="+e[key]['id']+" "+rt+">"+e[key]['name']+"</option>";
                  $('.name').append(op);
              });
              $('.name').chosen();
              $('.name').trigger("chosen:updated");
          }
        }, error:function(e){
        	alert('Error on fetching Users list. Refresh page and try again.');
        }
			})
		}
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
        		$('.teh-detail').css('display','block');
            $('.tehsil-drop').append(new Option("Choose Tehsil", "", "selected"));
            $('.tehsil-drop').chosen();
            $('.tehsil-drop').trigger("chosen:updated");
          }else{
          		$('.teh-detail').css('display','block');
              $('.tehsil-drop').append(new Option("Choose Tehsil Name", "",));
              var rt = "";
              $.each( e, function( key, value ) {
              	if (t_name == e[key]['id']) {
              		rt = 'selected';
              	}else{
              		rt = "";
              	}
                  var op = "<option value="+e[key]['id']+" "+rt+">"+e[key]['name']+"</option>";
                  $('.tehsil-drop').append(op);
              });
              $('.tehsil-drop').chosen();
              $('.tehsil-drop').trigger("chosen:updated");
          }
        }, error:function(e){
        	alert('Error on fetching Tehsil list. Refresh page and try again.');
        }
			})
		}
	})
</script>
@if($__userType == 'admin')
  @include('admin.layout.footer')
@endif
<script>
    $('input[name="joining_date"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
        endDate: 'today',
    });
    $('input[name="leaving_date"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
    });
</script>