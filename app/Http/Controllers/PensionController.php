<?php
namespace App\Http\Controllers;
use App\Models\Api;
use DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;
use Response;
class PensionController extends Controller {

    public function view(Request $request){
      if (request()->isMethod('post')) {
        $data = request()->all();
      }
      return view("front.pension");
    }
    public function generate_pdf(){
      if(Session::has('sesV')){
        $data = session('sesV');
        // $data[] = ['pdf'=>'yes'];
        return $this->calculate($data[0]);
      }else{
        return redirect(route('404'));
      }
    }
    // public function mail_pdf(){
    //   if(Session::has('sesV')){
    //     $data = session('sesV');
    //     // $data[] = ['pdf'=>'yes'];
    //     return $this->calculate($data[0]);
    //   }else{
    //     return redirect(route('404'));
    //   }
    // }
    public function pensionList(){
      if ( request('del')  ) {
        $file = Api::Select('pdf')->where('id', '=', request('del'))->first();
        $file = $file['pdf'];
        if(\File::exists($file)){
            \File::delete($file);
          }
        $row = Api::where('id', '=', request('del'))->delete();
        return  redirect('/'.admin.'/pension-list')->with('deletd_message','Record has been Deleted Successfully');
      }else{
        $data = Api::orderBy('id', 'DESC')->get()->all();
        return view("admin.pension-table" , compact("data")); 
      }
    }
    public function calculate($data = array()){   
      if(Session::has('sesV')){
         Session::pull('sesV');
      }
      $sesV = array();
      if(count($data) > 0){
        $name=$data["name"];
        $designaiton=$data["designation"];
        $pension=$data["type"];
        $scale=$data["scale"];
        $basic=$data["pay"];
        $city=$data["city"];
        $department=$data["department"];
        $sesV["name"] = $data["name"];
        $ret_date = implode('/', array_reverse(explode('-', $data["retireOn"])));
        $appoint_date = implode('/', array_reverse(explode('-', $data["appoint"])));
        $dob = str_replace("-","/",$data["birth"]);
        $non_fq = explode("-",$data["non_q"]);
        $yrs=($non_fq[0]=="Y") ? 0 : $non_fq[0];
        $mnths=($non_fq[0]=="M") ? 0 : $non_fq[1];
        $dys=($non_fq[0]=="D") ? 0 : $non_fq[0];
        $ny=$yrs;
        $nm=$mnths;
        $nd=$dys;
        $non=$nd." ".$nm." ".$ny;
        $scale=$data["scale"];
        $cl_pension=$data["type"];
        $is_view = "pdf";
      }else{
        $name=$_POST["name"];
        $designaiton=$_POST["designation"];
        $pension=$_POST["type"];
        $scale=$_POST["scale"];
        $basic=$_POST["pay"];
        $ny=$_POST["ny"];
        $nm=$_POST["nm"];
        $nd=$_POST["nd"];
        $ret_date = $_POST["retirement"];
        $appoint_date = $_POST["appointment"];
        $dob = $_POST["birth"];
        $yrs=$_POST["ny"];
        $mnths=$_POST["nm"];
        $dys=$_POST["nd"];
    	  $sesV["name"] = $_POST["name"];
    	  $non=$_POST["nd"]." ".$_POST["nm"]." ".$_POST["ny"];
        $non_fq=$_POST["ny"]."-".$_POST["nm"]."-".$_POST["nd"];
        $scale=$_POST["scale"];
        $cl_pension=$_POST["type"];
        $city=$_POST["city"];
        $department=$_POST["organization"];
      }
    $rr_date = explode("/" , $ret_date );
    $ret_day=$rr_date[0];
    $ret_month=$rr_date[1];
    $ret_year=$rr_date[2];
    $ret_date = $ret_year."-$ret_month-$ret_day";
    
    $apt_date = explode("/" , $appoint_date );
    $ap_day=$apt_date[0];
    $ap_month=$apt_date[1];
    $ap_year=$apt_date[2];
    $appoint_date = $ap_year."-$ap_month-$ap_day";
    
    $dob_date = explode("/" , $dob );
    $bd=$dob_date[0];
    $bm=$dob_date[1];
    $by=$dob_date[2];
    $dob = $by."-$bm-$bd";
    
    $sesV["type"] = $pension;
    $sesV["scale"] = $scale;
    $sesV["pay"] = $basic;
    $sesV["non_q"] = $ny."-$nm-$nd";
    $sesV["retireOn"] = $ret_date;
    $sesV["birth"] = $dob;
    $sesV["appoint"] = $appoint_date;
    $sesV["designation"] = $designaiton;
    $sesV["pension"] = $pension;
    $sesV["city"] = $city;
    $sesV["department"] = $department;
    // $sesV["pdf_id"] = $pdf_id;


    //*-----------------------------
    $retirement=$ret_day." ".$ret_month." ".$ret_year;
    $appointment=($ap_day)." ".$ap_month." ".$ap_year;
    $birth=$bd." ".$bm." ".$by;
    
    //* Start Service Date Differnece
    $start_date=$retirement;
    $end_date=$appointment;
    $date1=explode(" ",$start_date);
    $date2=explode(" ",$end_date);
    $start_day=round($date1[0]);
    $start_month=round($date1[1]);
    $start_year=round($date1[2]);
    $end_day=round($date2[0]);
    $end_month=round($date2[1]);
    $end_year=round($date2[2]);
    //Day Calculation
    if ($start_day<$end_day)
    {
     $day_diff=($start_day+30)-$end_day;
     $start_month=$start_month-1;
    }else{
     $day_diff=$start_day-$end_day;
    }
    //---------------------------
    //Month Caclulaton
    if ($start_month<$end_month)
    {
     $month_diff=($start_month+12)-$end_month;
    }else{
     $month_diff=$start_month-$end_month;
    }
    //Year Calculation
    if ($start_month<$end_month)
    {
     $year_diff=($start_year-1)-$end_year;
    }else{
     $year_diff=$start_year-$end_year;
    }
    $dd_diff=$day_diff;
    $mm_diff=$month_diff;
    $yy_diff=$year_diff;
    $ddd_diff=$day_diff;
    $mmm_diff=$month_diff;
    $yyy_diff=$year_diff;
    $sesV["net_service"] = $yyy_diff."-$mmm_diff-$ddd_diff";
    //* -------------------------------------------------
    //* Start Net Age  Date Differnece
    $start_date=$retirement;
    $end_date=$birth;
    $date1=explode(" ",$start_date);
    $date2=explode(" ",$end_date);
    $start_day=round($date1[0]);
    $start_month=round($date1[1]);
    $start_year=round($date1[2]);
    $end_day=round($date2[0]);
    $end_month=round($date2[1]);
    $end_year=round($date2[2]);
    //Day Calculation
    if ($start_day<$end_day)
    {
     $day_diff=($start_day+30)-$end_day;
     $start_month=$start_month-1;
    }else{
     $day_diff=$start_day-$end_day;
    }
    //---------------------------
    //Month Caclulaton
    if ($start_month<$end_month)
    {
     $month_diff=($start_month+12)-$end_month;
    }else{
     $month_diff=$start_month-$end_month;
    }
    //Year Calculation
    if ($start_month<$end_month)
    {
     $year_diff=($start_year-1)-$end_year;
    }else{
     $year_diff=$start_year-$end_year;
    }
    $net_day=$day_diff;
    $net_month=$month_diff;
    $net_year=$year_diff;
    $sesV["net_age"] = $net_year."-$net_month-$net_day";
    //* -------------------------------------------------
    //* Statrt Non Qualifying Service
    $start_date="$yyy_diff $mmm_diff $ddd_diff";
    $end_date=$non;
    $date1=explode(" ",$start_date);
    $date2=explode(" ",$end_date);
    $start_day=round($date1[0]);
    $start_month=round($date1[1]);
    $start_year=round($date1[2]);
    $end_day=round($date2[0]);
    $end_month=round($date2[1]);
    $end_year=round($date2[2]);
    //Day Calculation
    if ($start_day<$end_day)
    {
     $day_diff=($start_day+30)-$end_day;
     $start_month=$start_month-1;
    }else{
     $day_diff=$start_day-$end_day;
    }
    //---------------------------
    //Month Caclulaton
    if ($start_month<$end_month)
    {
     $month_diff=($start_month+12)-$end_month;
    }else{
     $month_diff=$start_month-$end_month;
    }
    //Year Calculation
    if ($start_month<$end_month)
    {
     $year_diff=($start_year-1)-$end_year;
    }else{
     $year_diff=$start_year-$end_year;
    }

    if ($ddd_diff<$dys)
    {
     $dd_diff=$ddd_diff+30;
      $dd_diff=$dd_diff-$dys." ";
      $mm_diff=$mmm_diff-1;
    }else{
      $dd_diff=$ddd_diff." ";
    }

    if ($mmm_diff<$mnths)
    {
     $mm_diff=$mm_diff+12;
      $mm_diff=$mm_diff-$mnths." ";
      $yy_diff=$yyy_diff-1;
    }else{
      
      $mm_diff=(int)$mm_diff-(int)$mnths." ";
      $yy_diff=$yyy_diff;
    }

     $yy_diff=(int)$yy_diff-(int)$yrs." ";
     "$yy_diff $mm_diff $dd_diff";
    $sy_diff=$yy_diff;
    $sm_diff=$mm_diff;


   
    // Scale Rate 2011
    $scale_incre_rate=array("01"=>"150","02"=>"170","03"=>"200","04"=>"230","05"=>"260","06"=>"290","07"=>"320","08"=>"350","09"=>"380","10"=>"420","11"=>"460","12"=>"500","13"=>"550","14"=>"610","15"=>"700","16"=>"800","17"=>"1200","18"=>"1500","19"=>"1800","20"=>"2350","21"=>"2800","22"=>"3050");
    // Scale Rate 2015
    $new_scale_rate=array("01"=>"195","02"=>"220","03"=>"260","04"=>"300","05"=>"340","06"=>"375","07"=>"415","08"=>"455","09"=>"495","10"=>"544","11"=>"595","12"=>"650","13"=>"715","14"=>"790","15"=>"905","16"=>"1035","17"=>"1555","18"=>"1950","19"=>"2075","20"=>"3050","21"=>"3375","22"=>"3960");
    // Scale Rate 2016
    $scale_rate_16 = array("01"=>"240", "02"=>"275", "03"=>"325", "4"=>"370", "05"=>"420", "06"=>"470", "07"=>"510", "08">"560", "09"=>"610", "10"=>"670", "11"=>"740", "12"=>"800", "13"=>"880", "14"=>"980", "15"=>"1120", "16"=>"1280", "17"=>"1930", "18"=>"2400", "19"=>"2560", "20"=>"3750", "21">"4150", "22"=>"4870"); 
    // Scale Rate 2017
    $scale_rate_17 = array("01"=>"290", "02"=>"330", "03"=>"390", "4"=>"440", "05"=>"500", "06"=>"560", "07"=>"610", "08">"670", "09"=>"730", "10"=>"800", "11"=>"880", "12"=>"960", "13"=>"1050", "14"=>"1170", "15"=>"1330", "16"=>"1520", "17"=>"2300", "18"=>"2870", "19"=>"3050", "20"=>"4510", "21">"5000", "22"=>"5870"); 

    $conv_p = strtotime($ret_year."-".$ret_month."-".$ret_day) ;
    $conv_2017_p = strtotime("2017-07-01");
    $conv_2016_p = strtotime("2016-07-01");
    $conv_2015_p = strtotime("2015-07-01");
    if ($conv_p >= $conv_2017_p){
      $scl_rate=$scale_rate_17["$scale"];     // 2017 Increment
    }elseif ($conv_p >= $conv_2016_p){
      $scl_rate=$scale_rate_16["$scale"];     // 2016 Increment
    }elseif ($conv_p >= $conv_2015_p){
      $scl_rate=$new_scale_rate["$scale"];    // 2015 Increment
    }else{
      $scl_rate=$scale_incre_rate["$scale"];    // 2011 Increment
    }
    $sesV["scale_rate"] = $scl_rate;
    $age_rate=array("20"=>"40.5043","21"=>"39.7341","22"=>"38.9653","23"=>"38.1974","24"=>"37.4307","25"=>"36.6651","26"=>"35.9006","27"=>"35.1372","28"=>"34.375","29"=>"33.6143","30"=>"32.8071","31"=>"32.0974","32"=>"31.7412","33"=>"30.5869","34"=>"29.8343","35"=>"29.0841","36"=>"28.3362","37"=>"27.5908","38"=>"26.8482","39"=>"26.1009","40"=>"25.3728","41"=>"24.6406","42"=>"23.9126","43"=>"23.184","44"=>"22.4713","45"=>"21.7592","46"=>"21.0538","47"=>"20.3555","48"=>"19.6653","49"=>"18.9841","50"=>"18.3129","51"=>"17.6526","52"=>"17.005","53"=>"16.371","54"=>"15.7517","55"=>"15.1478","56"=>"14.5602","57"=>"13.9888","58"=>"13.434","59"=>"12.8953","60"=>"12.3719","61"=>"11.8632","62"=>"11.3684","63"=>"10.8872","64"=>"10.4191","65"=>"9.9639","66"=>"9.5214","67"=>"9.0914","68"=>"8.6742","69","8.2697","70"=>"7.8778","71"=>"7.4983","72"=>"7.1314","73"=>"6.7766","74"=>"6.4342","75","6.1039","76"=>"5.7858","77"=>"5.4797","78"=>"5.1854","79"=>"4.903","80"=>"4.6321");
    if (round($ret_month)>=6)
    { 
      if (round($ret_month)<12){
        $increment_rat=round($scl_rate);
      }else{
        $increment_rat=0;
      }
    }else{
      $increment_rat=0;
    }
    $sesV["increment_rate"] = $increment_rat;
    if ($sy_diff>=30)
    {
     $net_service=30;
    }else{
     if ($sm_diff>=6)
     {
        if ($sm_diff!=12)
        {
        $net_service=round($sy_diff)+1;
       }else{
        $net_service=trim($sy_diff);
       }
     }else{
      $net_service=trim($sy_diff);
     }
    }

    $sesV["net_service_year"] = $net_service;
    if ($dd_diff>0 or $mm_diff>0)
    {
        if ($net_year>=60)
      {
        $net_year=60;
      }else{
        $net_year=$net_year+1;
      }
    }
    $sesV["net_year"] = $net_year;

    if (round($scale)<=16){       // Check Medical Allowance on Scale Checking
      $medial_allowance=25;
    }else{
      $medial_allowance=20;
    }


    $last_basic_pay=round($basic) + $increment_rat;
    $net_service;
    $increment_rat;
    $gross_pension=(($last_basic_pay*$net_service*7)) / 300; 
    $sesV["gross_pension"] = $gross_pension;
    $last_basic_pay=$last_basic_pay+$increment_rat;
    if ($pension=="Family"){
      $net_pension=number_format(($gross_pension*75)/100,2);
      $sesV["net_pension"] = ($gross_pension*75)/100;
      $sesV["formula"] = "75_25";
      $takehome=(($gross_pension*75)/100)+((($gross_pension*75)/100)*15)/100; // Increase 2010
      $sesV["increases"][2010] = [15,((($gross_pension*75)/100)*15)/100];
      $sesV["increases"][2011] = [15,($takehome*15)/100];
      $takehome=$takehome+($takehome*15)/100; // Increase 2011
      $ret_from=strtotime(date("2015-06-30"));
      $ret_on=strtotime(date($ret_year."-".$ret_month.""."-".$ret_day));
      if ($ret_on <= $ret_from){
        $sesV["increases"][2012] = [20,($takehome*20)/100];
        $takehome=$takehome+($takehome*20)/100; // Increase 2012
       }
     
       $ret_16 = strtotime(date("2016-06-30"));
       if ($ret_on <= $ret_16){ // If Retirement from 1 July 2017
        $sesV["increases"][2013] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100; // Increase 2013

        $sesV["increases"][2014] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100; // Increase 2014
       }

       $ret_15 =  strtotime(date("2015-06-30"));
       $ret_14 =  strtotime(date("2014-06-30"));
       if (!($ret_on > $ret_14 and $ret_on <= $ret_15)){
        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015
       }

       if ($ret_on > $ret_16){
         $sesV["increases"][2016] = [10,($takehome*10)/100];
         $takehome=$takehome+($takehome*10)/100;  // Increase 2016
       }

       // 2017 Increment
       $ret_17 = strtotime(date("2017-07-01"));
       if ($ret_on >= $ret_17){
        unset($sesV["increases"][2010]);
        $sesV["increases"][2011] = [15,((($gross_pension*75)/100)*15)/100];
        $takehome=(($gross_pension*75)/100)+((($gross_pension*75)/100)*15)/100; // Increase 2011

        unset($sesV["increases"][2012]);
        unset($sesV["increases"][2013]);
        unset($sesV["increases"][2014]);

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017
       }

       // 2018 Increment
       $ret_18 = strtotime(date("2018-07-01"));
       if ($ret_on >= $ret_18){
        $sesV["increases"][2011] = ((($gross_pension*75)/100)*15)/100;
        $takehome=(($gross_pension*75)/100)+((($gross_pension*75)/100)*15)/100; // Increase 2011

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017

        $sesV["increases"][2018] =[10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2018
       }
      
      // 2019 Increment
       $ret_19 = strtotime(date("2019-07-01"));
       if ($ret_on >= $ret_19){
        $sesV["increases"][2011] = ((($gross_pension*75)/100)*15)/100;
        $takehome=(($gross_pension*75)/100)+((($gross_pension*75)/100)*15)/100; // Increase 2011

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017

        $sesV["increases"][2018] =[10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2018

        $sesV["increases"][2019] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2019
       }


       $ret_from=strtotime(date("2015-07-01"));
       $ret_on=strtotime(date($ret_year."-".$ret_month.""."-".$ret_day));
       if ($ret_day>=1 and $ret_month>=7 and $ret_year>=2015){
        //$takehome=$takehome+($takehome*7.5)/100;  // Increase 2016
       }

       // Medical Allowances
       $med_alc=((($gross_pension*75)/100)*$medial_allowance)/100; // old allowance
       $sesV["medical_allowance"][] = [10,$medial_allowance,$med_alc]; 
       if ($ret_on >= $ret_from){
        $med_alc_new=$med_alc+($med_alc * 25 )/100; // Increase 2015
        $sesV["medical_allowance"][] = [10,25,($med_alc * 25 )/100]; 
       }else{
        $med_alc_new=$med_alc; 
       }

       $takehome=$takehome+$med_alc_new;  // Increase Medical Allowance
       $sesV["takehome"] = $takehome;
       $takehome=number_format($takehome,2);

       $total_pension=round(($gross_pension*75)/100)+round($last_basic_pay);
       $sesV["total_pension"] = $total_pension;
       $commute_pension=number_format(($gross_pension*25)/100,2);

       $sesV["commutation"] = $commute_pension; 

       $cm=($gross_pension*25)/100;
       $formula=25;
    }else{
       $net_pension=number_format(($gross_pension*65)/100,2);
       $sesV["net_pension"] = ($gross_pension*65)/100;
       $sesV["formula"] = "65_35";
       $takehome=(($gross_pension*65)/100)+((($gross_pension*65)/100)*15)/100; // Increase 2010
       $sesV["increases"][2010] = [15,((($gross_pension*65)/100)*15)/100];
       $sesV["increases"][2011] = [15,($takehome*15)/100];
       $takehome=$takehome+($takehome*15)/100;  // Increase 2011
       $ret_from=strtotime(date("2015/06/30"));
       $ret_on=strtotime(date($ret_year."/".$ret_month.""."/".$ret_day));
       if ($ret_on <= $ret_from){
         $sesV["increases"][2012] = [20,($takehome*20)/100];
        $takehome=$takehome+($takehome*20)/100; // Increase 2012
       }

       $ret_16 = strtotime(date("2016-06-30"));
       if ($ret_on <= $ret_16){ // If Retirement from 1 July 2017
        $sesV["increases"][2013] = [15,($takehome*15)/100];
        $takehome=$takehome+($takehome*10)/100; // Increase 2013
        $sesV["increases"][2014] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100; // Increase 2014
       }
       $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
       $takehome=$takehome+($takehome*7.5)/100; // Increase 2015


       if ($ret_on > $ret_16){
         $sesV["increases"][2016] = [10,($takehome*10)/100];
         $takehome=$takehome+($takehome*10)/100;  // Increase 2016
       }


        // 2017 Increment
       $ret_17 = strtotime(date("2017-07-01"));
       if ($ret_on >= $ret_17){
        unset($sesV["increases"][2010]);
        unset($sesV["increases"][2012]);
        unset($sesV["increases"][2013]);
        unset($sesV["increases"][2014]);
        $sesV["increases"][2011] = [15,((($gross_pension*65)/100)*15)/100];
        $takehome=(($gross_pension*65)/100)+((($gross_pension*65)/100)*15)/100; // Increase 2011

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017
       }
      
      
      // 2018 Increment
       $ret_18 = strtotime(date("2018-07-01"));
       if ($ret_on >= $ret_18){
        $takehome = (($gross_pension*65)/100); 
        unset($sesV["increases"][2010]);
        unset($sesV["increases"][2012]);
        unset($sesV["increases"][2013]);
        unset($sesV["increases"][2014]);
        $sesV["increases"][2011] = [15,((($gross_pension*65)/100)*15)/100];
        $takehome =$takehome+ ((($gross_pension*65)/100)*15)/100; // Increase 2011

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017

        $sesV["increases"][2018] =[10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2018
       }
      
       // 2019 Increment
       $ret_19 = strtotime(date("2019-07-01"));
       if ($ret_on >= $ret_19){
        $takehome = (($gross_pension*65)/100); 
        unset($sesV["increases"][2010]);
        unset($sesV["increases"][2012]);
        unset($sesV["increases"][2013]);
        unset($sesV["increases"][2014]);
        $sesV["increases"][2011] = [15,((($gross_pension*65)/100)*15)/100];
        $takehome =$takehome+ ((($gross_pension*65)/100)*15)/100; // Increase 2011

        $sesV["increases"][2015] = [7.5,($takehome*7.5)/100];
        $takehome=$takehome+($takehome*7.5)/100;  // Increase 2015

        $sesV["increases"][2016] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2016

        $sesV["increases"][2017] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2017

        $sesV["increases"][2018] =[10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2018

        $sesV["increases"][2019] = [10,($takehome*10)/100];
        $takehome=$takehome+($takehome*10)/100;   // Increase 2019
       }

       $ret_from=strtotime(date("2015-07-01"));
       $ret_on=strtotime(date($ret_year."-".$ret_month.""."-".$ret_day));
       if ($ret_on >= $ret_from){
        //$takehome=$takehome+($takehome*7.5)/100;  // Increase 2015
       }

       // Medical Allowances
      $med_alc=((($gross_pension*65)/100)*$medial_allowance)/100; // old allowance
      $sesV["medical_allowance"][] = [10,$medial_allowance,$med_alc]; 
       if ($ret_on >= $ret_from){
        $med_alc_new=$med_alc+($med_alc * 25 )/100; // Increase 2015
        $per_med = 25;
        $sesV["medical_allowance"][] = [15,$per_med,($med_alc * 25 )/100]; 
       }else{
         $med_alc_new=$med_alc; // Increase 2015
       }
       $med_alc_new;
       $takehome=$takehome+$med_alc_new;  // Increase Medical Allowance
       $sesV["takehome"] = $takehome;

       $takehome=number_format($takehome,2);
       $total_pension=round(($gross_pension*65)/100)+round($last_basic_pay);

       $sesV["total_pension"] = $total_pension;
       $commute_pension=number_format(($gross_pension*35)/100,2);

       $sesV["commutation"] = $commute_pension;
       $cm=($gross_pension*35)/100;
       $formula=35;
    }
    if(isset($age_rate[$net_year])){
      $commutation=@number_format(($cm*12)*abs($age_rate[$net_year]),2);
      $sesV["commutation"] = ($cm*12)*abs($age_rate[$net_year]);
      $sesV["age_rate"] = @$age_rate[$net_year];
      $age_value=@$age_rate[$net_year];
    
      if($sesV["formula"]=="65_35"){
          $sesV["f1"] = "65";
          $sesV["f2"] = "35";
        }else{
          $sesV["f1"] = "75";
          $sesV["f2"]= "25";
        }
      	Session::push('sesV', $sesV);
      if(isset($is_view)){

          // return view("front.temp.pdf" , compact("sesV"));
          $file = $sesV['name'].'-pension.pdf';
          pdf_generate($this->pension_pdf_generate($sesV),$file,true,false,'legal');
          $fileurl = base_path("images/".$file);

          return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
      }else{
  		  return view("front.temp.pension-table" , compact("sesV")); 
  	  }
    }else{
      $sesV["msg"] = "Net age must be greater then 20";
      Session::push('sesV', $sesV);
      if(isset($is_view)){
          // return view("front.temp.pdf" , compact("sesV"));
          $file = $sesV['name'].'-pension.pdf';
          pdf_generate($this->pension_pdf_generate($sesV),$file,true,false,'legal');
          $fileurl = base_path("images/".$file);

          return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
      }else{
  		  return view("front.temp.pension-table" , compact("sesV")); 
      }  
    }
  }

  function pension_pdf_generate($sesV = array()){
    return view("front.temp.pdf" , compact("sesV")); 
  }
}
