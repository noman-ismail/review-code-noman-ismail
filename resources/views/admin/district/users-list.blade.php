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
	@php
		$total_cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	@endphp
	@include('admin.layout.header')
@elseif($__userType == 'district')
	@include('admin.district.layouts.header')
@elseif($__userType == 'province')
	@php
		$total_cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->where('province',$__user->dept_id)->get();
	@endphp
	@include('admin.province.layouts.header')
@elseif($__userType == 'national')
	@php
		$total_cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	@endphp
	@include('admin.national.layouts.header')
@endif
{{-- {{ dd($__userType) }} --}}
@php
  if(request()->has('pending') and request('pending') == 'true'){
    $vll = 'pending';
  }elseif(request()->has('approved') and request('approved') == 'true'){
    $vll = 'approved';
  }elseif(request()->has('rejected') and request('rejected') == 'true'){
    $vll = 'rejected';
  }elseif(request()->has('deleted') and request('deleted') == 'true'){
    $vll = 'deleted';
  }else{
    $vll = 'all';
  }
  $dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
@endphp
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Users List <span style="font-size: 12px">( APJEA Members )</span></h6>
				</div>
				<div class="text-right">
					<a href="{{ route('user-list') }}" class="btn btn-sm {{ ($vll == 'all')?"btn-secondary":"btn-success" }}">All</a>
					<a href="{{ route('user-list')."?pending=true" }}" class="btn btn-sm {{ ($vll == 'pending')?"btn-secondary":"btn-success" }}">Pending</a>
					<a href="{{ route('user-list')."?approved=true" }}" class="btn btn-sm {{ ($vll == 'approved')?"btn-secondary":"btn-success" }}">Approved</a>
					<a href="{{ route('user-list')."?rejected=true" }}" class="btn btn-sm {{ ($vll == 'rejected')?"btn-secondary":"btn-success" }}">Rejected</a>
					<a href="{{ route('user-list')."?deleted=true" }}" class="btn btn-sm {{ ($vll == 'deleted')?"btn-secondary":"btn-success" }}">Deleted</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
		        <div class="col-md-12">
		          <form action="{{ route('user-list') }}">
		            @if (request()->has('approved'))
		              <input type="hidden" name="approved" value="{{ request('approved') }}">
		            @elseif(request()->has('pending'))
		              <input type="hidden" name="pending" value="{{ request('pending') }}">
		            @elseif(request()->has('rejected'))
		              <input type="hidden" name="rejected" value="{{ request('rejected') }}">
		            @elseif(request()->has('deleted'))
		              <input type="hidden" name="deleted" value="{{ request('deleted') }}">
		            @endif
		            <div class="form-row">
		              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-2">
		                <input type="text" name="search" class="form-control" placeholder="Search by Name" value="{{ request('search') }}">
		              </div>
		              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-2">
		                <input type="text" name="cnic" class="form-control" id="cnic" placeholder="Search by CNIC" value="{{ request('cnic') }}">
		              </div>
						@if ($__userType != 'district')
			              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-3">
			                <select class="form-control form-control-chosen" name="city">
			                  <option value="">Choose City</option>
			                  @if (count($total_cities))
			                    @foreach ($total_cities as $value)
			                      <option value="{{ $value->id }}" {{ ($value->id == request('city'))?"selected":"" }}>{{ $value->name }}</option>
			                    @endforeach
			                  @endif
			                </select>
			              </div>
						@else
			              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-3">
			                <select class="form-control form-control-chosen" name="designation">
			                  <option value="">Choose Designation</option>
			                  @if (count($dsg))
			                    @foreach ($dsg as $value)
			                      <option value="{{ $value->id }}" {{ ($value->id == request('designation'))?"selected":"" }}>{{ $value->name }}</option>
			                    @endforeach
			                  @endif
			                </select>
			              </div>
			            @endif
		              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-2">
		                <input type="text" name="date_from" class="form-control" id="date-picker" data-toggle="datepicker" autocomplete="off" placeholder="Date From" value="{{ request('date_from') }}">
		              </div>
		              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-2">
		                <input type="text" name="date_to" class="form-control" id="date-picker1" data-toggle="datepicker" autocomplete="off" placeholder="Date To" value="{{ request('date_to') }}">
		              </div>
		              <div class="form-group col-sm-4 col-md-4 col-lg-4 col-xl-1">
		                <button class="btn btn-info btn-sm w-100">Search</button>
		              </div>
		            </div>
		          </form>
		        </div>
				<div class="col-md-12">
					<table class="table table-striped">
						<thead>
							<th>#</th>
							<th>Name</th>
							<th>Designation</th>
							@if ($__userType != 'district')
								<th>City</th>
							@endif
							<th>Contact</th>
							<th>Residential City</th>
							<th>Register Date</th>
							@if ($vll == 'all')
								<th>Status</th>
							@endif
							@if ($__userType == 'district')
								<th>Action</th>
							@endif
						</thead>
						<tbody>
							@if(count($users) > 0)
								@php
									$i = 1;
								@endphp
								@foreach ($users as $value)
									<tr>
										<td>{{ $i++ }}</td>
										<td data-id="{{ $value->id }}">
											@if ($__userType == 'district')
											<span title="View" data-toggle="modal" data-target="#modalview" class="user-detail" style="cursor: pointer;">{{ $value->name }}</span>
											@else
											<span>{{ $value->name }}</span>
											@endif
										</td>
										<td>{{ get_user_off_dsg($value->designation) }}</td>
										@if ($__userType != 'district')
											<td>{{ get_DeptName($value->district , 'district') }}</td>
										@endif
										<td>{{ $value->contact }}</td>
										<td>{{ get_DeptName($value->residence , 'district') }}</td>
										<td>{{ date('d/m/Y h:i:s A' , strtotime($value->created_at)) }}</td>
										@if ($vll == 'all')
											<td class="status">{{ ucfirst(($value->status == 'reject') ? "rejected" : $value->status) }}</td>
										@endif
										@if ($__userType == 'district')
											<td data-id='{{ $value->id }}'>
												<a href="#">
													<i class="fa fa-check appr_u text-success first" title="Approve" style="display: {{ ($value->status == 'pending' and $value->status != "deleted")?"inherit":"none" }}"></i>
												</a>
												<a href="#">
													<i class="fa fa-times ml-3 text-danger first" title="Reject" style="display: {{ ($value->status == 'pending' and $value->status != "deleted")?"inherit":"none" }}"></i>
												</a>
												<a href="#">
													<i class="fa fa-info-circle text-success second" title="View" style="display: {{ ($value->status != 'pending')?"inherit":"none" }}" data-toggle="modal" data-target="#modalview"></i>
												</a>
												<a href="#">
													<i class="fa fa-trash ml-3 text-danger second del" title="Delete" style="display: {{ ($value->status != 'pending' and $value->status != "deleted")?"inherit":"none" }}" data-toggle="modal" data-target="#deleteUser"></i>
												</a>
												<a href="#">
													<i class="fas ml-3 text-primary  secondd {{ ($value->ban != 'ban')?"fa-lock":"fa-lock-open" }} ban" title="{{ ($value->ban != 'ban')?"ban":"unban" }}" style="display: {{ ($value->status == 'approved')?"inherit":"none" }}"></i>
												</a>
												@if ($vll == 'deleted')
													<a href="#">
														<i class="fa fa-trash text-success first p_delete ml-3" title="Permanent Delete"></i>
													</a>
													<a href="#">
														<i class="fa fa-check text-success first restore ml-3" title="Restore"></i>
													</a>
												@endif
											</td>
										@endif
									</tr>
								@endforeach
							@else
								<tr class="text-center">
									<td colspan="7">There is no record.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div><!--/.body content-->
	<div class="modal fade" id="modalview" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModal">User Information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModal2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModal2">Delete User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="hidden" class="hidden_del_id" >
						<div class="col-12">
							<p>Why do you want to delete this user? Choose an option</p>
			              <div class="productdetail">
			                <label class="chk-st-d">
			                  <input type="radio" id="death" class="width-auto reason" name="reason" value="death">
			                  <span>Death</span>
			                </label>
			                <label class="chk-st-d">
			                  <input type="radio" id="retire" class="width-auto reason" name="reason" value="retire">
			                  <span>Retired</span>
			                </label>
			                <label class="chk-st-d">
			                  <input type="radio" id="resign" class="width-auto reason" name="reason" value="resign">
			                  <span>Resigned</span>
			                </label>
			                <label class="chk-st-d">
			                  <input type="radio" id="transfer" class="width-auto reason" name="reason" value="transfer">
			                  <span>Transfer</span>
			                </label>
			                <label class="chk-st-d">
			                  <input type="radio" id="other" class="width-auto reason" name="reason" value="other">
			                  <span>Other</span>
			                </label>
			              </div>
			            </div>
			            <div class="col-md-12 mt-2">
			            	<div class="form-row death_detail delete_detail" style="display: none">
			            		<div class="col-12 form-group">
			            			<label for="">Death Date</label>
			            			<input type="text" class="form-control death_date" data-toggle="datepicker" id="#death_date">
			            		</div>
			            	</div>
			            	<div class="form-row retired_detail delete_detail" style="display: none">
			            		<div class="col-12 form-group">
			            			<label for="">Retired Date</label>
			            			<input type="text" class="form-control retired_date" data-toggle="datepicker" id="#retired_date">
			            		</div>
			            	</div>
			            	<div class="form-row resigned_detail delete_detail" style="display: none">
			            		<div class="col-12 form-group">
			            			<label for="">Resigned Date</label>
			            			<input type="text" class="form-control resigned_date" data-toggle="datepicker" id="#resigned_date">
			            		</div>
			            	</div>
			            	<div class="form-row transfer-detail delete_detail" style="display: none">
			            		<div class="col-12 form-group">
			            			<label for="">Transfer Date</label>
			            			<input type="text" class="form-control transfer_date" data-toggle="datepicker" id="#transfer_date">
			            		</div>
				            	<div class="form-group col-12">
				            		<label for="">Choose a City</label>
				            		<select class="transfer_city form-control form-control-chosen">
					            		<option value="">Choose an Option</option>
					            		@if (count($cities) > 0)
					            			@foreach ($cities as $val)
					            				<option value="{{ $val->id }}">{{ $val->name }}</option>
					            			@endforeach
					            		@endif
					            	</select>
				            	</div>
			            	</div>
			            	<div class="form-row other_detail delete_detail" style="display: none">
			            		<div class="col-12">
				            		<label for="">Reason</label>
				            		<input type="text" class="reason_detail form-control">
				            	</div>
			            	</div>
			            </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary delted" type="button" disabled> Submit </button>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
	<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.14.0/sweetalert2.min.css" integrity="sha512-A374yR9LJTApGsMhH1Mn4e9yh0ngysmlMwt/uKPpudcFwLNDgN3E9S/ZeHcWTbyhb5bVHCtvqWey9DLXB4MmZg==" crossorigin="anonymous" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.14.0/sweetalert2.min.js" integrity="sha512-tiZ8585M9G8gIdInZMGGXgEyFdu8JJnQbIcZYHaQxq+MP4+T8bkvA+TfF9BjPmiePjhBhev3bQ6nloOB1zF9EA==" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
      $('#cnic').samask("00000-0000000-0");
      $('#cnic').keyup(function(){
          $(this).val($(this).val().replace(/(\d{5})\-?(\d{7})-?(\d{1})/,'$1-$2-$3'))
      });
	    toastr.options = {
	      "closeButton": true,
	      "debug": false,
	      "newestOnTop": false,
	      "progressBar": true,
	      "positionClass": "toast-top-right",
	      "preventDuplicates": false,
	      "onclick": null,
	      "showDuration": "600",
	      "hideDuration": "1000",
	      "timeOut": "20000",
	      "extendedTimeOut": "20000",
	      "showEasing": "swing",
	      "hideEasing": "linear",
	      "showMethod": "fadeIn",
	      "hideMethod": "fadeOut"
	    };
	    $('.reason').click(function(){
	    	var reason_type = $(this).val();
	    	$('.delted').attr('disabled',false);
	    	if(reason_type == 'transfer'){
	    		$('.delete_detail').css('display','none');
	    		$('.transfer-detail').css('display','block');
	    	}else if(reason_type == 'other'){
	    		$('.delete_detail').css('display','none');
	    		$('.other_detail').css('display','block');
	    	}else if(reason_type == 'death'){ 		
	    		$('.delete_detail').css('display','none');
	    		$('.death_detail').css('display','block');
	    	}else if(reason_type == 'retire'){ 		
	    		$('.delete_detail').css('display','none');
	    		$('.retired_detail').css('display','block');
	    	}else if(reason_type == 'resign'){ 		
	    		$('.delete_detail').css('display','none');
	    		$('.resigned_detail').css('display','block');
	    	}else{
	    		$('.delete.detail').css('display','none');
	    	}
	    });
	    $('.del').click(function(){
					var id = $(this).closest('td').attr('data-id');
	    		$('.hidden_del_id').val(id);
	    })
	    $('.p_delete').click(function(){
	    	if (confirm('Are you sure want to delete this user permanently?')) {
					var get_request = '{{ $vll }}';
					// $(this).closest('td').find('.first').hide();
					var t = $(this);
					var id = $(this).closest('td').attr('data-id');	    		
					$.ajax({
						url:base_url+admin+'/user-list',
	          method:'POST',
	          dataType:'json',
	          data:{
	            action:'permanent_delete',
	            id,id,
	            _token:_token,
	          }, success:function(res){
	          	if(res == 'success'){
          			t.closest('tr').remove();
								toastr.success('User permanent deleted successfully.');
	          	}else{
								toastr.warning(res);	                		
	          	}
	          }, error:function(e){
	            toastr.error('Something wrong please refresh page and try again.');
	          }
					})
	    	}
	    })
			$('.appr_u , .restore').click(function(){
				var get_request = '{{ $vll }}';
				$(this).closest('td').find('.first').hide();
				var t = $(this);
				var id = $(this).closest('td').attr('data-id');
					$.ajax({
						url:base_url+admin+'/user-list',
	          method:'POST',
	          dataType:'json',
	          data:{
	            action:'approve',
	            id,id,
	            _token:_token,
	          }, success:function(res){
	          	if(res == 'success'){
	          		if (get_request == 'deleted') {
	          			t.closest('tr').remove();
	          		}
	          		t.closest('td').prev('td.status').html('Approved');
	          		t.closest('td').find('.first').css('display','none');
	          		t.closest('td').find('.second').css('display','inherit');
	          		t.closest('td').find('.secondd').css('display','inherit');
								toastr.success('User request is approved successfully.');
	          	}else{
								$('.first').show();
								toastr.warning(res);	                		
	          	}
	          }, error:function(e){
							$('.first').show();
	            toastr.error('Something wrong please refresh page and try again.');
	          }
					})
			});
			$('.fa-info-circle , .user-detail').click(function(){
      	$('#modalview .modal-body').html('');
				var t = $(this);
				var id = $(this).closest('td').attr('data-id');
				$.ajax({
					url:base_url+admin+'/user-list',
	        method:'POST',
	        dataType:'html',
	        data:{
	          action:'user_detail',
	          id,id,
	          _token:_token,
	        }, success:function(res){
	        	$('#modalview .modal-body').html(res);
	        }, error:function(e){
	          toastr.error('Something wrong please refresh page and try again.');
	        }
				})
			});
			$('.fa-times').click(function(){
				var t = $(this);
				var id = $(this).closest('td').attr('data-id');
				var title = "Why do you want to reject this request ?";
				change_status(title,'reject',id,t);
			});
			$('.delted').click(function(){
	    	var id =	$('.hidden_del_id').val();
				var reason_type = $('input[name="reason"]:checked').val();
				var check_error = '';
	    	var reason_array = {};
				if (reason_type == undefined) {
					alert('Why do you want to delete this user ?');
				}else{
			    reason_array['type'] = reason_type;
		    	if(reason_type == 'transfer'){
		    		var trns_c = $('.transfer_city').val();
		    		if (trns_c.trim() == '') {
		    			alert('Please choose transfer city.');
		    			check_error = 'yes';
		    		}else{
		    			var trans_city = $(".transfer_city option:selected").html();
		    			var reason = "This user has been trasnfered in "+trans_city;
					    reason_array['trasnfer_city'] = trns_c;
					    reason_array['trasnfer_city_name'] = trans_city;
		    		}
		    	}else if(reason_type == 'other'){
		    		var reason_detail = $('.reason_detail').val();
		    		if (reason_detail.trim() == '') {
		    			alert('Please Enter Raeson.');
		    			check_error = 'yes';
		    		}else{
		    			var reason = "This user has been deleted because "+reason_detail;
					    reason_array['reason_detail'] = reason_detail;
		    		}
		    	}else if(reason_type == 'death'){
		    		var death_date = $('.death_date').val();
		    		if (death_date.trim() == '') {
		    			alert('Please Enter Death Date.');
		    			check_error = 'yes';
		    		}else{
		    			var reason = "This user has been passed away on "+death_date;
					    reason_array['death_date'] = reason;
		    		}
		    	}else if(reason_type == 'retire'){
		    		var retired_date = $('.retired_date').val();
		    		if (retired_date.trim() == '') {
		    			alert('Please Enter Death Date.');
		    			check_error = 'yes';
		    		}else{
		    			var reason = "This user has been retired on "+retired_date;
					    reason_array['retired_date'] = reason;
		    		}
		    	}else if(reason_type == 'resign'){
		    		var resigned_date = $('.resigned_date').val();
		    		if (resigned_date.trim() == '') {
		    			alert('Please Enter Death Date.');
		    			check_error = 'yes';
		    		}else{
		    			var reason = "This user has been resigned on "+resigned_date;
					    reason_array['resigned_date'] = reason;
		    		}
		    	}
			    reason_array['reason_msg'] = reason;
					var t = $(this);
					if(check_error == ''){
						$.ajax({
							url:base_url+admin+'/user-list',
		          method:'POST',
		          dataType:'json',
		          data:{
		            action:'delete',
		            id,id,
		            reason_array,reason_array,
		            _token:_token,
		          }, success:function(res){
		          	if(res == 'success'){
		          		$('td[data-id="'+id+'"]').prev('.status').html('Deleted');
		          		var selectoor = $('td[data-id="'+id+'"]').closest('tr');
		          		selectoor.hide();
		          		selectoor.find('.fa').css('display','none');
		          		selectoor.find('.fa-info-circle').css('display','inherit');
		          		$('#deleteUser').modal('hide');
							    Swal.fire({
									  position: 'top-end',
									  icon: 'success',
									  title: 'User deleted successfully.',
									  showConfirmButton: false,
									  timer: 5000
									})
			        	}else{
									toastr.warning(res);	                		
					    	}
					    }, error:function(e){
					      toastr.error('Something wrong please refresh page and try again.');
					    }
						})
					}
		    }
			});
			$('.ban').click(function(){
				var t = $(this);
				var id = $(this).closest('td').attr('data-id');
				var status = t.attr('title');
				var title = 'Why do you want to ban this user ?';
				if (status == 'ban') {
					change_status(title,'ban',id,t);
        }else{
						$.ajax({
							url:base_url+admin+'/user-list',
			        method:'POST',
			        dataType:'json',
			        data:{
			          action:status,
			          id:id,
			          _token:_token,
			        }, success:function(res){
			        	if(res == 'success'){
			        		if(status == 'ban'){
			        			t.attr('title','unban');
			          		t.addClass('fa-lock-open').removeClass('fa-lock');
			        		}else{
			        			t.attr('title','ban');
			          		t.addClass('fa-lock').removeClass('fa-lock-open');
			        		}
									toastr.success('User is '+status+' successfully.');
		          	}else{
									toastr.warning(res);	                		
		          	}
		          }, error:function(e){
		            toastr.error('Something wrong please refresh page and try again.');
		          }
						})
					}
			});
			function change_status(title,action,id,t){
				Swal.fire({
				  title: title,
				  input: 'text',
				  inputAttributes: {
				    autocapitalize: 'off'
				  },
				  showCancelButton: true,
				  confirmButtonText: 'OK',
				  showLoaderOnConfirm: true,
				  allowOutsideClick: () => !Swal.isLoading()
				}).then((result) => {
				  if (result.isConfirmed) {
				  	if(result.value == ''){
								Swal.showValidationMessage(`Request failed: 'Please Enter a Reason'`)
				  	}else{
							$.ajax({
								url:base_url+admin+'/user-list',
				        method:'POST',
				        dataType:'json',
				        data:{
				          action:action,
				          id:id,
				          reason:result.value,
				          _token:_token,
				        }, success:function(res){
				        	if(res == 'success'){
				        		if (action == 'ban') {
					        		if(action == 'ban'){
					        			t.attr('title','unban');
					          		t.addClass('fa-lock-open').removeClass('fa-lock');
					        		}else{
					        			t.attr('title','ban');
					          		t.addClass('fa-lock').removeClass('fa-lock-open');
					        		}
									    Swal.fire({
											  position: 'top-end',
											  icon: 'success',
											  title: 'User is banned successfully.',
											  showConfirmButton: false,
											  timer: 10000
											})
									  }else if(action == 'reject'){
				          		t.closest('td').prev('td.status').html('Rejected');
				          		t.closest('td').find('.first').css('display','none');
				          		t.closest('td').find('.second').css('display','inherit');
									    Swal.fire({
											  position: 'top-end',
											  icon: 'success',
											  title: 'User request is rejected successfully.',
											  showConfirmButton: false,
											  timer: 10000
											})
										}
			          	}else{
								    Swal.fire({
										  position: 'center',
										  icon: 'warning',
										  title: res,
										  showConfirmButton: false,
										  timer: 10000
										})                		
			          	}
			          }, error:function(e){
			            toastr.error('Something wrong please refresh page and try again.');
			          }
							})
						}
				  }
				})
			}
		})
	</script>
	<script>
		if ($(window).width() < 947) {
			$('table').addClass('table-responsive');
		}else{
			$('table').removeClass('table-responsive');
		}
		$(window).resize(function(){
		    var w = $(window).width();
		    if (w < 947){
				$('table').addClass('table-responsive');
		    }else{
				$('table').removeClass('table-responsive');
			}
		});
	</script>
@if($__userType == 'admin')
	@include('admin.layout.footer')
@elseif($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif
