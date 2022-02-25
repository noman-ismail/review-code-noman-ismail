@php
	$_users_collection = collect($users);
	$_userInfo_collection = collect($user_info);
@endphp
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Funds History</h6>
				</div>
				<div class="text-right">
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
		        <div class="col-md-12">
		          <form action="{{ route('fund-history') }}">
		            <div class="form-row">
		              <div class="form-group col-sm-12 col-md-6 col-lg-3">
		                <select class="form-control form-control-chosen" name="collector">
		                  <option value="">Choose Collector Name</option>
			                  @if (count($user_info))
			                    @foreach ($user_info as $value)
			                    	@if ($value->collector == 'yes')
			                    		@php
			                    			$u_detail = $_users_collection->where('id',$value->user_id)->first();
											$designation = get_user_off_dsg($u_detail->designation);
											$dsg = ($designation) ? " - ".$designation : "";
			                    			if(empty($value->personnel_no)){
			                    				$peroson = "";
			                    			}else{
			                    				$peroson = " - (".$value->personnel_no.")";
			                    			}
			                    		@endphp
										<option value="{{ $value->user_id }}" {{ ($value->user_id == request('collector'))?"selected":"" }}>
											{{ $u_detail->name.$dsg.$peroson }}
										</option>
			                    	@endif
			                    @endforeach
			                  @endif
		                </select>
		              </div>
		              <div class="form-group col-sm-12 col-md-6 col-lg-3">
		                <select class="form-control form-control-chosen" name="search">
		                  <option value="">Choose User Name</option>
			                  @if (count($users))
			                    @foreach ($users as $value)
		                    		@php
		                    			$u_detail = $_userInfo_collection->where('user_id',$value->id)->first();
										$designation = get_user_off_dsg($value->designation);
										$dsg = ($designation) ? " - ".$designation : "";
		                    			if(empty($u_detail->personnel_no)){
		                    				$peroson = "";
		                    			}else{
		                    				$peroson = " - (".$u_detail->personnel_no.")";
		                    			}
		                    		@endphp
									<option value="{{ $value->id }}" {{ ($value->id == request('search'))?"selected":"" }}>
										{{ $value->name.$dsg.$peroson }}
									</option>
			                    @endforeach
			                  @endif
		                </select>
		              </div>
		              <div class="form-group col-sm-12 col-md-4 col-lg-2">
		                <input type="text" name="date_from" class="form-control" id="date-picker" data-toggle="datepicker" autocomplete="off" placeholder="Date From" value="{{ request('date_from') }}">
		              </div>
		              <div class="form-group col-sm-12 col-md-4 col-lg-2">
		                <input type="text" name="date_to" class="form-control" id="date-picker1" data-toggle="datepicker" autocomplete="off" placeholder="Date To" value="{{ request('date_to') }}">
		              </div>
		              <div class="form-group col-sm-12 col-md-4 col-lg-2">
		                <button class="btn btn-info w-100">Search</button>
		              </div>
		            </div>
		          </form>
		        </div>
				<div class="col-md-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Receipt No</th>
								<th>Deposited To</th>
								<th>Deposited By</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(count($record) > 0)
							@foreach($record as $value)
								@php
			            			$u_detail = $_users_collection->where('id',$value->user_id)->first();
			            			$u_detail2 = $_users_collection->where('id',$value->deposited_to)->first();
								@endphp
								<tr>
									<td>{{ $value->receipt_no }}</td>
									<td>{{ $u_detail2->name }}</td>
									<td>{{ $u_detail->name }}</td>
									<td>{{ $value->amount }}</td>
									<td>{{ date('d/m/Y',strtotime($value->deposited_on)) }}</td>
									<td>
										<a href="#">
											<i class="fa fa-info-circle text-success" title="View" data-id="{{ $value->id }}" data-toggle="modal" data-target="#modalview"></i>
										</a>
										<a href="#">
											<i class="fa fa-edit text-primary" title="Edit" data-id="{{ $value->id }}" data-toggle="modal" data-target="#EditModal"></i>
										</a>
										{{-- <a href="{{ route('funds')."?del=".$value->id }}" onclick="return confirm('Are you sure want to delete ?')">
											<i class="fa fa-trash" style="font-size: 16px;"></i>
										</a> --}}
									</td>
								</tr>
							@endforeach
							@else
							<tr class="text-center">
								<td colspan="6">There is no record.</td>
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
					<h5 class="modal-title" id="exampleModal">Fund Detail</h5>
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
	<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal2" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModal2">Edit Fund</h5>
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
	<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
	<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
	<script>
		$(document).ready(function(){
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
			$('.fa-info-circle , .user-detail').click(function(){
      	$('#modalview .modal-body').html('');
				var t = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					url:base_url+admin+'/fund-history',
	        method:'POST',
	        dataType:'html',
	        data:{
	          action:'fund_detail',
	          id,id,
	          _token:_token,
	        }, success:function(res){
	        	$('#modalview .modal-body').html(res);
	        }, error:function(e){
	          toastr.error('Something wrong please refresh page and try again.');
	        }
				})
			});
			$('.fa-edit').click(function(){
      	$('#EditModal .modal-body').html('');
				var t = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					url:base_url+admin+'/fund-history',
	        method:'POST',
	        dataType:'html',
	        data:{
	          action:'edit_fund',
	          id,id,
	          _token:_token,
	        }, success:function(res){
	        	$('#EditModal .modal-body').html(res);
	        }, error:function(e){
	          toastr.error('Something wrong please refresh page and try again.');
	        }
				})
			});
		})
		if ($(window).width() < 540) {
			$('table').addClass('table-responsive');
		}else{
			$('table').removeClass('table-responsive');
		}
		$(window).resize(function(){
		    var w = $(window).width();
		    if (w < 540){
				$('table').addClass('table-responsive');
		    }else{
				$('table').removeClass('table-responsive');
			}
		});
	</script>
	@include('admin.district.layouts.footer')