@php
	$_users_collection = collect($users);
	$_userInfo_collection = collect($user_info);
	$str = array();
	if (!empty(request('collector'))) {
		$str[] = "collector=".request('collector');
	}
	if (!empty(request('date_from'))) {
		$str[] = "date_from=".request('date_from');
	}
	if (!empty(request('date_to'))) {
		$str[] = "date_to=".request('date_to');
	}
	if (!empty($str)) {
		$query_querystr = "?".implode('&', $str);
	}else{
		$query_querystr = "";
	}
@endphp
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Fund Collector Ledger Report</h6>
				</div> {{-- Request::getRequestUri() --}}
	            <div class="text-right">
	              <a href="{{ route('fc-ledger-pdf').$query_querystr }}" class="btn btn-sm btn-success">Generate PDF</a>
	            </div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
		        <div class="col-md-12">
		          <form action="{{ route('fc-ledger-report') }}">
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
							</tr>
						</thead>
						<tbody>
							@if(count($record) > 0)
								@foreach($record as $key => $value)
									@php
		                    			$user_detail = $_users_collection->where('id',$value->collector_id)->first();
									@endphp
									<tr>
										<td>{{ ++$key }}</td>
										<td>{{ $user_detail->name }}</td>
										<td>{{ (!empty($value->date))?date('d/m/Y',strtotime($value->date)):"" }}</td>
										<td>{{ $value->ledger.$value->amount }}</td>
										<td>{{ $value->balance }}</td>
									</tr>
								@endforeach
							@else
								<tr class="text-center">
									<td colspan="5">There is no record.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!--/.body content-->
<div class="md-modal md-effect-9" id="modal-9" style="max-width: 1300px;min-width: 1300px;">
    <div class="md-content">
        <h4 class="font-weight-600 mb-0" style="padding: 5px 0px 0px 0px">Payment from Fund Collector Detail </h4>
        <div class="n-modal-body"  style="padding: 0px 0px 5px 0px">
        	<div class="mb-3">
            <p>This is a modal window. You can do the following things with it:</p>
            <ul>
                <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
                <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
                <li><strong>Close:</strong> click on the button below to close the modal.</li>
            </ul></div>
            <button class="btn btn-success md-close">Close me!</button>
        </div>
    </div>
</div><div class="md-overlay"></div><!-- Third Party Scripts(used by this page)--><!--Third party Styles(used by this page)--> 
<link href="{{ asset('admin-assets/plugins/modals/component.css') }}" rel="stylesheet">
<script src="{{ asset('admin-assets/plugins/modals/classie.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/modals/modalEffects.js') }}"></script>
<script>
	$(document).ready(function(){
		$('.fa-eye').click(function(){
			var div =  $('.n-modal-body').children('div');
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
					console.log($('.m-modal-body').children('div'));
                }, error:function(e){
                	toastr.error(e);
                }
			})
		})
	})
</script>
@include('admin.district.layouts.footer')