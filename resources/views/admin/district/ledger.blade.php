@php
	$_users_collection = collect($users);
	$_userInfo_collection = collect($user_info);
@endphp
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Ledger History</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
		        <div class="col-md-12">
		          <form action="{{ route('ledger') }}">
		            <div class="form-row">
		              <div class="form-group col-md-4">
		                <select class="form-control form-control-chosen" name="collector">
		                  <option value="">Choose Collector Name</option>
		                  @if (count($user_info))
		                    @foreach ($user_info as $value)
		                    	@if ($value->collector == 'yes')
		                    		@php
		                    			$u_detail = $_users_collection->where('id',$value->user_id)->first();
										$designation = get_user_off_dsg($u_detail->designation);
										$dsg = ($designation) ? " - ".$designation : "";
		                    			if(empty($value->personnel_no)){
		                    				$peroson = "";
		                    			}else{
		                    				$peroson = " - (".$value->personnel_no.")";
		                    			}
		                    		@endphp
									<option value="{{ $value->user_id }}" {{ ($value->user_id == request('collector'))?"selected":"" }}>
										{{ $u_detail->name.$dsg.$peroson }}
									</option>
		                    	@endif
		                    @endforeach
		                  @endif
		                </select>
		              </div>
		              <div class="form-group col-md-3">
		                <input type="text" name="date_from" class="form-control" id="date-picker" data-toggle="datepicker" autocomplete="off" placeholder="Date From" value="{{ request('date_from') }}">
		              </div>
		              <div class="form-group col-md-3">
		                <input type="text" name="date_to" class="form-control" id="date-picker1" data-toggle="datepicker" autocomplete="off" placeholder="Date To" value="{{ request('date_to') }}">
		              </div>
		              <div class="form-group col-md-2">
		                <button class="btn btn-info w-100">Search</button>
		              </div>
		            </div>
		          </form>
		        </div>
			</div>
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
								<th>Collector Name</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Balance</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(count($record) > 0)
								@php
									$i = 1;
									$_t = 0;
								@endphp
								@foreach($record as $value)
									@php
		                    			$user_detail = $_users_collection->where('id',$value->collector_id)->first();
										if($value->ledger == '+'){											
											$_t = $_t + $value->amount;
										}
									@endphp
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $user_detail->name }}</td>
										<td>{{ (!empty($value->date))?date('d/m/Y',strtotime($value->date)):"" }}</td>
										<td>{{ $value->ledger.$value->amount }}</td>
										<td>{{ $value->balance }}</td>
										<td>
											<a style="cursor:pointer;color:#17a2b8;" data-toggle="modal" data-target="#DetailModal"><i class="fa fa-eye"  data-id="{{ $value->id }}"></i></a>
										</td>
									</tr>
								@endforeach
								<tr>
									<th colspan="4" class="text-right">Total Collection : </th>
									<th>{{ $_t }}</th>
								</tr>
							@else
								<tr class="text-center">
									<td colspan="7">There is no record.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!--/.body content-->
<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Payment from Fund Collector Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body n-modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
		$('.fa-eye').click(function(){
			var div =  $('.n-modal-body');
			div.html('');
			var id = $(this).attr('data-id');
			$.ajax({
                url:'{{ route('remaining-budget') }}',
				method: 'POST',
				datatype: 'html',
				data: {
					action:'user_ledger',
					id:id,
					_token: "{{ csrf_token() }}",
				},
				success:function(res){
					div.html(res);
                }, error:function(e){
                	toastr.error(e);
                }
			})
		})
	})
</script>
@include('admin.district.layouts.footer')