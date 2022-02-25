@php
	$of_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
@endphp
<div class="row">
	<div class="col-md-12" id="user_record">
			@csrf
			<div class="card">
				<div class="card-header">{{ $record->name }}</div>
        <div class="card-body p-1">
          <div class="row">
            <div class="col-3 col-sm-3 col-lg-3">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-personal-tab" data-toggle="pill" href="#v-pills-personal" role="tab" aria-controls="v-pills-personal" aria-selected="true">Personal Information</a>
                <a class="nav-link" id="v-pills-nominee-tab" data-toggle="pill" href="#v-pills-nominee" role="tab" aria-controls="v-pills-nominee" aria-selected="false">Nominee Information</a>
                <a class="nav-link" id="v-pills-family-tab" data-toggle="pill" href="#v-pills-family" role="tab" aria-controls="v-pills-family" aria-selected="false">Family Information</a>
                <a class="nav-link" id="v-pills-photo-tab" data-toggle="pill" href="#v-pills-photo" role="tab" aria-controls="v-pills-photo" aria-selected="false">Upload Image</a>
                <a class="nav-link" id="v-pills-history-tab" data-toggle="pill" href="#v-pills-history" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
              </div>
            </div>
            <div class="col-9 col-sm-9 col-lg-9">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel" aria-labelledby="v-pills-personal-tab">
					<h2>Personal Information</h2>
                	<form id="personnel_form">
                		@csrf
                		<input type="hidden" name="user_id" value="{{ $record->id }}">
	                	<div class="row">
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Full Name</label>
                				<input type="text" name="full_name" class="form-control" value="{{ $record->name }}">
                				<span class="text-danger"></span>
                			</div>
                			<div class="form-group">
                				<label for="" class="font-weight-600">Father Name</label>
                				<input type="text" name="father_name" class="form-control" value="{{ (!empty($user_info))?$user_info->father_name:"" }}">
                			</div>
                			<div class="form-group">
                				<label for="" class="font-weight-600">CNIC</label>
                				<input type="text" name="CNIC_number" class="form-control" id="cnic2" value="{{ $record->cnic }}">
                				<span class="text-danger"></span>
                			</div>
                		</div>
                		<div class="col-md-6">
                			@php
                				$img = (!empty($user_info) and !empty($user_info->img))?$user_info->img:"avatar5.png";
                			@endphp
                			<img src="{{ asset('images/'.$img) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 100%; max-height: 226px">
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Pay Personnal No.</label>
                				<input type="text" name="personnal_number" class="form-control" value="{{ (!empty($user_info))?$user_info->personnel_no:"" }}">
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Date of Birthday</label>
                				<input type="text" name="dob" class="form-control" value="{{ (!empty($user_info) and !empty($user_info->dob))?date('d/m/Y',strtotime($user_info->dob)):"" }}" data-toggle="datepickerNew" autocomplete="off" id="date-pick" >
                				<span class="text-danger"></span>
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Official Designation</label>
                				<select name="official_designation" class="form-control form-control-dropdown">
                					<option value=""></option>
                					@if (count($of_dsg) > 0)
                						@foreach ($of_dsg as $val)
                							<option value="{{ $val->id }}" {{ ($record->designation == $val->id)?"selected":"" }}>{{ $val->name }}</option>
                						@endforeach
                					@endif
                				</select>
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Date of Appointment</label>
                				<input type="text" name="appointment_date" class="form-control" data-toggle="datepickerNew" autocomplete="off" id="date-pick1"  value="{{ (!empty($user_info) and !empty($user_info->appointment))?date('d/m/Y',strtotime($user_info->appointment)):"" }}">
                				<span class="text-danger"></span>
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Mobile No.</label>
                				<input type="text" name="phone_no" class="form-control" id="mobile3" value="{{ (!empty($record))?$record->contact:"" }}">
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Whatsapp No.</label>
                				<input type="text" name="whatsappp_no" class="form-control" id="mobile2" value="{{ (!empty($user_info))?$user_info->whatsapp_no:"" }}">
                			</div>
                		</div>
                		<div class="col-md-6">
                			@php
                				$blood_group = (!empty($user_info))?$user_info->blood_group:"";
                			@endphp
                			<div class="form-group">
                				<label for="" class="font-weight-600">Blood Group</label>
                				<select name="blood_group" class="form-control form-control-dropdown">
                					<option value="">Choose an Option</option>
									<option value="A+" {{ ($blood_group == 'A+')?"selected":"" }}>A+</option>
									<option value="A-" {{ ($blood_group == 'A-')?"selected":"" }}>A-</option>
									<option value="B+" {{ ($blood_group == 'B+')?"selected":"" }}>B+</option>
									<option value="B-" {{ ($blood_group == 'B-')?"selected":"" }}>B-</option>
									<option value="AB+" {{ ($blood_group == 'AB+')?"selected":"" }}>AB+</option>
									<option value="AB-" {{ ($blood_group == 'AB-')?"selected":"" }}>AB-</option>
									<option value="O+" {{ ($blood_group == 'O+')?"selected":"" }}>O+</option>
									<option value="O-" {{ ($blood_group == 'O-')?"selected":"" }}>O-</option>
                				</select>
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Email</label>
                				<input type="text" name="email" class="form-control" value="{{ $record->email }}">
                				<span class="text-danger"></span>
                			</div>
                		</div>
                		<div class="col-md-6">
                			<div class="form-group">
                				<label for="" class="font-weight-600">Address</label>
                				<textarea name="address" class="form-control">{{ (!empty($user_info))?$user_info->address:"" }}</textarea>
                			</div>
	                		</div>
	                	</div>
	                	<div class="text-right mr-2">
	                		<button type="submit" class="btn btn-sm btn-primary personal_btn" name="personnal_record">Update</button>
	                	</div>
	                </form>
                </div>
                <div class="tab-pane fade" id="v-pills-nominee" role="tabpanel" aria-labelledby="v-pills-nominee-tab">
                	<form id="nominee_info_form">
                		@csrf
                		<input type="hidden" name="user_id" value="{{ $record->id }}">
						<h2>Nominee Information</h2>
	                	<div class="row">
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">Nominee's Name</label>
	                				<input type="text" name="nominee_name" class="form-control" value="{{ (!empty($nominee_information))?$nominee_information->full_name:"" }}">
	                			</div>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">Relation</label>
	                				@php
	                					$relation = (!empty($nominee_information))?$nominee_information->relation:"";
	                				@endphp
									<select name="noinee_relation" class="form-control form-control-dropdown">
										<option value="">Select Relation</option>
										<option value="father" {{ ($relation == 'father')?"selected":"" }}>Father</option>
										<option value="mother" {{ ($relation == 'mother')?"selected":"" }}>Mother</option>
										<option value="brother" {{ ($relation == 'brother')?"selected":"" }}>Brother</option>
										<option value="sister" {{ ($relation == 'sister')?"selected":"" }}>Sister</option>
										<option value="uncle" {{ ($relation == 'uncle')?"selected":"" }}>Uncle</option>
										<option value="auntie" {{ ($relation == 'auntie')?"selected":"" }}>Auntie</option>
										<option value="husband" {{ ($relation == 'husband')?"selected":"" }}>Husband</option>
										<option value="wife" {{ ($relation == 'wife')?"selected":"" }}>Wife</option>
										<option value="son" {{ ($relation == 'son')?"selected":"" }}>Son</option>
										<option value="daughter" {{ ($relation == 'daughter')?"selected":"" }}>Daughter</option>
									</select>
	                			</div>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">Father/Husband's Name</label>
	                				<input type="text" name="guardian_name" class="form-control" value="{{ (!empty($nominee_information))?$nominee_information->father_name:"" }}">
	                			</div>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">CNIC</label>
	                				<input type="text" name="nominee_cnic" class="form-control" id="cnic3" value="{{ (!empty($nominee_information))?$nominee_information->cnic:"" }}">
	                			</div>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">Contact Number</label>
	                				<input type="text" name="nominee_phone_no" class="form-control" id="mobile" value="{{ (!empty($nominee_information))?$nominee_information->cell_no:"" }}">
	                			</div>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="form-group">
	                				<label for="" class="font-weight-600">Email</label>
	                				<input type="email" name="nominee_email" class="form-control" value="{{ (!empty($nominee_information))?$nominee_information->email:"" }}">
	                			</div>
	                		</div>
	                	</div>
	                	<div class="text-right mr-2">
	                		<button type="submit" class="btn btn-sm btn-primary">Update</button>
	                	</div>
                	</form>
                </div>
                @php
                	$family = (!empty($user_info) and !empty($user_info->family_info))?json_decode($user_info->family_info):array();
                @endphp
                <div class="tab-pane fade" id="v-pills-family" role="tabpanel" aria-labelledby="v-pills-family-tab">
                	{{-- {{ dd($family) }} --}}
                	<form id="family_info_form">
									<h2>Family Information</h2>
                		@csrf
                		<input type="hidden" name="user_id" value="{{ $record->id }}">
                		@if (count($family) > 0)
	                		@foreach ($family as $element)
								<div class="row custom-row">
									<div class="col-md-10 col-lg-10 col-xl-10 row">
										<div class="col-md-6 col-lg-6 col-xl-3">
											<div class="form-group">
												<input type="text" class="form-control name" placeholder="Member Name" name="name[]" value="{{ $element->name }}">
											</div>
										</div>
										<div class="col-md-6 col-lg-6 col-xl-3">
											<div class="form-group">
												<select name="relation[]" class="form-control form-control-dropdown">
													<option value="">Select Relation</option>
													<option value="father" {{ ($element->relation == 'father')?"selected":"" }}>Father</option>
													<option value="mother" {{ ($element->relation == 'mother')?"selected":"" }}>Mother</option>
													<option value="mother" {{ ($element->relation == 'husband')?"selected":"" }}>Husband</option>
													<option value="mother" {{ ($element->relation == 'wife')?"selected":"" }}>Wife</option>
													<option value="mother" {{ ($element->relation == 'son')?"selected":"" }}>Son</option>
													<option value="child" {{ ($element->relation == 'daughter')?"selected":"" }}>Daughter</option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-lg-6 col-xl-3">
											<div class="form-group">
												<input type="number" class="form-control age" placeholder="Age in Years" name="age[]" value="{{ $element->age }}" max="100" min="0">
											</div>
										</div>
										<div class="col-md-6 col-lg-6 col-xl-3">
											<div class="form-group">
												<select name="status[]" class="form-control form-control-dropdown">
													<option value="">Marital Status</option>
													<option value="married" {{ ($element->status=='married')?"selected":"" }}>Married</option>
													<option value="unmarried" {{ ($element->status=='unmarried')?"selected":"" }}>Unmarried</option>
													<option value="widow" {{ ($element->status=='widow')?"selected":"" }}>Widow</option>
													<option value="widower" {{ ($element->status=='widower')?"selected":"" }}>Widower</option>
													<option value="divorced" {{ ($element->status=='divorced')?"selected":"" }}>Divorced</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-lg-2 col-xl-2 text-center mt-2">
										<div class="form-group icon-group">
											<span class="icon-add" title="Add Row"><i class="icon-plus"></i></span>
											<span class="icon-delete" title="Delete Row"><i class="icon-bin"></i>
											</span>
										</div>
									</div>
								</div>
	                		@endforeach
	                	@else
							<div class="row custom-row">
								<div class="col-md-10 col-lg-10 col-xl-10 row">
									<div class="col-md-6 col-lg-6 col-xl-3">
										<div class="form-group">
											<input type="text" class="form-control name" placeholder="Member Name" name="name[]" value="">
										</div>
									</div>
									<div class="col-md-6 col-lg-6 col-xl-3">
										<div class="form-group">
											<select name="relation[]" class="form-control form-control-dropdown">
												<option value="">Select Relation</option>
												<option value="father">Father</option>
												<option value="mother">Mother</option>
												<option value="mother">Husband</option>
												<option value="mother">Wife</option>
												<option value="mother">Son</option>
												<option value="child">Daughter</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 col-lg-6 col-xl-3">
										<div class="form-group">
											<input type="number" class="form-control age" placeholder="Age in Years" name="age[]" value="" max="100" min="0">
										</div>
									</div>
									<div class="col-md-6 col-lg-6 col-xl-3">
										<div class="form-group">
											<select name="status[]" class="form-control form-control-dropdown">
												<option value="">Marital Status</option>
												<option value="married">Married</option>
												<option value="unmarried">Unmarried</option>
												<option value="widow">Widow</option>
												<option value="widower">Widower</option>
												<option value="divorced">Divorced</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-2 col-lg-2 col-xl-2 text-center mt-2">
									<div class="form-group icon-group">
										<span class="icon-add" title="Add Row"><i class="icon-plus"></i></span>
										<span class="icon-delete" title="Delete Row"><i class="icon-bin"></i>
										</span>
									</div>
								</div>
							</div>
                		@endif
	                	<div class="text-right mr-2">
	                		<button type="submit" class="btn btn-sm btn-primary">Update</button>
	                	</div>
	                </form>
                </div>
                <div class="tab-pane fade" id="v-pills-photo" role="tabpanel" aria-labelledby="v-pills-photo-tab">
                	<form id="photo_form" enctype="multipart/form-data">
                		@csrf
                		<input type="hidden" name="user_id" value="{{ $record->id }}">
	                	<div class="row">
							<div class="col-12 upload-section">
								<h2>Upload Profile Picture</h2>
								<label class="upload-area">
									<div class="dashes">
										<div class="upload-btn-container">
											<div class="btn btn-success img-plus-white upload-btn">Choose file</div>
										</div>
										<input class="file-upload-input" type="file" id="fileUpload" name="profile_image" accept="image/x-png,image/gif,image/jpeg">
										<p id="fileName" style="margin-top: 15px"></p>
									</div>
								</label>
							</div>
	                	</div>
	                	<div class="text-right mr-2">
	                		<button type="submit" class="btn btn-sm btn-primary img_btn" disabled>Update</button>
	                	</div>
	                </form>
                </div>
                <div class="tab-pane fade" id="v-pills-history" role="tabpanel" aria-labelledby="v-pills-history">
                	@php
                		$hi = (!empty($record->history)) ? json_decode($record->history ,true) : array() ;
                	@endphp
                	<div class="row">
						<div class="col-12">
							<h2>History</h2>
							<table class="table table-striped">
								@if (count($hi) > 0)
									@php
										$hi = array_reverse($hi);
									@endphp
									@foreach ($hi as $key => $vla)
										<tr>
											<td>{{ ++$key }}</td>
											<td>{{ $vla }}</td>
										</tr>
									@endforeach
								@endif
							</table>
						</div>
                	</div>
                </div>
              </div>
            </div>
          </div>
        </div>
			</div>
		{{-- </form> --}}
	</div>
</div>
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
<script>
    $('[data-toggle="datepickerNew"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
		endDate: 'today'
    });
    $('.form-control-dropdown').chosen();
    $('#mobile').samask("0000-0000000");
    $('#mobile3').samask("0000-0000000");
    $('#mobile2').samask("0000-0000000");
    $('#cnic3').samask("00000-0000000-0");
    $('#cnic2').samask("00000-0000000-0");
    $('#date-pick').samask("00/00/0000");
    $('#date-pick1').samask("00/00/0000");
    $('#date-pick2').samask("00/00/0000");
    $('#mobile , #mobile2 , #mobile3').keyup(function(){
        $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
    });
    $('#cnic3 , #cnic2').keyup(function(){
        $(this).val($(this).val().replace(/(\d{5})\-?(\d{7})\-?(\d{1})/,'$1-$2-$3'))
    });
    $('#date-pick , #date-pick1').keydown(function(e){
        if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
          return false; 
        }  else {
          return true;
        } 
    });
</script>
<script>
	$(document).ready(function(){
		check_row();
		function check_row() {
			var count_row = $('.icon-delete');
			if(parseInt(count_row.length) == 1){
				$('.icon-delete').hide();
			}else{
				console.log(parseInt(count_row.length));
				$('.icon-delete').each(function(){
					$(this).css('display','inline-block');
				});
			}
			// $('.icon-delete').each(function)
		}
		$('.name').keydown(function(e){
			var maxlength = $(this).val().length;
			if ((e.keyCode >= 33 && e.keyCode <= 64) || (e.keyCode >= 91 && e.keyCode <= 96) || e.keyCode >= 123 || e.keyCode == 17 ) {
	              return false; 
            }  else {
				if(maxlength > 50){
					console.log(50);
					return false;
				}else{
					return true;
				}
            } 
		});
		$('#fileUpload').change(function(){
			var val = $(this).val();
			if(val == ""){
				$('.img_btn').attr('disabled',true);
			}else{
				$('.img_btn').attr('disabled',false);
			}
		})
		$("#user_record").on("click",".icon-add i",function(){
			var row = `<div class="row custom-row">
							<div class="col-md-10 col-lg-10 col-xl-10 row">
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<input type="text" class="form-control name" placeholder="Member Name" name="name[]">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<select name="relation[]" class="form-control form-control-dropdown">
											<option value="">Select Relation</option>
											<option value="father">Father</option>
											<option value="mother">Mother</option>
											<option value="husband">Husband</option>
											<option value="wife">Wife</option>
											<option value="son">Son</option>
											<option value="daughter">Daughter</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<input type="number" class="form-control age" placeholder="Age in Years" name="age[]" max="100" min="0">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<select name="status[]" class="form-control form-control-dropdown">
											<option value="" selected="">Marital Status</option>
											<option value="married">Married</option>
											<option value="unmarried">Un-Married</option>
											<option value="widow">Widow</option>
											<option value="widower">Widower</option>
											<option value="divorced">Divorced</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-lg-2 col-xl-2 text-center mt-2">
								<div class="form-group icon-group">
									<span class="icon-add" title="Add Row"><i class="icon-plus"></i></span>
									<span class="icon-delete" title="Delete Row"><i class="icon-bin"></i>
									</span>
								</div>
							</div>
					   </div>`;
					$("#user_record").find("#v-pills-family").find('div:last').before(row);
	        $(".form-control-dropdown").chosen();
			$('.name').keydown(function(e){
				var maxlength = $(this).val().length;
				if ((e.keyCode >= 33 && e.keyCode <= 64) || (e.keyCode >= 91 && e.keyCode <= 96) || e.keyCode >= 123 || e.keyCode == 17 ) {
		              return false; 
	            }  else {
					if(maxlength > 50){
						console.log(50);
						return false;
					}else{
						return true;
					}
	            } 
			});
			check_row();
		});
		$("#user_record").on("click",".icon-delete i",function(){
			if($("#user_record").find(".custom-row").length > 1){
				if(confirm('Are you sure want to remove this member ?')){
					$(this).closest(".custom-row").remove();
				}
			}
			check_row();
		});

		$('#personnel_form').on('submit',function(e){
			e.preventDefault();
			$.ajax({
        url:'{{ route('update-users') }}',
				method: 'POST',
				datatype: 'json',
				data: new FormData($('#personnel_form')[0]),
				cache: false,
				contentType: false,
				processData: false,
				success:function(res){
					if(res == '"success"'){
						toastr.success('Personnal Information updated successfully');	
						$('.text-danger').html('');	 		
					}else{
						toastr.error('Record updatation failed');
						$('input[name="full_name"]').next('.text-danger').html(res.full_name);
						$('input[name="CNIC_number"]').next('.text-danger').html(res.CNIC_number);
						$('input[name="appointment_date"]').next('.text-danger').html(res.appointment_date);
						$('input[name="dob"]').next('.text-danger').html(res.dob);
						$('input[name="email"]').next('.text-danger').html(res.email);
					}
				}, error:function(e){
					toastr.error(e);
				}
			})
		})
		$('#nominee_info_form').on('submit',function(e){
			e.preventDefault();
			var cnc = $('#cnic3').val();
			if(cnc.length != 15){
				$('#cnic3').parent().find('.text-danger').remove();
				$('#cnic3').parent().append('<span class="text-danger">CNIC format is invalid.</span>');
			}else{
				$('#cnic3').parent().find('.text-danger').remove();
				$.ajax({
			        url:'{{ route('update-users') }}',
					method: 'POST',
					datatype: 'json',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					success:function(res){
						if(res == '"success"'){
							toastr.success('Nominee Information updated successfully');		 		
						}else{
							console.log(res);
						}
					}, error:function(e){
						toastr.error(e);
					}
				})
			}
		})
		$('#family_info_form').on('submit',function(e){
			e.preventDefault();
			$.ajax({
		        url:'{{ route('update-users') }}',
				method: 'POST',
				datatype: 'json',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				success:function(res){
					if(res == '"success"'){
						toastr.success('Family Information updated successfully');		 		
					}else if(res == '"error"'){
						toastr.error('Record updation failed due to incomplete form');
					}else{
						console.log(res);
					}
				}, error:function(e){
					toastr.error(e);
				}
			})
		});
		$('input[type=file]').on('change',function(){
			var value = $(this).val().replace(/C:\\fakepath\\/i, '');
			$('#fileName').text(value);
		})
		$('#photo_form').on('submit',function(e){
			e.preventDefault();
			$.ajax({
		        url:'{{ route('update-users') }}',
				method: 'POST',
				datatype: 'json',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				success:function(res){
					if(res == '"success"'){
						toastr.success('Your profile image updated successfully');		 		
					}else{
						toastr.error(res.profile_image);
					}
				}, error:function(e){
					toastr.error(e);
				}
			})
		})
	});
</script>