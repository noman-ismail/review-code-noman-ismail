<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;

class NationalPanel extends Controller
{
	function dashboard()
	{
		return view('admin.national.dashboard');
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
        if(request('panel_for') != '1'){
          return back()->with('error','Please select correct panel for');
        }
        $data = [
            'name' => $request->user_name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'society_dsg' => $request->society_designation,
            'official_dsg' => $request->official_designation,
            'city' => $request->city ,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'enc' => base64_encode($request->password),
            's_img' => base64_encode($request->security_image),
            'type' => 'national',
            'dept_id' => 1,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('admin')->insert($data);
        $ssdgf = DB::table('admin')->where('username',$request->username)->first();
        return redirect(route('national-u-list').'?id='.$ssdgf->id)->with('success','User added successfully');
      }else{
          return back()->with('error','Username is already exist');
      }
    }
		$society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
		return view('admin.national.add-user' , compact('society_dsg','ofc_dsg','cities'));
	}

  function national_user_list(Request $request)
  {
    if(request()->has("id") and is_numeric(request("id")) and request("id") > 0){
        if(request()->isMethod('post')){
          // dd(request()->all());
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
          if($wer > 0){
              return back()->with('error','Username is Already Takken');
          }
          $data['name'] = $request->user_name;
          $data['username'] = $request->username;
          $data['mobile'] = $request->mobile;
          $data['society_dsg'] = $request->society_designation;
          $data['official_dsg'] = $request->official_designation;
          $data['city'] = $request->city;
          $data['email'] = $request->email;
          $data['password'] = bcrypt($request->password);
          $data['enc'] = base64_encode($request->password);
          $data['s_img'] = base64_encode($request->security_image);
          DB::table('admin')->where('id',request('id'))->update($data);
          return back()->with('success','User updated successfully');
        }
        $user = DB::table('admin')->where('id',request('id'))->where('type','national')->first();
        $record = DB::table('admin')->where('type','national')->get();
        $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
        $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
        $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
        return view('admin.national.national-user-list',compact('user','record','society_dsg','cities','ofc_dsg'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
        DB::table('admin')->where('id',request('del'))->delete();
        return back()->with('success','User is deleted successfully');            
    }
    $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $record = DB::table('admin')->where('type','national')->get();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    return view('admin.national.national-user-list',compact('record','society_dsg','cities','ofc_dsg'));
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
                          'password' => bcrypt($request->new_password),
                          's_img' => base64_encode(request('new_security_image'))
                      );
              DB::table('admin')->where('id', $user->id)->update($data);
              return redirect(route('base_url').'/'.admin.'/national-login-update')->with('success','Login Update Successfully');
          }
      }
      $admin = DB::table('admin')->where('username',$username)->first();
      return view('admin.national.update-login',compact('admin'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
}