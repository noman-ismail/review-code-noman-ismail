@include('admin.layout.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Funds Period</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form action="{{ route('fund-periods') }}">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Date From</th>
									<th>Date to</th>
									<th>Funds Period Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(count($record) > 0)
									@php $i=1; @endphp
									@foreach($record as $key => $value)
										<tr data-id = '{{ $key }}'>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text" id="basic-addon1">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_from" id="date-picker{{ $i++ }}" value="{{ ($value->date_from != null)?date('d/m/Y' ,strtotime($value->date_from)):"" }}">
												</div>
											</td>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text" id="basic-addon1">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_to" id="date-picker{{ $i++ }}" value="{{ ($value->date_to != null)?date('d/m/Y' ,strtotime($value->date_to)):"" }}">
												</div>
											</td>
											<td>
												<input type="text" class="form-control data-name"  value="{{ $value->name }}">
											</td>
											<td>
												{{-- @if($key > 0) --}}
													<button type="button" class="btn btn-sm remv" >
														<i class="fa fa-trash text-danger mt-2" style="font-size: 18px"></i>
													</button>
												{{-- @endif --}}
											</td>
										</tr>
									@endforeach
								@else
									<tr data-id = '1'>
										<td>
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <span class="input-group-text" id="basic-addon1">
											    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
											    </span>
											  </div>
											  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_from" id="date-picker">
											</div>
										</td>
										<td>
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <span class="input-group-text" id="basic-addon1">
											    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
											    </span>
											  </div>
											  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_to" id="date-picker2">
											</div>
										</td>
										<td>
											<input type="text" class="form-control data-name">
										</td>
										<td>
											<a class="btn btn-sm remv">
												<i class="fa fa-trash text-danger mt-2" style="font-size: 18px"></i>
											</a>
										</td>
									</tr>
								@endif
							</tbody>
						</table>
						<div class="text-right">
							<button type="button" class="btn btn-info save">Save</button>
							<button type="button" class="btn btn-secondary ad-mor">Add More</button>
						</div>
					</div>
				</div>
			</form>
			<div class="row"></div>
		</div>
	</div>
</div><!--/.body content-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
	$(document).ready(function(){
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "600",
          "hideDuration": "1000",
          "timeOut": "20000",
          "extendedTimeOut": "20000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };
		var tr = `<tr data-id = '1'>
						<td>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">
							    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
							    </span>
							  </div>
							  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_from" id="date-picker">
							</div>
						</td>
						<td>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">
							    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
							    </span>
							  </div>
							  <input type="text" data-toggle="datepicker" autocomplete="off" class="form-control date_to" id="date-picker2">
							</div>
						</td>
						<td>
							<input type="text" class="form-control data-name">
						</td>
						<td>
							<a class="btn btn-sm remv" >
								<i class="fa fa-trash text-danger mt-2" style="font-size: 18px"></i>
							</a>
						</td>
					</tr>`;
        $('#date-picker3').samask("00/00/0000");
        $('#date-picker4').samask("00/00/0000");
        $('#date-picker5').samask("00/00/0000");
        $('#date-picker6').samask("00/00/0000");
        $('#date-picker7').samask("00/00/0000");
        $('#date-picker8').samask("00/00/0000");
        $('#date-picker9').samask("00/00/0000");
        $('#date-picker10').samask("00/00/0000");
        $('#date-picker11').samask("00/00/0000");
        $('#date-picker12').samask("00/00/0000");
        $('#date-picker13').samask("00/00/0000");
        $('#date-picker14').samask("00/00/0000");
        $('#date-picker15').samask("00/00/0000");
        $('#date-picker16').samask("00/00/0000");
		$('.remv').click(function(){
			if (confirm('Are you sure?')) {
				$(this).closest('tr').remove();
			}
		});
		$('.ad-mor').click(function(){
			var t = $('tbody').find('tr:last');
			var counter = t.attr('data-id');
			var selector = $('.copytr');
			counter = parseInt(counter)+parseInt('1');
			$('tbody').append(tr);

            $('[data-toggle="datepicker"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
            });
            $('#date-picker').samask("00/00/0000");
            $('#date-picker').keydown(function(e){
                if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                  return true; 
                }  else {
                  return false;
                } 
            });
		})
		$('.save').click(function(){
			var array = [];
			var check = 'false';
			$('tbody tr').each(function(e){
				if($(this).find('.data-name').val().length > 50){
					alert('Maximum 50 characters are allowed in Fund Periods Name');
					check = 'true';
				}else{
					array.push({
						'date_from':$(this).find('.date_from').val(),
						'date_to':$(this).find('.date_to').val(),
						'data_name':$(this).find('.data-name').val()
					});
				}
			});
			if (check == 'false') {
				if(array.length < 1){
					array = [{
						'date_from':null,
						'date_to':null,
						data_name:''
					}];
					toastr.warning('Please add atleast one fund period.');
				}else{
					var url = base_url+admin+'/fund-periods';
					$.ajax({
		                url:url,
		                method:'POST',
		                dataType:'json',
		                data:{
		                  action:'saave',
		                  array:array,
		                  _token:_token,
		                }, success:function(res){
		                	if(res == 'success'){
								toastr.success('Fund Periods are saved successfully.');
		                	}else{
								toastr.warning(res);	                		
		                	}
		                }, error:function(e){
		                  toastr.error('Fund Periods are not saved please try again.');
		                }
					})
				}	
			}
		})
	})
</script>
@include('admin.layout.footer')