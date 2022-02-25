@include('login.layouts.header')
{{-- 	<header class="title-header main-header">
		<div class="container">
			<div class="header-text">
				<h1 class="header-title">Dashboard</h1>
				<ul class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><span>User Dashboard</span></li>
				</ul>
			</div>
		</div>
	</header> --}}
	<main class="dashboard-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-lg-3">
					<div class="dash-aside">
						@include('login.layouts.sidebar')
					</div>
				</div>
				<div class="col-md-12 col-lg-9 dash-main">
					@if (!empty($fund_detail))
	                	@php
	                		$fund_period_collection = collect($fund_period);
	                		$ffd = $fund_period_collection->where('id',$fund_detail->period)->first(); 
							$_userInfo = get_userinfo_detail($fund_detail->deposited_to);
							$_userPersonal = get_userinfo_detail($fund_detail->user_id);
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
											<span style="padding-right:5px;"> Receipt No.</span> <strong> {{ $fund_detail->receipt_no }}</strong> 
										</td>

										<td style="padding:10px;">
											<span style="padding-right:5px;"> Date.</span>  <strong>{{ date('d M Y h:i:s A',strtotime($fund_detail->created_at)) }}</strong>
										</td>
									</tr>

									<tr>
										<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
											<span style="padding-right:5px;"> Pay Personal No.</span> <strong>{{ (!empty($_userPersonal)) ? $_userPersonal['personnel_no'] : "" }}</strong>
										</td>
									</tr>

									<tr>
										<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
											<span style="padding-right:5px;"> Payment Recieved with Thanks From</span> <strong>{{ GetLoginUserName($fund_detail->user_id) }}</strong>
										</td>
									</tr>
									<tr>
										<td style="border-top: 1px solid #4d8948;padding:10px;">
											<span style="padding-right:5px;"> Designation</span> <strong>District Nazir</strong>
										</td>
										<td style="border-top: 1px solid #4d8948;padding:10px;">
											<span style="padding-right:5px;"> Amount Rs.</span> <strong>{{ number_format($fund_detail->amount) }}</strong> <small style="text-transform:uppercase;">(For {{ $fund_detail->fund_for }})</small>
										</td>
									</tr>

									 <tr>
									 	<td style="border-top: 1px solid #4d8948;padding:10px;">
											<span style="padding-right:5px;"> Through</span> <strong>{{ ucfirst($fund_detail->through) }}</strong>
										</td>

										<td style="border-top: 1px solid #4d8948;padding:10px;">
											<span style="padding-right:5px;"> Fund Period</span> <strong>{{ ($ffd) ? $ffd->name : ""}}</strong>
										</td>
									 </tr>

									 <tr>
									 	<td style="border-top: 1px solid #4d8948;padding:10px;" colspan="2">
											<span style="padding-right:5px;"> <strong>Comments:</strong>{{ $fund_detail->comment }}</span>
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
											  	{{ GetLoginUserName($fund_detail->deposited_to).$ddd }}<br></strong>
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
					<div class="row listboxes amt-dash-history">
						<div class="col-md-12">
							<div class="list-box">
								<div class="list-head bg-grdgreen">
									<h3>Amount History</h3>
								</div>
								<div class="list-detail">
									<table>
										<tr>
											<th>#</th>
											<th>Deposit To</th>
											{{-- <th>Invoice No.</th> --}}
											<th>Receipt No.</th>
											<th>Amount</th>
											<th>Date</th>
											<th>Action</th>
										</tr>
										@if (count($record) > 0)
											@php
												$i = 1;
												$total = 0;
											@endphp
											@foreach ($record as $val)
												@php
													$total += $val->amount;
													// $user_info = get_userinfo_detail($val->user_id);
													$user_detail = get_user_detail($val->deposited_to);
												@endphp
												<tr>
													<td>{{ $i++ }}</td>
													<td>{{ (!empty($user_detail))?$user_detail['name']:"" }}</td>
													{{-- <td>{{ $val->invoic_no }}</td> --}}
													<td>{{ $val->receipt_no }}</td>
													<td>{{ $val->amount }}</td>
													<td>{{ (!empty($val->deposited_on))?date('d/m/Y' , strtotime($val->deposited_on)):"" }}</td>
													<th>
														<a href="{{ route('amount-history')."?print_id=".$val->id }}">
															<i class="icon-printer"></i>
														</a>
													</th>
												</tr>
											@endforeach
											<tr>
												<td colspan="4" class="text-right">Total:</td>
												<td>{{ $total }}</td>
												<td>&#128522;</td>
											</tr>
										@else
											<tr>
												<td class="text-center" colspan="6">There is no record. &#128542;</td>
											</tr>
										@endif
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@include('login.layouts.footer')