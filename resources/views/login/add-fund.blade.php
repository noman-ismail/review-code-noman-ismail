@include('login.layouts.header')
{{-- <header class="title-header main-header">
	<div class="container">
		<div class="header-text">
			<h1 class="header-title">Add Fund</h1>
			<ul class="breadcrumb" id="breadcrumb">
				<li><a href="{{ route('user-dashboard') }}">Home</a></li>
				<li><span>Add Fund</span></li>
			</ul>
		</div>
	</div>
</header> --}}
<main class="dashboard-section" id="outer-container">
	<div class="container-fluid" id="breadcrumb">
		<div class="row">
			<div class="col-md-12 col-lg-3">
				<div class="dash-aside">
					@include('login.layouts.sidebar')
				</div>
			</div>
			<div class="col-lg-9">
				<div class="main-column">
					<h3 class="rounded-top">Add New Funds</h3>
					<form action="{{ route('add-funds') }}" class="row funds-row" method="post">
						@csrf
							@if(session()->has("success"))
                <script>
                      $([document.documentElement, document.body]).animate({
                          scrollTop: $("#breadcrumb").offset().top
                      }, 1000);
                </script>
                @if (session()->has('fund_id'))
                	@php
                		$print_reocrd = DB::table('funds')->where('id',session("fund_id"))->first();
                		$fund_period_collection = collect($fund_period);
                		$ffd = $fund_period_collection->where('id',$print_reocrd->period)->first(); 
						$_userInfo = get_userinfo_detail($print_reocrd->deposited_to);
						$_userPersonal = get_userinfo_detail($print_reocrd->user_id);
                	@endphp
                	<style>
						table{border-collapse: collapse; border-spacing: 0px;}
						table td{border-spacing: 0px;}
						body{margin:0;padding:0;}
						.m-0{margin:0;}
						.p-3{padding:2rem;}
						.bg-green{background: #4d8948;}
						.text-white{color: #fff;}
						.h-2x{height:2px;}
						.txt{font-family: sans-serif;}
					</style>
					<div style="width:576px;margin:0 auto;margin-bottom:50px;" class="txt" id="print-reciept-form">
						<table style="border-bottom:thick solid 000;">
							<tr>
								<td style="width: 100px;padding-bottom: 10px;">
									<img src="https://apjea.com/images/logo-sm.png" width="100px" height="100px" alt="">
								</td>
								<td style="color:white;text-align: center;color:#000;width:476px;font-size:22px;font-weight: bold;padding-bottom: 10px;">
									All Pakistan Judiciary Employees Association <br> APJEA - {{ get_user_cityName(auth('login')->user()->district) }}
								</td>
							</tr>
						</table>
						

						<table style="width:576px;margin:8px auto;">
								<tr>
									<th style="text-align: center;text-transform: uppercase;color:#000;width:576px;" colspan="2">
										<div style="font-size:25px;padding:6px;border-radius:10px;border:2px solid #000;width:200px;margin: auto;">Cash Receipt</div>
									</th>
								</tr>
								<tr>
									<td style="padding:10px;">
										<span style="padding-right:5px;"> Receipt No.</span> <strong> {{ $print_reocrd->receipt_no }}</strong> 
									</td>

									<td style="padding:10px;">
										<span style="padding-right:5px;"> Date.</span>  <strong>{{ date('d M Y h:i:s A',strtotime($print_reocrd->created_at)) }}</strong>
									</td>
								</tr>

								<tr>
									<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
										<span style="padding-right:5px;"> Pay Personal No.</span> <strong>{{ (!empty($_userPersonal)) ? $_userPersonal['personnel_no'] : "" }}</strong>
									</td>
								</tr>

								<tr>
									<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
										<span style="padding-right:5px;"> Payment Recieved with Thanks From</span> <strong>{{ GetLoginUserName($print_reocrd->user_id) }}</strong>
									</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #4d8948;padding:10px;">
										<span style="padding-right:5px;"> Designation</span> <strong>District Nazir</strong>
									</td>
									<td style="border-top: 1px solid #4d8948;padding:10px;">
										<span style="padding-right:5px;"> Amount Rs.</span> <strong>{{ number_format($print_reocrd->amount) }}</strong> <small style="text-transform:uppercase;">(For {{ $print_reocrd->fund_for }})</small>
									</td>
								</tr>

								<tr>
								 	<td style="border-top: 1px solid #4d8948;padding:10px;">
										<span style="padding-right:5px;"> Through</span> <strong>{{ ucfirst($print_reocrd->through) }}</strong>
									</td>

									<td style="border-top: 1px solid #4d8948;padding:10px;">
										<span style="padding-right:5px;"> Fund Period</span> <strong>{{ ($ffd) ? $ffd->name : ""}}</strong>
									</td>
								</tr>

								<tr>
								 	<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
										<span style="padding-right:5px;"> <strong>Comments:</strong>{{ $print_reocrd->comment }}</span>
									</td>
								</tr>
									
								<tr>
								  	<td style="border-top: 1px solid #4d8948;"></td>
								  	<td style="border-top: 1px solid #4d8948;padding:30px 5px 2px 5px;">
										<span><small>Recieved By</small></span>  
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 10px;border-bottom: 1px solid #4d8948;"></td>
									<td style="padding-bottom: 10px;border-bottom: 1px solid #4d8948;">
										@php
											$ddd = (!empty($_userInfo) and !empty($_userInfo['personnel_no'])) ? " (".$_userInfo['personnel_no'].")" : "";
										@endphp
										  <strong>
										  	{{ GetLoginUserName($print_reocrd->deposited_to).$ddd }}<br></strong>
									</td>
								</tr>
								<tr>
									<td style="padding-top: 200px;" colspan="2"></td>
								</tr>
								<tr>
									<td style="padding-bottom: 10px;border-bottom: 1px solid #4d8948; text-align: center;" colspan="2">This is a computerized receipt and does not require any signature.</td>
								</tr>
								<tr>
									<td style="text-align: center;" colspan="2">Software Developed by <strong>Digital Applications</strong>: 0343-786 1234</td>
								</tr>
						</table>
					</div>
									<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
									<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
	                <script>
	                  function printReport()
	                  {
	                    $('#print-reciept-form').css('display','block');
	                    printJS({
	                      printable: 'print-reciept-form',
	                      type: 'html',
	                      style: '@page { size: portrait; }',
	                      // targetStyles: ['*']
	                   })
	                    $('#print-reciept-form').css('display','none');
	                  }
	                </script>
	                <script>printReport();</script>
                @endif
								<div class="col-md-12">
									<div class="message message-success">
										<span>{!! session("success") !!}</span>
										<i class="close close-message">×</i>
									</div>
								</div>
							@endif
							@if(session()->has("error"))
                <script>
                      $([document.documentElement, document.body]).animate({
                          scrollTop: $("#breadcrumb").offset().top
                      }, 1000);
                </script>
								<div class="col-md-12">
									<div class="message message-error">
										<span>{!! session("error") !!}</span>
										<i class="close close-message">×</i>
									</div>
								</div>
							@endif
						<div class="col-lg-5">
							<div class="image-col">
								<img src="{{ asset('assets/compress/fund.jpg') }}" class="img-fluid" alt="lock-image">
							</div>
						</div>
						<div class="col-lg-7">
							<div class="row">{{-- 
								<div class="col-md-4">
									<div class="form-group">
										<div class="resp-text">
											<label>Sr.No: <span class="comp">*</span></label>
											<span class="icon">
												<i class="icon-check_circle_outline"></i>
											</span>
										</div>
										<input type="text" class="form-control sr_no" name="sr_no" value="{{ $invoice_no }}" readonly>
									</div>
								</div> --}}

							<div class="col-md-6">
								<div class="form-group @error('receipt_no') input-group-error @enderror">
									<div class="resp-text">
										<label>Receipt No: <span class="comp">*</span></label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('receipt_no') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control receipt_no" name="receipt_no" value="{{ $receipt_no }}" readonly>
										<span class="icon @error('receipt_no') icon-error @enderror">
											@error('receipt_no') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('date') input-group-error @enderror">
									<div class="resp-text">
										<label>Date: <span class="comp">*</span></label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('date') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control date" id="date-picker" autocomplete="off" value="{{ date('d/m/Y') }}" name="date" readonly>
										<span class="icon @error('date') icon-error @enderror">
											@error('date') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group @error('user') input-group-error @enderror">
									<div class="resp-text">
										<label>Select User: <span class="comp">*</span></label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('user') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<select name="user" class="form-control ui-dropdown user">
											<option value="">Choose User</option>
											@if (count($users) > 0)
												@foreach ($users as $e)
			                    @php
			                      $get_user_info = get_userinfo_detail($e->id);
			                    @endphp
													<option value="{{ $e->id }}">{{ (!empty($get_user_info) and !empty($get_user_info['personnel_no']))?$get_user_info['personnel_no']." - ":"" }}{{ $e->name." - ".$e->cnic }}</option>
												@endforeach
											@endif
										</select>
										<span class="icon @error('user') icon-error @enderror">
											@error('user') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('amount') input-group-error @enderror">
									<div class="resp-text">
										<label>Amount: <span class="comp">*</span></label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('amount') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
											<input type="text" placeholder="Amount in Rupees" class="form-control amount" name="amount">
										<span class="icon @error('amount') icon-error @enderror">
											@error('amount') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('through') input-group-error @enderror">
									<div class="resp-text">
										<label>Through: <span class="comp">*</span></label>
										<span class="text">
											@if(count($errors) > 0)
											@foreach($errors->get('through') as $error)
											{{ $error }}
											@endforeach
											@endif
										</span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control through" name="through" placeholder="Example: Easypaisa, Jazzcash">
										<span class="icon @error('through') icon-error @enderror">
											@error('through') <i class="icon-cancel-circle"></i> @enderror
										</span>
									</div>
								</div>
							</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="resp-text">
											<label>Funds Period:</label>
											<span class="text"></span>
										</div>
										<select name="fund_period" class="form-control ui-dropdown fund_period">
											<option value="">Choose an Option</option>
											@if (count($fund_period) > 0)
												@foreach ($fund_period as $e)
													<option value="{{ $e->id }}">{{ $e->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="resp-text">
											<label>Funds For:</label>
											<span class="text"></span>
										</div>
										<select name="fund_for" class="form-control ui-dropdown fund_for">
											<option value="apjea">APJEA</option>
										</select>
									</div>
								</div>
							</div>
								<div class="form-group">
									<div class="resp-text">
										<label>Add Comments:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<textarea class="form-control comment" placeholder="Write Comments" name="comment"></textarea>
										<span class="icon">
											{{-- <i class="icon-check_circle_outline"></i> --}}
										</span>
									</div>
								</div>
							</div>
						<div class="col-lg-12">
							<div class="form-group button-group">
								<button type="submit" class="btn btn-submit"><i class="icon-check_circle_outline"></i>
								Submit</button>
							</div>
						</div>
							</div>
       


					</form>
				</div>
			</div>
		</div>
	</div>
</main>
    <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
<script>
	$(document).ready(function(){
      $('#date-picker').samask("00/00/0000");
    	$('#date-picker').change(function(e){
    		var new_val = $(this).val();
    		var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
    		$(this).val(new_val);
    	})
	    $('#date-picker').keydown(function(e){
	        if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
	          return true; 
	        }  else {
	          return false;
	        } 
	    });
	    $('.amount').keydown(function(er){
	    	if ((er.keyCode >= 47 && er.keyCode <= 58) || (er.keyCode >= 96 && er.keyCode <= 105) || er.keyCode == 8 || (er.keyCode >= 37 && er.keyCode <= 39)) {
	    		return true;
	    	}else{
	    		return false;
	    	}
	    })
		function show_msg(msg){
			var __error = `<div class="col-md-12">
				<div class="message message-error">
					<span>`+msg+`</span>
					<i class="close close-message">×</i>
				</div>
			</div>`;
			$('form').prepend(__error);
			$('.close').click(function(){
				$(this).parent('.message').fadeOut('slow');
			})
		}
		$('form').on('submit',function(){
				var user = $('.user').val().trim();
				var amount = $('.amount').val().trim();
				var receipt_no = $('.receipt_no').val().trim();
				var date = $('input[name="date"]').val().trim();
				var through = $('.through').val().trim();
				var fund_for = $('.fund_for').val().trim();
				var fund_period = $('.fund_period').val().trim();
				var comment = $('.comment').val().trim();
				var i = 0;
				if(receipt_no == ""){
					i = parseInt(i) + parseInt(1);
					show_msg('Receipt No Field is Required');
				}if(date == ""){
					$('input[name="date"]').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('input[name="date"]').closest('.form-group').addClass('input-group-error');
					$('input[name="date"]').closest('.form-group').find('.text').html(`Date Field is Required`);
					i = parseInt(i) + parseInt(1);
				}if(amount == ""){
					$('.amount').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.amount').closest('.form-group').addClass('input-group-error');
					$('.amount').closest('.form-group').find('.text').html(`Amount Field is Required`);
					i = parseInt(i) + parseInt(1);
				}if(through == ""){
					$('.through').closest('.resp-icon').find('.icon').addClass('icon-error').html(`<i class="icon-cancel-circle"></i>`);
					$('.through').closest('.form-group').addClass('input-group-error');
					$('.through').closest('.form-group').find('.text').html(`Through Field is Required`);
					i = parseInt(i) + parseInt(1);
				}
				if(user == ""){
					$('.user').closest('.form-group').addClass('input-group-error');
					$('.user').closest('.form-group').find('.text').html(`Please choose an option.`);
					$('.user').css('border-color','red');
					$('.user').next('div').find('.chosen-single').css('border','1px solid red');
					i = parseInt(i) + parseInt(1);
				}
				if(fund_for != "apjea"){
					$('.fund_for').closest('.form-group').addClass('input-group-error');
					$('.fund_for').closest('.form-group').find('.text').html(`Please choose an option.`);
					$('.fund_for').css('border-color','red');
					$('.fund_for').next('div').find('.chosen-single').css('border','1px solid red');
					i = parseInt(i) + parseInt(1);
				}
				if(i == 0){
					$('form').submit();
					return true;
				}else{
					$([document.documentElement, document.body]).animate({
					  scrollTop: $("#breadcrumb").offset().top
					}, 1000);
					return false;
				}
		})
		var style_url = '{{ asset('assets/style/chosen.css') }}';
		var js_url = '{{ asset('assets/js/chosen.js') }}';
		loadfiles(style_url,"css");
		loadfiles(js_url,"js");
	    $("#outer-container").on("mouseenter",function(){
	        $(".ui-dropdown").chosen();
	    });
	})
</script>
@include('login.layouts.footer')