<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Amount</th>
			<th>Entry Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

		@if(count($record) > 0)
			@php
				$i=1;
			@endphp
			@foreach($record as $value)
				<tr class="" >
					<td>{{ $i++ }}</td>
					<td>{{ $value->title }}</td>
					<td>{{ $value->amount }}</td>
					<td>{{ ($value->entry_date != null)?date('d/m/Y',strtotime($value->entry_date)):"" }}</td>
					<td>
						<a href="{{ route('add-expense').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
						<a href="{{ route('add-expense').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
							<i class="fa fa-trash"></i>
						</a>
					</td>
				</tr>
			@endforeach
		@else
			<tr class="text-center bg-default">
				<td colspan="5">There is no record</td>
			</tr>
		@endif
	</tbody>
</table>