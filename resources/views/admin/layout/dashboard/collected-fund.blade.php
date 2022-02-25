@php
	$record = DB::table('district_ledger')->orderby('id','desc')->where('year',date('Y'))->get();
	$total_users = DB::table('users')->get();
	$users_collection = collect($total_users);
	$users_detail = DB::table('user_info')->get();
	$detail_collection = collect($users_detail);
	$cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	$cities_collection = collect($cities);
	$province = DB::table('province')->get();
	$province_collection = collect($province);
	$admin = DB::table('admin')->where('type','district')->get();
	$admin_collection = collect($admin);
	// dd($record);
@endphp
<div class="col-md-12">
	<div class="card border-info">
		<div class="card-header bg-info text-white">
			<h4>Collected Fund</h4>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>User Name</th>
						<th>Collected City</th>
						<th>Deposit To</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Balance</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					{{-- {{ dd($record) }} --}}
					@if(count($record) > 0)
						@foreach($record as $key => $value)
							@php
								$city_detail = $cities_collection->where('id',$value->district)->first();
								$province_detail = $province_collection->where('id',$value->province)->first();
							    if ($value->ledger == '+') {
									$user_detail = $users_collection->where('id',$value->collector)->first();
							    	$collected_city = ($city_detail) ? $city_detail->name : "";
							    	$deposit_to = "";
							    }else{
									$user_detail = $admin_collection->where('id',$value->user_id)->first();
							    	$collected_city = ($city_detail) ? $city_detail->name : "";
							    	$deposit_to = ($province_detail) ? $province_detail->name : "";
							    }
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ ($user_detail) ? $user_detail->name : "" }}</td>
								<td>{{ $collected_city }}</td>
								<td>{{ $deposit_to }}</td>
								<td>{{ (!empty($value->date))?date('d/m/Y' , strtotime($value->date)):"" }}</td>
								<td>{{ $value->amount }}</td>
								<td>{{ $value->remaining }}</td>
								<td>{{ $value->status }}</td>
							</tr>
						@endforeach
					@else
						<tr class="text-center">
							<td colspan="8">There is no record.</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>