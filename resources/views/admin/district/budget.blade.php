@php
	if(old('title') != null || old('amount') != null || old('reason') != null){
		$title = old('title');
		$amount = old('amount');
		$reason = old('reason');
		$due_date = old('due_date');
		$province = old('province');
	}elseif(isset($get_data) and !empty($get_data)){
		$province = $get_data->reqst_to;
		$title = $get_data->title;
		$amount = $get_data->amount;
		$reason = $get_data->reason;
		$due_date = (!empty($get_data->due_date))?date('d/m/Y' , strtotime($get_data->due_date)):"";
	}else{
		$title = $amount = $reason = $province_name = $province = $due_date = "";
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
	          <h6 class="fs-17 font-weight-600 mb-0">New Request for Budget <span style="font-size: 12px"></span></h6>
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
			</div>
			<form action="{{ (isset($get_data) and !empty($get_data))?route('add-budget')."?id=".request('id'):route('add-budget') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							@php
								$__user = DB::table('admin')->where('username',Auth::user()->username)->first();
								if($__user->type == 'district'){
									$___userDept = DB::table('cities')->where('id',$__user->dept_id)->first();
									if($___userDept){
										$pr_id = $___userDept->province;
									}else{
										$pr_id = '';
									}
								}else{
									$pr_id = $__user->dept_id;
								}
							@endphp
							@if ($__user->type == 'national')
								<label for="">Request From <span class="required">*</span></label>
							@else
								<label for="">Request To <span class="required">*</span></label>
							@endif
							<input type="text" name='province_name' class="form-control" value="{{ user_ProvinceName() }}" readonly>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('province_name') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					@php
						$_rem = getCurrentRemaingBdg($__user->dept_id,$__user->type,request('id'));
					@endphp
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Remaining Allocated Budget</label>
							<input type="text" name="remaining" class="form-control remaining" value="{{ $_rem }}" readonly>
						</div>
					</div>
					@if ($__user->type == 'national')
						@php
							$provinces = DB::table('province')->get();
						@endphp
						<div class="col-md-3">
							<label for="">Select Province for Request <span class="required">*</span></label>
							<select class="form-control form-control-chosen province" name="province">
								<option value="">Choose an Option</option>
								@if (count($provinces) > 0)
									@foreach ($provinces as $element)
										<option value="{{ $element->id }}" {{ ($province == $element->id)?"selected":"" }}>{{ $element->name }}</option>
									@endforeach
								@endif
							</select>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('province') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
						<div class="col-md-3">
					@else
						<div class="col-md-6">
							<input type="hidden" name="province" value="{{ $pr_id }}">
					@endif
						<div class="form-group">
							<label for="">Budget Title <span class="required">*</span></label>
							<input type="text" name="title" class="form-control" value="{{ $title }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('title') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Amount <span class="required">*</span></label>
							<input type="number" name="amount" class="form-control amount" value="{{ $amount }}" min="1" max="{{ $_rem }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('amount') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Due Date <span class="required">*</span></label>
							<input type="text" data-toggle="DueDate" autocomplete="off" id="date-picker" name="due_date" class="form-control" value="{{ $due_date }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('due_date') as $error)
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
		<input type="hidden" class="__remaining" value="{{ ($__user->type == 'national')?"0":getCurrentRemaingBdg() }}">
	</div>
</div>
@if ($__user->type == 'national')
	<script>
		$(document).ready(function(){
			var province = $('.province').val();
			var type = '{{ auth('admin')->user()->type }}';
			if(parseInt(province) > 0){
				fetch_national_budget(province,type);
			}
			$('.province').change(function(){
				var prov = $(this).val();
				var type = '{{ auth('admin')->user()->type }}';
				var url = '{{ route('remaining-budget') }}';
				if(prov != ""){
					fetch_national_budget(prov,type);
				}
			});
			function fetch_national_budget(id,type){
				var url = '{{ route('remaining-budget') }}';
				$.ajax({
	                url:url,
	                method:'POST',
	                dataType:'json',
	                data:{
	                  action:'get-national',
	                  id:id,
	                  type:type,
	                  _token:_token,
	                }, success:function(res){
	                	$('.remaining').val(res);
	                	$('.__remaining').val(res);
	                }, error:function(e){
	                	alert('Error to get national remaining budget. Refresh page and try again');
	                }
				})
			}
		})
	</script>
@endif
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
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif
<script>
    $('[data-toggle="DueDate"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
        startDate:'today',
    });
</script>