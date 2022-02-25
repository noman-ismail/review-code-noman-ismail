@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4">
		<div class="card-header bg-success">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Jobs List</h6>
				</div>
		        <div class="text-right">
		         	<a href="{{ route('add-job') }}" class="btn btn-info">Add New Job</a>
		         	<a href="{{ route('fund-history') }}" class="btn btn-secondary">Jobs CMS</a>
		        </div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Sr. No</th>
								<th width="60%">Job Title</th>
								<th>Status</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(count($jobs) > 0)
								@php
									$i = 1;
								@endphp
								@foreach($jobs as $value)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $value->title }}</td>
										<td>{{ $value->status }}</td>
										<td>{{ ($value->date != null)?date('d/m/Y',strtotime($value->date)):"" }}</td>
										<td>
											<a href="{{ route('funds')."?id=".$value->id }}">
												<i class="typcn typcn-edit" style="font-size: 16px;"></i>
											</a>
											<a href="{{ route('funds')."?del=".$value->id }}" onclick="return confirm('Are you sure want to delete ?')">
												<i class="typcn typcn-trash" style="font-size: 16px;"></i>
											</a>
										</td>
									</tr>
								@endforeach
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
@include('admin.district.layouts.footer')