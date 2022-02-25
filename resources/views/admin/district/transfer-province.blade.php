@if(count($record) > 0)
	@php
	    $_calculate = $remaining;
	@endphp
	@foreach($record as $value)
		@php
			$_amount = $value->amount;
			if ($value->ledger == '+') {
				$_calculate = $_calculate + $_amount;
			}elseif ($value->ledger == '-') {
				$_calculate = $_calculate - $_amount;
			}
			$value->remaining = $_calculate;
		@endphp
	@endforeach
	@php
		$collection = collect($record);
		$record = $collection->sortDesc();
	@endphp
@endif
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Transfer Fund to Province List</h6>
				</div>
		        <div class="text-right">
		         	<a href="{{ route('transfer-to-province') }}" class="btn btn-secondary">Payment History</a>
		         	<a href="{{ route('transfer-payment') }}" class="btn btn-success">Transfer Payment</a>
		        </div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
		            @if(session()->has("success"))
		              <div class="alert alert-success alert-dismissible fade show" role="alert">
		                {!! session("success") !!}
		                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                  <span aria-hidden="true">&times;</span>
		                </button>
		              </div>
		            @endif
		            @if(session()->has("error"))
		              <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                {!! session("error") !!}
		                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                  <span aria-hidden="true">&times;</span>
		                </button>
		              </div>
		            @endif
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>User Name</th>
								<th>Deposited To</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Balance</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(count($record) > 0)
								@php
								    $user_detail = _user_data();
								    $i = 1;
								@endphp
								@foreach($record as $value)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ GetUserName($value->user_id) }}</td>
										<td>{{ get_dept_name($user_detail['province'],'province') }}</td>
										<td>{{ $value->amount }}</td>
										<td>{{ (!empty($value->date))?date('d/m/Y' , strtotime($value->date)):"" }}</td>
										<td>{{ $value->ledger.$value->remaining }}</td>
										<td>{{ $value->status }}</td>
										<td>
											@if ($value->status == 'Reject')
												<a href="{{ route('transfer-payment')."?id=".$value->id }}">
													<i class="fa fa-edit" style="font-size: 16px;"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#fundDetail" title="View Detail">
													<i class="fa fa-eye" style="font-size: 16px;" data-id="{{ $value->id }}"></i>
												</a>
											@elseif(!empty($value->status))
												<a href="#" data-toggle="modal" data-target="#fundDetail" title="View Detail">
													<i class="fa fa-eye" style="font-size: 16px;" data-id="{{ $value->id }}"></i>
												</a>
											@endif
										</td>
									</tr>
								@endforeach
							@else
								<tr class="text-center">
									<td colspan="8">There is no record.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="fundDetail" tabindex="-1" role="dialog" aria-labelledby="fundDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fundDetailLabel">Transfer Fund Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	$('document').ready(function(){
		$('.fa-eye').click(function(){
			var id = $(this).attr('data-id');
			var url = '{{ route('transfer-to-province') }}';
			$.ajax({
				url:url,
				method:'post',
				dataType:'html',
				data:{
					action:'view_detail',
					id:id,
					_token:_token,
				},success:function(e){
					$('#fundDetail').find('.modal-body').html(e);
				},error:function(e){
					alert('Unknown Error..!  Please refresh page and try again');
				}
			})
		})
	})
</script>
@include('admin.district.layouts.footer')