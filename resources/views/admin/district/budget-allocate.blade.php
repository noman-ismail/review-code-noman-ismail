@php
  $__username = auth('admin')->user()->username;
  $__userType = auth('admin')->user()->type;
  $__userDept = auth('admin')->user()->dept_id;
  $record = DB::table('cities')->where('province',$__userDept)->get();
  $collected_fff = get_collected_fund($__userDept);
	if(old('title') != null || old('amount') != null || old('reason') != null){
		$title = old('title');
		$amount = old('amount');
		$reason = old('reason');
		$allowcate_to = old('allowcate_to');
		$province = old('province');
	}elseif(isset($get_data) and !empty($get_data)){
		$province = $get_data->reqst_to;
		$title = $get_data->title;
		$amount = $get_data->amount;
		$reason = $get_data->reason;
		$allowcate_to = (!empty($get_data->allowcate_to))?date('d/m/Y' , strtotime($get_data->allowcate_to)):"";
	}else{
		$title = $amount = $reason = $province_name = $province = $allowcate_to = "";
	}
@endphp
@include('admin.province.layouts.header')
{{ full_editor() }}
<div class="body-content">
	<div class="card border-info">
	    <div class="card-header bg-info text-white">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h6 class="fs-17 font-weight-600 mb-0">Allocate New Budget</h6>
	        </div>
	        <div class="text-right">
	          <a href="{{ route('budget-distribution') }}" class="btn btn-sm btn-success">Budget List</a>
	          <a href="{{ route('budget-allocate') }}" class="btn btn-sm btn-secondary">Allocate New Budget</a>
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
		        </div>
				<div class="col-md-12">
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
			<form action="{{ (isset($get_data) and !empty($get_data))?route('budget-allocate')."?id=".request('id'):route('budget-allocate') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Remaining Budget</label>
							<input type="text" name="remaining" class="form-control remaining" value="{{ find_remaining_bdg() }}" readonly>
						</div>
					</div>				
					<div class="col-md-4">
						<div class="form-group">
							@php
								if($__userType == 'district'){
									$__userDept = DB::table('cities')->where('id',$__userDept)->first();
									if($__userDept){
										$pr_id = $__userDept->province;
									}else{
										$pr_id = '';
									}
								}else{
									$pr_id = $__userDept;
								}
								$_provinceName = DB::table('province')->where(['id'=>$__userDept])->first();
							@endphp
							<label for="">Allocate To <span class="required">*</span></label>
							<select name="allowcate_to" class="form-control form-control-chosen">
								<option value="">Choose an Option</option>
								<option value="1-n" {{ ($allowcate_to == "1-n")?"selected":"" }}>Pakistan</option>
								<option value="{{ $__userDept }}-p" {{ ($allowcate_to == $__userDept."-p")?"selected":"" }}>{{ $_provinceName->name }}</option>
								@if (count($record) > 0)
									@foreach ($record as $val)
										<option value="{{ $val->id }}-d" {{ ($allowcate_to == $val->id."-d")?"selected":"" }}>{{ $val->name }}</option>
									@endforeach
								@endif
							</select>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('province_name') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Amount <span class="required">*</span></label>
							<input type="number" name="amount" class="form-control amount" value="{{ $amount }}" min="1">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('amount') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Title <span class="required">*</span></label>
							<input type="text" name="title" class="form-control" value="{{ $title }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('title') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Reason <span class="required">*</span></label>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('reason') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
							<textarea  name="reason" rows="7" class="form-control">{!! $reason !!}</textarea>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<input type="hidden" name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}">
						<button class="btn btn-primary submi" name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}" type="button">
							Submit
						</button>
					</div>
				</div>
			</form>
		</div>
		<input type="hidden" class="__remaining" value="{{ find_remaining_bdg($__userDept) }}">
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.submi').click(function(){
			var remaining = $('.__remaining').val();
			var amount = $('.amount').val();
			if($.isNumeric( amount )){
				if(parseInt(remaining) < parseInt(amount)){
					alert('Your Remaining budget is less then your amount.');
				}else{
					$('form').submit();
				}
			}else{
				alert('Please enter correct amount');
			}
		})
	})
</script>
@include('admin.province.layouts.footer')