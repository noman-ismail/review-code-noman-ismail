<div class="row" id="abc">
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Budget Amount</label>
			<input type="text" class="form-control" value="{{ (!empty($data))?$data->amount:"" }}" readonly>
		</div>
		<div class="form-group">
			<label for="">Payment Via</label>
            <div class="productdetail">
              <label class="chk-st-d">
                <input type="radio" class="width-auto check" value="check" name="d">
                <span>Cheque</span>
              </label>
              <label class="chk-st-d">
                <input type="radio" class="width-auto bank" value="bank" name="d">
                <span>Bank Transfer</span>
              </label>
              <label class="chk-st-d">
                <input type="radio" class="width-auto cash" value="cash" name="d">
                <span>Cash Deposit</span>
              </label>
            </div>
		</div>
		<span class="text-danger"></span>
		<div class="form-group form-data" style="display: none;">
			<form method="POST" enctype="multipart/form-data" id="check-form" action="javascript:void(0)">
				@csrf
				<input type="hidden" name="hidden_id" class="hidden_id" value="{{ (!empty($data))?$data->id:"" }}">
				<div class="check-form" style="display: none">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Cheque Title</label>
								<input type="text" name="title" class="form-control check_title">
							</div>
							<div class="form-group">
								<label>Cheque Bank</label>
								<input type="text" name="bank" class="form-control check_bank">
							</div>
							<div class="form-group">
								<label>Cheque Number</label>
								<input type="text" name="no" class="form-control check_no">
							</div>
							<div class="form-group">
								<label>Cheque Date</label>
								<input type="text" name="date" class="form-control check_date" data-toggle='datepicker' id='date-picker' autocomplete="off">
							</div>
							<div class="form-group">
								<label>Cheque Image</label>
								<input type="file" name="cheque_image" class="form-control check_img">
								<span class="check_img_erro" style="color: red"></span>
							</div>
						<div class="text-right">
							<button class="btn btn-primary check_btn" type="button">Submit</button>
						</div>
						</div>
					</div>
				</div>
			</form>
			<form method="POST" enctype="multipart/form-data" id="cash-form" action="javascript:void(0)">
				@csrf
				<input type="hidden" name="hidden_id" class="hidden_id" value="{{ (!empty($data))?$data->id:"" }}">
				<div class="cash-form" style="display: none">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Bank Name</label>
								<input type="text" name="bank" class="form-control cash_bank">
							</div>
							<div class="form-group">
								<label>Cash Depositor Name <span class="required">*</span></label>
								<input type="text" name="depositor" value="" class="form-control cash_depositor">
								<span class="input-errorrs" style="color:red"></span>
							</div>
							<div class="form-group">
								<label>Receiver Account No</label>
								<input type="text" name="cash_no" class="form-control cash_ac_no">
							</div>
							<div class="form-group">
								<label>Receiver Account Title </label>
								<input type="text" name="title" class="form-control cach_title">
							</div>
							<div class="form-group">
								<label>Deposit Date</label>
								<input type="text" name="cash_date" class="form-control cash_deposit_date" data-toggle='datepicker' id='date-picker1' autocomplete="off">
							</div>
							<div class="form-group">
								<label>Cash Receipt Image</label>
								<input type="file" name="cash_image" class="form-control cash_img">
								<span class="cash_img_erro" style="color: red"></span>
							</div>
						<div class="text-right">
							<button class="btn btn-primary cash_btn" type="button">Submit</button>
						</div>
						</div>
					</div>
				</div>
			</form>
			<form method="POST" enctype="multipart/form-data" id="bank-form" action="javascript:void(0)">
				@csrf
				<input type="hidden" name="hidden_id" class="hidden_id" value="{{ (!empty($data))?$data->id:"" }}">
				<div class="bank-form" style="display: none">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Transfer To Bank Name</label>
								<input type="text" name="trans_to_name" class="form-control trans_to_name">
							</div>
							<div class="form-group">
								<label>Transfer To Account No</label>
								<input type="text" name="trans_to_ac" class="form-control trans_to_ac">
							</div>
							<div class="form-group">
								<label>Transfer To Bank Title</label>
								<input type="text" name="trans_to_bank" class="form-control trans_to_bank">
							</div>
							<div class="form-group">
								<label>Transfer From Bank Name</label>
								<input type="text" name="trans_from_name" class="form-control trans_from_name">
							</div>
							<div class="form-group">
								<label>Transfer From Account No</label>
								<input type="text" name="trans_from_ac" class="form-control trans_from_ac">
							</div>
							<div class="form-group">
								<label>Transfer From Bank Title</label>
								<input type="text" name="trans_from_bank" class="form-control trans_from_bank">
							</div>
							<div class="form-group">
								<label>Transfer Date</label>
								<input type="text" name="trans_date" class="form-control trans_date" data-toggle='datepicker' id='date-picker2' autocomplete="off">
							</div>
							<div class="form-group">
								<label>Transaction Id</label>
								<input type="text" name="trans_id" class="form-control trans_id">
							</div>
							<div class="form-group">
								<label>Bank Image</label>
								<input type="file" name="trans_img" class="form-control trans_img">
								<span class="trans_img_erro" style="color: red"></span>
							</div>
						<div class="text-right">
							<button class="btn btn-primary bank_btn" type="button">Submit</button>
						</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<link rel="stylesheet" href="{{ asset('admin-assets/plugins/sweetalert/sweetalert.css') }}">
<script type="text/javascript" src="{{ asset('admin-assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
<script>
    $('[data-toggle="datepicker"]').datepicker({
        format:'dd/mm/yyyy',
        zIndex:'9999',
        autoHide:true,
    });
    $('.form-control-chosen').chosen();
    $('#mobile').samask("0000-0000000");
    $('#date-picker').samask("00/00/0000");
    $('#date-picker1').samask("00/00/0000");
    $('#date-picker2').samask("00/00/0000");
    $('#mobile').keyup(function(){
        $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
    });
    
</script>
<script>
	$(document).ready(function(){
		$('.check').click(function(){
			$('.check-form').css('display','block');
			$('.bank-form').css('display','none');
			$('.cash-form').css('display','none');
			$('.form-data').css('display','block')
		});
		$('.bank').click(function(){
			$('.check-form').css('display','none');
			$('.bank-form').css('display','block');
			$('.cash-form').css('display','none');
			$('.form-data').css('display','block')
		});
		$('.cash').click(function(){
			$('.check-form').css('display','none');
			$('.bank-form').css('display','none');
			$('.cash-form').css('display','block');
			$('.form-data').css('display','block')
		});
		$('.check_btn').click(function(){
			var t = $(this);
			t.attr('disabled',true);
			var title = $('.check_title').val();
			var check_bank = $('.check_bank').val();
			var check_no = $('.check_no').val();
			var check_date = $('.check_date').val();
			var check_img = $('.check_img').val();
			if(title == "" || check_bank == '' || check_no == '' || check_date == ''){
				t.attr('disabled',false);
				$('.text-danger').html('Please fill the complete form.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(title.length > 50 ){
				$('.text-danger').html('Cheque Title is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(check_date.length > 10){
				$('.text-danger').html('Date Format is Invalid.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(check_no.length > 20){
				$('.text-danger').html('Cheque No is too long');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(check_bank.length > 30){
				$('.text-danger').html('Cheque Bank is too long');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else{
		        $.ajax({
		          url:baseURL+"budget-request?status=check",
		          method: 'POST',
		          dataType: 'json',
		          data: new FormData($('#check-form')[0]),
		          cache: false,
		          contentType: false,
		          processData: false,
		          success:function(res){
		          	if(res == 'success'){
						swal({
				            title: "Success!",
				            text: "Payment Submitted Successfully ",
							icon: "success",
				            type: "success"
				        },function() {
				        	location.reload();
				        });
		          	}else{
						t.attr('disabled',false);
		          		$('.check_img_erro').html(res.cheque_image);
		          	}
					}, error:function(e){
						t.attr('disabled',false);
						alert('Failed to proceed payment method. Please refresh page and try again');
					}
		        });
			}
		})
		$('.cash_btn').click(function(){
			var t = $(this);
			t.attr('disabled',true);
			var title = $('.cach_title').val();
			var cash_bank = $('.cash_bank').val();
			var cash_no = $('.cash_ac_no').val();
			var cash_date = $('.cash_deposit_date').val();
			var cash_img = $('.cash_img').val();
			if(title == "" || cash_bank == '' || cash_no == '' || cash_date == '' ){
				t.attr('disabled',false);
				$('.text-danger').html('Please fill the complete form.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(title.length > 50 ){
				$('.text-danger').html('Cash Title is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(cash_bank.length > 50 ){
				$('.text-danger').html('Cash Bank title is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(cash_date.length > 10){
				$('.text-danger').html('Date Format is Invalid.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(cash_no.length > 20){
				$('.text-danger').html('Account No is too long');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else{
		        $.ajax({
		          url:baseURL+"budget-request?status=cash",
		          method: 'POST',
		          dataType: 'json',
		          data: new FormData($('#cash-form')[0]),
		          cache: false,
		          contentType: false,
		          processData: false,
		          success:function(res){
		          	if(res == 'success'){
						swal({
				            title: "Success!",
				            text: "Payment Submitted Successfully ",
							icon: "success",
				            type: "success"
				        },function() {
				        	location.reload();
				        });
		          	}else{
						t.attr('disabled',false);
		          		$('.cash_img_erro').html(res.cash_image);
		          	}
		          }, error:function(e){
					t.attr('disabled',false);
		            alert('Failed to proceed payment method. Please refresh page and try again');
		          }
		        });
			}
		});
		$('.bank_btn').click(function(){
			var t = $(this);
			t.attr('disabled',true);
			var title = $('.trans_to_name').val();
			var title2 = $('.trans_from_name').val();
			var ac1 = $('.trans_to_ac').val();
			var ac2 = $('.trans_from_ac').val();
			var to_bank = $('.trans_to_bank').val();
			var from_bank = $('.trans_from_bank').val();
			var trans_id = $('.trans_id').val();
			var trans_date = $('.trans_date').val();
			var trans_img = $('.trans_img').val();
			if(title == "" || title2 == "" || ac1 == '' || ac2 == '' || to_bank == '' || from_bank == '' || trans_id == '' || trans_date == ''){
				t.attr('disabled',false);
				$('.text-danger').html('Please fill the complete form.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(title.length > 50 ){
				$('.text-danger').html('Transfer To Bank Name is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(title2.length > 50 ){
				$('.text-danger').html('Transfer From Bank Name is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(ac1.length > 50 ){
				$('.text-danger').html('Transfer To Bank Account No is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(ac2.length > 50 ){
				$('.text-danger').html('Transfer From Bank Account No is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(to_bank.length > 50 ){
				$('.text-danger').html('Transfer to Bank Title is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(from_bank.length > 50 ){
				$('.text-danger').html('Transfer from Bank Title is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(trans_id.length > 30 ){
				$('.text-danger').html('Transaction Id is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else if(trans_date.length > 10 ){
				$('.text-danger').html('Transaction Date is too long.');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#abc").offset().top
                }, 1000);
                t.attr('disabled',false);
			}else{
		        $.ajax({
		          url:baseURL+"budget-request?status=bank",
		          method: 'POST',
		          dataType: 'json',
		          data: new FormData($('#bank-form')[0]),
		          cache: false,
		          contentType: false,
		          processData: false,
		          success:function(res){
		          	if(res == 'success'){
						swal({
				            title: "Success!",
				            text: "Payment Submitted Successfully ",
							icon: "success",
				            type: "success"
				        },function() {
				        	location.reload();
				        });
		          	}else{
						t.attr('disabled',false);
		          		$('.trans_img_error').html(res.trans_img);
		          	}
		          }, error:function(e){
					t.attr('disabled',false);
		            alert('Failed to proceed payment method. Please refresh page and try again');
		          }
		        });
			}
		})
	})
</script>