<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;
use Mail;

class AdminPanel extends Controller
{
	public function dashboard() // Accounts dashboard
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user){
      if($user->type == 'national'){
        return redirect(route('national-dashboard'));
      }elseif($user->type == 'province'){
        return redirect(route('province-dashboard'));
      }elseif($user->type == 'district'){
        return redirect(route('district-dashboard'));
      }elseif($user->type == 'admin'){
        return view('admin.dashboard');
      }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
      }
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  public function stats_dashboard() // Stats dashboard
  {
    if(auth('admin')->user()->type == 'admin'){
      if (request()->isMethod('post')) {
        if (request()->has('action') and request('action') == 'funds-detail') {
          return view('admin.layout.dashboard.collected-fund');
        }elseif (request()->has('action') and request('action') == 'allocated-bdg') {
          return view('admin.layout.dashboard.allocated-bdg');
        }elseif (request()->has('action') and request('action') == 'available-bdg') {
          return view('admin.layout.dashboard.available-bdg');
        }elseif (request()->has('action') and request('action') == 'remaining-bdg') {
          return view('admin.layout.dashboard.remaining-bdg');
        }elseif (request()->has('action') and request('action') == 'pending-bdg') {
          return view('admin.layout.dashboard.pending-bdg');
        }elseif (request()->has('action') and request('action') == 'used-bdg') {
          return view('admin.layout.dashboard.used-bdg');
        }elseif (request()->has('action') and request('action') == 'districts') {
          return view('admin.layout.dashboard.districts');
        }elseif (request()->has('action') and request('action') == 'users') {
          return view('admin.layout.dashboard.users');
        }elseif (request()->has('action') and request('action') == 'province') {
          $type = 'multi';
          return view('admin.layout.dashboard.province',compact('type'));
        }elseif(request()->has('action') and request('action') == 'single-province'){
          $type = 'single';
          $data = DB::table('province')->where('id',request('id'))->first();
          if(empty($data)){
            return '<div class="text-center h4">Province Not Found.</div>';
          }
          return view('admin.layout.dashboard.province',compact('type','data'));
        }
      }
        return view('admin.stats-dashboard');
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
	public function login(Request $request)
	{
		if(request()->isMethod('post')){
			$username = request('email');
			$password = request('password');
			$img_s = base64_encode(request('imageSecurity'));
      $rslt = DB::table('admin')->where('username',$username)->first();
      // dd([$rslt->username,base64_decode($rslt->enc),base64_decode($rslt->s_img)]);
			if($rslt != ""){
				if($rslt->status == 'on'){
					if($rslt->type == request('membership') && $rslt->s_img == $img_s){
						if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) {
              DB::table('admin')->where('username',$username)->update(['tries'=>'0']);
              if($rslt->type == 'national'){
                return redirect(route('national-dashboard'));
              }elseif($rslt->type == 'province'){
                return redirect(route('province-dashboard'));
              }elseif($rslt->type == 'district'){
                return redirect(route('district-dashboard'));
              }elseif($rslt->type == 'admin'){
                return redirect(route('admin-dashboard'));
              }else{
                session(['back_url'=>url()->previous()]);
                return redirect(route('404'));
              }
						}else{
              $d = $rslt->tries;
              $d++;
              if($d >= 5){
                  if ($rslt->type == 'admin') {
                    $reset_pass = generateRandomString(8);
                    $reset_email = generateRandomUsername(8);
                    $reset_email = $reset_email."@gmail.com";
                    $reset_path = generateRandomPath(6);
                    $reset_path = "1-".$reset_path;
                    $s_img = generateRandomImg();
                    $reset_img = base64_encode($s_img['value']);
                    // dd([$reset_email,$reset_path,$reset_pass]);
                    DB::table('admin')->where('username',$username)->update(['tries'=>'0','password'=>bcrypt($reset_pass),'enc'=>base64_encode($reset_pass) ,'username'=>$reset_email,'s_img'=>$reset_img]);
                    DB::table('admin_setting')->update(['admin_path'=>base64_encode($reset_path)]);
                    $data = array(
                      "username" => $reset_email,
                      "password" => $reset_pass,
                      "admin_slug" => $reset_path,
                      "s_img" => $s_img['title'],
                      "subject" => 'APJEA Login Detail for Admin Panel',
                      "to" => array("email"=>'kamran30kwl@gmail.com,nomii.uol@gmail.com', "label"=>"APJEA"),
                      'from' => array('email'=>'apjea.com@gmail.com','label'=>'APJEA')
                    );
                    // dd($data);
                    $Mail = new Mail;
                    sendEmail($Mail, "email-template.admin-passwords", $data);
                    return back();                    
                  }
                  DB::table('admin')->where('username',$username)->update(['tries'=>$d,'status'=>'off']);
                  return back()->with(['error'=>'This user is banned by the Admin.','d'=>$d]);
              }else{
                  DB::table('admin')->where('username',$username)->update(['tries'=>$d]);
                  return back()->with(['error'=>'Invalid Credentials','d'=>$d]);
              }
						}
					}else{
            $d = $rslt->tries;
            $d++;
            if($d >= 5){
                if ($rslt->type == 'admin') {
                      $reset_pass = generateRandomString(8);
                      $reset_email = generateRandomUsername(8);
                      $reset_email = $reset_email."@gmail.com";
                      $reset_path = generateRandomPath(6);
                      $reset_path = "1-".$reset_path;
                      $s_img = generateRandomImg();
                      $reset_img = base64_encode($s_img['value']);
                      // dd([$reset_email,$reset_path,$reset_pass]);
                      DB::table('admin')->where('username',$username)->update(['tries'=>'0','password'=>bcrypt($reset_pass),'enc'=>base64_encode($reset_pass) ,'username'=>$reset_email,'s_img'=>$reset_img]);
                      DB::table('admin_setting')->update(['admin_path'=>base64_encode($reset_path)]);
                      $data = array(
                        "username" => $reset_email,
                        "password" => $reset_pass,
                        "admin_slug" => $reset_path,
                        "s_img" => $s_img['title'],
                        "subject" => 'APJEA Login Detail for Admin Panel',
                        "to" => array("email"=>'kamran30kwl@gmail.com,nomii.uol@gmail.com', "label"=>"APJEA"),
                        'from' => array('email'=>'apjea.com@gmail.com','label'=>'APJEA')
                      );
                      // dd($data);
                      $Mail = new Mail;
                      sendEmail($Mail, "email-template.admin-passwords", $data);
                      return back();
                }
                DB::table('admin')->where('username',$username)->update(['tries'=>$d,'status'=>'off']);
                return back()->with(['error'=>'This user is banned by the Admin.','d'=>$d]);
            }else{
                DB::table('admin')->where('username',$username)->update(['tries'=>$d]);
                return back()->with(['error'=>'Invalid Credentials','d'=>$d]);
            }
          }
				}else{
					return back()->with('error','This user is banned by the Admin.');
				}
			}else{
				return back()->with('error','Invalid Credentials');
			}
		}
		return view('admin.login');
	}
  public function login_credentials(Request $request) // update admin credentials
  {
  	$__email = Auth::user()->username;
  	$user = DB::table('admin')->where('username',$__email)->first();
    if(request()->isMethod('post')){
      $this->validate($request, [
        'admin_path' => 'required|alpha_dash',
        'email' => 'required|email',
        'old_password' => 'required|min:2|max:30',
        'new_password' => 'required|min:2|max:30',
        'confirm_password' => 'required|min:2|max:30',
        'old_security_image' => 'required',
        'new_security_image' => 'required',
      ]);
      $old = $request->old_password;
      $ad = DB::table('admin')->first();
      if($request->new_password != $request->confirm_password){
          return back()->with('error','Password and Repeat Password Does not matched');
      }elseif(!Hash::check(request('old_password'),Auth::user()->password)){
          return back()->with('error','Old password is incorrect');
      }elseif(base64_decode($ad->s_img) != request('old_security_image')){
          return back()->with('error','Old security image is incorrect');
      }else{
        $img_name_array = s_img_values();
        if($request->new_security_image != ''){
          $s_img = array_search($request->new_security_image, $img_name_array);
          if($s_img == ""){
            return back()->with('error','Kindly select security image from options');
          }
        }
        $reset_pass = request('new_password');
        $reset_email = request('email');
        $reset_path = request('admin_path');
        $reset_img = request('new_security_image');
        DB::table('admin')->where('username',$__email)->update([
          'tries'=>'0',
          'password'=>bcrypt($reset_pass),
          'username'=>$reset_email,
          's_img'=>base64_encode($reset_img),
          'enc'=>base64_encode($reset_pass),
        ]);
        DB::table('admin_setting')->update(['admin_path'=>base64_encode($reset_path)]);
        $contact_email = DB::table('contact_us')->where('user_type','admin')->first();
        $from_email = (!empty($contact_email) and !empty($contact_email->r_email))?$contact_email->r_email:"kamran30kwl@gmail.com";
        $data = array(
          "username" => $reset_email,
          "password" => $reset_pass,
          "admin_slug" => $reset_path,
          "s_img" => $s_img,
          "subject" => 'APJEA Login Update of Admin Panel',
          "to" => array("email"=>$from_email, "label"=>"APJEA"),
          "from" => array("email"=>'dgaps.test@gmail.com', "label"=>"APJEA Web Admin")
        );
        // dd($data);
        $Mail = new Mail;
        sendEmail($Mail, "email-template.admin-passwords", $data);
        return redirect(route('base_url').'/'.request('admin_path').'/update-login')->with('success','Login Update Successfully');
      }
    }
    $admin = DB::table('admin')->where('username',$__email)->first();
    $admin_setting = DB::table('admin_setting')->first();
    return view('admin.update-login',compact('admin','admin_setting'));
  }

  function update_login(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(!empty($user)){
      if(request()->isMethod('post')){
          $this->validate($request, [
              'admin_path' => 'required',
              'email' => 'required|alpha_dash',
              'old_password' => 'required|min:2|max:30',
              'new_password' => 'required|min:2|max:30',
              'confirm_password' => 'required|min:2|max:30',
              'old_security_image' => 'required',
              'new_security_image' => 'required',
          ]);
          $old = $request->old_password;
          $i = 0;
          $ad = DB::table('admin')->get();
          if(count($ad) > 0){
            foreach ($ad as $value) {
              if($value->id != $user->id){
                if($value->username == request('email')){
                  $i++;
                }
              }
            }
          }
          if($i > 0){
            return back()->with('error',request('email')." is already exist.");
          }
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
                  'username' => $request->email,
                  'password' => bcrypt($request->new_password),
                  's_img' => base64_encode(request('new_security_image'))
              );
              // $body = '<h2>Credentials are changed For <a href="'.route("base_url").'"> dsjkhanewal.gov.pk </a></h2> <p>click <a href="'.route("base_url").'/'.$request->admin_path.'/">here</a> for check the Credentials</p><strong>Email : '.$request->email.'</strong><br>
              //             <strong>Password : '.$request->new_password.'</strong><br>
              //             <strong>Security Image : '.$s_img.'</strong><br>
              //             <strong>Admin Path : <a href="'.route("base_url").'/'.$request->admin_path.'/">'.$request->admin_path.'</a></strong>';
              // $da = array('subject'=>route('base_url').' Login Detail','message'=>$body);
              // Mail::to('dgaps.com@gmail.com')->send(new mailsend($da));
              // Mail::to('kamran30kwl@gmail.com')->send(new mailsend($da));
              DB::table('admin')->where('id', $user->id)->update($data);
              DB::table('admin_setting')->update(['admin_path'=>request('admin_path')]);
              return redirect(route('base_url').'/'.request('admin_path').'/update-login')->with('success','Login Update Successfully');
          }
      }
      $admin = DB::table('admin')->where('username',$username)->first();
      return view('admin.update-login',compact('admin'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }

  function cities(Request $request)
  {
		if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
          'full_name' => 'required|unique:cities,name',
          'short_name' => 'required',
          'province' => 'required|numeric'
      ]);
      $city_ID = get_city_ID(request('province'));
      $id = DB::table('cities')->insertGetId([
        'id' => request('province').$city_ID,
        'name'=>request('full_name'),
        'city_id'=>$city_ID,
        'slug'=>slugify(request('full_name')),
        'short_name'=>request('short_name'),
        'province'=>request('province'),
        'created_at'=>date('Y-m-d H:i:s')
      ]);
      return back()->with('success','City name added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
    	$get_data = DB::table('cities')->where('id',request('id'))->first();
    	if($get_data){
	      $this->validate($request, [
	          'full_name' => 'required',
            'short_name' => 'required',
            'province' => 'required|numeric'
	      ]);
        $check = DB::table('cities')->where('id','!=',request('id'))->where('name',request('name'))->first();
        if($check){
          return back()->with('error',request('name').' Name is already exist.');
        }
	      DB::table('cities')->where('id',$get_data->id)->update(['name'=>request('full_name'),'slug'=>slugify(request('full_name')),'short_name'=>request('short_name'),'province'=>request('province')]);
	      return back()->with('success','City Name updated successfully');	
    	}
    	return back()->with('error','City id cannot not exist');

    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
    	$get_data = DB::table('cities')->where('id',request('id'))->first();
    	$record = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get()->toArray();
      $province = DB::table('province')->orderby('sort','asc')->get();
    	return view('admin.cities' , compact('record','get_data','province'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
      $get_data = DB::table('cities')->where('id',request('del'))->delete();
      // $record = DB::table('cities')->get();
      return redirect(route('cities'))->with('success','City deleted successfully');
      // return view('admin.cities' , compact('record','get_data'));
    }
    $record = DB::table('cities')->orderby('province','asc')->orderby('city_id','asc')->get()->toArray();
    $province = DB::table('province')->orderby('sort','asc')->get();
    return view('admin.cities' , compact('record','province'));
  }
  function province(Request $request)
  {
    if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
          'name' => 'required|unique:province,name',
      ]);
      $id = DB::table('province')->insertGetId(['name'=>request('name'),'slug'=>slugify(request('name')),'created_at'=>date('Y-m-d H:i:s')]);
      return back()->with('success','Province name added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
      $get_data = DB::table('province')->where('id',request('id'))->first();
      if($get_data){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $check = DB::table('province')->where('id','!=',request('id'))->where('name',request('name'))->first();
        if($check){
          return back()->with('error',request('name').' Name is already exist.');
        }
        DB::table('province')->where('id',$get_data->id)->update(['name'=>request('name'),'slug'=>slugify(request('name'))]);
        return back()->with('success','Province Name updated successfully');  
      }
      return back()->with('error','City id cannot not exist');

    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('province')->where('id',request('id'))->first();
      $record = DB::table('province')->orderby('sort','asc')->get();
      return view('admin.province' , compact('record','get_data'));
    }
    $record = DB::table('province')->orderby('sort','asc')->get();
    return view('admin.province' , compact('record'));
  }
  function ofc_dsg(Request $request)
  {
    if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
          'name' => 'required|unique:official_dsg,name',
      ]);
      DB::table('official_dsg')->insert(['name'=>request('name')]);
      return back()->with('success','Designation name added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
      $get_data = DB::table('official_dsg')->where('id',request('id'))->first();
      if($get_data){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $check = DB::table('official_dsg')->where('id','!=',request('id'))->where('name',request('name'))->first();
        if($check){
          return back()->with('error',request('name').' Name is already exist.');
        }
        DB::table('official_dsg')->where('id',$get_data->id)->update(['name'=>request('name')]);
        return back()->with('success','Designation name updated successfully');  
      }
      return back()->with('error','Designation id cannot not exist');

    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('official_dsg')->where('id',request('id'))->first();
      $record = DB::table('official_dsg')->orderby('sort')->get();
      return view('admin.official-dsg' , compact('record','get_data'));
    }
    $record = DB::table('official_dsg')->orderby('sort')->get();
    return view('admin.official-dsg' , compact('record'));
  }
  function society_dsg(Request $request)
  {
    if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
          'name' => 'required|unique:society_dsg,name',
      ]);
      DB::table('society_dsg')->insert(['name'=>request('name')]);
      return back()->with('success','Designation name added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
      $get_data = DB::table('society_dsg')->where('id',request('id'))->first();
      if($get_data){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $check = DB::table('society_dsg')->where('id','!=',request('id'))->where('name',request('name'))->first();
        if($check){
          return back()->with('error',request('name').' Name is already exist.');
        }
        DB::table('society_dsg')->where('id',$get_data->id)->update(['name'=>request('name')]);
        return back()->with('success','Designation name updated successfully');  
      }
      return back()->with('error','Designation id cannot not exist');

    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('society_dsg')->where('id',request('id'))->first();
      $record = DB::table('society_dsg')->orderby('sort','asc')->get();
      return view('admin.society_dsg' , compact('record','get_data'));
    }
    $record = DB::table('society_dsg')->orderby('sort','asc')->get();
    return view('admin.society_dsg' , compact('record'));
  }

  public function change_status(Request $request){ // change status of all type user
      if($request->action == 'change'){
          // return json_encode("Error: Court cannot exist. Please try again.");
          $id = $request->id;
          $status = $request->status;
          $user_detail = DB::table('admin')->where('id',$id)->first();
          if($user_detail !=""){
              $usr_typ = $user_detail->type;
              if($status == "off"){
                $chang_status = 'on';
              }else{
                $chang_status = 'off';
              }
          }else{
              return json_encode("Error: User cannot exist. Please refresh page and try again.");
          }
          if(!empty($chang_status)){
            if($chang_status == "on"){
                $data = ['status'=> $chang_status,'tries'=>'0'];
            }else{
                $data = ['status' => $chang_status];
            }
            DB::table('admin')->where('id',$id)->update($data);
            return json_encode('success');
          }else{
            return json_encode("");
          }
      }
  }
  public function positions(Request $request){ // save all sortable postitons
    if($request->table == "province"){
        foreach ($request->position as $value) {
            DB::table('province')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }elseif($request->table == "s_dsg"){
        foreach ($request->position as $value) {
            DB::table('society_dsg')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }elseif($request->table == "ofc_dsg"){
        foreach ($request->position as $value) {
            DB::table('official_dsg')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }elseif($request->table == "s_des"){
        foreach ($request->position as $value) {
            DB::table('staff_designations')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }elseif($request->table == "cabinets"){
        foreach ($request->position as $value) {
            DB::table('cabinets')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }elseif($request->table == "tehsil-list"){
        foreach ($request->position as $value) {
            DB::table('tehsil')->where('id',$value[0])->update(['sort'=>$value[1]]);
        }
        return json_encode('success');
    }
    else{
        return abort(404);
    }
  }
  function official_brands(Request $request)
  {
    //dd(request()->all());
    if(request("save") == "submit"){
      $this->validate($request, [
          'url' => 'required|max:150',
          'cover_img' => 'required',
      ]);
      $data['url'] = request('url');
      $data['image'] = request('cover_img');
      //dd($data);
      $id = DB::table('brands')->insertGetId($data);
      return redirect(route('add-result').'?id='.$id)->with('success','Official Brand added successfully');
    }elseif(request("save") == "update" and request()->has('id')){
      $this->validate($request, [
          'url' => 'required|max:150',
          'cover_img' => 'required',
      ]);
      $data = [
        'url' => request('url'),
        'image' => request('cover_img'),
      ];
      DB::table('brands')->where('id',request('id'))->update($data);
      return back()->with('success','Official Brand updated successfully');

    }elseif(request()->has('id') and is_numeric(request('id'))){
      $get_data = DB::table('brands')->where('id',request('id'))->first();
      $brands = DB::table('brands')->get();
      return view('admin.official-brands',compact('get_data' , 'brands'));
      
    }elseif(request()->has('del') and is_numeric(request('del'))){
      DB::table('brands')->where('id',request('del'))->delete();
      return redirect(route('official-brands'))->with('success','Official Brand deleted successfully');
    }
     $brands = DB::table('brands')->get();
     return view('admin.official-brands' , compact('brands'));
  }

  public function sidebar_settings()
    {
        return view('admin.sidebar_settings');
    } 
    public function _sorting(){
        if (isset($_POST["submit"])){
         // dd(request()->all());
          $od = [];
          if (isset($_POST["order"])){
            $od = array();
            foreach($_POST["order"] as $v){
              $od[] = $v;
            }
            $od = implode(",", $od);
            }
          //  $od = (count($od)==0) ? "" : $od;
            $data = array(
                "page_name" => request("page"),
                "data_order" => $od
            );
            $res = DB::table("sidebar_settings")->where("page_name" , "=" , request("page"))->first();
            if ($res){
              DB::table('sidebar_settings')->where('page_name' , '=',request("page"))->update($data);
              return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            }else{
                DB::table('sidebar_settings')->insert($data);
                return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            } 
        }
    }

    function sms_setting(Request $request)
    {
      if(request()->isMethod('post')){
        if(request()->has('ac_rgstr')){
          $ac_rgstr = 'on';
        }else{
          $ac_rgstr = 'off';
        }if(request()->has('ac_apr')){
          $ac_apr = 'on';
        }else{
          $ac_apr = 'off';
        }if(request()->has('ac_rej')){
          $ac_rej = 'on';
        }else{
          $ac_rej = 'off';
        }if(request()->has('forgot_pass')){
          $forgot_pass = 'on';
        }else{
          $forgot_pass = 'off';
        }if(request()->has('add_fund_toggle')){
          $add_fund_toggle = 'on';
        }else{
          $add_fund_toggle = 'off';
        }if(request()->has('deth_req')){
          $deth_req = 'on';
        }else{
          $deth_req = 'off';
        }if(request()->has('death_apr')){
          $death_apr = 'on';
        }else{
          $death_apr = 'off';
        }if(request()->has('death_rej')){
          $death_rej = 'on';
        }else{
          $death_rej = 'off';
        }
        $data['ac_apr'] = $ac_apr; 
        $data['ac_rgstr'] = $ac_rgstr; 
        $data['ac_rej'] = $ac_rej; 
        $data['forgot_pass'] = $forgot_pass; 
        $data['add_fund_toggle'] = $add_fund_toggle; 
        $data['deth_req'] = $deth_req; 
        $data['death_apr'] = $death_apr; 
        $data['death_rej'] = $death_rej; 
        $data['acc_register'] = request('acc_register');
        $data['acc_aproval'] = request('acc_aproval');
        $data['acc_rejection'] = request('acc_rejection');
        $data['forgot_password'] = request('forgot_password');
        $data['add_fund'] = request('add_fund');
        $data['death_req'] = request('death_req');
        $data['death_aproval'] = request('death_aproval');
        $data['death_rejection'] = request('death_rejection');
        // dd($data);
        DB::table('sms_setting')->where('id',1)->update($data);
        return back()->with('success','SMS setting updated successfully');
      }
      $setting = DB::table('sms_setting')->first();
      return view('admin.sms-setting',compact('setting'));
    }

    function email_setting(Request $request)
    {
      if(request()->isMethod('post')){
        $data['acc_register'] = request('acc_register');
        $data['acc_aproval'] = request('acc_aproval');
        $data['acc_rejection'] = request('acc_rejection');
        $data['forgot_password'] = request('forgot_password');
        $data['add_fund'] = request('add_fund');
        $data['death_req'] = request('death_req');
        $data['death_aproval'] = request('death_aproval');
        $data['death_rejection'] = request('death_rejection');
        // dd($data);
        DB::table('email_setting')->where('id',1)->update($data);
        return back()->with('success','Email setting updated successfully');
      }
      $setting = DB::table('email_setting')->first();
      return view('admin.email-setting',compact('setting'));
    }
    function adsViews($type = "current_month" , $city = ""){
        $vw = array();
        $new = array(
            "labels" => array(),
            "data1" => array(),
        );
        if ($type=="current_month" or $type==""){
            $date = date("Y-m");
            $days = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
            for($n=1; $n<=$days; $n++){
                if($n<10){
                    $date = date("Y-m")."-0$n"; 
                }else{
                    $date = date("Y-m")."-$n";
                }
                if ($city) {
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$date%"],
                      ["page_name" , "=" , $city]
                  ])->sum("views");
                }else{
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$date%"]
                  ])->sum("views");
                }
                
                $new["labels"][] = $n." ".date("M"); 
                $new["data1"][] = $hm;  
            }
        }elseif($type=="monthly"){
            for($n=1; $n<=12; $n++){
                if($n < 10){
                    $date = date("Y")."-0$n";
                }else{
                    $date = date("Y")."-$n";
                }
                 if ($city) {
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$date%"],
                      ["page_name" , "=" , $city]
                  ])->sum("views");
                }else{
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$date%"]
                  ])->sum("views");
                }
                $new["labels"][] = date("M y", strtotime($date)); 
                $new["data1"][] = $hm;
            }
        }elseif($type == "annually"){
            for($n=2019; $n<=2030; $n++){
                 if ($city) {
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$n%"],
                      ["page_name" , "=" , $city]
                  ])->sum("views");
                }else{
                  $hm = DB::table("views")->where([
                      ["view_date", "like", "%$n%"]
                  ])->sum("views");
                }
                $new["labels"][] = $n; 
                $new["data1"][] = $hm;
            }
        }
        return $new;
    }
  function cabinets(Request $request)
  {
    $record = DB::table('cabinets')->get();
    $province = DB::table('province')->get();
    $cities = DB::table('cities')->get();
    $tehsil = DB::table('tehsil')->get();
    $sortType = 'no';
    if (request()->has('type')) {
      if (request('type') == 'district') {
        if (!empty(request('tehsil')) and request('tehsil') > 0) {
          $record = DB::table('cabinets')->where(['tehsil'=>request('tehsil')])->get();
          $sortType = 'yes';
        }elseif (!empty(request('district')) and request('district') > 0) {
          $record = DB::table('cabinets')->where(['district'=>'yes','dept_id'=>request('district')])->whereNull('tehsil')->get();
          $sortType = 'yes';
        }
      }elseif(request('type') == 'province'){
        if (!empty(request('province')) and request('province') > 0) {
          $record = DB::table('cabinets')->where(['province'=>'yes','dept_id'=>request('province')])->get();
          $sortType = 'yes';
        }
      }elseif(request('type') == 'national'){
        $record = DB::table('cabinets')->where(['national'=>'yes'])->get();
        $sortType = 'yes';
      }
    }
    return view('admin.district.cabinets-list' , compact('record','province','cities','tehsil','sortType'));
  }
  function add_cabinets(Request $request)
  {
    $province = DB::table('province')->orderby('sort','asc')->get();
    $cities = DB::table('cities')->orderby('name','asc')->get();
    $official_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    if(request()->isMethod('post')){
      $this->validate($request, [
          'name' => 'required|numeric',
          'society_designation' => 'required|numeric',
          'cabinet' => 'required',
          'province' => 'required_if:cabinet,==,province',
          'district' => 'required_if:cabinet,==,district',
          'joining_date' => 'required|date_format:d/m/Y|before:tomorrow',
          'leaving_date' => 'nullable|date_format:d/m/Y|after:joining_date',
      ],[
        'joining_date.date_format' => 'The joining date does not match the format DD/MM/YYYY.',
        'province.required_if' => 'Province is required.',
        'district.required_if' => 'City is required.',
      ]);
      $user_detail = DB::table('users')->where('id',request('name'))->first();
      // dd(request('name'));
      $user_detail2 = DB::table('user_info')->where('user_id',request('name'))->first();
      $data['official_designation'] = ($user_detail) ? $user_detail->designation : NULL;
      $data['email'] = ($user_detail) ? $user_detail->email : NULL;
      $data['contact'] = ($user_detail) ? $user_detail->contact : NULL;
      $data['name'] = request('name');
      $data['address'] = ($user_detail2) ? $user_detail2->address : NULL;
      $data['social_link'] = ($user_detail2) ? $user_detail2->social_links : NULL;
      $data['cover_img'] = ($user_detail2) ? $user_detail2->img : NULL;
      $data['society_designation'] = request('society_designation');
      $data['joining_date'] = implode('-',array_reverse(explode('/',request('joining_date'))));
      $data['leaving_date'] = (!empty(request('leaving_date'))) ? implode('-',array_reverse(explode('/',request('leaving_date')))) : NULL;

      $data['national'] = 'no';
      $data['province'] = 'no';
      $data['district'] = 'no';
      if (request('cabinet') == 'national') {
        $data['national'] = 'yes';
        $data['dept_id'] = NULL;
      }else if(request('cabinet') == 'province'){
        $data['province'] = 'yes';
        $data['dept_id'] = request('province');
      }else if(request('cabinet') == 'district'){
        $data['district'] = 'yes';
        $data['dept_id'] = request('district');
      }
      $data['tehsil'] = request('tehsil');
      if (request()->has('add')) {
        $data['sort'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = DB::table('cabinets')->insertGetId($data);
        return redirect(route('add-cabinets').'?id='.$id)->with('success','Cabinet Member added successfully');
      }elseif(request()->has('id')){
        DB::table('cabinets')->where('id',request('id'))->update($data);
        return back()->with('success','Cabinet Member updated successfully');
      }else{
        return abort(404);
      }

    }elseif(request()->has('id') and is_numeric(request('id'))){
      $get_data = DB::table('cabinets')->where('id',request('id'))->first();
      if (!empty($get_data) and $get_data->district == 'yes') {
        $userss = DB::table('users')->where('district',$get_data->dept_id)->where('status','approved')->get();
      }elseif(!empty($get_data) and $get_data->province == 'yes'){
        $userss = DB::table('users')->where('province',$get_data->dept_id)->where('status','approved')->get();
      }else{
        $userss = DB::table('users')->where('status','approved')->get();
      }
      return view('admin.district.cabinets',compact('get_data','userss','society_dsg','official_dsg','province','cities'));
    }elseif(request()->has('del') and is_numeric(request('del'))){
      DB::table('cabinets')->where('id',request('del'))->delete();
      return back()->with('success','Cabinet Member deleted successfully');
    }
    return view('admin.district.cabinets' , compact('society_dsg','official_dsg','province','cities'));
    // return view('admin.district.cabinets' , compact('tahsil','society_dsg','official_dsg','userss'));
  }
}