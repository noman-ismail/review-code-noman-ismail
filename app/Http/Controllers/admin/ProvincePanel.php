<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;
use Response;

class ProvincePanel extends Controller
{
	function dashboard()
	{
		return view('admin.province.dashboard');
	}
	function add_user(Request $request)
	{
    if(request()->isMethod('post')){
      $this->validate($request, [
        'user_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
        'mobile' => 'required|max:100',
        'email' => 'nullable|email',
        'username' => 'required|alpha_dash|unique:admin,username|min:5|max:100',
        'password' => 'required|min:4|max:100',
        'security_image' => 'required|max:100',
      ]);
  		$img_name_array = s_img_values();
      $chck_username = DB::table('admin')->where('username',$request->username)->first();
      $img_name = array_search($request->security_image, $img_name_array);
      if($img_name == ""){
        return back()->with('error','Kindly select security image from options');
      }
      if($chck_username == ""){
        if(isset($request->sms)){
            $sms = "on";
            $no = generate_mbl($request->mobile);
            $msg = $request->sms_format;
            sendSMS($no,$msg);
        }else{
            $sms = "off";
        }
        if(isset($request->status)){
            $status = "on";
        }else{
            $status = "off";
        }
        $data = [
            'name' => $request->user_name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'dept_id' => $request->panel_for,
            'society_dsg' => $request->society_designation,
            'official_dsg' => $request->official_designation,
            'city' => $request->city ,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'enc' => base64_encode($request->password),
            's_img' => base64_encode($request->security_image),
            'type' => 'province',
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('admin')->insert($data);
        $ssdgf = DB::table('admin')->where('username',$request->username)->first();
        // dd('sdf');
        return redirect(route('province-u-list').'?id='.$ssdgf->id)->with('success','User added successfully');
      }else{
          return back()->with('error','Username is already exist');
      }
    }
		$society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $province = DB::table('province')->orderby('sort','asc')->get();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
		return view('admin.province.add-user' , compact('society_dsg','ofc_dsg','province','cities'));
	}

  function province_user_list(Request $request)
  {
    if(request()->has("id") and is_numeric(request("id")) and request("id") > 0){
        if(request()->isMethod('post')){
          $this->validate($request, [
            'user_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'username' => 'required|alpha_dash|min:5|max:100',
            'mobile' => 'required|max:100',
            'email' => 'nullable|email',
            'password' => 'required|min:4',
            'security_image' => 'required',
          ]);
          if(isset($request->sms)){
              $sms = "on";
              $no = generate_mbl($request->mobile);
              $msg = $request->sms_format;
              sendSMS($no,$msg);
          }else{
              $sms = "off";
          }
	        $img_name_array = s_img_values();
          $wer = 0;
          $get_users = DB::table('admin')->get();
          foreach ($get_users as $value) {
              if($value->id != request('id')){
                  if(strtolower($request->username) == strtolower($value->username)){
                      $wer++;
                  }
              }else{
                  $old_password = base64_decode($value->enc);
                  $s_img = array_search(base64_decode($value->s_img), $img_name_array);
              }
          }
          if($request->security_image != ''){
            $s_img = array_search($request->security_image, $img_name_array);
            if($s_img == ""){
              return back()->with('error','Kindly select security image from options');
            }
          }
          $data['name'] = $request->user_name;
          $data['username'] = $request->username;
          $data['mobile'] = $request->mobile;
          $data['dept_id'] = $request->panel_for;
          $data['society_dsg'] = $request->society_designation;
          $data['official_dsg'] = $request->official_designation;
          $data['city'] = $request->city;
          $data['slug'] = admin;
          $data['email'] = $request->email;
          $data['password'] = bcrypt($request->password);
          $data['enc'] = base64_encode($request->password);
          $data['s_img'] = base64_encode($request->security_image);
          DB::table('admin')->where('id',request('id'))->update($data);
          return back()->with('success','User updated successfully');
        }
        $user = DB::table('admin')->where('id',request('id'))->where('type','province')->first();
        $record = DB::table('admin')->where('type','province')->get();
        $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
        $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
        $province = DB::table('province')->orderby('sort','asc')->get();
        $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
        return view('admin.province.province-user-list',compact('user','record','society_dsg','ofc_dsg','cities','province'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
        DB::table('admin')->where('id',request('del'))->delete();
        return back()->with('success','User is deleted successfully');            
    }
    $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $record = DB::table('admin')->where('type','province')->get();
    $province = DB::table('province')->orderby('sort','asc')->get();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    return view('admin.province.province-user-list',compact('record','society_dsg','ofc_dsg','cities','province'));
  }
  function update_login(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(!empty($user)){
      if(request()->isMethod('post')){
          $this->validate($request, [
              'email' => 'required|alpha_dash',
              'old_password' => 'required',
              'new_password' => 'required',
              'confirm_password' => 'required',
              'old_security_image' => 'required',
              'new_security_image' => 'required',
          ]);
          $old = $request->old_password;
          // dd(request()->all());
          if($request->new_password != $request->confirm_password){
              return back()->with('error','Password and Repeat Password Does not matched');
          }elseif(!Hash::check(request('old_password'),Auth::user()->password)){
              return back()->with('error','Old password is incorrect');
          }elseif($user->s_img != base64_encode(request('old_security_image'))){
              return back()->with('error','Old security image is incorrect');
          }else{
              $img_name_array = s_img_values();
              if($request->new_security_image != ''){
                $s_img = array_search($request->new_security_image, $img_name_array);
                if($s_img == ""){
                  return back()->with('error','Kindly select security image from options');
                }
              }
              $data = array(
                          'slug' => base64_encode(admin),
                          'password' => bcrypt($request->new_password),
                          's_img' => base64_encode(request('new_security_image'))
                      );
              DB::table('admin')->where('id', $user->id)->update($data);
              return redirect(route('base_url').'/'.admin.'/province-login-update')->with('success','Login Update Successfully');
          }
      }
      $admin = DB::table('admin')->where('username',$username)->first();
      return view('admin.province.update-login',compact('admin'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }

  function budget_distribution(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $date = request('year');
    $panel = request('panel');
    $date_from = request('date_from');
    $date_to = request('date_to');
    $query = "Select * from budget_list where budget_type = 'allocate' and reqst_from = ".auth('admin')->user()->dept_id;
    if (!empty($date)) {
      $query .= " and year = '$date'";
    }
    if (!empty($panel)) {
      if($panel == 'pakistan'){
        $query .= " and type = 'national'"; 
      }elseif($panel == 'all'){
        $query .= " and reqst_to is Not Null";
      }elseif($panel == 'current'){
        $query .= " and reqst_to = ".auth('admin')->user()->dept_id;
      }else{
        $query .= " and reqst_to = '$panel'";
      }
    }
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and created_at > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and created_at < '$to'";
    }
    $record = DB::select($query);
    return view('admin.province.reports.distribution', compact('record'));
  }

  function distribution_pdf(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
      $file = 'Budget Allcoation Report of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_dis_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);    
  }
  function view_dis_pdf()
  {
    $date = request('year');
    $panel = request('panel');
    $date_from = request('date_from');
    $date_to = request('date_to');
    $query = "Select * from budget_list where budget_type = 'allocate' and reqst_from = ".auth('admin')->user()->dept_id;
    if (!empty($date)) {
      $query .= " and year = '$date'";
    }
    if (!empty($panel)) {
      if($panel == 'pakistan'){
        $query .= " and type = 'national'"; 
      }elseif($panel == 'all'){
        $query .= " and reqst_to is Not Null";
      }elseif($panel == 'current'){
        $query .= " and reqst_to = ".auth('admin')->user()->dept_id;
      }else{
        $query .= " and reqst_to = '$panel'";
      }
    }
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and created_at > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and created_at < '$to'";
    }
    // dd($query);
    $record = DB::select($query);
    return view('admin.province.reports.distribution-pdf', compact('record'));
  }

  function budget_request(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $record = $this->bdg_request_data();
    return view('admin.province.reports.budget', compact('record'));
  }
  function bdg_request_data()
  {
    $date = request('year');
    $panel = request('panel');
    $date_from = request('date_from');
    $date_to = request('date_to');
    $query = "Select * from budget_list where budget_type = 'request' and reqst_from = ".auth('admin')->user()->dept_id;
    if (!empty($date)) {
      $query .= " and year = '$date'";
    }
    if (!empty($panel)) {
      if($panel == 'pakistan'){
        $query .= " and type = 'national'"; 
      }elseif($panel == 'all'){
        $query .= " and reqst_to is Not Null";
      }elseif($panel == 'current'){
        $query .= " and reqst_to = ".auth('admin')->user()->dept_id;
      }else{
        $query .= " and reqst_to = '$panel'";
      }
    }
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and due_date > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and due_date < '$to'";
    }
    // dd($query);
    $record = DB::select($query);
    return $record;
  }
  function budget_pdf(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
      $file = 'Budget Distribution of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_bdg_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);    
  }
  function view_bdg_pdf()
  {
    $record = $this->bdg_request_data();
    return view('admin.province.reports.budget-pdf', compact('record'));
  }
  function fund_request(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $record = $this->fund_request_data();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    $admin_users = DB::table('admin')->get();
    return view('admin.province.reports.funds', compact('record','cities','admin_users'));
  }
  function fund_request_data()
  {
    $date = request('year');
    $panel = request('panel');
    $date_from = request('date_from');
    $date_to = request('date_to');
    $query = "Select * from district_ledger where ledger = '-' and province = ".auth('admin')->user()->dept_id;
    if (!empty($date)) {
      $query .= " and year = '$date'";
    }
    if (!empty($panel)) {
        $query .= " and district = '$panel'";
    }
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and date > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and date < '$to'";
    }
    // dd($query);
    $record = DB::select($query);
    return $record;
  }
  function fund_pdf(Request $request)
  {
    if(auth('admin')->user()->type != 'province'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
      $file = 'Fund Requests of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_fund_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);    
  }
  function view_fund_pdf()
  {
    $record = $this->fund_request_data();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    $admin_users = DB::table('admin')->get();
    return view('admin.province.reports.funds-pdf', compact('record','cities','admin_users'));
  }
  function death_report(Request $request)
  {
    if(auth('admin')->user()->type == 'admin' || auth('admin')->user()->type == 'national'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $record = $this->death_request_data();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    if(auth('admin')->user()->type == 'province'){
      $admin_users = DB::table('users')->where('province',auth('admin')->user()->dept_id)->get();
    }elseif(auth('admin')->user()->type == 'district'){
      $admin_users = DB::table('users')->where('district',auth('admin')->user()->dept_id)->get();
    }else{
      return redirect('404');
    }
    return view('admin.province.reports.death', compact('record','cities','admin_users'));
  }
  function death_request_data()
  {
    $panel = request('panel');
    $date_from = request('date_from');
    $date_to = request('date_to');
    if (auth('admin')->user()->type == 'province') {
      $query = "Select * from death_claims where request_panel = ".auth('admin')->user()->dept_id;
    }elseif(auth('admin')->user()->type == 'district'){
      $query = "Select * from death_claims where dept_id = ".auth('admin')->user()->dept_id;      
    }else{
      return redirect('404');
    }
    if (!empty($panel)) {
        $query .= " and request_panel = '$panel'";
    }
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and death_date > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and death_date < '$to'";
    }
    // dd($query);
    $record = DB::select($query);
    return $record;
  }
  function death_pdf(Request $request)
  {
      $file = 'Death Claim Requests of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_death_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);    
  }
  function view_death_pdf()
  {
    $record = $this->death_request_data();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    if(auth('admin')->user()->type == 'province'){
      $admin_users = DB::table('users')->where('province',auth('admin')->user()->dept_id)->get();
    }elseif(auth('admin')->user()->type == 'district'){
      $admin_users = DB::table('users')->where('district',auth('admin')->user()->dept_id)->get();
    }else{
      return redirect('404');
    }
    return view('admin.province.reports.death-pdf', compact('record','cities','admin_users'));
  }
  function expense_report(Request $request)
  {
    if(auth('admin')->user()->type == 'admin'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $record = $this->expense_data();
    return view('admin.province.reports.expense', compact('record'));
  }
  function expense_data()
  {
    $date_from = request('date_from');
    $date_to = request('date_to');
    $query = "Select * from expense where type = '".auth('admin')->user()->type."' and dept_id = ".auth('admin')->user()->dept_id;
    if (!empty($date_from) ) {
      $from = implode('-', array_reverse(explode('/', $date_from)));
      $query .= " and entry_date > '$from'";
    }
    if (!empty($date_to) ) {
      $to = implode('-', array_reverse(explode('/', $date_to)));
      $query .= " and entry_date < '$to'";
    }
    // dd($query);
    $record = DB::select($query);
    return $record;
  }
  function expense_pdf(Request $request)
  {
      $file = 'Expense Sheet of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_expense_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);    
  }
  function view_expense_pdf()
  {
    $record = $this->expense_data();
    return view('admin.province.reports.expense-pdf', compact('record'));
  }


}