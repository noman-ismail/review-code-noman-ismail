
<fieldset>
	<legend>Fund Detail</legend>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped">
				<tr>
					<th>Receipt No.</th>
					<td>{{ $record->receipt_no }}</td>
					<th>Deposited On</th>
					<td>{{ date('d/m/Y' , strtotime($record->deposited_on)) }}</td>
				</tr>
				<tr>
					<th>User Name</th>
					<td>{{ $user->name." - ".get_user_off_dsg($user->designation)." - ".$user->cnic }}</td>
					<th>Deposited To</th>
					<td>{{ $collector->name." - ".get_user_off_dsg($collector->designation)." - ".$collector->cnic }}</td>
				</tr>
				<tr>
					<th>Amount</th>
					<td>{{ $record->amount }}</td>
					<th>Payment Through</th>
					<td>{{ $record->through }}</td>
				</tr>
				<tr>
					<th>Fund For</th>
					<td>{{ ucfirst($record->fund_for) }}</td>
					<th>Fund Period</th>
					<td>{{ ($fund_period) ? $fund_period->name." ( ".date('d/m/Y',strtotime($fund_period->date_from))." - ".date('d/m/Y',strtotime($fund_period->date_to))." )" : "" }}</td>
				</tr>
				<tr>
					<th>Comment</th>
					<td colspan="3">{{ $record->comment }}</td>
				</tr>
			</table>
		</div>
	</div>
</fieldset>