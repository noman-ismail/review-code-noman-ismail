@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
  $province = DB::table('budget_allocation')->where(['allowcate_from'=>$__user->dept_id,'type'=>'province','allowcate_to'=>$__user->dept_id])->first();
  // dd($province);
  // $record = DB::table('budget_allocation')->where(['allowcate_from'=>$__user->dept_id,'type'=>'city'])->get();
  $record = DB::table('cities')->where('province',$__user->dept_id)->get();
  $national = DB::table('national_allocation')->where(['allowcate_from'=>$__user->dept_id])->first();
  $collected_fff = get_collected_fund($__user->dept_id);
   // dd($collected_fff);
@endphp
@include('admin.province.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Budget Distribution</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<h5>Total Collection of Funds <span class="badge badge-info badge-collection">{{ $collected_fff }}</span></h5>
				</div>
				<div class="col-md-6">
					<h5>Total Remaining Budget <span class="badge badge-info badge-remaining">{{ $collected_fff }}</span></h5>
				</div>
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr class="bg-info text-white">
								<th>Name</th>
								<th>Annual</th>
								<th>Supplimentary</th>
								<th>Revised</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody class="table-record">
							<tr data-national="pakistan">
								<td>Pakistan</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control annual" value="{{ (!empty($national))?$national->annual:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control supp" value="{{ (!empty($national))?$national->supplementary:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control revised" value="{{ (!empty($national))?$national->revised:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control total" value="{{ (!empty($national))?$national->total:"0" }}">
									</div>
								</td>
							</tr>
							<tr data-provinc='{{ $__user->dept_id }}'>
								<td>{{ user_ProvinceName() }}</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control annual" value="{{ (!empty($province))?$province->annual:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control supp" value="{{ (!empty($province))?$province->supplementary:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control revised" value="{{ (!empty($province))?$province->revised:"0" }}">
									</div>
								</td>
								<td>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text">
									    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
									    </span>
									  </div>
									  <input type="number" class="form-control total" value="{{ (!empty($province))?$province->total:"0" }}">
									</div>
								</td>
							</tr>
							@if(count($record) > 0)
								@php $i=1; @endphp
								@foreach($record as $key => $value)
									@php
										$__record = get_city_allocation($value->id);
									@endphp
										<tr data-id = '{{ $value->id }}'>
											<td>{{ $value->name }}</td>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="number" class="form-control annual" value="{{ ($__record)?$__record->annual:"0" }}">
												</div>
											</td>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="number" class="form-control supp" value="{{ ($__record)?$__record->supplementary:"0" }}">
												</div>
											</td>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="number" class="form-control revised" value="{{ ($__record)?$__record->revised:"0" }}">
												</div>
											</td>
											<td>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="typcn typcn-calendar-outline" style="font-size: 18px"></i>
												    </span>
												  </div>
												  <input type="number" class="form-control total" value="{{ ($__record)?$__record->total:"0" }}">
												</div>
											</td>
										</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					<div class="text-right">
						<button type="button" class="btn btn-info save">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--/.body content-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.css') }}">
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
	$(document).ready(function(){
		calculate_remaining();
		function calculate_remaining(){
			var _total = 0;
			$('.total').each(function(e){
				let u = $(this).val();
				_total = parseInt(_total)+parseInt(u);
			});
			var _grandTotal = '{{ $collected_fff }}';
			$('.badge-remaining').html(parseInt(_grandTotal)-parseInt(_total));
		}
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
		$('.annual , .supp , .revised').change(function(){
			var t = $(this);
			var annual = t.closest('tr').find('.annual').val();
			var supp = t.closest('tr').find('.supp').val();
			var revised = t.closest('tr').find('.revised').val();
			supp = ($.isNumeric(supp)) ? parseInt(supp) : '0';
			annual = ($.isNumeric(annual)) ? parseInt(annual) : '0';
			revised = ($.isNumeric(revised)) ? parseInt(revised) : '0';
			t.closest('tr').find('.total').val(parseInt(annual)+parseInt(supp)+parseInt(revised));
			calculate_remaining();
		});
		$('.total').attr('readonly','true');
		$('.save').click(function(){
			var record = $('.table-record').find('tr[data-id]');
			var province = $('.table-record').find('tr[data-provinc]');
			var national = $('.table-record').find('tr[data-national]');
			var city = [];
			record.each(function(i){
				var _city = [];
				_city.push([$(this).attr('data-id')]);
				_city.push([$(this).find('.annual').val()]);
				_city.push([$(this).find('.supp').val()]);
				_city.push([$(this).find('.revised').val()]);
				_city.push([$(this).find('.total').val()]);
				city.push(_city);
			});
			var _province = [];
			_province.push(province.find('.annual').val());
			_province.push(province.find('.supp').val());
			_province.push(province.find('.revised').val());
			_province.push(province.find('.total').val());
			var _national = [];
			_national.push(national.find('.annual').val());
			_national.push(national.find('.supp').val());
			_national.push(national.find('.revised').val());
			_national.push(national.find('.total').val());
      $.ajax({
        url:baseURL+"budget-distribution",
        method:'POST',
        dataType:'json',
        data:{
          action:'update',
          district:city,
          province:_province,
          national:_national,
          _token:_token,
        }, success:function(res){
            toastr.success('Budget Allocation saved successfully');
        }, error:function(e){
            toastr.error('Failed : '+e);
        }
      });
		})
	})
</script>
@include('admin.province.layouts.footer')