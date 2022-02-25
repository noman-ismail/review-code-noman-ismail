@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
  if($__userType == 'province'){
  	$budget_allocation = DB::table('budget_allocation')->where('allowcate_from',$__user->dept_id)->get();
  }else{
  	script_redirect(url()->previous());
  }
  $national_allocation = DB::table('national_allocation')->where('allowcate_from',$__user->dept_id)->first();
@endphp

@include('admin.province.layouts.header')
<div class="body-content">
	<div class="card mb-4">
		<div class="card-header bg-success">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Budget Stats</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Allowed</th>
								<th>Consumed</th>
								<th>Pipline</th>
								<th>Remaining</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>Pakistan</th>
								<td>{{ ($national_allocation != "")?$national_allocation->total:"0" }}</td>
								<td>{{ ($national_allocation != "")?$consumed = find_bdg_stat('1','consumed','national'):$consumed = '0' }}</td>
								<td>{{ ($national_allocation != "")?$pipline = find_bdg_stat('1','pipline','national'):$consumed = '0' }}</td>
								<td>{{ ($national_allocation != "")?$national_allocation->total-$consumed-$pipline:'0' }}</td>
							</tr>
							@if (count($budget_allocation) > 0)
								@foreach ($budget_allocation as $value)
									@php
										$typeName = ($value->type == 'city')?"district":$value->type;
									@endphp
									<tr>
										<th>{{ get_DeptName($value->allowcate_to,$typeName) }}</th>
										<td>{{ $value->total }}</td>
										<td>{{ $consumed = find_bdg_stat($value->allowcate_to,'consumed',$typeName) }}</td>
										<td>{{ $pipline = find_bdg_stat($value->allowcate_to,'pipline',$typeName) }}</td>
										{{-- {{ dd($pipline) }} --}}
										<td>{{ $value->total - $consumed - $pipline }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					{{-- <div class="text-right">
						<button type="button" class="btn btn-info save">Save</button>
						<button type="button" class="btn btn-secondary ad-mor">Add More</button>
					</div> --}}
				</div>
			</div>
		</div>
	</div>
</div><!--/.body content-->

@include('admin.province.layouts.footer')