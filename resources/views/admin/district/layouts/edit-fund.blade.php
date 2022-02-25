
<fieldset>
	<legend>Edit Fund</legend>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Receipt No.</label>
				<input type="text" value="{{ $record->receipt_no }}" class="form-control" name="receipt_no">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Date</label>
				<input type="text" value="{{ date('d/m/Y' , strtotime($record->deposited_on)) }}" class="form-control" name="date" data-toggle="datepicker" id="date-picker">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="font-weight-bold">User Name</label>
				<select class="form-control form-control-dropdown user" name="user">
					<option value="">Choose an Option</option>
					@if (count($users) > 0)
						@foreach ($users as $val)
		                    @php
		                      $get_user_info = get_userinfo_detail($val->id);
		                    @endphp
							<option value="{{ $val->id }}" {{ ($val->id == $record->user_id)?"selected":"" }}>
								{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?$get_user_info['personnel_no']." - ":"" }}{{ $val->name." - ".$val->cnic }}
							</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Amount</label>
				<input type="number" value="{{ $record->amount }}" class="form-control" name="amount" min="0">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Through</label>
				<input type="text" value="{{ $record->through }} " class="form-control" name="through">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Fund For</label>
				<select class="form-control form-control-dropdown fund_for" name="fund_for">
					<option value="apjea">APJEA</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="font-weight-bold">Fund Period</label>
				<select class="form-control form-control-dropdown fund_period" name="fund_period">
					<option value="">Choose an Option</option>
					@if (count($fund_period) > 0)
						@foreach ($fund_period as $val)
							<option class="{{ $val->id }}">{{ $val->name }}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>
		<input type="hidden" class="hidden_id" value="{{ $record->id }}">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="font-weight-bold">Comment</label>
				<textarea class="form-control comment" name="comment"></textarea>
			</div>
		</div>
		<div class="col-md-12 text-right">
			<button class="btn btn-info btn-sm sb-btn" type="button">Submit</button>
		</div>
	</div>
</fieldset>
<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('admin-assets/dist/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/component-chosen.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
<script>
    $('[data-toggle="datepicker"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
    });
    $('.form-control-dropdown').chosen();
    $('#date-picker').samask("00/00/0000");
    $('#date-picker').keydown(function(e){
        if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
          return false; 
        }  else {
          return true;
        } 
    });
    $('.sb-btn').click(function(){
    	var id = $('input[type="hidden"]').val();
    	var receipt_no = $('input[name="receipt_no"]').val();
    	var user = $('.user').val();
    	var date = $('input[name="date"]').val();
    	var amount = $('input[name="amount"]').val();
    	var through = $('input[name="through"]').val();
    	var fund_for = $('.fund_for').val();
    	var fund_period = $('.fund_period').val();
    	var comment = $('.comment').val();
    	var check = 'true';
    	if (id == '') {
    		alert('Fund ID not Found');
    		check = 'false';
    	}
    	if (receipt_no == '') {
    		alert('Receipt No. is required');
    		check = 'false';
    	}
    	if (user == '') {
    		alert('User Name is required');
    		check = 'false';
    	}
    	if (date == '') {
    		alert('Date is required');
    		check = 'false';
    	}
    	if (amount == '') {
    		alert('Amount is required');
    		check = 'false';
    	}
    	if (through == '') {
    		alert('Payment through is required');
    		check = 'false';
    	}
    	if (check == 'true') {
    		$.ajax({
				url:base_url+admin+'/fund-history',
		        method:'POST',
		        dataType:'json',
		        data:{
		          action:'fund-update',
		          id:id,
		          receipt_no:receipt_no,
		          user:user,
		          date:date,
		          amount:amount,
		          through:through,
		          fund_for:fund_for,
		          fund_period:fund_period,
		          comment:comment,
		          _token:_token,
		        }, success:function(res){
		        	console.log(res);
		        	if (res == "success") {
						toastr.success('Fund updated successfully.');
		        	}else{
						toastr.warning(res);
					}
		        }, error:function(e){
		          toastr.error('Something wrong please refresh page and try again.');
		        }
    		})
    	}
    })
</script>