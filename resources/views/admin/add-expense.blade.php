 @php
	if(old('title') != null || old('amount') != null || old('description') != null){
		$title = old('title');
		$amount = old('amount');
		$entry_date = old('entry_date');
		$description = old('description');
	}elseif(isset($get_data) and !empty($get_data)){
		$title = $get_data->title;
		$amount = $get_data->amount;
		$entry_date = $get_data->entry_date;
		$description = $get_data->description;
	}else{ 
		$title = $amount = $description = "";
		$entry_date = date('d/m/Y');
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
<div class="body-content">
	<div class="card border-info">
	    <div class="card-header bg-info text-white">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h6 class="fs-17 font-weight-600 mb-0">Add New Expense </h6>
	        </div>
	        <div class="text-right">
	          <a href="{{ route('expense-sheet') }}" class="btn btn-sm btn-success">Expense Sheet</a>
	          <a href="{{ route('add-expense') }}" class="btn btn-sm btn-secondary">Add New</a>
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
			<form action="{{ (isset($get_data) and !empty($get_data))?route('add-expense')."?id=".request('id'):route('add-expense') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-12">
						
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<label for="">Title <span class="required">*</span></label>
							<input type="text" name="title" class="form-control" placeholder="Enter Expense Title" value="{{ $title }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('title') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Amount <span class="required">*</span></label>
							<input type="number" min="1" max="1000000000"placeholder="" name="amount" class="form-control" value="{{ $amount }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('amount') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Entry Date <span class="required">*</span></label>
							<input type="text" name="entry_date" class="form-control" autocomplete="off" id="date-picker" value="{{ $entry_date }}" {{ (isset($get_data) and !empty($get_data))?"":"readonly" }}>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('entry_date') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="form-group">
							<label for="">Description</label>
							<textarea class="form-control" rows="5" name="description">{{ $description }}</textarea>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('description') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-8 text-right">
						<button class="btn btn-primary" name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}" type="submit">
							Submit
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('form').on('submit',function(){
			$(this).find('button').attr('disabled',true);
			return true;
		})
	})
</script>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif