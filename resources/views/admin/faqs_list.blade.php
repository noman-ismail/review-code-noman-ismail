@include('admin.layout.header')
<div class="body-content">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Blogs Meta</h6>
						</div>
						<div class="text-right">
							<div class="actions">
								<a href="/<?= admin ?>/faqs" class="btn btn-info">Add New Record</a>
								<a href="/<?= admin ?>/faqs/meta" class="btn btn-info">FAQs Meta Settings</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-responsive">
						<thead>
							<tr>
								<th><strong>ID</strong> </th>
								<th><strong>Question</strong> </th>
								<th><strong>Action</strong>	</th>
							</tr>
							<thead>
								<tbody>
									@foreach($faqs as $faq)
									<tr>
										<td style="width: 5%">{{ $faq->id }}</td>
										<td style="width: 70%">	<b>{{$faq->question}}</b><br> <br>	{!! $faq->answer !!}</td>
										<td>
											 <a href="/<?= admin ?>/faqs?edit={{ $faq->id }}" class="-soft  mr-1 fa fa-edit" title="Edit"></a>
                      						<a href="/<?= admin ?>/faqs?del={{ $faq->id }}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('admin.layout.footer')