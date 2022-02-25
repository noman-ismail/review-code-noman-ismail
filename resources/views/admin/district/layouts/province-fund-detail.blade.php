@if (!empty($record))
	@php
		if($record->through == 'bank'){
			$through = "Bank Transfer";
		}elseif($record->through == 'cash'){
			$through = "Cash Deposit";
		}else{
			$through = "Cheque";
		}
		$histriy = (!empty($record->history))?json_decode($record->history,true):array();
		$json_data = (!empty($record->payment_detail))?json_decode($record->payment_detail , true):array();
	@endphp
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<body>
					<tr>
						<th>Transfer From</th>
						<td>{{ get_DeptName($record->district,'district') }}</td>
					</tr>
					<tr>
						<th>Transfer To</th>
						<td>{{ get_DeptName($record->province,'province') }}</td>
					</tr>
					<tr>
						<th>Total Transfer Amount</th>
						<td>{{ $record->amount }}</td>
					</tr>
					<tr>
						<th>Transfer Date</th>
						<td>{{ date('d/m/Y' , strtotime($record->date)) }}</td>
					</tr>
					<tr>
						<th>Transfer Fund Via</th>
						<td>{{ $through }}</td>
					</tr>
					@if (!empty($record->comment))
						<tr>
							<th>Description</th>
							<td>
								{!! $record->comment !!}
							</td>
						</tr>
					@endif
				</body>
			</table>
			@if (count($histriy) > 0)
				<h4 class="text-center">History</h4>
				<ol>
					@foreach ($histriy as $ele)
						<li>{{ $ele }}</li>
					@endforeach
				</ol>
			@endif
		</div>
		<div class="col-md-6">
			@if (!empty($json_data))
				<fieldset>
					<legend>{{ $through." Detail" }}</legend>
					<table class="table table-striped">
						<tbody>
							@if ($record->through == 'check')
								<tr>
									<th>Cheque title</th>
									<td>{{ $json_data['Cheque title'] }}</td>
								</tr>
								<tr>
									<th>Cheque Bank Name</th>
									<td>{{ $json_data['Cheque Bank'] }}</td>
								</tr>
								<tr>
									<th>Cheque Number</th>
									<td>{{ $json_data['Cheque Number'] }}</td>
								</tr>
								<tr>
									<th>Cheque Date</th>
									<td>{{  $json_data['Cheque Date'] }}</td>
								</tr>
								<tr>
									<th>Cheque Image</th>
									<td>
										<img src="{{ asset('images/cheque/'.$json_data['Cheque Image']) }}" alt="Cheque Image" width="200px" height="100px">
									</td>
								</tr>
							@elseif($record->through == 'bank')
								<tr>
									<th>Transfer To Bank Name</th>
									<td>{{ $json_data['Transfer To Bank Name'] }}</td>
								</tr>
								<tr>
									<th>Transfer To Account No</th>
									<td>{{ $json_data['Transfer To Account No'] }}</td>
								</tr>
								<tr>
									<th>Transfer To Account Title</th>
									<td>{{ $json_data['Transfer To Account Title'] }}</td>
								</tr>
								<tr>
									<th>Transfer From Bank Name</th>
									<td>{{ $json_data['Transfer From Bank Name'] }}</td>
								</tr>
								<tr>
									<th>Transfer From Account No</th>
									<td>{{ $json_data['Transfer From Account No'] }}</td>
								</tr>
								<tr>
									<th>Transfer From Account Title</th>
									<td>{{ $json_data['Transfer From Account Title'] }}</td>
								</tr>
								<tr>
									<th>Transfer Date</th>
									<td>{{ $json_data['Transfer Date'] }}</td>
								</tr>
								<tr>
									<th>Transaction Id</th>
									<td>{{ $json_data['Transaction Id'] }}</td>
								</tr>
								<tr>
									<th>Cheque Image</th>
									<td>
										<img src="{{ asset('images/cheque/').$json_data['Cheque Image'] }}" alt="Cheque Image" height="200px" width="200px">
									</td>
								</tr>
							@elseif($record->through == 'cash')
								<tr>
									<th>Bank Name</th>
									<td>{{ $json_data['Cash Bank'] }}</td>
								</tr>
								<tr>
									<th>Cash Depositor Name </th>
									<td>{{ $json_data['Depositor'] }}</td>
								</tr>
								<tr>
									<th>Receiver Account Title </th>
									<td>{{ $json_data['Cash title'] }}</td>
								</tr>
								<tr>
									<th>Receiver Account No</th>
									<td>{{ $json_data['Account Number'] }}</td>
								</tr>
								<tr>
									<th>Deposit Date</th>
									<td>{{  $json_data['Deposit Date'] }}</td>
								</tr>
								<tr>
									<th>Cash Receipt Image</th>
									<td>
										<img src="{{ asset('images/cheque/'.$json_data['Cash Image']) }}" alt="Cheque Image" width="200px" height="100px">
									</td>
								</tr>
							@endif
						</tbody>
					</table>
				</fieldset>
			@endif
		</div>
	</div>
@else
	<h3 style="text-align: center;">Fund not Found. Refresh page and try again</h3>
@endif