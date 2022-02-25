@php
	$provinces = DB::table('province')->orderby('sort','asc')->get();
	$cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
	$cities_collection = collect($cities);
@endphp
<div class="col-md-6">	
	<div class="card border-info">
		<div class="card-header bg-info text-white">
			<h4>Available Budget</h4>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Province Name</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
					@if(count($provinces) > 0)
						@foreach($provinces as $key => $value)
							@php
								$collected_fund = get_collected_fund($value->id);
								$get_record = DB::table('budget_list')->where([
								    'reqst_from' => $value->id,
								    'year' => date('Y'),
								    'budget_type' => 'allocate',
								])->sum('amount');
								$allocated = $get_record;
								$r = $collected_fund - $allocated  ;

								$available = $collected_fund - $r;
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $value->name }}</td>
								<td>{{ number_format((int)$available) }}</td>
							</tr>
						@endforeach
					@else
						<tr class="text-center">
							<td colspan="3">There is no record.</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>