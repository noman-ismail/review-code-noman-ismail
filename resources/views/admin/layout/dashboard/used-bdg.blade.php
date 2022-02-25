@php
	$record = DB::table('budget_list')->where(['budget_type'=>'request','year'=>date('Y'),'status'=>'delivered'])->orderby('id','desc')->get();
	$cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	$province = DB::table('province')->get();
	$province_collection = collect($province);;
	$cities_collection = collect($cities);
@endphp
<div class="col-md-12">
	<div class="card border-info">
		<div class="card-header bg-info text-white">
			<h4>Used Budget</h4>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Requested To</th>
						<th>Requested From</th>
						<th>Amount</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if(count($record) > 0)
						@foreach($record as $key => $value)
							@php
								if ($value->type == 'district') {
									$ss = $cities_collection->where('id',$value->reqst_from)->first();
									$requested_from = ($ss) ? $ss->name : "";
								}else if($value->type == 'province'){
									$ss = $province_collection->where('id',$value->reqst_from)->first();
									$requested_from = ($ss) ? $ss->name : "";
								}else{
									$requested_from = 'Pakistan';
								}
								$requested_to = $province_collection->where('id',$value->reqst_to)->first();
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $value->title }}</td>
								<td>{{ ($requested_to) ? $requested_to->name : "" }}</td>
								<td>{{ $requested_from }}</td>
								<td>{{ number_format($value->amount) }}</td>
								<td>{{ $value->status }}</td>
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