@php
	$_users_collection = collect($users);
	$dc_users = collect($district_users);
	$_userInfo_collection = collect($user_info);
	$province_collection = collect($provinces);
	$str = array();
	if (!empty(request('collector'))) {
		$str[] = "collector=".request('collector');
	}
	if (!empty(request('user'))) {
		$str[] = "user=".request('user');
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
					<h6 class="fs-17 font-weight-600 mb-0"> District Ledger</h6>
				</div>
		        <div class="text-right">
	              <a href="{{ route('district-ledger-pdf').$query_querystr }}" class="btn btn-sm btn-success">Generate PDF</a>
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
		          <form action="{{ route('district-ledger-report') }}">
		            <div class="form-row">
		              <div class="form-group col-md-3">
		                <select class="form-control form-control-chosen" name="user">
		                  <option value="">Choose District User</option>
		                  @if (count($district_users))
		                    @foreach ($district_users as $value)
								<option value="{{ $value->id }}" {{ ($value->id == request('user'))?"selected":"" }}>
									{{ $value->name }}
								</option>
		                    @endforeach
		                  @endif
		                </select>
		              </div>
		              <div class="form-group col-md-3">
		                <select class="form-control form-control-chosen" name="collector">
		                  <option value="">Choose Collector Name</option>
		                  @if (count($user_info))
		                    @foreach ($user_info as $value)
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
		                    @endforeach
		                  @endif
		                </select>
		              </div>
		              <div class="form-group col-md-2">
		                <input type="text" name="date_from" class="form-control" id="date-picker" data-toggle="datepicker" autocomplete="off" placeholder="Date From" value="{{ request('date_from') }}">
		              </div>
		              <div class="form-group col-md-2">
		                <input type="text" name="date_to" class="form-control" id="date-picker1" data-toggle="datepicker" autocomplete="off" placeholder="Date To" value="{{ request('date_to') }}">
		              </div>
		              <div class="form-group col-md-2">
		                <button class="btn btn-info w-100">Search</button>
		              </div>
		            </div>
		          </form>
		        </div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>User Name</th>
								<th>Deposited To/From</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							@if(count($record) > 0)
								@php
								    $user_detail = _user_data();
								    $i = 1;
								@endphp
								@foreach($record as $value)
									@php
										$uu = $dc_users->where('id',$value->user_id)->first();
									    if ($value->ledger == '+') {
									    	// $vv = GetLoginUserName($value->collector);
											$vv = $_users_collection->where('id',$value->collector)->first();
									    }else{
											$vv = $province_collection->where('id',$user_detail['province'])->first();
									    	// $vv = get_dept_name($user_detail['province'],'province');
									    }
									@endphp
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ ($uu) ? $uu->name : "" }}</td>
										<td>{{ ($vv) ? $vv->name : "" }}</td>
										<td>{{ (!empty($value->date))?date('d/m/Y' , strtotime($value->date)):"" }}</td>
										<td>{{ $value->ledger.$value->amount }}</td>
										<td>{{ $value->remaining }}</td>
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
</div>
@include('admin.district.layouts.footer')