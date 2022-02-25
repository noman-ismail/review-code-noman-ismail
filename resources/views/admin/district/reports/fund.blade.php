@php
	$_users_collection = collect($users);
	$_userInfo_collection = collect($user_info);
	$str = array();
	if (!empty(request('collector'))) {
		$str[] = "collector=".request('collector');
	}
	if (!empty(request('search'))) {
		$str[] = "search=".request('search');
	}
	if (!empty(request('date_from'))) {
		$str[] = "date_from=".request('date_from');
	}
	if (!empty(request('date_to'))) {
		$str[] = "date_to=".request('date_to');
	}
	if (!empty($str)) {
		$query_querystr = "?".implode('&', $str);
	}else{
		$query_querystr = "";
	}
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
	              <a href="{{ route('fund-history-pdf').$query_querystr }}" class="btn btn-sm btn-success">Generate PDF</a>
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
		          <form action="{{ route('fund-history-report') }}">
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
								</tr>
							@endforeach
							@else
							<tr class="text-center">
								<td colspan="5">There is no record.</td>
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