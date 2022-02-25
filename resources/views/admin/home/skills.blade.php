@include( 'admin.layout.header' )
@php
tiny_editor();
@endphp
<div class="body-content">
	<div class="row">
		<div class="col-md-10 col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Skills & Rewards</h6>
						</div>
						<div class="text-right">
							<div class="actions">
								 <a href="{{url('/'.admin.'/homepage')}}" class="btn {{ Request::segment(2)=='homepage'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Home Meta</a>
				                <a href="{{url('/'.admin.'/homepage/grants')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='grants'  ? 'btn-inverse' : 'btn-info' }} pull-right">Grants</a>
				                <a href="{{url('/'.admin.'/homepage/initiatives')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='initiatives'  ? 'btn-inverse' : 'btn-info' }} pull-right">Initiatives</a>
				                <a href="{{url('/'.admin.'/homepage/skills')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='skills'  ? 'btn-inverse' : 'btn-info' }} pull-right">Skills</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					@if (Session::has('flash_message'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>{!! Session('flash_message') !!}</strong>
					</div>
					@endif @if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<form method="POST" action="/{{ admin }}/homepage/skills" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-lg-12">
								@php
								$skills = ($data->skills !="" )? json_decode($data->skills , true) : array();
								@endphp
								<input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
								<div class="form-group col-lg-10 p-0">
									<div class="card">
										<div class="card-header card bg-secondary text-white">
											<b> Personal Skills</b>
										</div>
										<div class="card-body">
											<div class="interest">
												<div class="form-rows">
													<table class="table table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>Name</th>
																<th>Percentage</th>
																<th></th>
															</tr>
														</thead>
														<tbody class="ps">
															@php $res = $skills; $rev_count = (count($res)==0) ? 0 : count($res) - 1; for ($n=0; $n
															<=$rev_count; $n++){ $ps_name=( isset($res[$n][ "ps_name"])) ? $res[$n][ "ps_name"]: ""; $ps_percent=( isset($res[$n][ "ps_percent"])) ? $res[$n][ "ps_percent"]: ""; @endphp <tr class="tr-row">
																<td>{{ $n+1 }}</td>
																<td>
																	<div class="form-group m-0">
																		<input type="text" name="ps_name[]" placeholder="Interset Name" class="form-control" value="{{ $ps_name }}"/>
																		<div class="text-danger"> </div>
																	</div>
																</td>
																<td>
																	<div class="form-group m-0">
																		<div class="input-group">
																			<input type="number" min="1" max="100" name="ps_percent[]" placeholder="98" class="form-control" value="{{ $ps_percent }}"/>
																			<div class="input-group-append">
																				<span class="input-group-text count countshow">%</span>
																			</div>
																		</div>
																	</div>
																</td>
																<td class="text-center"> <i class="fa fa-trash text-danger clear-item mx-auto my-auto"></i>
																</td>
															</tr>
															@php } @endphp
														</tbody>
													</table>
													<div style="text-align:right;">
														<a href="" class="btn btn-success add-ps text-white"><i class="fa fa-plus"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('admin.layout.footer')
	<script>
		$( ".add-more-rewards" ).click( function () {
			var html_obj = $( ".rewards-rows .row" ).first().clone();
			var ln = $( ".rewards-rows .row" ).length;
			$( html_obj ).find( "input" ).each( function () {
				$( this ).attr( "value", "" );
			} );
			$( html_obj ).find( "textarea" ).each( function () {
				$( this ).text( "" );
			} );
			$( ".rewards .rewards-rows" ).append( "<div class='border row'>" + html_obj.html() + "</div>" );
			return false;
		} );
		$( document ).on( "click", ".clear-data2", function () {
			var v = window.confirm( "Do you want to delete data?" );
			if ( v ) {
				$( this ).closest( ".row" ).remove();
			}
		} );
		$( ".add-pr" ).click( function () {
			var html_obj = $( ".pr tr" ).first().clone();
			var ln = $( ".pr tr" ).length;
			$( html_obj ).find( "input" ).each( function () {
				$( this ).attr( "value", "" );
			} );
			$( html_obj ).find( "textarea" ).each( function () {
				$( this ).text( "" );
			} );
			html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
		$( ".interest .pr" ).append( "<tr>" + html_obj.html() + "</tr>" );
		return false;
	} );
	$( ".add-dvlp" ).click( function () {
		var html_obj = $( ".dvlp tr" ).first().clone();
		var ln = $( ".dvlp tr" ).length;
		$( html_obj ).find( "input" ).each( function () {
			$( this ).attr( "value", "" );
		} );
		$( html_obj ).find( "textarea" ).each( function () {
			$( this ).text( "" );
		} );
		html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
		$( ".interest .dvlp" ).append( "<tr>" + html_obj.html() + "</tr>" );
		return false;
	} );
	$( ".add-ps" ).click( function () {
		var html_obj = $( ".ps tr" ).first().clone();
		var ln = $( ".ps tr" ).length;
		$( html_obj ).find( "input" ).each( function () {
			$( this ).attr( "value", "" );
		} );
		$( html_obj ).find( "textarea" ).each( function () {
			$( this ).text( "" );
		} );
		html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
		$( ".interest .ps" ).append( "<tr>" + html_obj.html() + "</tr>" );
		return false;
	} );
	$( ".add-wrkshp" ).click( function () {
		var html_obj = $( ".wrkshp tr" ).first().clone();
		var ln = $( ".wrkshp tr" ).length;
		$( html_obj ).find( "input" ).each( function () {
			$( this ).attr( "value", "" );
		} );
		$( html_obj ).find( "textarea" ).each( function () {
			$( this ).text( "" );
		} );
		html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
		$( ".workshop .wrkshp" ).append( "<tr>" + html_obj.html() + "</tr>" );
		return false;
	} );
	$( document ).on( "click", ".clear-item", function () {
		var v = window.confirm( "Do you want to delete data?" );
		if ( v ) {
			$( this ).closest( "tr" ).remove();
		}
	} );
</script>