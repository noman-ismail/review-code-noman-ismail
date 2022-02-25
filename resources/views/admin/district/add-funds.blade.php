@php 
	$remaining = (isset($remaining))?$remaining:"";
	$payment_via = $amount = $title = $bank = $no = $comment = $account_no = $date = $cash_date = $transaction_id = $cash_image = $check_date = $cheque_image = $transfer_date = $transfer_id = $transfer_img = $transfer_to_name = $transfer_to_ac = $transfer_to_bank = $transfer_from_bank = $transfer_from_ac = $transfer_from_name = $remainig = $depositor = "";
	if(old()){
		$remaining = old('remaining');
		$amount = old('amount');
		$date = old('date');
		$comment = old('comment');
		$payment_via = old('payment_via');
		if($payment_via == 'cash'){
			$title = old('title');
			$bank = old('bank');
			$account_no = old('account_no');
			$cash_date = old('cash_date');
			$transaction_id = old('transaction_id');
			$cash_image = old('cash_image');
		}elseif($payment_via == 'check'){
			$title = old('title');
			$bank = old('bank');
			$no = old('no');
			$check_date = old('check_date');
			$cheque_image = old('cheque_image');
		}elseif($payment_via == 'bank'){
			$transfer_date = old('transfer_date');
			$transfer_id = old('transfer_id');
			$transfer_img = old('transfer_img');
			$transfer_to_name = old('transfer_to_name');
			$transfer_to_ac = old('transfer_to_ac');
			$transfer_to_bank = old('transfer_to_bank');
			$transfer_from_name = old('transfer_from_name');
			$transfer_from_ac = old('transfer_from_ac');
			$transfer_from_bank = old('transfer_from_bank');
		}
	}elseif(isset($get_data) and !empty($get_data)){
		$remaining = $get_data->amount + $remaining;
		$payment_via = $get_data->through;
		$amount = $get_data->amount;
		$comment = $get_data->comment;
		$date = ($get_data->date != null)?date('d/m/Y' , strtotime($get_data->date)):"";
		$json_data = (!empty($get_data->payment_detail))?json_decode($get_data->payment_detail , true):array();
		// dd($json_data);
		if(!empty($json_data) and $payment_via == 'cash'){
			$title = $json_data['Cash title'];
			$bank = $json_data['Cash Bank'];
			$account_no = $json_data['Account Number'];
			$cash_date = $json_data['Deposit Date'];
			$depositor = $json_data['Depositor'];
			$cash_image = $json_data['Cash Image'];
		}elseif(!empty($json_data) and $payment_via == 'check'){
			$title = $json_data['Cheque title'];
			$bank = $json_data['Cheque Bank'];
			$no = $json_data['Cheque Number'];
			$check_date = $json_data['Cheque Date'];
			$cheque_image = $json_data['Cheque Image'];
		}elseif(!empty($json_data) and $payment_via == 'bank'){
			$transfer_date = $json_data['Transfer Date'];
			$transfer_id = $json_data['Transaction Id'];
			$transfer_img = $json_data['Cheque Image'];
			$transfer_to_name = $json_data['Transfer To Bank Name'];
			$transfer_to_ac = $json_data['Transfer To Account No'];
			$transfer_to_bank = $json_data['Transfer To Bank Title'];
			$transfer_from_name = $json_data['Transfer From Bank Name'];
			$transfer_from_ac = $json_data['Transfer From Account No'];
			$transfer_from_bank = $json_data['Transfer From Bank Title'];
		}
	}
@endphp
@include('admin.district.layouts.header')
<div class="body-content">
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h6 class="fs-17 font-weight-600 mb-0">Transfer Fund to Province</h6>
				</div>
		        <div class="text-right">
		         	<a href="{{ route('transfer-to-province') }}" class="btn btn-success">Payment History</a>
		         	<a href="{{ route('transfer-payment') }}" class="btn btn-secondary">Transfer Payment</a>
		        </div>
			</div>
		</div>
		<div class="card-body">
			<input type="hidden" class="current_bdgt" value="{{ (isset($__rem))?$__rem:$remaining }}">
			<form action="{{ (isset($get_data) and !empty($get_data))?route('transfer-payment').'?id='.request('id'):route('transfer-payment') }}" method="post" enctype="multipart/form-data" id="transfer_fund">
				@csrf
				<div class="row">
			        <div class="col-md-12">
			          @if(session()->has("error"))
			            <div class="alert alert-danger alert-dismissible fade show" role="alert">
			              {!! session("error") !!}
			              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                <span aria-hidden="true">&times;</span>
			              </button>
			            </div>
			          @endif
			          @if(session()->has("success"))
			            <div class="alert alert-success alert-dismissible fade show" role="alert">
			              {!! session("success") !!}
			              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                <span aria-hidden="true">&times;</span>
			              </button>
			            </div>
			          @endif
			        </div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Total Remaining Fund <span class="required">*</span></label>
							<input type="number" class="form-control remainig" name="remaining" value="{{ $remaining }}" readonly>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('remaining') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Enter Transfer Amount  <span class="required">*</span></label>
							<input type="number" class="form-control amount" min="1" name="amount" value="{{ $amount }}"  max="{{ (isset($__rem))?$__rem:$remaining }}">
							<span class="__error"></span>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('amount') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Payment Via</label>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('payment_via') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
				            <div class="productdetail">
				              <label class="chk-st-d">
				                <input type="radio" class="width-auto check" value="check" name="payment_via" {{ ($payment_via == 'check')?"checked":"" }}>
				                <span>Cheque</span>
				              </label>
				              <label class="chk-st-d">
				                <input type="radio" class="width-auto bank" value="bank" name="payment_via" {{ ($payment_via == 'bank')?"checked":"" }}>
				                <span>Bank Transfer</span>
				              </label>
				              <label class="chk-st-d">
				                <input type="radio" class="width-auto cash" value="cash" name="payment_via" {{ ($payment_via == 'cash')?"checked":"" }}>
				                <span>Cash Deposit</span>
				              </label>
				            </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Date  <span class="required">*</span></label>
							<input type="text" name="date" data-toggle="TransferDate" autocomplete="off" id="date-picker" class="form-control" value="{{ $date }}">
			                @if(count($errors) > 0)
			                  @foreach($errors->get('date') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-12 mb-3" id="cash_detail">
						<div class="check-form">
							<fieldset>
								<legend>Payment Detail</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Cheque Title <span class="required">*</span></label>
											<input type="text" name="title" value="{{ $title }}" class="form-control check_title">
											@if (old('payment_via') == 'check')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('title') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cheque Bank <span class="required">*</span></label>
											<input type="text" name="bank" value="{{ $bank }}" class="form-control check_bank">
											@if (old('payment_via') == 'check')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('bank') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cheque Number <span class="required">*</span></label>
											<input type="text" name="no" value="{{ $no }}" class="form-control check_no">
											@if (old('payment_via') == 'check')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('no') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cheque Date <span class="required">*</span></label>
											<input type="text" name="check_date" value="{{ $check_date }}" class="form-control check_date" data-toggle='TransferDate' id='date-picker2' autocomplete="off" placeholder="dd/mm/yyyy">
											@if (old('payment_via') == 'check')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('check_date') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cheque Image <span class="required">*</span></label>
											<input type="hidden" name='file_hidden' value="{{ $cheque_image }}">
											<input type="file" name="cheque_image" class="form-control check_img">
											@if (old('payment_via') == 'check')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('cheque_image') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
											<span class="check_img_erro" style="color: red"></span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="cash-form">
							<fieldset>
								<legend>Payment Detail</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Bank Name <span class="required">*</span></label>
											<input type="text" name="bank" value="{{ $bank }}" class="form-control cash_bank">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('bank') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cash Depositor Name <span class="required">*</span></label>
											<input type="text" name="depositor" value="{{ $depositor }}" class="form-control cash_bank">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('depositor') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Receiver Account No <span class="required">*</span></label>
											<input type="text" name="account_no" value="{{ $account_no }}" class="form-control cash_ac_no">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('account_no') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Receiver Account Title <span class="required">*</span></label>
											<input type="text" name="title" value="{{ $title }}" class="form-control cach_title">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('title') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Deposit Date <span class="required">*</span></label>
											<input type="text" name="cash_date" value="{{ $cash_date }}" class="form-control cash_deposit_date" data-toggle='TransferDate' id='date-picker3' autocomplete="off" placeholder="dd/mm/yyyy">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('cash_date') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Cash Receipt Image <span class="required">*</span></label>
											<input type="hidden" name='file_hidden' value="{{ $cash_image }}">
											<input type="file" name="cash_image" class="form-control cash_img">
											@if (old('payment_via') == 'cash')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('cash_image') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
											<span class="cash_img_erro" style="color: red"></span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="bank-form">
							<fieldset>
								<legend>Payment Detail</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer To Bank Name <span class="required">*</span></label>
											<input type="text" name="transfer_to_name" value="{{ $transfer_to_name }}" class="form-control transfer_to_name">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_to_name') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer To Account No <span class="required">*</span></label>
											<input type="text" name="transfer_to_ac" value="{{ $transfer_to_ac }}" class="form-control transfer_to_ac">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_to_ac') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer To Account Title <span class="required">*</span></label>
											<input type="text" name="transfer_to_bank" value="{{ $transfer_to_bank }}" class="form-control transfer_to_bank">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_to_bank') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer From Bank Name <span class="required">*</span></label>
											<input type="text" name="transfer_from_name" value="{{ $transfer_from_name }}" class="form-control transfer_from_name">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_from_name') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer From Account No <span class="required">*</span></label>
											<input type="text" name="transfer_from_ac" value="{{ $transfer_from_ac }}" class="form-control transfer_from_ac">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_from_ac') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer From Account Title <span class="required">*</span></label>
											<input type="text" name="transfer_from_bank" value="{{ $transfer_from_bank }}" class="form-control transfer_from_bank">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_from_bank') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transfer Date <span class="required">*</span></label>
											<input type="text" name="transfer_date" value="{{ $transfer_date }}" class="form-control transfer_date" data-toggle='TransferDate' id='date-picker4' autocomplete="off" placeholder="dd/mm/yyyy">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_date') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Transaction Id</label>
											<input type="text" name="transfer_id" value="{{ $transfer_id }}" class="form-control transfer_id">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_id') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Screenshot Image <span class="required">*</span></label>
											<input type="hidden" name='file_hidden' value="{{ $transfer_img }}">
											<input type="file" name="transfer_img" class="form-control transfer_img">
											@if (old('payment_via') == 'bank')
								                @if(count($errors) > 0)
								                  @foreach($errors->get('transfer_img') as $error)
								                    <div class="text-danger">{{ $error }}</div>
								                  @endforeach 
								                @endif
											@endif
											<span class="trans_img_erro" style="color: red"></span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Comment</label>
							<textarea name="comment" class="form-control" rows="5">{{ $comment }}</textarea>
			                @if(count($errors) > 0)
			                  @foreach($errors->get('comment') as $error)
			                    <div class="text-danger">{{ $error }}</div>
			                  @endforeach 
			                @endif
						</div>
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-info" id="submit" name="{{ (isset($get_data) and !empty($get_data))?"update":"add" }}">{{ (isset($get_data) and !empty($get_data))?"Update":"Add" }} Fund</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--/.body content-->
<script>
	$(document).ready(function(){
		var remaining = '{{ $remaining }}';
		$('.amount').on('change',function(){
			var amount = $('.amount').val().trim();
			if(parseInt(amount) < 0){
				$('#submit').attr('type','button');				
			}else{
				$('#submit').attr('type','submit');
			}
			if(parseInt(amount) > parseInt(remaining)){
				$('#submit').attr('type','button');
			}else{
				$('#submit').attr('type','submit');
			}
		})
		$('#submit').click(function(){
			var amount = $('.amount').val().trim();
			if(parseInt(amount) <= 0){
				$('.__error').addClass('text-danger');
				$('.__error').html(`Transfer Amount should be greater than zero`);
			}else if(parseInt(amount) > parseInt(remaining)){
				$('.__error').addClass('text-danger');
				$('.__error').html(`Transfer Amount should be less then or equal to Current Remaining Fund`);
			}
		})
		var through = '{{ $payment_via }}';
		var check_form = $('.check-form').clone();
		var bank_form = $('.bank-form').clone();
		var cash_form = $('.cash-form').clone();
		if(through != 'check'){
			$('.check-form').remove();
		}
		if(through != 'bank'){
			$('.bank-form').remove();
		}
		if(through != 'cash'){
			$('.cash-form').remove();
		}
		$('.check').click(function(){
			$('#cash_detail').html(check_form);
            $('[data-toggle="TransferDate"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
                endDate:'today',
            });
            $('#date-picker2').samask("00/00/0000");
            $('#date-picker2').keydown(function(e){
                if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                  return true; 
                }  else {
                  return false;
                } 
            });
		});
		$('.bank').click(function(){
			$('#cash_detail').html(bank_form);
            $('[data-toggle="TransferDate"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
                endDate:'today',
            });
            $('#date-picker4').samask("00/00/0000");
            $('#date-picker4').keydown(function(e){
                if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                  return true; 
                }  else {
                  return false;
                } 
            });
		});
		$('.cash').click(function(){
			$('#cash_detail').html(cash_form);
            $('[data-toggle="TransferDate"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
                endDate:'today',
            });
            $('#date-picker3').samask("00/00/0000");
            $('#date-picker3').keydown(function(e){
                if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                  return true; 
                }  else {
                  return false;
                } 
            });
		});
	});
</script>
@include('admin.district.layouts.footer')
<script>
    $('[data-toggle="TransferDate"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
        endDate:'today',
    });
</script>