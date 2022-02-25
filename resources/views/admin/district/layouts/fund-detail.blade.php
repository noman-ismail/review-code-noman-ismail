<form id="fund-detail">
@csrf
<input type="hidden" name="id" value="{{ $id }}">
<div class="row" id="ff_detail">
	<div class="col-md-12">
		<span class="text-danger"></span>
		<table class="table"> 
			<tr>
				<th>Total Collection : </th>
				<td>{{ $total_collection }}</td>
			</tr> 
			<tr>
				<th>Total Transfered : </th>
				<td>{{ $tatal_transfered }}</td>
			</tr> 
			<tr>
				<th>Total Un-Transfered : </th>
				<td>{{ $total_collection - $tatal_transfered }}</td>
			</tr> 
			<tr>
				<th>Total Amount : </th>
				<td>
					<input type="number" class="form-control amount" name="amount" value="{{ $total_collection - $tatal_transfered }}">
					<span class="text-danger-span" style="color: red"></span>
				</td>
			</tr> 
			<tr>
				<th>Total Balance : </th>
				<td>
					<span class="balance">0</span>
				</td>
			</tr>
			<tr>
				<th>Date : </th>
				<td>
					<input type="text" data-toggle="PaymentDate" autocomplete="off" class="datepick form-control" autofocus="on" autocomplete="off" id="date-picker" name="date">
					<span class="text-danger-span" style="color:red"></span>
				</td>
			</tr> 
			<tr>
				<th>Payment Via : </th>
				<td>
					<div class="form-group">
			            <div class="productdetail">
			              <label class="chk-st-d">
			                <input type="radio" class="width-auto check" value="check" name="payment_via">
			                <span>Cheque</span>
			              </label>
			              <label class="chk-st-d">
			                <input type="radio" class="width-auto bank" value="bank" name="payment_via">
			                <span>Bank Transfer</span>
			              </label>
			              <label class="chk-st-d">
			                <input type="radio" class="width-auto cash" value="cash" name="payment_via">
			                <span>Cash Deposit</span>
			              </label>
			              <label class="chk-st-d">
			                <input type="radio" class="width-auto mobile" value="mobile" name="payment_via">
			                <span>Mobile Transfer</span>
			              </label>
			              <label class="chk-st-d">
			                <input type="radio" class="width-auto bycash" value="bycash" name="payment_via">
			                <span>Cash</span>
			              </label>
			            </div>
					</div>
				</td>
			</tr>
		</table>
		<div class="col-md-12 mb-3" id="cash_detail">
			<div class="check-form">
				<fieldset>
					<legend>Payment Detail</legend>
					<div class="row">
						<div class="col-md-12">
							<span class="payment-danger" style="color:red"></span>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cheque Title <span class="required">*</span></label>
								<input type="text" name="title" value="" class="form-control check_title">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cheque Bank <span class="required">*</span></label>
								<input type="text" name="bank" value="" class="form-control check_bank">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cheque Number <span class="required">*</span></label>
								<input type="text" name="no" value="" class="form-control check_no">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cheque Date <span class="required">*</span></label>
								<input type="text" name="check_date" value="" class="form-control check_date" data-toggle='datepicker' id='date-picker2' autocomplete="off" placeholder="dd/mm/yyyy">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Cheque Image <span class="required">*</span></label>
								<input type="file" name="cheque_image" class="form-control check_img">
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
						<div class="col-md-12">
							<span class="payment-danger" style="color:red"></span>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bank Name <span class="required">*</span></label>
								<input type="text" name="bank" value="" class="form-control cash_bank">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cash Depositor Name <span class="required">*</span></label>
								<input type="text" name="depositor" value="" class="form-control cash_depositor">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Receiver Account No <span class="required">*</span></label>
								<input type="text" name="account_no" value="" class="form-control cash_ac_no">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Receiver Account Title <span class="required">*</span></label>
								<input type="text" name="title" value="" class="form-control cash_title">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Deposit Date <span class="required">*</span></label>
								<input type="text" name="cash_date" value="" class="form-control cash_deposit_date" data-toggle='datepicker' id='date-picker3' autocomplete="off" placeholder="dd/mm/yyyy">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Cash Receipt Image <span class="required">*</span></label>
								<input type="file" name="cash_image" class="form-control cash_img">
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
						<div class="col-md-12">
							<span class="payment-danger" style="color:red"></span>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer To Bank Name <span class="required">*</span></label>
								<input type="text" name="transfer_to_name" value="" class="form-control transfer_to_name">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer To Account No <span class="required">*</span></label>
								<input type="text" name="transfer_to_ac" value="" class="form-control transfer_to_ac">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer To Account Title <span class="required">*</span></label>
								<input type="text" name="transfer_to_bank" value="" class="form-control transfer_to_bank">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer From Bank Name <span class="required">*</span></label>
								<input type="text" name="transfer_from_name" value="" class="form-control transfer_from_name">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer From Account No <span class="required">*</span></label>
								<input type="text" name="transfer_from_ac" value="" class="form-control transfer_from_ac">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer From Account Title <span class="required">*</span></label>
								<input type="text" name="transfer_from_bank" value="" class="form-control transfer_from_bank">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transfer Date <span class="required">*</span></label>
								<input type="text" name="transfer_date" value="" class="form-control transfer_date" data-toggle='datepicker' id='date-picker4' autocomplete="off" placeholder="dd/mm/yyyy">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transaction Id</label>
								<input type="text" name="transfer_id" value="" class="form-control transfer_id">
								<span class="input-errorrs" style="color:red"></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Screenshot Image <span class="required">*</span></label>
								<input type="file" name="transfer_img" class="form-control transfer_img">
								<span class="trans_img_erro" style="color: red"></span>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="mobile-form">
				<fieldset>
					<legend>Payment Detail</legend>
					<div class="form-row">
						<div class="col-md-12">
							<span class="payment-danger" style="color:red"></span>
						</div>
						<div class="form-group col-md-4">
							<label for="">Enter Mobile Account No.</label>
							<input type="text" name="mobile_ac" id="mobile" placeholder="Enter Mobile Account No." class="form-control">
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<div class="col-md-12 text-right">
		<button class="btn btn-primary transfer" type="button">Transfer</button>
	</div>
</div>
</form>
<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
            <script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
<script>
	$(document).ready(function(){
		var total_amount = '{{ $total_collection - $tatal_transfered }}';
		var id = '{{ $id }}';
        $('[data-toggle="datepicker"]').datepicker({
            format:'dd/mm/yyyy',
            zIndex:'9999',
            autoHide:true,
        });
	    $('.datepick').samask("00/00/0000");
        $('#date-picker').keydown(function(e){
            if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
              return true; 
            }  else {
              return false;
            } 
        });

		var check_form = $('.check-form').clone();
		var bank_form = $('.bank-form').clone();
		var cash_form = $('.cash-form').clone();
		var mobile_form = $('.mobile-form').clone();
		$('.check-form').remove();
		$('.bank-form').remove();
		$('.cash-form').remove();
		$('.mobile-form').remove();
		$('.bycash').click(function(){
			$('#cash_detail').html('');
		});
		$('.check').click(function(){
			$('#cash_detail').html(check_form);
            $('[data-toggle="datepicker"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
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
		$('.mobile').click(function(){
			$('#cash_detail').html(mobile_form);
            $('[data-toggle="datepicker"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
            });
            $('#mobile').samask("0000-0000000");
            $('#mobile').keyup(function(){
                $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
            });
		});
		$('.bank').click(function(){
			$('#cash_detail').html(bank_form);
            $('[data-toggle="datepicker"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
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
            $('[data-toggle="datepicker"]').datepicker({
                format:'dd/mm/yyyy',
                zIndex:'9999',
                autoHide:true,
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
		$('.amount').on('keyup , change',function(){
			var amount = $(this).val();
			$('.balance').html(parseInt(total_amount)-parseInt(amount));
		});
		function check_validation(){
			var checked = $('input[type="radio"]:checked').val();
			window.__type = checked;
			if(checked == 'check'){
				var check_title = $('.check_title').val().trim();
				var check_no = $('.check_no').val().trim();
				var check_bank = $('.check_bank').val().trim();
				var check_date = $('.check_date').val().trim();
				var check_img = $('.check_img').val().trim();
				if(check_title == '' || check_no == '' || check_bank == '' || check_date == '' || check_img == ''){
					$('input[type="radio"]:checked').closest('.row').find('.payment-danger').html('Please fill all the required field.');
					window._____ISERROR = true;
				}
			}else if(checked == 'bank'){
				var transfer_to_bank = $('.transfer_to_bank').val().trim();
				var transfer_to_ac = $('.transfer_to_ac').val().trim();
				var transfer_to_name = $('.transfer_to_name').val().trim();
				var transfer_from_bank = $('.transfer_from_bank').val().trim();
				var transfer_from_ac = $('.transfer_from_ac').val().trim();
				var transfer_from_name = $('.transfer_from_name').val().trim();
				var transfer_date = $('.transfer_date').val().trim();
				var transfer_id = $('.transfer_id').val().trim();
				var transfer_img = $('.transfer_img').val().trim();
				if(transfer_to_bank == '' || transfer_to_ac == '' || transfer_to_name == '' || transfer_from_bank == '' || transfer_from_ac == '' || transfer_from_name == '' || transfer_date == '' || transfer_img == ''){
					$('input[type="radio"]:checked').closest('.row').find('.payment-danger').html('Please fill all the required field.');
					window._____ISERROR = true;
				}
			}else if(checked == 'cash'){
				var cash_title = $('.cash_title').val();
				var cash_ac_no = $('.cash_ac_no').val().trim();
				var cash_bank = $('.cash_bank').val().trim();
				var cash_deposit_date = $('.cash_deposit_date').val().trim();
				var cash_depositor = $('.cash_depositor').val().trim();
				var cash_img = $('.cash_img').val().trim();
				if(cash_title == '' || cash_ac_no == '' || cash_bank == '' || cash_deposit_date == '' || cash_depositor == '' || cash_img == ''){
					$('input[type="radio"]:checked').closest('.row').find('.payment-danger').html('Please fill all the required field.');
					window._____ISERROR = true;
				}
			}else if(checked == 'mobile'){
				var mobile = $('#mobile').val();
				if(mobile == '' ){
					$('input[type="radio"]:checked').closest('.row').find('.payment-danger').html('Please fill all the required field.');
					window._____ISERROR = true;
				}else{
					var split_array = mobile.split('-');
					if (split_array.length != 2 || split_array[0].length != 4 || split_array[1].length != 7 ) {
						$('input[type="radio"]:checked').closest('.row').find('.payment-danger').html('Mobile account format is invalid.');
						window._____ISERROR = true;
					}
				}
			}else if(checked == 'bycash'){
				window._____ISERROR = false;
			}else{
				console.log(checked);
				$('.text-danger').html('Please select a payment method');
				window._____ISERROR = true;
			}
		}
		$('.transfer').click(function(){
			var t = $(this);
			window._____ISERROR = false;
			var amount = $('.amount').val().trim();
			var date = $('.datepick').val().trim();
			var balance = parseInt($('.balance').text());
			if(amount == '' || date == ''){
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#ff_detail").offset().top - 80
				}, 1000);
				$('.text-danger').html('Please enter amount and date.');
			}else{
				check_validation();
				if(window._____ISERROR == true){
					return false;
				}
				if(Number(amount) > Number(total_amount)){
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#ff_detail").offset().top - 80
					}, 1000);
					$('.text-danger').html('Transfered amount must be less than or equal to un-transfered amount.');
				}else if(amount <= 0){
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#ff_detail").offset().top - 80
					}, 1000);
					$('.text-danger').html('Transfered amount must be greater than zero.');
				}else{
					t.attr('disabled',true);
					t.html('Please Wait');
					$('.text-danger').html('');
					$.ajax({
		                url:'{{ route('collect-payment') }}',
						method: 'POST',
						datatype: 'json',
						data: new FormData($('#fund-detail')[0]),
						cache: false,
						contentType: false,
						processData: false,
						success:function(res){
							t.attr('disabled',false);
							t.html('Transfer');
							if(res == '[object Object]'){
		                		if(window.__type == 'check'){
									$([document.documentElement, document.body]).animate({
										scrollTop: $("#cash_detail").offset().top - 80
									}, 1000);
		                			$('.check_img').next('.check_img_erro').html(res.cheque_image);
		                		}else if(window.__type == 'cash'){
									$([document.documentElement, document.body]).animate({
										scrollTop: $("#cash_detail").offset().top - 80
									}, 1000);
		                			$('.cash_img').next('.cash_img_erro').html(res.cash_image);
		                		}else if(window.__type == 'bank'){
									$([document.documentElement, document.body]).animate({
										scrollTop: $("#cash_detail").offset().top - 80
									}, 1000);
		                			$('.transfer_img').next('.trans_img_erro').html(res.transfer_img);
		                		}else{
		                			console.log(res);
		                		}
							}else if( JSON.parse(res) == 'success'){
			                	toastr.success('Fund Transfered successfully');		
			                	$('._div').css('display','none');                		
		                	}
		                }, error:function(e){
							t.attr('disabled',false);
							t.html('Transfer');
		                	toastr.error(e);
		                }
					})
					// alert('Under Construction.');
				}
			}
		})
	});
</script>
<script>
    $('[data-toggle="PaymentDate"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
        endDate:'today',
    });
</script>