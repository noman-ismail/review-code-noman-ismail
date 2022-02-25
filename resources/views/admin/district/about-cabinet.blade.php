@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if($__userType == 'district')
  @include('admin.district.layouts.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
{{ full_editor() }}
@php
	$record = (empty($data))?array():json_decode($data->cabinet);
@endphp
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info">
			<div class="d-flex justify-content-between align-items-center text-white">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">About Cabinet</h6>
				</div>
	            <div class="text-right">
	              <a href="{{ route('about-cabinet') }}" class="btn btn-sm btn-secondary">About Cabinet</a>
	              <a href="{{ route('about-cabinet-meta') }}" class="btn btn-sm btn-success">About Cabinet Meta</a>
	            </div>
			</div>
		</div>
		<div class="card-body">
			<form action="{{ route('about-cabinet') }}" method="post">
				@csrf
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
			        </div>
			        <div class="col-md-12 mb-2">
			        	<div class="card border-info">
			        		<div class="card-header bg-secondary text-white font-weight-600">Pink Box</div>
			        		<div class="card-body">
					        	<div class="form-group">
					        		<label for="">Enter Heading</label>
					        		<input type="text" class="form-control" name="heading" value="{{ (!empty($record))?$record->heading:"" }}">
					        	</div>
					        	<div class="form-group">
					        		<label>Enter Body</label>
					        		<textarea name="body" class="form-control oneditor"> {!! (!empty($record))?$record->body:"" !!} </textarea>
					        	</div>
					        </div>
			        	</div>
			        </div>
			        <div class="col-md-12">
						<label class="font-weight-600">Detail</label>
						@error('text') <span class="text-danger">{{ $message }}</span> @enderror
			        	<button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#shortcode-model">
			        		Short Code
			        	</button>
					</div>
					<div class="col-md-12">
						<textarea name="text" class="form-control oneditor" rows="20">{!! (!empty($record))?$record->detail:"" !!}</textarea>
					</div>
					<div class="col-md-12 mt-3">
						<button class="btn btn-primary" name="submit">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--/.body content-->
<div class="modal fade" id="shortcode-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Description For Short Codes</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th> Short Code</th>
                        <th> Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td> Highlight Section: </td>
                        <td > <span class="ss_code" data-value=" [[highlight]] " style="cursor: copy;"> [[highlight]] </span> </td>
                        <td>Write this code what ever you want to show Latest Events</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td> Pink Section: </td>
                        <td > <span class="ss_code" data-value=" [[pink-section]] " style="cursor: copy;"> [[pink-section]] </span> </td>
                        <td>Write this code what ever you want to show Pink Box Section</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$('.ss_code').click(function(){
	var copyText = $(this).text();
	console.log(copyText);
	var fullLink = document.createElement('input');
	document.body.appendChild(fullLink);
	fullLink.value = copyText;
	fullLink.select();
	document.execCommand("copy");
	fullLink.remove();
	$(this).attr('title','Text Copied Successfully');
	$(this).attr('data-toggle','tooltip');
	$(this).attr('data-placement','top');
	$(this).tooltip('show')
});
</script>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif