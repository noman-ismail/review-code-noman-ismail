@php
	$collection = collect($users);
	$user_detail = $collection->where('id',$record->collector_id)->first();
	$admins = collect($admin);
	if($record->ledger == '+'){
		$user_name = $collection->where('id',$record->user_id)->first();
	}else{
		$user_name = $admins->where('id',$record->user_id)->first();
	}
	$history = json_decode($record->history,true);
@endphp
<div class="col-md-12">
	<fieldset>
		<legend>Payment Detail</legend>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Collector Name</th>
							<th>{{ $user_detail?$user_detail->name." - ".$user_detail->cnic:"" }}</th>
							<th>Date</th>
							<td>{{ date( 'd/m/Y' , strtotime($record->date)) }}</td>
						</tr>
						<tr>
							<th>Amount</th>
							<td>{{ $record->amount }}</td>
							<th>{{ ($record->ledger == '+')?"User Name":"Collected By" }}</th>
							<td>{{ $user_name?$user_name->name:"" }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				@if (!empty($history))
					@php
						$i = 1;
						$count = count($history) - 1;
						// dd($history);
					@endphp
					<table class="table table-striped">
						@foreach ($history as $key => $val)
							@if ($key != 'history')
								@if ($i % 2 != 0)
									<tr>
								@endif
									<th>{{ $key }}</th>
									@if ($key == 'Cheque Image' || $key == 'Cash Image')
										<td>
											<img src="{{ asset('images/cheque/'.$val) }}" alt="cheque image" height="200" width="300">
										</td>
									@else
										<td>{{ $val }}</td>
									@endif
								@if ($i % 2 == 0)
									</tr>
								@endif
								@php
									$i++;
								@endphp
							@else
								@php
									$histtt[$key] = $val;
								@endphp
							@endif
						@endforeach
						<caption>{{ $histtt['history'] }}</caption>						
					</table>
					{{-- <p>{{ $histtt['history'] }}</p> --}}
				@endif
			</div>
		</div>
	</fieldset>
</div>
<script>
	$('#DetailModal .modal-dialog').addClass('modal-lg');
</script>