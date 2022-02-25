@php
	if(old()){
		$full_name = old('full_name');
		$cnic = old('cnic');
		$father_name = old('father_name');
		$cell_no = old('cell_no');
		$relation = old('relation');
		$email = old('email');
	}elseif(!empty($user)){
		$record = (!empty($user_info) )?json_decode(json_encode($user_info) , true):array();
		$full_name = (array_key_exists('full_name', $record))?$record['full_name']:"";
		$relation = (array_key_exists('relation', $record))?$record['relation']:"";
		$father_name = (array_key_exists('father_name', $record))?$record['father_name']:"";
		$cnic = (array_key_exists('cnic', $record))?$record['cnic']:"";
		$cell_no = (array_key_exists('cell_no', $record))?$record['cell_no']:"";
		$email = (array_key_exists('email', $record))?$record['email']:"";
	}else{
		$full_name = $father_name = $cnic = $relation = $cell_no = $email = "";
	}
@endphp
@include('login.layouts.header')
{{-- <header class="title-header main-header">
	<div class="container">
		<div class="header-text">
			<h1 class="header-title">Nominee Information</h1>
			<ul class="breadcrumb" id="breadcrumb">
				<li><a href="{{ route('user-dashboard') }}">Home</a></li>
				<li><span>Nominee Information</span></li>
			</ul>
		</div>
	</div>
</header> --}}
<main class="dashboard-section" id="breadcrumb">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-3">
				<div class="dash-aside">
					@include('login.layouts.sidebar')
				</div>
			</div>
			<div class="col-md-12 col-lg-9">
				<div class="main-column">
					<h3 class="rounded-top">Nominee Information</h3>
					<form action="{{ route('nominee-information') }}" method="post" id="nominee_info" class="user-form">
						@csrf
						<div class="row">
							@if ($errors->any())
							<script>
							$([document.documentElement, document.body]).animate({
							scrollTop: $("#breadcrumb").offset().top
							}, 1000);
							</script>
							@endif
							@if(session()->has("success"))
							<script>
							$([document.documentElement, document.body]).animate({
							scrollTop: $("#breadcrumb").offset().top
							}, 1000);
							</script>
							<div class="col-md-12">
								<div class="message message-success">
									<span>{!! session("success") !!}</span>
									<i class="close close-message">×</i>
								</div>
							</div>
							@endif
							@if(session()->has("error"))
							<script>
							$([document.documentElement, document.body]).animate({
							scrollTop: $("#breadcrumb").offset().top
							}, 1000);
							</script>
							<div class="col-md-12">
								<div class="message message-error">
									<span>{!! session("error") !!}</span>
									<i class="close close-message">×</i>
								</div>
							</div>
							@endif
							<div class="col-md-6">
								<div class="form-group @error('full_name') input-group-error @enderror">
									<div class="resp-text">
										<label>Nominee's Name:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('full_name') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control full_name" name="full_name" value="{{ $full_name }}">
										<span class="icon @error('full_name') icon-error @enderror">
											@error('full_name') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('relation') input-group-error @enderror">
									<div class="resp-text">
										<label>Relation:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('relation') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<select name="relation" class="relation ui-dropdown">
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
										<span class="icon @error('relation') icon-error @enderror">
											@error('relation') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('father_name') input-group-error @enderror">
									<div class="resp-text">
										<label>Father/Husband's Name:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('father_name') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control father_name" name="father_name" value="{{ $father_name }}">
										<span class="icon @error('father_name') icon-error @enderror">
											@error('father_name') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('cnic') input-group-error @enderror">
									<div class="resp-text">
										<label>CNIC:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('cnic') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="tel" class="form-control cnic" name="cnic" value="{{ $cnic }}">
										<span class="icon @error('cnic') icon-error @enderror">
											@error('cnic') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('cell_no') input-group-error @enderror">
									<div class="resp-text">
										<label>Contact No:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('cell_no') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="tel" class="form-control cell_no" name="cell_no" value="{{ $cell_no }}">
										<span class="icon @error('cell_no') icon-error @enderror">
											@error('cell_no') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('email') input-group-error @enderror">
									<div class="resp-text">
										<label>Email:</label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('email') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="email" class="form-control email" name="email" value="{{ $email }}">
										<span class="icon @error('email') icon-error @enderror">
											@error('email') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn btn-submit"><i class="icon-check_circle_outline"></i>
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
  <script src="{{ asset('assets/js/validateLogin.js') }}"></script>
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
  <script>
    $(document).ready(function(){
      $('.cnic').samask("00000-0000000-0");
	  	$('.cnic').keyup(function(e){
	  		var new_val = $(this).val();
	  		var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
	  		$(this).val(new_val);
	  	})
		  $('.cell_no').samask("0000-0000000");
	  	$('.cell_no').keyup(function(e){
	  		var new_val = $(this).val();
	  		var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
	  		$(this).val(new_val);
	  	})
			window._____ISERROR = false;
			_is_validate("#nominee_info", { 
				full_name: { require: !0}, 
				cnic: { require: !0, cnic: !0 }, 
				father_name: { require: !0}, 
				relation: { require: !0}, 
				email: { require: !0,email: !0}, 
				cell_no: { require: !0, phone: !0}
			});
			$('form').submit(function(e){
				if(window._____ISERROR == true){
					return false;
				}else{
					return true;
				}
			})
    })
  </script>
@include('login.layouts.footer')