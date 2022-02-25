<table class="table table-striped">
	<tr>
		<th>Request From</th>
		<td class="pl-4">{{ (!empty($data))?get_DeptName($data->reqst_from , $data->type):"" }}</td>		
	</tr>
	<tr>
		<th>Title</th>
		<td class="pl-4">{{ (!empty($data))?$data->title:"" }}</td>
	</tr>
	<tr>
		<th>Amount</th>
		<td class="pl-4">{{ (!empty($data))?$data->amount:"" }}</td>
	</tr>
	<tr>
		<th>Due Date</th>
		<td class="pl-4">{{ (!empty($data) and !empty($data->due_date))?date('d/m/y',strtotime($data->due_date)):"" }}</td>
	</tr>
	<tr>
		<th colspan="2" class="text-center">Reason</th>
	</tr>
	<tr>
		<td colspan="2">
			{!! (!empty($data))?$data->reason:"" !!}
		</td>
	</tr>
</table>
<style>
	.history_table{
		counter-reset: koibe;
	}
	.history_table tbody tr::before{
		counter-increment: koibe;
		content : counter(koibe)"- ";
	}
</style>
<table class="table-striped history_table">
	<thead>
		<tr>
			<th colspan="2">History</th>
		</tr>
	</thead>
	<tbody>
	@php
		$history = json_decode($data->history , true);
		if(count($history) > 0){
			@endphp
			<tr>
				<td colspan="2">{{ $history[0] }}</td>
			</tr>
			@foreach ($history as $key => $element)
				@php
					if($key == '0'){
						$index = '';
					}elseif($key == 'bank'){
						$index = 'Bank Name';
					}elseif($key == 'no'){
						$index = 'A/C No';
					}elseif($key == 'date'){
						$index = 'Date';
					}elseif ($key == 'img') {
						$element = '<img src="'.asset('images/cheque/'.$element).'" alt="" height="100px" width="100px">';
						$index = 'Image';
					}elseif ($key == 'change_status') {
						$index = '';
					}elseif ($key == 'title') {
						$index = 'Title';
					}elseif ($key == 'trans_to_name') {
						$index = 'Transfer To Bank Name';
					}elseif ($key == 'trans_to_ac') {
						$index = 'Transfer To A/C';
					}elseif ($key == 'trans_to_bank') {
						$index = 'Transfer To Bank Title';
					}elseif ($key == 'trans_from_name') {
						$index = 'Transfer From Bank Name';
					}elseif ($key == 'trans_from_ac') {
						$index = 'Transfer From A/C No';
					}elseif ($key == 'trans_from_bank') {
						$index = 'Transfer From Bank Title';
					}elseif ($key == 'trans_date') {
						$index = 'Transfer From Transfer Date';
					}elseif ($key == 'trans_id') {
						$index = 'Transaction ID';
					}
				@endphp
				@if ($key != '0')
					<tr>
						@if (empty($index))
							<td colspan="2">{{ $element }}</td>
						@else
							<th>{{ $index }}</th>
							<td>{!! $element !!}</td>
						@endif
					</tr>
				@endif
				{{-- @if ($key == 0)
				@else
					<tr>
						<th>{{ $key }}</th>
						<td>{!! $element !!}</td>
					</tr>
				@endif --}}
			@endforeach
			@php
		}
	@endphp
	</tbody>
</table>