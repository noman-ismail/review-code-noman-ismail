@php
	if(!empty(old())){
		$description = old('description');
		$message_body = old('message_body');
		$message_heading = old('message_heading');
 	}elseif(isset($get_data) and !empty(json_decode($get_data->cabinet_team))){
		$data = json_decode($get_data->cabinet_team , true);
		$description = (array_key_exists('description', $data))?$data['description']:"";
		$message_body = (array_key_exists('message_body', $data))?$data['message_body']:"";
		$message_heading = (array_key_exists('message_heading', $data))?$data['message_heading']:"";
	}else{
		$description = $message_body = $message_heading = "";
	}
@endphp
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
<div class="body-content">
	<div class="card border-info">
	    <div class="card-header bg-info text-white">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h6 class="fs-17 font-weight-600 mb-0">Cabinet Team</h6>
	        </div>
	        <div class="text-right">
	          <a href="{{ route('cabinet-team-meta') }}" class="btn btn-sm btn-success">Cabinet Team Meta</a>
	          <a href="{{ route('cabinet-content') }}" class="btn btn-sm btn-secondary">Cabinet Team</a>
	        </div>
	      </div>
	    </div>
		<div class="card-body">
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
				</div>
			</div>
			<form action="{{ (isset($get_data) and !empty($get_data))?route('cabinet-content')."?id=".request('id'):route('cabinet-content') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Description</label>
							@error('description')<div class="text-danger">{{ $message }}</div>@enderror
							<textarea name="description" class="form-control oneditor" rows="15">{!! $description !!}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card border-info mb-3">
							<div class="card-header bg-secondary text-white font-weith-600">Chairman Message</div>
							<div class="card-body">
								<div class="form-group">
									<label>Message Heading</label>
									<input type="text" name="message_heading" class="form-control" value="{{ $message_heading }}">
									@error('message_heading')<div class="text-danger">{{ $message }}</div>@enderror
								</div>
								<div class="form-group">
									<label>Message Body</label>
									<textarea class="form-control oneditor " name="message_body">{!! $message_body !!}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<button class="btn btn-primary" name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}">
							Submit
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif