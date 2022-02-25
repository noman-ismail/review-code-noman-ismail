@php
	$collect = collect($users);
@endphp

@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Payment from Fund Collectors</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form action="{{ route('collect-payment') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Select Collector for Transfer Payment</legend>
							<div class="form-group">
								<select name="name" class="form-control form-control-chosen collector">
									<option value="">Choose an Option</option>
									@if(count($collectors) > 0 )
										@foreach ($collectors as $value)
						                    @php
						                      $user_detail = $collect->where('id',$value->user_id)->first();
						                      $designation = get_user_off_dsg($user_detail->designation);
						                      $dsg = ($designation) ? " - ".$designation : "";
						                    @endphp
											<option value="{{ $value->user_id }}">{{ $user_detail->name.$dsg." - ".$user_detail->cnic }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</fieldset>
					</div>
					<div class="col-md-12 _div" style="display: none;">
						<fieldset>
							<legend>User Fund Detail</legend>
							<div class="detail"></div>
						</fieldset>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--/.body content-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
	$(document).ready(function(){
		$('.collector').change(function(){
			var url = '{{ route('collect-payment') }}';
			id = $(this).val();
			if(id == ""){
				$('._div').css('display','none');
			}else{
				$.ajax({
	                url:url,
	                method:'POST',
	                dataType:'html',
	                data:{
	                  // action:'user-ledger',
	                  action:'detail',
	                  id:id,
	                  _token:_token,
	                }, success:function(res){
	                	$('._div .detail').html(res);
	                	$('._div').css('display','block');
	                }, error:function(e){
	                	toastr.error(e);
	                }
				})
			}
		})
	})
</script>
@include('admin.district.layouts.footer')