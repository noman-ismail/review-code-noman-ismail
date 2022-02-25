@php
  $netA = explode("-", $sesV["net_age"]);
  $netS = explode("-", $sesV["net_service"]);
  $ns = ($netA[0] > 60) ? $sesV["net_service_year"] : $netA[0];
@endphp  
@if (isset($sesV["msg"]))
@php
   echo "<p class='text-center' style='color:red'>".$sesV["msg"]."</p>"
@endphp
@else
<div class="row bg-white generate-pdf" style="display:block;">
    <div class="col-md-12 col-lg-12 mx-auto">
        <h3 class="head-top text-center">Pension Calculation {{ date('Y') }}</h3>
        <table class="table table-pension table-desktop" cellspacing="0">
            <tr>
                <th>Name of Pensioner</th>
                <th colspan="5">{{ $sesV['name'] }}</th>
            </tr>
            <tr>
               <td class="dark">City</td>
               <td>{{ $sesV['city'] }}</td>
               <td class="dark">Organization</td>
               <td colspan="3">{{ $sesV['department'] }}</td>
            </tr>
            <tr>
               <td class="dark">Designation</td>
               <td>{{ $sesV['designation'] }}</td>
               <td class="dark">B.P Scale</td>
               <td colspan="3">{{ $sesV['scale'] }}</td>
            </tr>
            <tr>
               <td class="dark">Last Pay</td>
               <td>{{ number_format($sesV["pay"],2)  ."+".  number_format($sesV["increment_rate"],2) ." = ". number_format($sesV["pay"] + $sesV["increment_rate"],2) }}</td>
               <td class="dark">Class of Pention</td>
               <td colspan="3">{{ $sesV['pension'] }}</td>
            </tr>
            <tr>
               <td class="dark">Date of Retirement</td>
               <td>{{ date("d M Y",strtotime($sesV["retireOn"])) }}</td>
               <td class="dark">Gross Service</td>
               <td>Y=<strong>{{ $netS[0] }}</strong></td>
               <td>M=<strong>{{ $netS[1] }}</strong></td> 
               <td>D=<strong>{{ $netS[2] }}</strong></td>
            </tr>
            <tr>
               <td class="dark">Date of Appointment</td>
               <td>{{ date("d M Y " , strtotime($sesV["appoint"])) }}</td>
               <td class="dark">Gross Age</td>
               <td>Y=<strong>{{ $netA[0] }}</strong></td>
               <td>M=<strong>{{ $netA[1] }}</strong></td> 
               <td>D=<strong>{{ $netA[2] }}</strong></td>
            </tr>
            <tr>
               <td class="dark">Date of Birth</td>
               <td>{{ date("d M Y " , strtotime($sesV["birth"])) }}</td>
               <td class="dark">Net Service</td>
               <td colspan="3">{{ $sesV['net_service_year'] }} Years</td>
            </tr>
            <tr>
               <td class="dark">Net Age</td>
               <td>{{ $sesV['net_year'] }} Years</td>
               <td class="dark">%age of Pension</td>
               <td colspan="3">
                   <div class="row three-col">
                       <div class="col-md-3 col-lg-2 dark"> {{ $sesV["f1"] }}%</div>
                       <div class="col-md-6 col-lg-8 text-center">% Per Commutation</div>
                       <div class="col-md-3 col-lg-2 dark">{{ $sesV["f2"] }}%</div>
                   </div>
               </td>
            </tr>
        </table>
        
        <table class="table table-pension table-mobile" cellspacing="0">
            <tr>
                <th colspan="2">Name of Pensioner</th>
                <th colspan="3">{{ $sesV['name'] }}</th>
            </tr>
            <tr>
               <td class="dark">City</td>
               <td colspan="3">{{ $sesV['designation'] }}</td>
            </tr>
            <tr>
                <td class="dark">Organization</td>
                <td colspan="3">Digital Application</td>
            </tr>
            <tr>
               <td class="dark">Designation</td>
               <td colspan="3">Frontend Developer</td>
            </tr>
            <tr>
                <td class="dark">B.P Scale</td>
                <td colspan="3">{{ $sesV['scale'] }}</td>
            </tr>
            <tr>
               <td class="dark">Last Pay</td>
               <td colspan="3">Rs. {{ number_format($sesV["pay"],2)  ."+".  number_format($sesV["increment_rate"],2) ." = ". number_format($sesV["pay"] + $sesV["increment_rate"],2) }}</td>
            </tr>
            <tr>
                <td class="dark">Class of Pention</td>
                <td colspan="3">{{ $sesV['pension'] }}</td>
            </tr>
            <tr>
                <td class="dark">Date of Retirement</td>
                <td colspan="3">{{ date("d M Y",strtotime($sesV["retireOn"])) }}</td>
            </tr>
            <tr>
               <td class="dark">Gross Service</td>
               <td>Y=<strong>{{ $netS[0] }}</strong></td>
               <td>M=<strong>{{ $netS[1] }}</strong></td> 
               <td>D=<strong>{{ $netS[2] }}</strong></td>
            </tr>
            <tr>
               <td class="dark">Date of Appointment</td>
               <td colspan="3">{{ date("d M Y",strtotime($sesV["appoint"])) }}</td>
            </tr>
            <tr>
               <td class="dark">Gross Age</td>
               <td>Y=<strong>{{ $netA[0] }}</strong></td>
               <td>M=<strong>{{ $netA[1] }}</strong></td> 
               <td>D=<strong>{{ $netA[2] }}</strong></td>
            </tr>
            <tr>
               <td class="dark">Date of Birth</td>
               <td colspan="3">Rs. {{ date("d M Y",strtotime($sesV["birth"])) }}</td>
            </tr>
            <tr>
               <td class="dark">Net Service</td>
               <td colspan="3">{{ $sesV['net_service_year'] }} Years</td>
            </tr>
            <tr>
               <td class="dark">Net Age</td>
               <td colspan="3">{{ $sesV['net_year'] }} Years</td>
            </tr>
            <tr>
               <td class="dark">%age of Pension</td>
               <td colspan="3">
                   <div class="row three-col">
                       <div class="col-3 dark">{{ $sesV['f1'] }}%</div>
                       <div class="col-6 text-center">% Per Commutation</div>
                       <div class="col-3 dark">{{ $sesV['f2'] }}%</div>
                   </div>
               </td>
            </tr>
        </table>
        
        
        <table class="table table-info">
          <tbody>
            <tr>
              <td class="f-pad-dt txt-bold" style="width: 150px">Gross Pension</td>
              <td class="f-pad-dt left">
                <table style="width: auto;">
                  <tbody>
                    <tr>
                      <td class="text-center" style="font-size:10px;width:80px;">B. Pay</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;width:80px;">Net Service</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;width:80px;">Formula</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;width:80px;">Gross Pension</td>
                    </tr>
                    <tr>
                      <td class="text-center">{{ number_format($sesV["pay"] + $sesV["increment_rate"],2) }}</td>
                      <td class="text-center">x</td>
                      <td class="text-center">30</td>
                      <td class="text-center">x</td>
                      <td class="text-center">7   ÷300</td>
                      <td class="text-center">=</td>
                      <td class="txt-bold text-center">{{ number_format(round($sesV["gross_pension"],2),2) }} </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td class="f-pad-dt txt-bold">Net Gross Pension</td>
              <td class="f-pad-dt">
                <table style="width: auto;">
                  <tbody>
                    <tr>
                      <td class="text-center" style="font-size:10px;width:80px;">Gross Pension</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;width:80px;">Percentage</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;width:80px;">Net Pension</td>
                    </tr>
                    <tr>
                      <td class="text-center">{{ number_format(round($sesV["gross_pension"],2),2) }}</td>
                      <td class="text-center">x</td>
                      <td class="text-center">65 %</td>
                      <td class="text-center">=</td>
                      <td class="txt-bold text-center">{{ number_format(round($sesV["net_pension"],2),2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td class="f-pad-dt txt-bold">Commutation</td>
              <td class="f-pad-dt">
                <table style="width: auto;">
                  <tbody>
                    <tr>
                      <td class="text-center" style="font-size:10px;width:80px;">Gross Pension</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td class="text-center" style="font-size:10px;">Percentage</td>
                      <td class="text-center" style="font-size:10px;width:30px;">&nbsp;</td>
                      <td colspan="5" class="right" style="font-size:10px;width:270px;">Formulat / Age  Next Birthday</td>
                      <td class="text-center" style="font-size:10px;width:130px;">Total Commutation</td>
                    </tr>
                    <tr>
                      <td class="text-center  ">{{ number_format(round($sesV["gross_pension"],2),2) }}</td>
                      <td class="text-center  ">x</td>
                      <td class="text-center  ">35 %</td>
                      <td class="text-center  ">=</td>
                      <td class="text-center  ">
                        {{ number_format(round(($sesV["gross_pension"]* $sesV["f2"]) / 100,2),2) }}
                      </td>
                      <td class="text-center  ">x</td>
                      <td class="text-center  ">12</td>
                      <td class="text-center  ">x</td>
                      <td class="right  ">{{ $sesV["age_rate"] }}</td>
                      <td class="txt-bold text-center  ">Rs. {{ number_format(round($sesV["commutation"],2),2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        
        
        <table class="table table-increase" cellspacing="0">
          <tbody>
            <tr>
              <td class="rotate-td">
                <div class="text-rotate">Increases</div>
              </td>
              <td>
                <table style="width:100%;" cellspacing="0" cellpadding="6px">
                  <tbody style="border: 1px solid;">
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
                      <td>
                        {!! $desp !!}
                      </td>
                      <td>{{ $rate }} %</td>
                      <td><strong>{{ number_format($amount,2) }}</strong></td>
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
                      <td>
                       {!! $desp !!}
                      </td>
                      <td>{{ $rate }} %</td>
                      <td><strong>{{ number_format($amount,2) }}</strong></td>
                    </tr>
                  @php
                    }
                  @endphp
                    <tr class="footer-tr">
                      <td colspan="2" class="dark"><strong>Total Increases</strong></td>
                      <td class="dark">{{ number_format($total_increase,2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        
        
        <table class="table table-result" cellspacing="0">
          <tbody>
            <tr>
              <td class="rotate-td">
                <div class="text-rotate">Result</div>
              </td>
              <td>
                <table cellspacing="5" cellpadding="5" class="inner-table-lg">
                  <tbody>
                    <tr>
                      <td class="dark">Commutation</td>
                      <td>Rs. {{ number_format(round($sesV["commutation"],2),2) }}</td>
                    </tr>
                    <tr>
                      <td class="dark">Net Pension</td>
                      <td>Rs. {{ number_format(round($sesV["net_pension"],2),2) }}</td>
                    </tr>
                    <tr>
                      <td class="dark">Take Home Pension</td>
                      <td>Rs. {{ number_format(round($sesV["takehome"],2),2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        
    </div>
    <div class="col-md-12 d-flex justify-content-center footer-button">
        <a href="{{ route('pension-pdf') }}" type="button" class="btn btn-pdf pen-pdf" target="_blank">Generate PDF</a>
        {{-- <button type="button" class="btn btn-email">Recieve via Email</button> --}}
    </div>
</div>
@endif