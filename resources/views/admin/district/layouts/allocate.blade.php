<table class="table table-striped">
	<tbody>
		<tr>
			<th>Title</th>
			<td>{{ ($record)?$record->title:"" }}</td>
		</tr>
		<tr>
			<th>Allocate To</th>
			<td>{{ (!empty($record))?get_DeptName($record->reqst_to,$record->type):"" }}</td>
		</tr>
		<tr>
			<th>Amount</th>
			<td>{{ (!empty($record))?$record->amount:"" }}</td>
		</tr>
		<tr>
			<th>Reason</th>
			<td>{!! ($record)?$record->reason:"" !!}</td>
		</tr>
		@php
			$history = (!empty($record) and !empty($record->history))?json_decode($record->history,true):array();
		@endphp
		<tr>
			<th>History</th>
			<td>
				<ol>
					@if (count($history) > 0)
						@foreach ($history as $element)
							<li>{{ $element }}</li>
						@endforeach
					@endif
				</ol>
			</td>
		</tr>
	</tbody>
</table>