@php
	if(old('user_name') != null || old('death_date') != null || old('death_reason') != null || old('death_place') != null){
		$user_name = old('user_name');
		$death_date = old('death_date');
		$death_reason = old('death_reason');
		$death_place = old('death_place');
	}elseif(isset($get_data) and !empty($get_data)){
		$user_name = $get_data->user_id;
		$death_date = date('d/m/Y' , strtotime($get_data->death_date));
		$death_reason = $get_data->death_reason;
		$death_place = $get_data->death_place;
	}else{
		$user_name = $death_date = $death_reason = $death_place = "";
	}
@endphp
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card border-info">
	    <div class="card-header bg-info text-white">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h6 class="fs-17 font-weight-600 mb-0">New Request for Death Claim</h6>
	        </div>
	        <div class="text-right">
	          <a href="{{ route('death-claim-list') }}" class="btn btn-sm btn-success">Death Claim List</a>
	          <a href="{{ route('death-claim') }}" class="btn btn-sm btn-secondary">Add New</a>
	        </div>
	      </div>
	    </div>
		<div class="card-body">
			<form action="{{ (isset($get_data) and !empty($get_data))?route('death-claim')."?id=".request('id'):route('death-claim') }}" method="post">
				@csrf
				<div class="row" id="carrd-body">
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
					<div class="col-md-8">
						<div class="form-group">
							<label for="">User Name <span class="required">*</span></label>
							<select name="user_name" class="form-control form-control-chosen">
								<option value="">Choose an Option</option>
								@foreach ($users as $key => $value)
				                    @php
				                      $get_user_info = get_userinfo_detail($value->id);
				                    @endphp
									<option value="{{ $value->id }}" {{ ($user_name == $value->id)?"selected":"" }}>{{ $value->name }}{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?" - ".$get_user_info['personnel_no']:"" }}</option>
								@endforeach
							</select>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('user_name') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Date of Death <span class="required">*</span></label>
							<input type="text" placeholder="DD/MM/YY" data-toggle="deathdate" autocomplete="off" id="date-picker" name="death_date" class="form-control death_date" value="{{ $death_date }}">
							<span class="text-danger death_erro"></span>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('death_date') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Death Reason <span class="required">*</span></label>
							<input type="text" placeholder="Enter Death Reason" name="death_reason" class="form-control" value="{{ $death_reason }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('death_reason') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Place of Death <span class="required">*</span></label>
							<input type="text" name="death_place" placeholder="Enter Death Place" class="form-control" value="{{ $death_place }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('death_place') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-8 text-right">
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

		$('.btn-submit').click(function(){
			$(this).prev('input').attr('name',$(this).attr('data-name'));
			var death_date = $('.death_date').val().trim();
			if(death_date != ""){
				// $('form').submit();
		        var dString = death_date.split('/');
		        if(dString.length == 3){
		        	var get_year = dString[2];
		        	var get_month = parseInt(dString[1])-parseInt(1); 
		        	var get_date = dString[0]; 
		        	// console.log(get_year+'  --  '+get_month+'  --  '+get_date)
		        	var expireDate = new Date(get_year,get_month,get_date);
					var todayDate = new Date();
					if(get_year <= todayDate.getFullYear()){
						// console.log(todayDate);
						// console.log(expireDate);
						if (todayDate < expireDate) {
				        	$('.death_erro').html('Death Date should be today or less than today');
		                    $([document.documentElement, document.body]).animate({
		                        scrollTop: $("#carrd-body").offset().top
		                    }, 1000);
						}else{
							$('form').submit();
						}
					}else{
			        	$('.death_erro').html('Death Date should be today or less than today');
	                    $([document.documentElement, document.body]).animate({
	                        scrollTop: $("#carrd-body").offset().top
	                    }, 1000);
					}
		        }else{
		        	$('.death_erro').html('Death Date Format is Invalid');
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#carrd-body").offset().top
                    }, 1000);
		        }
			}else{
				$('form').submit();
			}
		})
	})
</script>
@include('admin.district.layouts.footer')
<script>
    $('[data-toggle="deathdate"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
        endDate:'today',
    });
</script>