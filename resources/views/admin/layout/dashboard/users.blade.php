@php
	$record = DB::table('users')->orderby('name','asc')->get();
	$total_users = DB::table('user_info')->get();
	$users_collection = collect($total_users);
	$off_dsg = DB::table('official_dsg')->get();
	$dsg = collect($off_dsg);
	$cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	$cities_collection = collect($cities);
@endphp
<div class="col-md-12">
	<div class="card border-info">
		<div class="card-header bg-info text-white">
			<h4>Users List</h4>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>User Name</th>
						<th>CNIC</th>
						<th>Phone No</th>
						<th>Personnel No</th>
						<th>Official Designation</th>
						<th>City Name</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if (count($record) > 0)
						@foreach ($record as $key => $value)
							@php
								$user_detail = $users_collection->where('user_id',$value->id)->first();
								$dsg_detail = $dsg->where('id',$value->designation)->first();
								$city_detail = $cities_collection->where('id',$value->district)->first();
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $value->name}}</td>
								<td>{{ $value->cnic }}</td>
								<td>{{ $value->contact }}</td>
								<td>{{ ($user_detail) ? $user_detail->personnel_no : "" }}</td>
								<td>{{ ($dsg_detail) ? $dsg_detail->name : "" }}</td>
								<td>{{ ($city_detail) ? $city_detail->name : "" }}</td>
								<td>{{ $value->status }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>