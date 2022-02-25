@php
	if(old()){
		$full_name = old('full_name');
		$cnic = old('cnic');
		$father_name = old('father_name');
		$personal_no = old('personal_no');
		$dob = old('dob');
		$appointment = old('appointment');
		$designation = old('designation');
		$cell_no = old('cell_no');
		$whatsapp_no = old('whatsapp_no');
		$blood_group = old('blood_group');
		$address = old('address');
		$email = old('email');
		$profile_pic = "";
		$fb_link = old('facebook_link');
		$tw_link = old('twitter_link');
		$insta_link = old('instagram_link');
		$linkedin_link = old('linkedin_link');
	}elseif(!empty($user)){
		$full_name = $user->name;
		$cnic = $user->cnic;
		$email = $user->email;
		$designation = $user->designation;
		$cell_no = (!empty($user))?$user->contact:"";
		$whatsapp_no = (!empty($user_info))?$user_info->whatsapp_no:"";
		$blood_group = (!empty($user_info))?$user_info->blood_group:"";
		$address = (!empty($user_info))?$user_info->address:"";
		$father_name = (!empty($user_info))?$user_info->father_name:"";
		$personal_no = (!empty($user_info))?$user_info->personnel_no:"";
		$appointment = (!empty($user_info))?implode('/', array_reverse(explode('-', $user_info->appointment))):"";
		$dob = (!empty($user_info))?implode('/', array_reverse(explode('-', $user_info->dob))):"";
		$profile_pic = (!empty($user_info))?$user_info->img:"";
		$social = (!empty($user_info) and !empty($user_info->social_links))?json_decode($user_info->social_links) : "";
		if(!empty($social)){
			$fb_link = $social->fb_link;
			$tw_link = $social->tw_link;
			$insta_link = $social->insta_link;
			$linkedin_link = $social->linkedin_link;
		}else{
			$linkedin_link = $insta_link = $fb_link = $tw_link = "";
		}
	}else{
		$full_name = $father_name = $cnic = $personal_no = $dob = $designation = $appointment = $cell_no = $whatsapp_no = $blood_group = $profile_pic = $email = $address = $fb_link = $insta_link = $tw_link = $linked_link = "";
	}
	$off__dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
@endphp
@include('login.layouts.header')
<style>
	.req{
		color: red;
	}
</style>
{{-- <header class="title-header main-header">
	<div class="container">
		<div class="header-text">
			<h1 class="header-title">Personal Information</h1>
			<ul class="breadcrumb">
				<li><a href="{{ route('user-dashboard') }}">Home</a></li>
				<li><span>Personal Information</span></li>
			</ul>
		</div>
	</div>
</header> --}}
<main class="dashboard-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-3">
				<div class="dash-aside">
					@include('login.layouts.sidebar')
				</div>
			</div>
			<div class="col-md-12 col-lg-9">
				{{-- {{ dd(array_value()) }} --}}
				<div class="main-column">
					<h3 class="rounded-top">Personal Information</h3>
					<form action="{{ route('personal-information') }}" method="post" enctype="multipart/form-data">
						@csrf

						@if(session()->has("success"))
						<div class="row">
							<div class="col-md-12">
								<div class="message message-success">
									<span>{!! session("success") !!}</span>
									<i class="close">&times;</i>
								</div>
							</div>
						</div>
						@endif
						{{--  --}}
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<div class="form-group">
									<div class="resp-text">
										<label>Full Name: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control full_name" name="full_name" value="{{ $full_name }}" readonly>
										<span class="icon"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="resp-text">
										<label>Father Name: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control father_name" name="father_name" value="{{ $father_name }}">
										<span class="icon"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="resp-text">
										<label>CNIC: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="tel" class="form-control cnic" name="cnic" value="{{ $cnic }}" readonly>
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-4">
								@php
									if(!empty($profile_pic)){
										// $fileName = 
										$strr = "background-image: url(".asset('images/'.$profile_pic).");background-size: contain;background-position: center;background-repeat: no-repeat;";
										$opacity = "opacity:0";
									}else{
										$strr = "";
										$opacity = "opacity:1";
									}
								@endphp
								@error('upload-file')
									@php $strr .= "margin-top:5px"; @endphp
								@enderror
								@error('upload-file') <span class="text" style="color: red"> {!! $message !!} </span>@enderror
								<div class="image-box" style="{{ $strr }}">
									<label class="fileUpload" style="{{ $opacity }}">
										<i class="icon-camera"></i>
										<span>Upload Your Image</span>
										<input type="file" class="form-control upload-file" name="upload-file">
									</label>
								</div>
							</div>			
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Pay Personal No: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control personal_no" name="personal_no" value="{{ $personal_no }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group @error('dob') {{ 'input-group-error' }} @enderror">
									<div class="resp-text">
										<label>Date of Birth: <span class="req">*</span></label>
										<span class="text">@error('dob') {!! $message !!} @enderror</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control dob" placeholder="DD/MM/YYYY" value="{{ $dob }}" name="dob" id="dob" autocomplete="off" >
										<span class="icon @error('dob') {{ 'icon-error' }} @enderror">
											@error('dob')<i class="icon-cancel-circle"></i>@enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Official Designation: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<select class="form-control designation ui-dropdown" name="designation">
											<option value="">Choose an Option</option>
											@if (count($off__dsg) > 0)
												@foreach ($off__dsg as $val)
													<option value="{{ $val->id }}" {{( $designation == $val->id) ? "selected" : ""}}>{{ $val->name }}</option>
												@endforeach
											@endif
										</select>
										{{-- <input type="text" class="form-control designation" name="designation" value="{{ $designation }}"> --}}
										<span class="icon"></span>
									</div>
								</div>
							</div>
							{{-- {{ dd($dob) }} --}}
							<div class="col-md-12 col-lg-6">
								<div class="form-group @error('appointment') {{ 'input-group-error' }} @enderror">
									<div class="resp-text">
										<label>Date of Appointment: <span class="req">*</span></label>
										<span class="text">@error('appointment') {!! $message !!} @enderror</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control appointment" value="{{ $appointment }}" name="appointment" id="appointment" placeholder="DD/MM/YYYY" autocomplete="off">
										<span class="icon @error('appointment') {{ 'icon-error' }} @enderror">
											@error('appointment')<i class="icon-cancel-circle"></i>@enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Cell No: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="tel" class="form-control cell_no" name="cell_no" value="{{ $cell_no }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>WhatsApp No:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="tel" class="form-control whatsapp_no" name="whatsapp_no" value="{{ $whatsapp_no }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Blood Group: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<select class="form-control ui-dropdown blood_group" name="blood_group">
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
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Email:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="email" class="form-control email" name="email" value="{{ $email }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Address: <span class="req">*</span></label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control address" name="address" value="{{ $address }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Facebook Link:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control facebook_link" name="facebook_link" value="{{ $fb_link }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>LinkedIn Link:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control linkedin_link" name="linkedin_link" value="{{ $linkedin_link }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Instagram Link:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control instagram_link" name="instagram_link" value="{{ $insta_link }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<div class="resp-text">
										<label>Twitter Link:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control twitter_link" name="twitter_link" value="{{ $tw_link }}">
										<span class="icon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<button type="button" class="btn btn-submit"><i class="icon-check_circle_outline"></i>
									Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
	<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
	<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
    <script>
        $('.whatsapp_no').samask("0000-0000000");
        $('.cell_no').samask("0000-0000000");
        $('#dob').samask("00/00/0000");
        $('#appointment').samask("00/00/0000");
    	$('.cell_no , .whatsapp_no').change(function(e){
    		var new_val = $(this).val();
    		var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
    		$(this).val(new_val);
    	});
    	$('#dob , #appointment').change(function(e){
    		var new_val = $(this).val();
    		var new_val = new_val.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3");
    		$(this).val(new_val);
    	});

        $("input[name='appointment']").datepicker({
            format:'dd/mm/yyyy',
            autoHide:true,
            Default: "{{ $appointment }}",
            endDate : 'today',
        });
        $("input[name='dob']").datepicker({
            format:'dd/mm/yyyy',
            autoHide:true,
            Default: "{{ $dob }}",
            endDate : 'today',
        });
        function on_change(selector){
        	if($(selector).val().trim() != ''){
				$(selector).closest('.resp-icon').find('.icon').addClass('icon-success').removeClass('icon-error').html(`<i class="icon-check_circle_outline"></i>`);
				$(selector).closest('.form-group').addClass('input-group-success').removeClass('input-group-error');
				$(selector).closest('.form-group').find('.text').html('');
        	}else{
				$(selector).closest('.resp-icon').find('.icon').addClass('icon-error').removeClass('icon-success').html(`<i class="icon-cancel-circle"></i>`);
				$(selector).closest('.form-group').addClass('input-group-error').removeClass('input-group-success');
			}
        }
        function on_change2(selector){
        	if($(selector).val().trim() != ''){
				$(selector).closest('.resp-icon').find('.icon').addClass('icon-success').removeClass('icon-error').html(``);
				$(selector).closest('.form-group').addClass('input-group-success').removeClass('input-group-error');
				$(selector).closest('.form-group').find('.text').html('');
        	}else{
				$(selector).closest('.resp-icon').find('.icon').addClass('icon-error').removeClass('icon-success').html(`<i class="icon-cancel-circle"></i>`);
				$(selector).closest('.form-group').addClass('input-group-error').removeClass('input-group-success');
			}
        }
        function on_change3(selector){
        	if($(selector).val().trim() != ''){
        		if($(selector).val().length == 10){
        			var ss = $(selector).val();
        			var new_ss = ss.split('/');
        			if(new_ss.length != 3 && new_ss[1].length == 2){
						$(selector).closest('.resp-icon').find('.icon').addClass('icon-error').removeClass('icon-success').html(`<i class="icon-cancel-circle"></i>`);
						$(selector).closest('.form-group').addClass('input-group-error').removeClass('input-group-success');
        			}else{
						$(selector).closest('.resp-icon').find('.icon').addClass('icon-success').removeClass('icon-error').html(``);
						$(selector).closest('.form-group').addClass('input-group-success').removeClass('input-group-error');
						$(selector).closest('.form-group').find('.text').html('');        				
        			}
        		}else{
					$(selector).closest('.resp-icon').find('.icon').addClass('icon-error').removeClass('icon-success').html(`<i class="icon-cancel-circle"></i>`);
					$(selector).closest('.form-group').addClass('input-group-error').removeClass('input-group-success');
        		}
        	}else{
				$(selector).closest('.resp-icon').find('.icon').addClass('icon-error').removeClass('icon-success').html(`<i class="icon-cancel-circle"></i>`);
				$(selector).closest('.form-group').addClass('input-group-error').removeClass('input-group-success');
			}
        }
        $('.full_name , .father_name , .cnic , .personal_no, .designation, .cell_no, .blood_group').on('change , keyup',function(){
        	on_change($(this));
        })
        $('.dob, .appointment').on('change , keyup',function(){
        	on_change3($(this));
        })
        $('.address').on('change , keyup',function(){
        	on_change2($(this));
        })
        $(document).ready(function(){
        	$('.btn-submit').click(function(){
        		var full_name = $('.full_name').val().trim();
        		var father_name = $('.father_name').val().trim();
        		var cnic = $('.cnic').val().trim();
        		var personal_no = $('.personal_no').val().trim();
        		var dob = $('.dob').val().trim();
        		var designation = $('.designation').val().trim();
        		var appointment = $('.appointment').val().trim();
        		var cell_no = $('.cell_no').val().trim();
        		var whatsapp_no = $('.whatsapp_no').val().trim();
        		var blood_group = $('.blood_group').val().trim();
        		var email = $('.email').val().trim();
        		var address = $('.address').val().trim();
        		var i = 0;
				if(full_name == ""){
					$('.full_name').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.full_name').closest('.form-group').addClass('input-group-error');
					$('.full_name').closest('.form-group').find('.text').html(`Full Name Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(father_name == ""){
					$('.father_name').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.father_name').closest('.form-group').addClass('input-group-error');
					$('.father_name').closest('.form-group').find('.text').html(`Father Name Field is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(father_name.length > 30){
					$('.father_name').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.father_name').closest('.form-group').addClass('input-group-error');
					$('.father_name').closest('.form-group').find('.text').html(`Father Name character's length exceed`);
					i = parseInt(i) + parseInt(1);
				}
				if(cnic == ""){
					$('.cnic').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.cnic').closest('.form-group').addClass('input-group-error');
					$('.cnic').closest('.form-group').find('.text').html(`CNIC Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(personal_no == ""){
					$('.personal_no').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.personal_no').closest('.form-group').addClass('input-group-error');
					$('.personal_no').closest('.form-group').find('.text').html(`Personal No Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(dob == ""){
					$('.dob').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.dob').closest('.form-group').addClass('input-group-error');
					$('.dob').closest('.form-group').find('.text').html(`Date of Birth Field is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(dob.length > 0){
					var dob_ex = dob.split('/');
					if(dob_ex.length != 3){
						$('.dob').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
						$('.dob').closest('.form-group').addClass('input-group-error');
						$('.dob').closest('.form-group').find('.text').html(`Date of Birthday format is invalid.`);
						i = parseInt(i) + parseInt(1);
					}else{
						dob = new Date(dob);
						var today = new Date();
						var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
						if(Number(age) < 18){
							$('.dob').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
							$('.dob').closest('.form-group').addClass('input-group-error');
							$('.dob').closest('.form-group').find('.text').html(`DOB must be greater than 18 years.`);
							i = parseInt(i) + parseInt(1);
						}
					}
				}
				if(appointment == ""){
					$('.appointment').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.appointment').closest('.form-group').addClass('input-group-error');
					$('.appointment').closest('.form-group').find('.text').html(`Appointment Date is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(appointment.length > 0){
					var appointment_ex = appointment.split('/');
					console.log(appointment_ex);
					if(appointment_ex.length != 3){
						$('.appointment').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
						$('.appointment').closest('.form-group').addClass('input-group-error');
						$('.appointment').closest('.form-group').find('.text').html(`Appointment Date format is invalid.`);
						i = parseInt(i) + parseInt(1);
					}
				}
				if(designation == ""){
					$('.designation').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.designation').closest('.form-group').addClass('input-group-error');
					$('.designation').closest('.form-group').find('.text').html(`Designation Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(cell_no == ""){
					$('.cell_no').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.cell_no').closest('.form-group').addClass('input-group-error');
					$('.cell_no').closest('.form-group').find('.text').html(`Cell No Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(address == ""){
					// $('.address').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.address').closest('.form-group').addClass('input-group-error');
					$('.address').closest('.form-group').find('.text').html(`Address Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(blood_group == ""){
					$('.blood_group').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.blood_group').closest('.form-group').addClass('input-group-error');
					$('.blood_group').closest('.form-group').find('.text').html(`Blood Group is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(i == 0){
					$('form').submit();
				}else{
					
                  $([document.documentElement, document.body]).animate({
                      scrollTop: $("form").find('.input-group-error').offset().top - 50
                  }, 1000);
				}
        	})
        })
    </script>
@include('login.layouts.footer')