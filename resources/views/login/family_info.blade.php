@include('login.layouts.header')
	@php
		$record = (!empty($user_info) and !empty($user_info->family_info ))?json_decode($user_info->family_info , true):array();
		// dd($record);
	@endphp
{{-- 		<header class="title-header main-header">
			<div class="container">
				<div class="header-text">
					<h1 class="header-title">Family Information</h1>
					<ul class="breadcrumb">
						<li><a href="{{ route('user-dashboard') }}">Home</a></li>
						<li><span>Family Information</span></li>
					</ul>
				</div>
			</div>
		</header>
 --}}
		<main class="dashboard-section">
			<div class="container-fluid" id="outer-container">
				<div class="row">
					<div class="col-md-12 col-lg-3">
						<div class="dash-aside">
							@include('login.layouts.sidebar')
						</div>
					</div>
					<div class="col-md-12 col-lg-9">
						<div class="main-column">
							<h3 class="rounded-top">Family Information</h3>
							<div class="row custom-row">
								<div class="col-md-12 col-lg-12 col-xl-12 row">
									<div class="col-12 msg_div"></div>
								</div>
							</div>
							<form action="{{ route('family-information') }}" class="family-form" method="post">
								@csrf
								@if (count($record) > 0)
									{{-- {{ dd($record) }} --}}
									@foreach ($record as $e)
										<div class="row custom-row">
											<div class="col-md-10 col-lg-10 col-xl-10 row">
												<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="form-group">
														<input type="text" class="form-control name" placeholder="Member Name" name="name[]" value="{{ $e['name'] }}">
													</div>
												</div>
												<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="form-group">
														<select name="relation[]" class="ui-dropdown">
															<option value="">Select Relation</option>
															<option value="father" {{ ($e['relation'] == 'father')?"selected":"" }}>Father</option>
															<option value="mother" {{ ($e['relation'] == 'mother')?"selected":"" }}>Mother</option>
															<option value="husband" {{ ($e['relation'] == 'husband')?"selected":"" }}>Husband</option>
															<option value="wife" {{ ($e['relation'] == 'wife')?"selected":"" }}>Wife</option>
															<option value="son" {{ ($e['relation'] == 'son')?"selected":"" }}>Son</option>
															<option value="daughter" {{ ($e['relation'] == 'daughter')?"selected":"" }}>Daughter</option>
														</select>
													</div>
												</div>
												<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="form-group">
														<input type="number" class="form-control age" placeholder="Age in Years" name="age[]" value="{{ $e['age'] }}" max="200" min="0">
													</div>
												</div>
												<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="form-group">
														<select name="status[]" class="ui-dropdown">
															<option value="">Marital Status</option>
															<option value="married" {{ ($e['status']=='married')?"selected":"" }}>Married</option>
															<option value="unmarried" {{ ($e['status']=='unmarried')?"selected":"" }}>Unmarried</option>
															<option value="widow" {{ ($e['status']=='widow')?"selected":"" }}>Widow</option>
															<option value="widower" {{ ($e['status']=='widower')?"selected":"" }}>Widower</option>
															<option value="divorced" {{ ($e['status']=='divorced')?"selected":"" }}>Divorced</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-2 col-lg-2 col-xl-2 text-center">
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
													<input type="name" class="form-control name" placeholder="Member Name" name="name[]">
												</div>
											</div>
											<div class="col-md-6 col-lg-6 col-xl-3">
												<div class="form-group">
													<select name="relation[]" class="ui-dropdown">
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
													<select name="status[]" class="ui-dropdown">
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
										<div class="col-md-2 col-lg-2 col-xl-2 text-center">
											<div class="form-group icon-group">
												<span class="icon-add" title="Add Row"><i class="icon-plus"></i></span>
												<span class="icon-delete" title="Delete Row"><i class="icon-bin"></i>
												</span>
											</div>
										</div>
									</div>
								@endif
								<div class="row">
									<div class="col-md-3" style="margin-left:auto;">
										<div class="form-group">
											<button type="button" class="btn btn-submit family-btn-submit"><i class="icon-check_circle_outline"></i>
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

<script>
	$(document).ready(function(){
		check_row();
		function check_row() {
			var count_row = $('.icon-delete');
			if(parseInt(count_row.length) == 1){
				$('.icon-delete').hide();
			}else{
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
		$(".family-form").on("click",".icon-add i",function(){
			var row = `<div class="row custom-row">
							<div class="col-md-10 col-lg-10 col-xl-10 row">
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<input type="text" class="form-control name" placeholder="Member Name" name="name[]">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="form-group">
										<select name="relation[]" class="ui-dropdown">
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
										<select name="status[]" class="ui-dropdown">
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
							<div class="col-md-2 col-lg-2 col-xl-2 text-center">
								<div class="form-group icon-group">
									<span class="icon-add" title="Add Row"><i class="icon-plus"></i></span>
									<span class="icon-delete" title="Delete Row"><i class="icon-bin"></i>
									</span>
								</div>
							</div>
					   </div>`;
			$(".family-form").find(".row:last-child").before(row);
	        $(".ui-dropdown").chosen();
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
		$(".family-form").on("click",".icon-delete i",function(){
			if($(".family-form").find(".custom-row").length > 1){
				if(confirm('Are you sure want to remove this member ?')){
					$(this).closest(".custom-row").remove();
				}
			}
			check_row();
		});
		$('.family-btn-submit').click(function(){
			var FormData = $('form').serializeArray();
			var url = '{{ route('family-information') }}';
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data:{
					update:'true',
					FormData:FormData,
					_token:_token,
				},success:function(e){
					console.log(e);
					if(e == 'success'){
						$('.msg_div').html(`<div class="message message-success">
												<span>Family Information has been updated successfully.</span>
												<i class="close">&times;</i>
											</div>`);
						$('.close').click(function(){
							$('.msg_div').html('');
						});
						$('.age').each(function(index){
							if($(this).val() > 100){
								$(this).val(100);
							}else if($(this).val() < 0){
								$(this).val(0);
							}
						})
					}else{
						// alert('adsf');
						$('.msg_div').html(`<div class="message message-error">
												<span>Record updation failed due to incomplete form. </span>
												<i class="close">&times;</i>
											</div>`);
						$('.close').click(function(){
							$('.msg_div').html('');
						});
						$('.age').each(function(index){
							if($(this).val() > 100){
								$(this).val(100);
							}else if($(this).val() < 0){
								$(this).val(0);
							}
						})
					}
				},error:function(e){
					console.log(e);
					alert(e);
				}
			})
		});
	    // $("#outer-container").on("mouseenter",function(){
	    // });
    })
</script>
@include('login.layouts.footer')