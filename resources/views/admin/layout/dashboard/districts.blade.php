@php
	$record = DB::table('cities')->orderby('name','asc')->get();
	$total_users = DB::table('users')->get();
	$users_collection = collect($total_users);
@endphp
<div class="col-md-12">
	<div class="card border-info">
		<div class="card-header bg-info text-white">
			<h4>Districts List</h4>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>City Name</th>
						<th>Pending Users</th>
						<th>Rejected Users</th>
						<th>Approved Users</th>
						<th>Deleted Users</th>
						<th>Total Users</th>
					</tr>
				</thead>
				<tbody>
					@if (count($record) > 0)
						@foreach ($record as $key => $value)
							@php
								$appr_users = $users_collection->where('district',$value->id)->where('status','approved')->count();
								$pend_users = $users_collection->where('district',$value->id)->where('status','pending')->count();
								$rej_users = $users_collection->where('district',$value->id)->where('status','reject')->count();
								$del_users = $users_collection->where('district',$value->id)->where('status','deleted')->count();
								$total_users = $users_collection->where('district',$value->id)->count();
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $value->name." - ".$value->short_name}}</td>
								<td>{{ (int)$pend_users }}</td>
								<td>{{ (int)$rej_users }}</td>
								<td>{{ (int)$appr_users }}</td>
								<td>{{ (int)$del_users }}</td>
								<td>{{ (int)$total_users }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>