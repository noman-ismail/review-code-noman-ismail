<!DOCTYPE html>
<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<style>
			body{padding:0; margin:0;}
			table{padding:0; margin:0;}
			.table-data-padding tr td{padding:2px 0px;}
			.f-pad-dt{padding:3px 5px;}
			 .txt-center{
               text-align:center;
           }
           .detail-heading{font-size:16px;font-weight:bold;}
           .upper-txt{font-size:10px;}
           .text-center{text-align:center;}
           .txt-bold{font-weight:bold;}
           .pad-l-r{padding:0px 15px}
           .for-width{width:100px;}
		</style>
	</head>
	<body>
		@php
			$netA = explode("-", $sesV["net_age"]);
			$netS = explode("-", $sesV["net_service"]);
			$ns = ($netA[0] > 60) ? $sesV["net_service_year"] : $netA[0];
		//dd($sesV);
		@endphp
		<section class="pension-detail">
			<div class="" style="width:100%;padding:0;margin:0;">
				<table class="solid-border" style="width:100%;text-align:center;border:thick solid #000;border-collapse: collapse;">
					<tbody style="text-align: center;">
						<tr style="width: 100%">
							<td class="heading-d" style="width:100%;font-size:30px;font-weight:bold;text-align:center;">Pension Calculation {{ date('Y') }}</td>
						</tr>
					</tbody>
				</table>
				<table class="solid-border for-desktop-ver" style="border-collapse:collapse;margin-top: 6px;width:100%;border:thick solid #000;">
					<tbody>
						<tr>
							<td class="table-data-padding" style="font-size: 12px;">
								<table style="width:100%;border:solid 1px #000;border-collapse: collapse;">
									<tbody>
										<tr>
											<td style="padding:3px 5px;border-right: 1px solid #000;border-bottom:thick double #000;background-color:#DBDBDB;" class="back-color-head ">Name of Pensioner</td>
											<td colspan="7" class=" txt-bold penr-user-name" style="text-align:center;border-bottom:thick double #000;font-size:18px;font-weight:bold;padding:6px 2px;">{{ $sesV['name'] }}</td>
										</tr>
										<tr>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">City</td>
											<td class="f-pad-dt txt-bold    " colspan="3" style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center">{{ $sesV['city'] }}</td>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Organization</td>
											<td class="f-pad-dt txt-bold  " colspan="3" style="padding:3px 5px;font-weight:bold;border-bottom: 1px solid #000;text-align:center;">{{ $sesV['department'] }}</td>
										</tr>
										<tr>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Designation</td>
											<td class="f-pad-dt txt-bold    " colspan="3" style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center">{{ $sesV['designation'] }}</td>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">B.P Scale</td>
											<td class="f-pad-dt txt-bold  " colspan="3" style="padding:3px 5px;font-weight:bold;border-bottom: 1px solid #000;text-align:center;">{{ $sesV['scale'] }}</td>
										</tr>
										<tr>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Last Pay</td>
											<td class="f-pad-dt txt-bold   " style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;" colspan="3">{{ number_format($sesV["pay"],2)  ."+".  number_format($sesV["increment_rate"],2) ." = ". number_format($sesV["pay"] + $sesV["increment_rate"],2) }}
											</td>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Class of Pension</td>
											<td class="txt-bold f-pad-dt  " colspan="3" style="padding:3px 5px;font-weight:bold;border-bottom: 1px solid #000;text-align:center;">{{ $sesV['pension'] }}</td>
										</tr>
										<tr>
											<td class="back-color-head    f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Date of Retirement</td>
											<td class="txt-bold    " style="font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center; " colspan="3"> {{ date("d M Y",strtotime($sesV["retireOn"])) }}
											</td>
											<td class="back-color-head    f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Gross Service</td>
											<td class="  " style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;">Y = <strong>{{ $netS[0] }}</strong></td>
											<td class="  " style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;"> M = <strong>{{ $netS[1] }}</strong>
											</td>
											<td  style="border-bottom: 1px solid #000;text-align:center;"> D = <strong>{{ $netS[2] }}</strong>
											</td>
										</tr>
										<tr>
											<td class="back-color-head    f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Date of Appointment</td>
											<td class="txt-bold   " style="font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;" colspan="3"> {{ date("d M Y " , strtotime($sesV["appoint"])) }}</td>
											<td class="back-color-head f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Gross Age</td>
											<td class="  " style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;"> Y = <strong>{{ $netA[0] }}</strong>
											</td>
											<td  style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;">M = <strong>{{ $netA[1] }}</strong></td>
											<td class="  " style="border-bottom: 1px solid #000;text-align:center;">D = <strong>{{ $netA[2] }}</strong></td>
										</tr>
										<tr>
											<td class="back-color-head    f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Date of Birth</td>
											<td class=" txt-bold    f-pad-dt" colspan="3" style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;">{{ date("d M Y " , strtotime($sesV["birth"])) }}</td>
											<td class="back-color-head    f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;background-color:#DBDBDB;">Net Service</td>
											<td class=" txt-bold    f-pad-dt" colspan="3" style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;"> {{ $sesV['net_service_year'] }} = Years</td>
										</tr>
										<tr>
											<td class="back-color-head " style="padding:3px 5px;border-right: 1px solid #000;background-color:#DBDBDB;">Percentage for Pension</td>
											<td class="   txt-bold" style="font-weight:bold;border-right: 1px solid #000;text-align:center;"> {{ $sesV["f1"] }}%</td>
											<td class=" f-pad-dt  " style="padding:3px 5px;font-size:12px;border-right: 1px solid #000;text-align:center;">Per. for Commutation</td>
											<td class=" f-pad-dt txt-bold  " style="padding:3px 5px;font-weight:bold;border-right: 1px solid #000;text-align:center;">{{ $sesV["f2"] }}%</td>
											<td class="back-color-head  f-pad-dt" style="padding:3px 5px;border-right: 1px solid #000;background-color:#DBDBDB;">Net Age</td>
											<td class="  txt-bold " colspan="3" style="font-weight:bold;border-right: 1px solid #000;text-align:center;">{{ $sesV['net_year'] }} = Years</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td  class="solid-border table-data-padding" style="border:thick solid #000;">
								<table style="width:100%;padding:15px 0px; border-collapse: collapse;">
									<tbody>
										<tr>
											<td class="table-data-pad">
												<table>
													<tbody>
														<tr>
															<td style="padding:8px 0px;" class="detail-heading">Gross Pension</td>
															<td>&nbsp;&nbsp;</td>
															<td style="padding:8px 0px;" class="deatil-detiling">
																<table style="">
																	<tbody>
																		<tr>
																			<td class="text-center upper-txt" >B. Pay</td>
																			<td class="text-center" style="font-size:10px;width:10px;">&nbsp;</td>
																			<td class="text-center upper-txt" >Net Service</td>
																			<td class="text-center" style="font-size:10px;width:20px;">&nbsp;</td>
																			<td class="text-center upper-txt">Formula</td>
																			<td class="text-center " style="font-size:10px;width:30px;">&nbsp;</td>
																			<td colspan="2" class="text-center upper-txt" style="">Gross Pension</td>
																		</tr>
																		<tr>
																			<td class="text-center for-width">{{ number_format($sesV["pay"] + $sesV["increment_rate"],2) }}</td>
																			<td class="text-center ">x</td>
																			<td class="text-center for-width"style="width: 20px;">30</td>
																			<td class="text-center ">x</td>
																			<td class="text-center for-width">7÷300</td>
																			<td class="text-center ">&nbsp;</td>
																			<td class="text-center ">=</td>
																			<td class="txt-bold text-center for-width">{{ number_format(round($sesV["gross_pension"],2),2) }}</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="padding:8px 0px;" class="f-pad-dt txt-bold detail-heading">Net Gross Pension</td>
															<td>&nbsp;&nbsp;</td>
															<td style="padding:8px 0px;" class="f-pad-dt">
																<table style="border-collapse:collapse;">
																	<tbody>
																		<tr>
																			<td class="upper-txt text-center">Gross Pension</td>
																			<td  class="upper-txt text-center" style="font-size:10px;width:20px;">&nbsp;</td>
																			<td  class="upper-txt text-center" style="width: 20px;">Percentage</td>
																			<td  class="upper-txt " style="font-size:10px;width:20px;">&nbsp;</td>
																			<td  class="upper-txt text-center">Net Pension</td>
																		</tr>
																		<tr>
																			<td class="for-width for-width" style="text-align:center;">{{ number_format(round($sesV["gross_pension"],2),2) }}</td>
																			<td class="" style="text-align:center;">x</td>
																			<td class="for-width" style="text-align:center;width: 20px;">65%</td>
																			<td class="" style="text-align:center;">=</td>
																			<td class="txt-bold for-width" style="text-align:center;">{{ number_format(round($sesV["net_pension"],2),2) }}</td>
																			<td  class="upper-txt " style="font-size:10px;width:30px;">&nbsp;</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="padding:8px 0px;" class="f-pad-dt txt-bold detail-heading">Communication</td>
															<td>&nbsp;&nbsp;</td>
															<td style="padding:8px 0px;" class="f-pad-dt">
																<table style="border-collapse:collapse;">
																	<tbody>
																		
																		<tr>
																			<td class="text-center upper-txt" >Gross Pension</td>
																			<td style="font-size:10px;text-align:center;width:10px;">&nbsp;</td>
																			<td class="text-center upper-txt"style="width: 20px;" >Percentage</td>
																			<td style="font-size:10px;text-align:center;width:20px;">&nbsp;</td>
																			<td class="text-center upper-txt" >Formulat / Age  Next Birthday</td>
																			<td colspan="2" class="text-center upper-txt pad-l-r">Total Commutation</td>
																		</tr>
																		<tr>
																			<td  class="text-center for-width">{{ number_format(round($sesV["gross_pension"],2),2) }}</td>
																			<td  class="text-center ">x</td>
																			<td  class="text-center for-width" style="width: 20px;">35%</td>
																			<td  class="text-center ">=</td>
																			<td  class="text-center for-width">{{ number_format(round(($sesV["gross_pension"]* $sesV["f2"]) / 100,2),2) }} &nbsp;x&nbsp;12&nbsp;x&nbsp;{{ $sesV["age_rate"] }}</td>
																			<td  class="text-center">&nbsp;=</td>
																			<td class="txt-bold text-center pad-l-r for-width">Rs. {{ number_format(round($sesV["commutation"],2),2) }}</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td  class="solid-border table-data-padding" style="border:thick solid #000;">
								<table style="border-collapse:collapse;">
									<tbody>
										<tr>
											<td style="width: 20px;white-space: nowrap;vertical-align: middle;text-align:center;">
												<div style="transform: rotate(-90deg) translate(-5px, 0px);font-size:20px;font-weight:bold;font-family:arial;width:100%;max-width: 50px;">Increases</div>
											</td>
											<td style="width:500px;">
												<table style="width:100%;padding:15px 0px;border-collapse:collapse;" >
													<tbody>
														<tr>
															<td class="txt-bold   back-color-head f-pad-dt solid-border " style="padding:3px 5px;font-weight:bold;border:thick solid #000;background-color:#DBDBDB;text-align:center;">Description</td>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="padding:3px 5px;font-weight:bold;border:thick solid #000;background-color:#DBDBDB;text-align:center;">Rate %</td>
															<td class="txt-bold   f-pad-dt back-color-head solid-border" style="padding:3px 5px;font-weight:bold;border:thick solid #000;background-color:#DBDBDB;text-align:center;">Amount Rs.</td>
														</tr>
														@php
														$total_increase = 0;
														foreach($sesV["medical_allowance"] as $k=>$v){
														if($v[0]==15){
														$desp = "Increase on M.A from <strong>(01.07.$v[0])</strong>";
														}else{
														$desp = "Medical Allowance <strong>(01.07.$v[0])</strong>";
														}
														
														$rate = $v[1];
														$amount = round($v[2],2);
														$total_increase+=$amount;
														@endphp
														<tr>
															<td class="left f-pad-dt   bord-lft " style="padding:3px 5px;border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">
																{!! $desp !!}
															</td>
															<td class="  f-pad-dt   " style="padding:3px 5px;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;">{{ $rate }} %</td>
															<td class="  f-pad-dt   bord-lft  " style="padding:3px 5px;border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;"><strong>{{ number_format($amount,2) }}</strong></td>
														</tr>
														@php
														}
														@endphp
														@php
														foreach($sesV["increases"] as $k=>$v){
														$desp = "Increase from <strong>(01.07.$k)</strong>";
														$rate = $v[0];
														$amount = round($v[1],2);
														$total_increase+=$amount;
														@endphp
														<tr>
															<td class="left f-pad-dt   bord-lft " style="padding:3px 5px;border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">
																{!! $desp !!}
															</td>
															<td class="  f-pad-dt   " style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;">{{ $rate }} %</td>
															<td class="  f-pad-dt   bord-lft  " style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center;"><strong>{{ number_format($amount,2) }}</strong></td>
														</tr>
														@php
														}
														@endphp
														<tr>
															<td colspan="2" class="  f-pad-dt back-color-head    bord-lft" style="border-left: 1px solid #000;font-size:18px;background-color:#DBDBDB;text-align:center;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Total Increases</strong></td>
															<td class="  f-pad-dt back-color-head txt-bold   " style="font-weight:bold;border-right: 1px solid #000;font-size:18px;background-color:#DBDBDB;text-align:center;border-bottom: 1px solid #000;">
																{{ number_format($total_increase,2) }}
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td class="solid-border table-data-padding" style="width:100%;border:thick solid #000;padding:15px 0px;">
								<table style="border-collapse:collapse;">
									<tbody>
										<tr>
											<td style="width: 20px;white-space: nowrap;vertical-align: middle;text-align:center;">
												<div style="transform: rotate(-90deg) translate(-5px, 0px);font-size:20px;font-weight:bold;font-family:arial;width:100%;max-width: 50px;">Results</div>
											</td>
											<td style="width:100%;">
												<table style="border-collapse: separate;border-spacing:5px;width:100%;">
													<tbody>
														<tr>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;background-color:#DBDBDB;font-size:18px;border:thick double #000;text-align:center;">Commutation</td>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;font-size:22px;background-color:#DBDBDB;border:thick double #000;text-align:center;">Rs. {{ number_format(round($sesV["commutation"],2),2) }}</td>
														</tr>
														<tr>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;text-align:center;background-color:#DBDBDB;font-size:18px;border:thick double #000;">Net Pension</td>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;text-align:center;background-color:#DBDBDB;font-size:22px;border:thick double #000;">Rs. {{ number_format(round($sesV["net_pension"],2),2) }}</td>
														</tr>
														<tr>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;text-align:center;background-color:#DBDBDB;font-size:18px;border:thick double #000;">Take Home Pension</td>
															<td class="txt-bold   back-color-head f-pad-dt solid-border" style="font-weight:bold;width:250px;text-align:center;background-color:#DBDBDB;font-size:22px;border:thick double #000;">Rs. {{ number_format(round($sesV["takehome"],2),2) }}</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td class="solid-border  " style="border:solid thick #000;padding:8px 2px;text-align:center;">
								<div style="font-size:12px;">PREPARED BY <strong>ABDUL MUNAF BHATTI</strong><br>DISTRICT NAZIR SESSIONS COURTS, KHANEWAL</div>
								<div style="font-size:10px;"><strong>Contacts</strong>: 0300-6999957,
								<strong>Email Address</strong>: abdulmunafbhatti@gmail.com</div>
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
		</section>
	</body>
</html>
</div>
</section>
</body>
</html>