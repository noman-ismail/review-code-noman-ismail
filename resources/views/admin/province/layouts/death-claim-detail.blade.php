@php
	$get_user_info = get_user_detail($data->user_id);
	$history =  (!empty($data->history)) ? json_decode($data->history , true) : array();
@endphp
<div class="row">
	<div class="{{ (count($history) > 0) ? 'col-md-6' : 'col-md-12' }}">
		<table class="table table-striped">
			<tr>
				<th>User Name</th>
				<td class="pl-4">{{ ($get_user_info)?$get_user_info['name']:"" }}</td>
			</tr>
			<tr>
				<th>Request From</th>
				<td class="pl-4">{{ (!empty($data))?get_DeptName($data->dept_id , $data->type):"" }}</td>		
			</tr>
			<tr>
				<th>Death Reason</th>
				<td class="pl-4">{{ (!empty($data))?$data->death_reason:"" }}</td>
			</tr>
			<tr>
				<th>Approval Amount</th>
				<td class="pl-4">{{ (!empty($data))?$data->amount:"" }}</td>
			</tr>
			<tr>
				<th>Death Date</th>
				<td class="pl-4">{{ (!empty($data) and !empty($data->death_date))?date('d/m/Y',strtotime($data->death_date)):"" }}</td>
			</tr>
			<tr>
				<th>Death Place</th>
				<td class="pl-4">{{ (!empty($data))?$data->death_place:"" }}</td>
			</tr>
		</table>
	</div>
	@if (count($history) > 0)
		<script>
			$('#viewModal').find('.modal-dialog').removeClass('modal-md').addClass('modal-xl');
		</script>
		<div class="col-md-6">
			<table class="table">
				@foreach ($history as $key => $element)
					@php
						if($key == '0'){
							$key = '';
						}elseif($key == 'bank'){
							$key = 'Bank Name';
						}elseif($key == 'no'){
							$key = 'A/C No';
						}elseif($key == 'date'){
							$key = 'Date';
						}elseif ($key == 'img') {
							$element = '<img src="'.asset('images/cheque/'.$element).'" alt="" height="100px" width="100px">';
							$key = 'Image';
						}elseif ($key == 'change_status') {
							$key = '';
						}elseif ($key == 'title') {
							$key = 'Title';
						}elseif ($key == 'trans_to_name') {
							$key = 'Transfer To Bank Name';
						}elseif ($key == 'trans_to_ac') {
							$key = 'Transfer To A/C';
						}elseif ($key == 'trans_to_bank') {
							$key = 'Transfer To Bank Title';
						}elseif ($key == 'trans_from_name') {
							$key = 'Transfer From Bank Name';
						}elseif ($key == 'trans_from_ac') {
							$key = 'Transfer From A/C No';
						}elseif ($key == 'trans_from_bank') {
							$key = 'Transfer From Bank Title';
						}elseif ($key == 'trans_date') {
							$key = 'Transfer From Transfer Date';
						}elseif ($key == 'trans_id') {
							$key = 'Transfer From Transaction ID';
						}
					@endphp
					<tr>
						@if (empty($key))
							<th colspan="2">{!! $element !!}</th>
						@else
							<th>{{ $key }}</th>
							<td>{!! $element !!}</td>
						@endif
					</tr>
				@endforeach
			</table>
		</div>
	@else
		<script>
			$('#viewModal').find('.modal-dialog').removeClass('modal-xl').addClass('modal-md');
		</script>
	@endif
</div>