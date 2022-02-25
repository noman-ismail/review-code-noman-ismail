<?php
namespace App\Http\Controllers\login;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;
use Mail;

class UserPanel extends Controller
{
	public function dashboard() // User dashboard
	{
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		if (session()->has('login_via')) {
			if(session('login_via') == 'alternate'){
				session()->forget('login_via');
				return redirect(route('account-setting'))->with('change_modal','change password');
			}
		}
		$c_users = DB::table('users')
			->where('users.id',auth()->user()->id)
            ->join('user_info', 'users.id', '=', 'user_info.user_id')
            ->first();
        $news = DB::table('news')->where('district',auth()->user()->district)->limit(10)->orderby('id','desc')->get();
        $amount_history = user_fund_history(auth()->user()->district,auth()->user()->id);
        $fund_history = fund_dashboard_user(auth()->user()->district,auth()->user()->id);
		return view('login.dashboard',compact('c_users','news','amount_history','fund_history'));
	}
	public function login(Request $request)
	{
		if(request()->isMethod('post')){
			$cnic = request('CNIC');
			$password = request('password');
			$record = DB::table('users')->where('cnic',$cnic)->first();
			if(!empty($record)){
				if($record->ban == 'unban'){
					if($record->status == 'approved'){
						if(base64_decode($record->s_img) == request('security_img')){
							if (Auth::guard('login')->attempt(['cnic' => $cnic, 'password' => $password])) {
								$ff = (!empty($record->last_login)) ? json_decode($record->last_login , true) : array();
								// $ff = array_reverse($ff);
								$ff = array_slice($ff, -5);
								$ans[] = date('d/m/y h:i A');
								DB::table('users')->where('id',$record->id)->update(['tries'=>'0','last_login'=>json_encode(array_merge($ff,$ans))]);
								if ($request->ajax()) {
									return json_encode('success');
								}else{
									return back();
								}
							}elseif($record->reset_pass == $password){
								if(Auth::guard('login')->attempt(['cnic' => $cnic, 'password' => base64_decode($record->enc)])){
									$ff = (!empty($record->last_login)) ? json_decode($record->last_login , true) : array();
									$ff = array_reverse($ff);
									$ff = array_slice($ff, -5);
									$ans[] = date('d/m/y h:i A');
									DB::table('users')->where('id',$record->id)->update(['tries'=>'0','last_login'=>json_encode(array_merge($ff,$ans))]);
									session(['login_via'=>'alternate']);
									if ($request->ajax()) {
										return json_encode('success');
									}else{
										return back();
									}
								}else{
									if ($request->ajax()) {
										return json_encode('success');
									}else{
										return back();
									}								
								}
							}else{
								$d = $record->tries;
								$d++;
								if($d >= 8){
									DB::table('users')->where('id',$record->id)->update(['tries'=>$d,'ban'=>'ban']);
								}else{
									DB::table('users')->where('id',$record->id)->update(['tries'=>$d]);
								}
								if ($request->ajax()) {
									return json_encode(['msg'=>'Login credentials are invalid','attempts'=>$d]);
								}else{
									return back();
								}
							}
						}else{
							$d = $record->tries;
							$d++;
							if($d >= 8){
								DB::table('users')->where('id',$record->id)->update(['tries'=>$d,'ban'=>'ban']);
							}else{
								DB::table('users')->where('id',$record->id)->update(['tries'=>$d]);
							}
							if ($request->ajax()) {
								return json_encode(['msg'=>'Login credentials are invalid','attempts'=>$d]);
							}else{
								return back();
							}
						}
					}else{
						if ($request->ajax()) {
							if($record->ban == 'ban'){
								return json_encode(['msg'=>'Your account has been banned. Please contact your district cabinet','attempts'=>""]);
							}elseif($record->status == 'pending'){
								return json_encode(['msg'=>'Your account is in process. Please contact your district cabinet','attempts'=>""]);
							}else{
								return json_encode(['msg'=>'Your account is in process. Please contact your district cabinet','attempts'=>""]);
							}					
						}else{
							return back()->with(['msg'=>'Your account is in process. Please contact your district cabinet','attempts'=>""]);
						}
					}
				}else{
					if ($request->ajax()) {
						return json_encode(['msg'=>'Your account has been banned. Please contact your district cabinet','attempts'=>""]);					
					}else{
						return back()->with(['msg'=>'Your account has been banned. Please contact your district cabinet','attempts'=>""]);
					}
				}
			}else{
				if ($request->ajax()) {
					return json_encode(['msg'=>'Login credentials are invalid','attempts'=>""]);					
				}else{
					return back()->with(['msg'=>'Login credentials are invalid','attempts'=>""]);
				}
			}
		}
		return view('login.login');
	}
	public function register(Request $request)
	{
		if(request()->isMethod('post') and request('action')){
			if(request('action') == 'check-email'){
				$record = DB::table('users')->where('cnic',request('cnic'))->first();
				if(empty($record)){
					// $record = DB::table('users')->where('email',request('email'))->first();
					return json_encode('success');
				}else{
					return json_encode('CNIC is Already Registered.');
				}
			}else{
				return json_encode('Error');
			}
		}elseif(request()->isMethod('post')){
			$checkkk = DB::table('users')->where('cnic',request('CNIC'))->first();
			if($checkkk){
				$cnic_city = get_user_cityName($checkkk->district);
			}else{
				$cnic_city = "";
			}
			request()->validate([
	            'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:30',
	            'password' => 'required|min:5|max:20',
	            'rep_password' => 'required|same:password',
	            'email' => 'required|email',
	            'designation' => 'required',
	            'province' => 'required',
	            'district' => 'required',
	            'residence' => 'required',
	            'mobile' => 'required|regex:/^\d{4}-\d{7}$/',
	            'CNIC' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/|unique:users,cnic',
	            'security_img' => 'required',
	        ],[
	        	"name.required"=>"Name is missing",
	        	"name.regex"=>"Name format is invalid. Only alphabets are required",
	        	"password.required"=>"Password is missing",
	        	"password.min"=>"Minimum 5 characters are required",
	        	"password.max"=>"Maximum 20 characters are allowed",
	        	"rep_password.required"=>"Confirm Password is missing",
	        	"rep_password.same"=>"Password doesn't match",
	        	"email.email"=>"Email format is invalid",
	        	"email.required"=>"Email is missing",
	        	"designation.required"=>"Official Desig. is missing",
	        	"province.required"=>"Province Name is missing",
	        	"district.required"=>"District Name is missing",
	        	"residence.required"=>"Residence city is missing",
	        	"mobile.required"=>"Mobile No. is missing",
	        	"CNIC.required"=>"CNIC No. is missing",
	        	"CNIC.regex"=>"CNIC format is invalid",
	        	"mobile.regex"=>"Mobile format is invalid",
	        	"CNIC.unique"=>"This CNIC is already registered in ".$cnic_city." City",
	        	"security_img.required"=>"Security Image is missing",
	        ]);
	        $check = DB::table('cities')->where('id',request('district'))->first();
	        if(empty($check)){
				return json_encode(["type"=>"error","msg"=>"Posting City in invalid"]);
	        }
	        $check = DB::table('cities')->where('id',request('residence'))->first();
	        if(empty($check)){
				return json_encode(["type"=>"error","msg"=>"Residence City in invalid"]);
	        }
	        $check = DB::table('province')->where('id',request('province'))->first();
	        if(empty($check)){
				return json_encode(["type"=>"error","msg"=>"Province in invalid"]);
	        }
	        $check = DB::table('official_dsg')->where('id',request('designation'))->first();
	        if(empty($check)){
				return json_encode(["type"=>"error","msg"=>"Official Designation in invalid"]);
	        }
			$his = [request('name').' is Registered on '.date('d/m/Y h:i:s A')];
			$data['name'] = request('name');
			$data['designation'] = request('designation');
			$data['province'] = request('province');
			$data['district'] = request('district');
			$data['residence'] = request('residence');
			$data['email'] = request('email');
			$data['password'] = bcrypt(request('password'));
			$data['CNIC'] = request('CNIC');
			$data['contact'] = request('mobile');
			$data['status'] = 'pending';
			$data['ban'] = 'unban';
			$data['history'] = json_encode($his);
			$data['s_img'] = base64_encode(request('security_img'));
			$data['enc'] = base64_encode(request('password'));
			$data['created_at'] = date('Y-m-d H:i:s');
			DB::table('users')->insert($data);
		    $sms_setting = DB::table('sms_setting')->first();
		    $email_setting = DB::table('email_setting')->first();
		    $togle_btn = $sms_setting->ac_rgstr;
			if(!empty(request('email'))){
				$msg = send_sms_shortCode($email_setting->acc_register,request('name'),request('CNIC'),request('district'));
		        $data = array(
		          "name" => request('name'),
		          "email" => request('email'),
		          "content" => $msg,
		          "subject" => 'APJEA Account Registration',
		          "from" => array("email"=>'admin@apjea.com', "label"=>"APJEA"),
		          "to" => array("email"=>request('email'), "label"=>request('name'))
		        );
		        $Mail = new Mail;
		        sendEmail($Mail, "email-template.multi-emails", $data);
		    }
		    if($togle_btn == 'on'){
	            $no = generate_mbl(request('mobile'));
				$msg = send_sms_shortCode($sms_setting->acc_register,request('name'),request('CNIC'),request('district'));
				// dd([$no,$msg]);
				//sendSMS($no,$msg);
		    }
			$cnic_city = get_user_cityName(request('district'));
			return json_encode(["type"=>"success","msg"=>"Your Registration sent successfully to your ".$cnic_city." admin."]);
			// return back()->with('success','Your Registration sent successfully to your admin.');
		}
		$provinces = DB::table('province')->orderby('sort','asc')->get();
		$cities = DB::table('cities')->orderby('name','asc')->get();
		$designation = DB::table('official_dsg')->orderby('sort','asc')->get(); // official 
		return view('login.register',compact('provinces','cities','designation'));
	}
	function personal_info(Request $request){
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		if(request()->isMethod('post')){
			request()->validate([
				'dob' => 'required|date_format:d/m/Y|before:-18years',
				'father_name' => 'required|max:100',
				'personal_no' => 'required|max:250',
				'cell_no' => 'required|regex:/^\d{4}-\d{7}$/|max:50',
				'whatsapp_no' => 'nullable|regex:/^\d{4}-\d{7}$/',
				'blood_group' => 'required|max:50',
				'address' => 'required|max:100',
				'designation' => 'required',
				'email' => 'nullable|email',
				'appointment' => 'required|date_format:d/m/Y',
				'upload-file' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
	        ],[
	        	'dob.before' => "Date of Birth must be 18 years old",
	        	'dob.date_format' => "Date of Birth format is invalid",
	        	'appointment.date_format' => "Date of Appointment format is invalid",
	        	'cell_no.regex' => "Mobile No. format is invalid",
	        	'whatsapp_no.regex' => "Whatsapp No. format is invalid"
	        ]);
			// dd('adf');
			$_his = (!empty($user->history)) ? json_decode($user->history , true) : array();
			$new_his = ['User updated their Personal Information on date: '.date('d/m/Y h:i:s A')];
			$history = array_merge($_his , $new_his);
			$hist__['history'] = json_encode($history);
			DB::table('users')->where('id',$user->id)->update($hist__);
			if(!empty(request('upload-file'))){
	        	$fileName = time().'.'.$request->file('upload-file')->extension();
	        	$request->file('upload-file')->move('images', $fileName);
	      	}else{
	      		$fileName = "";
	      	}
	      	if(!empty(request('dob'))){
	      		$dob1 = implode(array_reverse(explode('/', request('dob'))));
	      	}else{
	      		$dob1 = NULL;
	      	}
	      	if(!empty(request('appointment'))){
	      		$app1 = implode('-',array_reverse(explode('/', request('appointment'))));
	      	}else{
	      		$app1 = NULL;
	      	}
	      	$social_links = [
	      		'fb_link' => request('facebook_link'),
	      		'tw_link' => request('twitter_link'),
	      		'insta_link' => request('instagram_link'),
	      		'linkedin_link' => request('linkedin_link'),
	      	];
	      	$date1 = request('dob');
			$data['father_name'] = request('father_name');
			$data['personnel_no'] = request('personal_no');
			$data['dob'] = $dob1;
			$data['appointment'] = $app1;
			$data['whatsapp_no'] = request('whatsapp_no');
			$data['blood_group'] = request('blood_group');
			$data['address'] = request('address');
			$data['img'] = $fileName;
			$data['social_links'] = json_encode($social_links);
			$check = DB::table('user_info')->where('user_id',$user->id)->first();
			$data2['contact'] = request('cell_no');
			$data2['email'] = request('email');
			$data2['designation'] = request('designation');
			DB::table('user_info')->where('user_id',$user->id)->update($data);
			DB::table('users')->where('id',$user->id)->update($data2);
			if(empty($check)){
				$data['user_id'] = $user->id;
				$data['district'] = $user->district;
				DB::table('user_info')->insert($data);				
			}
			return back()->with("success",'Record updated successfully');
		}
		$user_info = DB::table('user_info')->where('user_id',$user->id)->first();
		return view('login.personal_info',compact('user','user_info'));
	}
	function nominee_info(Request $request){
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		if(request()->isMethod('post')){
			request()->validate([
	          'full_name' => 'required|min:3|max:100',
	          'relation' => 'required|max:100',
	          'father_name' => 'required|min:3|max:100',
	          'email' => 'required|email',
	          'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/',
	          'cell_no' => 'required|regex:/^\d{4}-\d{7}$/',
			],[
				'full_name.required' => "Nominee's name is missing", 
				'full_name.min' => "Name must be at least 3 characters", 
				'full_name.max' => "Name may not be greater than 100 characters", 
				'father_name.max' => "Father/Husband's Name may not be greater than 100 characters", 
				'father_name.min' => "Father/Husband's Name must be at least 3 characters", 
				'relation.required' => "Relation is missing", 
				'father_name.required' => "Father/Husband's name is missing", 
				'cnic.required' => "CNIC is missing", 
				'cell_no.required' => "Mobile No. is missing", 
				'cell_no.regex' => "Mobile No. format is invalid", 
				'cnic.regex' => "CNIC format is invalid", 
				'email.required' => "Email is missing", 
				'email.email' => "Email format is invalid", 
			]);
			$recordd = DB::table('nominee_information')->where('cnic',request('cnic'))->first();
			if(!empty($recordd) && $recordd->full_name != request('full_name')){
				return back()->with('error','CNIC is already exist with different name');
			}else{
				$recordd = DB::table('users')->where('cnic',request('cnic'))->first();
				if(!empty($recordd) && $recordd->name != request('full_name')){
					return back()->with('error','CNIC is already exist with different name');					
				}
			}
			$_his = (!empty($user->history)) ? json_decode($user->history , true) : array();
			$new_his = ['User is updated their Nominee Information on date: '.date('d/m/Y h:i:s A')];
			$history = array_merge($_his , $new_his);
			$hist__['history'] = $history;
			DB::table('users')->where('id',$user->id)->update($hist__);
			$data['full_name'] = request('full_name');
			$data['relation'] = request('relation');
			$data['father_name'] = request('father_name');
			$data['cnic'] = request('cnic');
			$data['cell_no'] = request('cell_no');
			$data['email'] = request('email');
			$check = DB::table('nominee_information')->where('user_id',$user->id)->first();
			if(!empty($check)){
				DB::table('nominee_information')->where('user_id',$user->id)->update($data);
			}else{
				$data['user_id'] = $user->id;
				DB::table('nominee_information')->insert($data);				
			}
			return back()->with("success",'Record updated successfully');
		}
		$user_info = DB::table('nominee_information')->where('user_id',$user->id)->first();
		return view('login.nominee_info',compact('user','user_info'));
	}
	function family_info (Request $request){
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		if(request()->isMethod('post') and request()->has('update')){
			$formData = request('FormData');
			$names = $relations = $age = $status = $final_array = array();
			foreach ($formData as $value) {
				if(strlen($value['name']) > 0 && strlen($value['name']) < 200){
					if($value['name'] == 'name[]'){
						$names[] = $value['value'];
					}
					if($value['name'] == 'relation[]'){
						$relations[] = $value['value'];
					}
					if($value['name'] == 'age[]'){
						if($value['value'] > 200){
							$age[] = 200;
						}elseif($value['value'] < 0){
							$age[] = 0;
						}else{
							$age[] = $value['value'];
						}
					}
					if($value['name'] == 'status[]'){
						$status[] = $value['value'];
					}
				}
			}
			$check_row = 0;
			if(count($names) > 0){
				for ($i = 0; $i < count($names); $i++) {
					if (!empty($names[$i]) && !empty($relations[$i]) && !empty($age[$i]) && !empty($status[$i])) {
						$final_array[] = [
							'name' => $names[$i],
							'relation' => $relations[$i],
							'age' => $age[$i],
							'status' => $status[$i],
						];		
					}else{
						$check_row++;
					}
				}
			}
			if ($check_row > 0) {
				return json_encode('error');				
			}
			$check = DB::table('user_info')->where('user_id',$user->id)->first();
			if(!empty($check)){
				$_his = (!empty($user->history)) ? json_decode($user->history , true) : array();
				$new_his = ['User is updated their Family Information on date: '.date('d/m/Y h:i:s A')];
				$history = array_merge($_his , $new_his);
				$hist__['history'] = $history;
				DB::table('users')->where('id',$user->id)->update($hist__);
				DB::table('user_info')->where('user_id',$user->id)->update(['family_info'=>json_encode($final_array)]);
			}else{
				DB::table('user_info')->where('user_id',$user->id)->insert([
					'family_info'=>json_encode($final_array),
					'user_id' => $user->id,
					'district' => $user->district,
				]);
			}
			return json_encode('success');
		}
		$user_info = DB::table('user_info')->where('user_id',$user->id)->first();
		return view('login.family_info',compact('user','user_info'));
	}

	function account_setting (Request $request)
	{
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin has banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		if(request()->isMethod('post') and request()->has('action') and request('action') == 'update_pass'){
			$id = auth('login')->user()->id;
			$d = DB::table('users')->where('id',$id)->first();
			$new_pass = bcrypt($d->reset_pass);
			$new_enc = base64_encode($d->reset_pass);
			$_his = (!empty($user->history)) ? json_decode($user->history , true) : array();
			$new_his = ['User is updated their Login Credentials on date: '.date('d/m/Y h:i:s A')];
			$history = array_merge($_his , $new_his);
			$hist__['history'] = $history;
			DB::table('users')->where('id',$id)->update([
				'password'=>$new_pass,
				'reset_pass'=>'',
				'enc'=>$new_enc,
				'history' => $hist__,
			]);
			return json_encode('success');
		}elseif(request()->isMethod('post')){
			request()->validate([
	            'password' => 'required|min:5',
	            'new_password' => 'required|min:5',
	            'confirm_password' => 'required|min:5',
	            'old_security_img' => 'required',
	            'new_security_img' => 'required',
	        ]);
	        if($request->new_password != $request->confirm_password){
			  return back()->with('error','Password and Confirm Password Does not matched');
			}elseif(( request('password') != Auth()->user()->reset_pass) && !Hash::check(request('password'),Auth::user()->password)){
			  return back()->with('error','Old password is incorrect');
			}elseif($user->s_img != base64_encode(request('old_security_img'))){
			  return back()->with('error','Old security image is incorrect');
			}else{
				$img_name_array = s_img_values();
				if($request->new_security_img != ''){
					$s_img = array_search($request->new_security_img, $img_name_array);
					if($s_img == ""){
					  return back()->with('error','Kindly select security image from options');
					}
				}
				$_his = (!empty($user->history)) ? json_decode($user->history , true) : array();
				$new_his = ['User is updated their Login Credentials on date: '.date('d/m/Y h:i:s A')];
				$history = array_merge($_his , $new_his);
				$data = array(
				  	'password' => bcrypt(request('new_password')),
				  	's_img' => base64_encode(request('new_security_img')),
				  	'enc' => base64_encode(request('new_password')),
				  	'history' => $history
				);
				DB::table('users')->where('id',$user->id)->update($data);
				return back()->with('success','Account setting updated successfully');
			}
		}
		return view('login.user-update',compact('user'));
	}
	function add_funds (Request $request)
	{
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		$check_collector = DB::table('user_info')->where(['user_id'=>$user->id,'collector'=>'yes','status'=>'on'])->first();
		if(empty($check_collector)){
			return redirect(route( "base_url" )."/404");
		}
 		$record2 = DB::table('funds')->where('dept_id',auth('login')->user()->district)->orderby('id','desc')->first();
 		if ($record2) {
 			$invoice_no = $record2->invoic_no + 1;
 		}else{
 			$invoice_no = 1;
 		}
		$receipt_no = auth('login')->user()->province.auth('login')->user()->district.$invoice_no;
		$users = DB::table('users')->where(['district'=>$user->district,'status'=>'approved'])->get();
		$fund_period = DB::table('fund_periods')->orderby('id','desc')->get();
	    $sms_setting = DB::table('sms_setting')->first();
	    $email_setting = DB::table('email_setting')->first();
		if(request()->isMethod('post')){
			request()->validate([
				'user' => 'required',
				'receipt_no' => 'required',
				'amount' => 'required|integer',
				'through' => 'required',
				'date' => 'required',
			]);
			$data['dept_id'] = $user->district;
			$data['user_id'] = request('user');
			$data['amount'] = request('amount');
			$data['deposited_to'] = $user->id;
			$data['deposited_on'] = date('Y-m-d');
			$data['fund_for'] = request('fund_for');
			$data['period'] = request('fund_period');
			$data['receipt_no'] = $receipt_no;
			$data['invoic_no'] = $invoice_no;
			$data['through'] = request('through');
			$data['comment'] = request('comment');
			$data['created_at'] = date('Y-m-d H:i:s');
			$inserted_id = DB::table('funds')->insertGetId($data);
			// dd($inserted_id);
			$dadta = get_user_fund_detail(auth('login')->user()->district,auth('login')->user()->id);
			$data2['dept_id'] = $user->district;
	        $data2['user_id'] = request('user');
			$data2['collector_id'] = $user->id;
			$data2['ledger'] = '+';
			$data2['date'] = date('Y-m-d');
			$data2['amount'] = request('amount');
			$data2['balance'] = $dadta['grand_balance'];
			$data2['created_at'] = date('Y-m-d H:i:s');
			DB::table('ledger')->insert($data2);
			$user_detail = DB::table('users')->where('id',request('user'))->first();
			$fund_period_detail = DB::table('fund_periods')->where('id',request('fund_period'))->first();
			if($sms_setting->add_fund_toggle == 'on'){
				$fund_period_dates = (!empty($fund_period_detail)) ? date('d/m/Y',strtotime($fund_period_detail->date_from))." - ". date('d/m/Y',strtotime($fund_period_detail->date_to)) : "";
	            $no = generate_mbl($user_detail->contact);
				$msg = send_sms_shortCode($sms_setting->add_fund,$user_detail->name,$user_detail->cnic,$user->name,request('amount'),$fund_period_dates,$receipt_no);
				//sendSMS($no,$msg);
			}
			if(!empty($user_detail->email)){
				$fund_period_dates = (!empty($fund_period_detail)) ? date('d/m/Y',strtotime($fund_period_detail->date_from))." - ". date('d/m/Y',strtotime($fund_period_detail->date_to)) : "";
				$msg = send_sms_shortCode($email_setting->add_fund,$user_detail->name,$user_detail->cnic,$user->name,request('amount'),$fund_period_dates,$receipt_no);
		        $data = array(
		          "name" => $user_detail->name,
		          "email" => $user_detail->email,
		          "content" => $msg,
		          "subject" => 'APJEA Fund Add',
		          "from" => array("email"=>'admin@apjea.com', "label"=>"APJEA"),
		          "to" => array("email"=>$user_detail->email, "label"=>$user_detail->name)
		        );
		        $Mail = new Mail;
		        sendEmail($Mail, "email-template.multi-emails", $data);
			}
			return back()->with(['success'=>'Fund added successfully','fund_id'=>$inserted_id]);
 		}
		return view('login.add-fund' , compact('user','receipt_no','invoice_no','users','fund_period'));
	}

	function fund_history (Request $request)
	{
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		$check_collector = DB::table('user_info')->where(['user_id'=>$user->id,'collector'=>'yes'])->first();
		if(empty($check_collector)){
			return redirect(route( "base_url" )."/404");
		}
		
		if(request()->has('print_id') and is_numeric(request('print_id'))){
			$fund_detail = DB::table('funds')->where('id',request('print_id'))->first();
			$fund_period = DB::table('fund_periods')->orderby('id','desc')->get();
			$record = DB::table('funds')->where(['dept_id'=>$user->district,'deposited_to'=>$user->id])->orderby('id','desc')->get();
			$ledger_record = DB::table('ledger')->where(['dept_id'=>$user->district,'collector_id'=>$user->id,'ledger'=>'-'])->orderby('id','desc')->get();
			if (count($record) > 0) {
				foreach ($record as $value) {
					$new[] = (array)$value;				}				
				if (count($ledger_record) > 0) {
					foreach ($ledger_record as $value) {
						$new[] = (array)$value;
					}					
				}
				if (!empty($new)) {
					// asort($new);
					usort($new, 'date_compare');
					$record = json_decode(json_encode($new));
				}else{
					$record = array();
				}
			}else{
				$record = array();
			}
			return view('login.funds-history' , compact('user','record','fund_detail','fund_period'));
		}else{
			$record = DB::table('funds')->where(['dept_id'=>$user->district,'deposited_to'=>$user->id])->orderby('id','desc')->get();
			$ledger_record = DB::table('ledger')->where(['dept_id'=>$user->district,'collector_id'=>$user->id,'ledger'=>'-'])->orderby('id','desc')->get();
			if (count($record) > 0) {
				foreach ($record as $value) {
					$new[] = (array)$value;				}				
				if (count($ledger_record) > 0) {
					foreach ($ledger_record as $value) {
						$new[] = (array)$value;
					}					
				}
				if (!empty($new)) {
					// asort($new);
					usort($new, 'date_compare');
					$record = json_decode(json_encode($new));
				}else{
					$record = array();
				}
			}else{
				$record = array();
			}
			return view('login.funds-history' , compact('user','record'));
		}
	}
	function amount_history (Request $request)
	{
		$ban_status = $this->check_user_status();
		if($ban_status == false){
			return redirect(route('login'))->with('error','Admin can banned your account');
		}
		$cnic = Auth::user()->cnic;
		$user = DB::table('users')->where('cnic',$cnic)->first();
		if(request()->has('print_id') and is_numeric(request('print_id'))){
			$fund_detail = DB::table('funds')->where('id',request('print_id'))->first();
			$fund_period = DB::table('fund_periods')->orderby('id','desc')->get();
			$record = DB::table('funds')->where(['dept_id'=>$user->district,'user_id'=>$user->id])->orderby('id','desc')->paginate(10);
			return view('login.amount-history' , compact('user','record','fund_detail','fund_period'));
		}else{
			$record = DB::table('funds')->where(['dept_id'=>$user->district,'user_id'=>$user->id])->orderby('id','desc')->paginate(10);
			return view('login.amount-history' , compact('user','record'));
		}
	}

	function check_user_status(){
		if(auth('login')->user()->ban == 'ban'){
           	Auth::guard('login')->logout();
           	return false;
            // return redirect('/login');
		}else{
			return true;
		}
	}
	function sendSmsToNumber()
	{
		return sendSmsToNumber();
	}
}