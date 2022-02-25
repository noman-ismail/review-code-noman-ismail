<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use App\Models\Cities;
use SoapClient;
use Validator;
use Mail;
use Response;

class DistrictPanel extends Controller
{
	function dashboard()
	{
		return view('admin.district.dashboard');
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
            $this->validate($request, [
              'sms_format' => 'required',
            ]);
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
          'city' => $request->city,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'enc' => base64_encode($request->password),
          's_img' => base64_encode($request->security_image),
          'type' => 'district',
          'status' => $status,
          'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('admin')->insert($data);
        $ssdgf = DB::table('admin')->where('username',$request->username)->first();
        return redirect(route('district-u-list').'?id='.$ssdgf->id)->with('success','User added successfully');
      }else{
          return back()->with('error','Username is already exist');
      }
    }
		$society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
		return view('admin.district.add-user' , compact('society_dsg','ofc_dsg','cities'));
	}

  function district_user_list(Request $request)
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
      $user = DB::table('admin')->where('id',request('id'))->where('type','district')->first();
      $record = DB::table('admin')->where('type','district')->get();
      $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
      $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
      $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
      return view('admin.district.district-user-list',compact('user','record','society_dsg','ofc_dsg','cities'));
    }elseif(request()->has('search')){
      $search = request('search');      
      $city = request('city');
      if(!empty(trim($search)) and !empty(trim($city))){
        $record = DB::table('admin')
              ->whereRaw("MATCH(name) AGAINST('$search')")
              ->where("dept_id",$city)
              ->orderBy('id','desc')
              ->where('type','district')
              ->get();
      }elseif(empty(trim($search)) and !empty(trim($city))){
        $record = DB::table('admin')
              ->where("dept_id",$city)
              ->orderBy('id','desc')
              ->where('type','district')
              ->get();
      }elseif(!empty(trim($search)) and empty(trim($city))){
        $record = DB::table('admin')
              ->whereRaw("MATCH(name) AGAINST('$search')")
              ->orderBy('id','desc')
              ->where('type','district')
              ->get();
      }else{
        $record = DB::table('admin')->where('type','district')->get();
      }
      // dd($record);
      $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
      $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();      // dd($record);
      $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
      return view('admin.district.district-user-list',compact('record','society_dsg','ofc_dsg','cities'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
        DB::table('admin')->where('id',request('del'))->delete();
        return back()->with('success','User is deleted successfully');            
    }
    $society_dsg = DB::table('society_dsg')->orderby('sort','asc')->get();
    $ofc_dsg = DB::table('official_dsg')->orderby('sort','asc')->get();
    $record = DB::table('admin')->where('type','district')->get();
    // dd($record);
    $cities = DB::table('cities')->orderby('province','asc')->orderby('name','asc')->get();
    return view('admin.district.district-user-list',compact('record','society_dsg','ofc_dsg','cities'));
  }

  function fund_periods(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post') and request()->has('action')){
      if(request('action') == 'saave'){
        DB::table('fund_periods')->delete();
        if(count(request('array')) > 0){
          $error = $error2 = array();
          foreach (request('array') as $key => $value) {
            if($value['date_from'] != "" and $value['date_to'] != "" and $value['data_name'] != ""){
              $__dateFrom = explode('/', $value['date_from']);
              $__dateTo = explode('/', $value['date_to']);
              if(checkdate($__dateFrom[1], $__dateFrom[0], $__dateFrom[2]) and checkdate($__dateTo[1], $__dateTo[0], $__dateTo[2]) and $value['data_name'] != ""){
                $date_from = implode('-', array_reverse(explode('/', $value['date_from'])));
                $date_to = implode('-', array_reverse(explode('/', $value['date_to'])));
                DB::table('fund_periods')->insert([
                  'date_from'=>$date_from,
                  'date_to'=>$date_to,
                  'name'=>$value['data_name'],
                ]);
              }else{
                $error[] = $key+1;
              }
            }else{
              $error2[] = $key+1;
            }
          }
          if(count($error) > 0){
            $sc = implode(',', $error);
            if(count($error) > 1){
              return json_encode("Fund periods are saved except these row ".$sc." due to wrong data");
            }else{
              return json_encode("Fund periods are saved except row ".$sc." due to wrong data");        
            }
          }elseif(count($error2) > 0){
            $sc = implode(',', $error2);
            if(count($error2) > 1){
              return json_encode("Fund periods are saved except these row ".$sc." due to imcomplete data");
            }else{
              return json_encode("Fund periods are saved except row ".$sc." due to imcomplete data");              
            }
          }
        }else{
          if($array[0]['date_from'] == "" and $array[0]['date_to'] == "" and $array[0]['data_name'] == ""){
            $__dateFrom = explode('/', $array[0]['date_from']);
            $__dateTo = explode('/', $array[0]['date_to']);
            if(checkdate($__dateFrom[1], $__dateFrom[0], $__dateFrom[2]) and checkdate($__dateTo[1], $__dateTo[0], $__dateTo[2]) and $array[0]['data_name'] != ""){
              $date_from = implode('-', array_reverse(explode('/', $array[0]['date_from'])));
              $date_to = implode('-', array_reverse(explode('/', $array[0]['date_to'])));
              $array = request('array');
              DB::table('fund_periods')->insert([
                'date_from'=>$date_from,
                'date_to'=>$date_to,
                'name'=>$array[0]['data_name'],
              ]); 
            }else{
              return json_encode("Please enter correct date's or fund period name");
            }
          }else{
            return json_encode("Please enter correct date's or fund period name");
          }
        }
        return json_encode('success');
      }
    }
    $record = DB::table('fund_periods')->orderby('id','desc')->get();
    return view('admin.district.fund-periods' , compact('record'));
  }
  function fund_history(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    if(request()->isMethod('post') and request()->has('action') and request('action') == 'fund_detail'){
      $record = DB::table('funds')->where('id',request('id'))->first();
      if (empty($record)) {
        $bb = "<h3 class='text-center'>Record Not Found</h3>";
        return $bb;
      }
      $user = DB::table('users')->where(['district'=>auth('admin')->user()->dept_id,'id'=>$record->user_id])->first();
      $collector = DB::table('users')->where(['district'=>auth('admin')->user()->dept_id,'id'=>$record->deposited_to])->first();
      $fund_period = DB::table('fund_periods')->where('id',$record->period)->first();
      return view('admin.district.layouts.f-history',compact('record','user','collector','fund_period'));
    }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'edit_fund'){
      $record = DB::table('funds')->where('id',request('id'))->first();
      if (empty($record)) {
        $bb = "<h3 class='text-center'>Record Not Found</h3>";
        return $bb;
      }
      $users = DB::table('users')->where(['district'=>auth('admin')->user()->dept_id])->get();
      $fund_period = DB::table('fund_periods')->orderby('id','desc')->get();
      return view('admin.district.layouts.edit-fund',compact('record','users','fund_period'));
    }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'fund-update'){
      $record = DB::table('funds')->where('id',request('id'))->first();
      if (empty($record)) {
        $bb = "Fund record not found";
        return json_encode($bb);
      }
      $ledger_record = DB::table('ledger')->where([
        'amount'=>$record->amount,
        'created_at'=>$record->created_at,
        'ledger'=>'+',
        'dept_id' => $record->dept_id,
        'date' => $record->deposited_on
      ])->first();
      $diff = $ledger_record->balance + ( request('amount') - $record->amount);
      $data2['amount'] = request('amount');
      $data2['balance'] = $diff;
      $data2['date'] = implode('-', array_reverse(explode('/', request('date'))));
      $data2['user_id'] = request('user');
      DB::table('ledger')->where('id',$ledger_record->id)->update($data2);


      $data['user_id'] = request('user');
      $data['amount'] = request('amount');
      $data['deposited_on'] = implode('-', array_reverse(explode('/', request('date'))));
      $data['period'] = request('fund_period');
      $data['fund_for'] = request('fund_for');
      $data['through'] = request('through');
      $data['comment'] = request('comment');
      DB::table('funds')->where('id',$record->id)->update($data);
      return json_encode("success");
    }elseif(request()->has('del') and is_numeric(request('del'))){
      return back()->with('error','Fund cant be deleted');
    }elseif(request()->has('collector') or request()->has('date_from') or request()->has('date_to') or request()->has('search')){
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $search = request('search');
        if(!empty($collector) || !empty($date_from) || !empty($date_to) || !empty($search)){
          $query = "SELECT * FROM funds WHERE dept_id = '".$user->dept_id."' ";
          if(!empty($collector)){
            $query .= " AND deposited_to = '$collector'";
          }
          if(!empty($search)){
            $query .= " AND user_id = '$search'";
          }
          if (!empty($date_from) or !empty($date_to)) {
            
            $_from = implode('-', array_reverse(explode('/',$date_from)));
            $_to = implode('-', array_reverse(explode('/',$date_to)));
            $from = (validate_date($date_from))?$_from:"";
            $to = (validate_date($date_to))?$_to:"";
            if(!empty($from)){
              $query .= " AND deposited_on >= '$from'";
            }if(!empty($to)){
              $query .= " AND deposited_on <= '$to'";
            }
          }
          $query .= " ORDER BY id DESC";
          // dd($query);
          $record = DB::select($query);
          // dd($searchRecord);
        }else{
          $record = array();
        }
        if(empty($collector) && empty($date_from) && empty($date_to) && empty($search)){
          $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();  
        }
    }else{
      $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();
    }
    return view('admin.district.fund-history',compact('record','users','user_info'));
  }
  function collect_payment(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post')){
      if(request()->has('action') and request('action') == 'detail'){
        $id = request('id');
        $data = get_fund_detail($id);
        $total_collection = (!empty($data))?$data['total_collection']:"0";
        $tatal_transfered = (!empty($data))?$data['tatal_transfered']:"0";
        return view('admin.district.layouts.fund-detail' , compact('total_collection','tatal_transfered','id'));
      }else{
        $img_data = array();
        if(request('payment_via') == 'check'){
          $validation = Validator::make($request->all(), [
            'cheque_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
          ]);
          if($validation->passes()){
            $fileName = time().'.'.$request->file('cheque_image')->extension();
            $request->file('cheque_image')->move('images/cheque', $fileName);
            $img_data = [
              'Cheque Account title' => request('title'),
              'Cheque Bank' => request('bank'),
              'Cheque Number' => request('no'),
              'Cheque Date' => request('check_date'),
              'Cheque Image' => $fileName,
              'history' => 'This payment has been collected through Cheque by '.Auth::user()->name.' on '.date('d/m/Y H:i:s a'),              
            ];
          }else{
              return response()->json([
                'cheque_image' => $validation->errors()->get('cheque_image')
              ]);
          }
        }elseif(request('payment_via') == 'bank'){
          $validation = Validator::make($request->all(), [
            'transfer_img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
          ],[
            'transfer_img.image' => 'Screenshot image must be an image',
            'transfer_img.mimes' => ' Screenshot image must be a file of type: jpeg, png, jpg, gif, webp.',
          ]);
          if($validation->passes()){
            $fileName = time().'.'.$request->file('transfer_img')->extension();
            $request->file('transfer_img')->move('images/cheque', $fileName);
            $time = date('d/m/Y H:i:s:a');
            $img_data = [
              'Transfer To Bank Name' => request('transfer_to_name'),
              'Transfer To Account No' => request('transfer_to_ac'),
              'Transfer To Bank Title' => request('transfer_to_bank'),
              'Transfer From Bank Name' => request('transfer_from_name'),
              'Transfer From Account No' => request('transfer_from_ac') ,
              'Transfer From Bank Title' => request('transfer_from_bank'),
              'Transfer Date' => request('transfer_date'),
              'Transaction Id' => request('transfer_id'),
              'Cheque Image' => $fileName,
              'history' => 'This payment has been collected through Bank Transfer by '.Auth::user()->name.' on '.date('d/m/Y H:i:s a'),   
            ];
          }else{
              return response()->json([
                'transfer_img' => $validation->errors()->get('transfer_img')
              ]);
          }
        }elseif(request('payment_via') == 'cash'){
          $validation = Validator::make($request->all(), [
            'cash_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
          ],[
            'cash_image.image' => 'Cash receipt image must be an image. ',
            'cash_image.mimes' => ' Cash receipt image must be a file of type: jpeg, png, jpg, gif, webp.',
          ]);
          if($validation->passes()){
            $fileName = time().'.'.$request->file('cash_image')->extension();
            $request->file('cash_image')->move('images/cheque', $fileName);
            $img_data = [
              'Cash title' => request('title'),
              'Cash Bank' => request('bank'),
              'Account Number' => request('account_no'),
              'Deposit Date' => request('check_date'),
              'Depositor' => request('depositor'),
              'Cash Image' => $fileName,
              'history' => 'This payment has been collected through Cash Deposit by '.Auth::user()->name.' on '.date('d/m/Y H:i:s a'),  
            ];
          }else{
              return response()->json([
                'cash_image' => $validation->errors()->get('cash_image')
              ]);
          }
        }elseif(request('payment_via') == 'bycash'){
            $img_data = [
              'history' => 'This payment has been collected bycash on '.date('d/m/Y h:i:s a').' by '.Auth::user()->name,  
            ];
        }elseif(request('payment_via') == 'mobile'){
            $img_data = [
              'Account Number' => request('mobile_ac'),
              'history' => 'This payment has been collected through mobile transfer on '.date('d/m/Y h:i:s a').' by '.Auth::user()->name,  
            ];
        }
        $id = request('id');
        $record = get_fund_detail($id);
        $data['collector_id'] = $id;
        $data['dept_id'] = $user->dept_id;
        $data['user_id'] = auth('admin')->user()->id;
        $data['amount'] = request('amount');
        $data['balance'] = $record['grand_balance'] - request('amount');
        $data['ledger'] = '-';
        $data['history'] = json_encode($img_data);
        $data['date'] = implode('-', array_reverse(explode('/', request('date'))));
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('ledger')->insert($data);
        $user_detail = _user_data();
        $recoDrd = get_district_fund_detail($user->dept_id);
        $data2['district'] = $user->dept_id;
        $data2['province'] = $user_detail['province'];
        $data2['date'] = date('Y-m-d');
        $data2['year'] = date('Y');
        $data2['user_id'] = auth('admin')->user()->id;
        $data2['collector'] = $id;
        $data2['amount'] = request('amount');
        $data2['ledger'] = '+';
        $data2['remaining'] = $recoDrd['balance'] + request('amount');
        $data2['created_at'] = date('Y-m-d H:i:s');
        DB::table('district_ledger')->insert($data2);
        return json_encode('success');
      }
    }
    $collectors = DB::table('user_info')->where('district',$user->dept_id)->where('collector','yes')->get();
    $users = DB::table('users')->where('district',$user->dept_id)->where('status','approved')->get();
    return view('admin.district.collect-payment' , compact('collectors','users'));
  }
  function transfer_province(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $user_detail = _user_data();
    $reorded = get_district_fund_detail($user->dept_id);
    $remaining = $reorded['total_collection'];
    if(request()->isMethod('post') and request()->has('action')){
      if(request('action') == 'view_detail'){
        $record = DB::table('district_ledger')->where('id',request('id'))->orderby('id','desc')->first();
        return view('admin.district.layouts.province-fund-detail',compact('record'));
      }
    }
    $record = DB::table('district_ledger')->where([
      'district' => $user->dept_id,
      'province' => $user_detail['province'],
    ])->where('status','!=','NULL')->orderby('id','asc')->get();
    return view('admin.district.transfer-province',compact('record','remaining'));
  }
  function district_ledger(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user->type != "district"){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->has('user') or request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
        $district_user = request('user');
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $query = "SELECT * FROM district_ledger WHERE district = '".$user->dept_id."' ";
        if(!empty($district_user)){
          $query .= "AND user_id = '$district_user'";
        }
        if(!empty($collector)){
          $query .= "AND collector = '$collector'";
        }
        if (!empty($date_from) or !empty($date_to)) {
          
          $_from = implode('-', array_reverse(explode('/',$date_from)));
          $_to = implode('-', array_reverse(explode('/',$date_to)));
          $from = (validate_date($date_from))?$_from:"";
          $to = (validate_date($date_to))?$_to:"";
          if(!empty($from)){
            $query .= "AND date >= '$from'";
          }if(!empty($to)){
            $query .= "AND date <= '$to'";
          }
        }
        $query .= " ORDER BY id DESC";
        $record = DB::select($query);
    }else{
      $record = DB::table('district_ledger')->where(['district' => $user->dept_id])->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    $district_users = DB::table('admin')->where(['type'=>'district','dept_id'=>$user->dept_id])->get();
    return view('admin.district.district-ledger',compact('record','users','user_info','district_users'));
  }

  function transfer_payment(Request $request)
  {
    if(Auth::user()->type != 'district'){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $data2 = array();
    $user_detail = _user_data();
    $reorded = get_district_fund_detail($user->dept_id);
    $remaining = $reorded['balance'];
    if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
        'amount' => 'required|integer|min:0',
        'payment_via' => 'required',
        'date' => 'required',
      ]);
      $time = date('d/m/Y h:i:s a');
      if(request('payment_via') == 'check'){
        $this->validate($request, [
          'title' => 'required|max:100',
          'bank' => 'required|max:100',
          'check_date' => 'required|max:100',
          'no' => 'required|max:100',
          'cheque_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'title.required'=>"Cheque title is missing",
          'bank.required'=>"Cheque bank name is missing",
          'check_date.required'=>"Cheque date is missing",
          'no.required'=>"Cheque number is missing",
          'cheque_image.required'=>"Cheque image is missing",
        ]);
        $fileName = time().'.'.$request->file('cheque_image')->extension();
        $request->file('cheque_image')->move('images/cheque', $fileName);
        $data2 = [
          'Cheque title' => request('title'),
          'Cheque Bank' => request('bank'),
          'Cheque Number' => request('no'),
          'Cheque Date' => request('check_date'),
          'Cheque Image' => $fileName
        ];
          $data = [
            'This payment has been submitted through Cheque on '.$time,
          ];
      }elseif(request('payment_via') == 'bank'){
        $this->validate($request, [
          'transfer_to_name' => 'required|max:100',
          'transfer_to_ac' => 'required|max:100',
          'transfer_to_bank' => 'required|max:100',
          'transfer_from_name' => 'required|max:100',
          'transfer_from_ac' => 'required|max:100',
          'transfer_from_bank' => 'required|max:100',
          'transfer_date' => 'required|max:100',
          'transfer_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'transfer_to_name.required' => 'Transfer to bank name is missing',
          'transfer_to_ac.required' => 'Transfer to account no. is missing',
          'transfer_to_bank.required' => 'Transfer to account title is missing',
          'transfer_from_name.required' => 'Transfer from bank name is missing',
          'transfer_from_ac.required' => 'Transfer from account no. is missing',
          'transfer_from_bank.required' => 'Transfer from account title is missing',
          'transfer_date.required' => 'Transfer date is missing',
          'transfer_img' => 'Screen-shot is missing',
        ]);
        $fileName = time().'.'.$request->file('transfer_img')->extension();
        $request->file('transfer_img')->move('images/cheque', $fileName);
        $data2 = [
          'Transfer To Bank Name' => request('transfer_to_name'),
          'Transfer To Account No' => request('transfer_to_ac'),
          'Transfer To Bank Title' => request('transfer_to_bank'),
          'Transfer From Bank Name' => request('transfer_from_name'),
          'Transfer From Account No' => request('transfer_from_ac') ,
          'Transfer From Bank Title' => request('transfer_from_bank'),
          'Transfer Date' => request('transfer_date'),
          'Transaction Id' => request('transfer_id'),
          'Cheque Image' => $fileName
        ];
          $data = [
            'This payment has been submitted via Bank Transfer on '.$time,
          ];
      }elseif(request('payment_via') == 'cash'){
        $this->validate($request, [
          'title' => 'required|max:100',
          'bank' => 'required|max:100',
          'account_no' => 'required|max:100',
          'cash_date' => 'required|max:100',
          'depositor' => 'required|max:100',
          'cash_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'title.required' => 'Receiver account title is missing',
          'bank.required' => 'Bank name is missing',
          'account_no.required' => 'Receiver account no is missing',
          'cash_date.required' => 'Cash date is missing',
          'depositor.required' => 'Depositor is missing',
          'cash_image.required' => 'Cash receipt image is missing',
        ]);
        $fileName = time().'.'.$request->file('cash_image')->extension();
        $request->file('cash_image')->move('images/cheque', $fileName);
        $data2 = [
          'Cash title' => request('title'),
          'Cash Bank' => request('bank'),
          'Account Number' => request('account_no'),
          'Deposit Date' => request('cash_date'),
          'Depositor' => request('depositor'),
          'Cash Image' => $fileName
        ];
        $data = [
          'This payment has been submitted through Cash on '.$time,
        ];
      }
      if(floor($remaining) < request('amount')){
        return back()->with('error','Transfer Amount should be less then or equal to Remaining Fund');
      }
      $__date = implode('-', array_reverse(explode('/', request('date'))));
      $__data['district']   = $user->dept_id;
      $__data['province']   = $user_detail['province'];
      $__data['date']       = $__date;
      $__data['user_id']    = $user->id;
      $__data['amount']     = request('amount');
      $__data['through']    = request('payment_via');
      $__data['comment']    = request('comment');
      $__data['status']     = 'Deliver';
      $__data['remaining']  = $reorded['balance'] - request('amount');
      $__data['ledger']     = '-';
      $__data['year']       = date('Y');
      $__data['payment_detail']    = json_encode($data2);
      $__data['history']    = json_encode($data);
      $__data['created_at'] = date('Y-m-d H:i:s');
      $id = DB::table('district_ledger')->insertGetId($__data);
      return back()->with('success','Fund added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
      $get_ledger = DB::table('district_ledger')->where([
        'id' => request('id') ,
        'district' => $user->dept_id,
        'province' => $user_detail['province'],
      ])->first();
      if(empty($get_ledger)){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
      }
      $time = date('d/m/Y h:i:s a');
      if((floor($remaining) + $get_ledger->amount) < request('amount')){
        return back()->with('error','Transfer Amount should be less then or equal to Remaining Fund');
      }
      $_his = (!empty($get_ledger->history))?json_decode($get_ledger->history,true):array();
      $this->validate($request, [
        'payment_via' => 'required',
        'date' => 'required',
      ]);
      if(request('payment_via') == 'check'){
        $this->validate($request, [
          'title' => 'required|max:100',
          'bank' => 'required|max:100',
          'check_date' => 'required|max:100',
          'no' => 'required|max:100',
          'cheque_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'title.required'=>"Cheque title is missing",
          'bank.required'=>"Cheque bank name is missing",
          'check_date.required'=>"Cheque date is missing",
          'no.required'=>"Cheque number is missing",
          'cheque_image.required'=>"Cheque image is missing",
        ]);
        if(request()->has('cheque_image')){
          $fileName = time().'.'.$request->file('cheque_image')->extension();
          $request->file('cheque_image')->move('images/cheque', $fileName);
        }else{
          $fileName = request('file_hidden');
        }
        $data2 = [
          'Cheque title' => request('title'),
          'Cheque Bank' => request('bank'),
          'Cheque Number' => request('no'),
          'Cheque Date' => request('check_date'),
          'Cheque Image' => $fileName
        ];
        $data = [
          'This payment has been updated through Cheque on '.$time,
        ];
      }elseif(request('payment_via') == 'bank'){
        $this->validate($request, [
          'transfer_to_name' => 'required|max:100',
          'transfer_to_ac' => 'required|max:100',
          'transfer_to_bank' => 'required|max:100',
          'transfer_from_name' => 'required|max:100',
          'transfer_from_ac' => 'required|max:100',
          'transfer_from_bank' => 'required|max:100',
          'transfer_date' => 'required|max:100',
          'transfer_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'transfer_to_name.required' => 'Transfer to bank name is missing',
          'transfer_to_ac.required' => 'Transfer to account no. is missing',
          'transfer_to_bank.required' => 'Transfer to account title is missing',
          'transfer_from_name.required' => 'Transfer from bank name is missing',
          'transfer_from_ac.required' => 'Transfer from account no. is missing',
          'transfer_from_bank.required' => 'Transfer from account title is missing',
          'transfer_date.required' => 'Transfer date is missing',
          'transfer_img' => 'Payment Screen-shot is missing',
        ]);
        if(request()->has('transfer_img')){
          $fileName = time().'.'.$request->file('transfer_img')->extension();
          $request->file('cheque_image')->move('images/cheque', $fileName);
        }else{
          $fileName = request('file_hidden');
        }
        $data2 = [
          'Transfer To Bank Name' => request('transfer_to_name'),
          'Transfer To Account No' => request('transfer_to_ac'),
          'Transfer To Account Title' => request('transfer_to_bank'),
          'Transfer From Bank Name' => request('transfer_from_name'),
          'Transfer From Account No' => request('transfer_from_ac'),
          'Transfer From Account Title' => request('transfer_from_bank'),
          'Transfer Date' => request('transfer_date'),
          'Transaction Id' => request('transfer_id'),
          'Cheque Image' => $fileName
        ];
          $data = [
            'This payment has been updated through Bank Transfer on '.$time,
          ];
      }elseif(request('payment_via') == 'cash'){
        $this->validate($request, [
          'title' => 'required|max:100',
          'bank' => 'required|max:100',
          'account_no' => 'required|max:100',
          'cash_date' => 'required|max:100',
          'depositor' => 'required|max:100',
          'cash_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
          'title.required' => 'Receiver account title is missing',
          'bank.required' => 'Bank name is missing',
          'account_no.required' => 'Receiver account no is missing',
          'cash_date.required' => 'Deposit date is missing',
          'depositor.required' => 'Depositor is missing',
          'cash_image.required' => 'Cash receipt image is missing',
        ]);
        if(request()->has('cash_image')){
          $fileName = time().'.'.$request->file('cash_image')->extension();
          $request->file('cheque_image')->move('images/cheque', $fileName);
        }else{
          $fileName = request('file_hidden');
        }
        $data2 = [
          'Cash title' => request('title'),
          'Cash Bank' => request('bank'),
          'Account Number' => request('account_no'),
          'Deposit Date' => request('cash_date'),
          'Depositor' => request('depositor'),
          'Cash Image' => $fileName
        ];
        $data = [
          'This payment has been updated through Cash on '.$time,
        ];
      }
      $__fhis = array_merge($_his,$data);
      // dd($__fhis);
      $__date = implode('-', array_reverse(explode('/', request('date'))));
      $user_detail = _user_data();
      $__data['date']   = $__date;
      $__data['user_id']    = $user->id;
      $__data['amount']     = request('amount');
      $__data['through']    = request('payment_via');
      $__data['comment']    = request('comment');
      $__data['status']     = 'Deliver';
      $__data['remaining']  = $reorded['balance'] - request('amount');
      $__data['ledger']     = '-';
      $__data['payment_detail']    = json_encode($data2);
      $__data['history']    = json_encode($__fhis);
      DB::table('district_ledger')->where('id',$get_ledger->id)->update($__data);
      return back()->with('success','Fund updated successfully');
    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('district_ledger')->where([
        'id' => request('id') ,
        'district' => $user->dept_id,
        'province' => $user_detail['province'],
      ])->first();
      return view('admin.district.add-funds' , compact('get_data','remaining'));
    }
    return view('admin.district.add-funds' , compact('remaining'));
  }

  function ledger()
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $query = "SELECT * FROM ledger WHERE dept_id = '".$user->dept_id."' ";
        if(!empty($collector)){
          $query .= "AND collector_id = '$collector'";
        }
        if (!empty($date_from) or !empty($date_to)) {
          
          $_from = implode('-', array_reverse(explode('/',$date_from)));
          $_to = implode('-', array_reverse(explode('/',$date_to)));
          $from = (validate_date($date_from))?$_from:"";
          $to = (validate_date($date_to))?$_to:"";
          if(!empty($from)){
            $query .= "AND date >= '$from'";
          }if(!empty($to)){
            $query .= "AND date <= '$to'";
          }
        }
        $query .= " ORDER BY id DESC";
        $record = DB::select($query);
    }else{
      $record = DB::table('ledger')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    return view('admin.district.ledger' , compact('record','users','user_info'));
  }
  function fund_collector(Request $request)
  {
    if(Auth::user()->type != 'district'){
      return redirect(route('base_url')."/404");
    }
    $user = DB::table('admin')->where('username',Auth::user()->username)->first();
    if(request()->isMethod('post')){
      $this->validate($request, [
        'name' => 'required',
      ]);
      $check = DB::table('user_info')->where('user_id',request('name'))->first();
      if(!empty($check)){
        if ($check->district == Auth::user()->dept_id) {
          if($check->collector == 'yes'){
            return back()->with('success','This user is already added as a fund collector.');
          }else{
            $data['collector'] = 'yes';
            $data['status'] = 'on';
            $data['district'] = $user->dept_id;
            DB::table('user_info')->where('user_id',request('name'))->update($data);
            return back()->with('success','New fund collector is added successfully');
          }
        }else{
          return back()->with('error','User Not Found');   
        }
      }else{
          $data['collector'] = 'yes';
          $data['district'] = $user->dept_id;
          $data['user_id'] = request('name');
          $data['status'] = 'on';
          DB::table('user_info')->insert($data);
          return back()->with('success','New fund collector is added successfully');
      }
    }elseif(request()->has('del') and is_numeric(request('del'))){
      $record = DB::table('user_info')->where(['id'=>request('del'),'district'=>auth('admin')->user()->dept_id])->first();
      if($record){
        if ($record->status == 'on') {
          DB::table('user_info')->where('id',request('del'))->update(['status'=>'off']);
          return back()->with('success','Fund collector is banned successfully');
        }else{
          DB::table('user_info')->where('id',request('del'))->update(['status'=>'on']);
          return back()->with('success','Fund collector is Un-banned successfully');
        }
      }else{
        return back()->with('error','Fund collector not found');
      }
    }
    $record = DB::table('user_info')->where('district',$user->dept_id)->where(['collector'=>'yes'])->get();
    $users = DB::table('users')->where(['district'=>$user->dept_id,'status'=>'approved'])->get();
    return view('admin.district.add-fund-collector' , compact('record','users'));
  }
  function about_cabinet(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post')){
      $this->validate($request, [
        'text' => 'required|min:10',
      ]);
      $data = ['heading'=>request('heading') , 'body'=>request('body') , 'detail'=>request('text')];
      if($user->type == 'district'){
        DB::table('cities')->where('id',$user->dept_id)->update(['cabinet'=>json_encode($data)]);
        return back()->with('success','Record updated successfully');
      }elseif($user->type == 'province'){
        DB::table('province')->where('id',$user->dept_id)->update(['cabinet'=>json_encode($data)]);
        return back()->with('success','Record updated successfully');
      }elseif($user->type == 'national'){
        DB::table('national')->update(['cabinet'=>json_encode($data)]);
        return back()->with('success','Record updated successfully');
      }
    }else{
      if($user->type == 'district'){
        $data = DB::table('cities')->where('id',$user->dept_id)->first();
        return view('admin.district.about-cabinet' , compact('data'));
      }elseif($user->type == 'province'){
        $data = DB::table('province')->where('id',$user->dept_id)->first();
        return view('admin.district.about-cabinet' , compact('data'));
      }elseif($user->type == 'national'){
        $data = DB::table('national')->first();
        return view('admin.district.about-cabinet' , compact('data'));
      }
    }
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
              return redirect(route('base_url').'/'.admin.'/district-login-update')->with('success','Login Update Successfully');
          }
      }
      $admin = DB::table('admin')->where('username',$username)->first();
      return view('admin.district.update-login',compact('admin'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }


  function user_list(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $sms_setting = DB::table('sms_setting')->first();
    $email_setting = DB::table('email_setting')->first();
    $cities = DB::table('cities')->orderby('name','asc')->get();
    if(request()->isMethod('post')){
      if(request()->has('action') and request('action') == 'approve'){
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        if($record){
          $_his = (!empty($record->history)) ? json_decode($record->history , true) : array();
          $new_his = ['User request for APJEA members is approved by ('.auth('admin')->user()->username.') on date: '.date('d/m/Y h:i:s A')];
          $history = array_merge($_his , $new_his);
          DB::table('users')->where('id',$record->id)->update(['status'=>'approved','history'=>$history]);
          if($sms_setting->ac_apr == 'on'){
            $no = generate_mbl($record->contact);
            $msg = send_sms_shortCode($sms_setting->acc_aproval,$record->name,$record->cnic,$record->district);
            sendSMS($no,$msg);
          }
          if(!empty($record->email)){
            $msg = send_sms_shortCode($email_setting->acc_aproval,$record->name,$record->cnic,$record->district);
            $data = array(
              "name" => $record->name,
              "email" => $record->email,
              "content" => $msg,
              "subject" => 'APJEA Account Approval',
              "from" => array("email"=>'admin@apjea.com', "label"=>"APJEA"),
              "to" => array("email"=>$record->email, "label"=>$record->name)
            );
            $Mail = new Mail;
            sendEmail($Mail, "email-template.multi-emails", $data);
          }
          return json_encode('success');
        }else{
          return json_encode('User not found please refresh the page and try again');
        }
      }elseif(request()->has('action') and request('action') == 'reject'){
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        if($record){
          $_his = (!empty($record->history)) ? json_decode($record->history , true) : array();
          $new_his = ['User request for APJEA members is rejected by ('.auth('admin')->user()->username.') on date: '.date('d/m/Y h:i:s A').' due to '.request('reason')];
          $history = array_merge($_his , $new_his);
          DB::table('users')->where('id',$record->id)->update(['status'=>'reject','history'=>$history]);
          if($sms_setting->ac_rej == 'on'){
            $no = generate_mbl($record->contact);
            $msg = send_sms_shortCode($sms_setting->acc_rejection,$record->name,$record->cnic,$record->district,'',request('reason'));
            sendSMS($no,$msg);
          }
          if(!empty($record->email)){
            $msg = send_sms_shortCode($email_setting->acc_rejection,$record->name,$record->cnic,$record->district,'',request('reason'));
            $data = array(
              "name" => $record->name,
              "email" => $record->email,
              "content" => $msg,
              "subject" => 'APJEA Account Rejection',
              "from" => array("email"=>'admin@apjea.com', "label"=>"APJEA"),
              "to" => array("email"=>$record->email, "label"=>$record->name)
            );
            $Mail = new Mail;
            sendEmail($Mail, "email-template.multi-emails", $data);
          }
          return json_encode('success');
        }else{
          return json_encode('User not found please refresh the page and try again');
        }
      }elseif(request()->has('action') and request('action') == 'delete'){
        // dd(request()->all());
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        if($record){
          $reason = request('reason_array');
          $_his = (!empty($record->history)) ? json_decode($record->history , true) : array();
          if ($reason['type'] == 'transfer') {
            $transfer_city = $reason['trasnfer_city'];
            $reason_msg[] = 'This user is transfered by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s A').' to '.$reason['trasnfer_city_name'];
            $history = array_merge($_his , $reason_msg);
            $transf_city_detail = DB::table('cities')->where('id',$transfer_city)->first();
            $data = [
              'province' => $transf_city_detail->province, 
              'district' => $transfer_city, 
              'status' => 'pending' , 
              'ban' => 'unban',
              'history' => $history,
            ];
            DB::table('users')->where('id',$record->id)->update($data);
          }elseif ($reason['type'] == 'resign') {
            $reason_msg[] = 'This user is deleted by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s A').' due to '.$reason['reason_msg'];
            $history = array_merge($_his , $reason_msg);  
            $data = [
              'status' => 'deleted' , 
              'ban' => 'unban',
              'history' => $history,
            ];
            DB::table('users')->where('id',$record->id)->update($data);          
          }elseif ($reason['type'] == 'retire') {
            $reason_msg[] = 'This user is deleted by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s A').' due to '.$reason['reason_msg'];
            $history = array_merge($_his , $reason_msg);  
            $data = [
              'status' => 'deleted' , 
              'ban' => 'unban',
              'history' => $history,
            ];
            DB::table('users')->where('id',$record->id)->update($data);  
            
          }elseif ($reason['type'] == 'death') {
            $reason_msg[] = 'This user is deleted by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s A').' due to '.$reason['reason_msg'];
            $history = array_merge($_his , $reason_msg);  
            $data = [
              'status' => 'deleted' , 
              'ban' => 'unban',
              'history' => $history,
            ];
            DB::table('users')->where('id',$record->id)->update($data); 
            
          }elseif ($reason['type'] == 'other') {
            $reason_msg[] = 'This user is deleted by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s A').' due to '.$reason['reason_detail'];
            $history = array_merge($_his , $reason_msg);  
            $data = [
              'status' => 'deleted' , 
              'ban' => 'unban',
              'history' => $history,
            ];
            DB::table('users')->where('id',$record->id)->update($data); 
          }
          return json_encode('success');
        }else{
          return json_encode('User not found please refresh the page and try again');
        }
      }elseif(request()->has('action') and request('action') == 'ban'){
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        if($record){
          $_his = (!empty($record->history)) ? json_decode($record->history , true) : array();
          $new_his = ['User request for APJEA members is banned by ('.auth('admin')->user()->username.') on date: '.date('d/m/Y h:i:s A').' due to '.request('reason')];
          $history = array_merge($_his , $new_his);
          DB::table('users')->where('id',$record->id)->update(['ban'=>'ban','history'=>$history]);
          return json_encode('success');
        }else{
          return json_encode('User not found please refresh the page and try again');
        }
      }elseif(request()->has('action') and request('action') == 'unban'){
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        if($record){
          $_his = (!empty($record->history)) ? json_decode($record->history , true) : array();
          $new_his = ['User request for APJEA members is Un-banned by ('.auth('admin')->user()->username.') on date: '.date('d/m/Y h:i:s A')];
          $history = array_merge($_his , $new_his);
          DB::table('users')->where('id',$record->id)->update(['ban'=>'unban','tries'=>'0','history'=>$history]);
          return json_encode('success');
        }else{
          return json_encode('User not found please refresh the page and try again');
        }
      }elseif(request()->has('action') and request('action') == 'user_detail'){
        $record = DB::table('users')->where([
          'district'=>$user->dept_id,
          'id'=>request('id')
        ])->first();
        $user_info = DB::table('user_info')->where(['district'=>$user->dept_id,'user_id'=>request('id')])->first();
        $nominee_information = DB::table('nominee_information')->where(['user_id'=>request('id')])->first();
        // dd($user_info);
        return view('admin.district.layouts.user-detail',compact('record','user_info','cities','nominee_information'));
      }elseif(request()->has('action') and request('action') == 'permanent_delete'){
        $check_fund = DB::table('funds')->where('dept_id',$user->dept_id)->Where(['deposited_to' => request('id')])->orWhere(['user_id' => request('id')])->get();
        if (count($check_fund) > 0) {
          return json_encode("User cannot delete because user has fund history.");
        }else{
          $check_death = DB::table('death_claims')->where(['dept_id'=>$user->dept_id,'user_id'=>request('id')])->first();
          if($check_death){
            return json_encode("User cannot delete because user has death record");
          }else{
            $user_ledger = DB::table('ledger')->where(['user_id'=>request('id'),'dept_id'=>$user->dept_id])->first();
            if ($user_ledger) {
              return json_encode("User cannot delete because user has fund history");
            }else{
              DB::table('users')->where([
                'district'=>$user->dept_id,
                'id'=>request('id')
              ])->delete();
              DB::table('user_info')->where([
                'district'=>$user->dept_id,
                'user_id'=>request('id')
              ])->delete();
              return json_encode("success");
            }
          }
        }
      }else{
        return json_encode("Error");
      }
    }elseif(request()->has('search') or request()->has('cnic') or request()->has('designation') or request()->has('date_from') or request()->has('date_to') or request()->has('pending') or request()->has('approved') or request()->has('rejected') or request()->has('deleted')  or request()->has('city') ){
      $title = request('search');
      $panel = request('designation');
      $cnic = request('cnic');
      $date_from = request('date_from');
      $date_to = request('date_to');
      $approved = request('approved');
      $pending = request('pending');
      $rejected = request('rejected');
      $deleted = request('deleted');
      $city = request('city');
      $_from = implode('-', array_reverse(explode('/',$date_from)));
      $_to = implode('-', array_reverse(explode('/',$date_to)));
      $from = (validate_date($date_from))?$_from:"";
      $to = (validate_date($date_to))?$_to:"";

      if($user->type == 'district'){
        $users = DB::table('users')->where('district',$user->dept_id)->get();
        $query = "SELECT * FROM users WHERE district = '".$user->dept_id."' ";
      }elseif($user->type == 'province'){
        $query = "SELECT * FROM users WHERE province = '".$user->dept_id."' ";
      }else{
        $query = "SELECT * FROM users WHERE email is NOT NULL ";
      }
      if(!empty($approved)){
        $query .= "AND status = 'approved'";
      }if(!empty($pending)){
        $query .= "AND status = 'pending'";
      }if(!empty($rejected)){
        $query .= "AND status = 'reject'";
      }if(!empty($deleted)){
        $query .= "AND status = 'deleted'";
      }if(!empty($city)){
        $query .= "AND district = '$city'";
      }if(!empty($title)){
        $query .= "AND name LIKE '%$title%'";
      }if(!empty($cnic)){
        $query .= "AND cnic = '$cnic'";
      }if(!empty($panel)){
        $query .= "AND designation LIKE '%$panel%'";
      }if(!empty($from)){
        $query .= "AND created_at > '$from'";
      }if(!empty($to)){
        $query .= "AND created_at < '$to'";
      }
      $query .= " ORDER BY id DESC";
      $users = DB::select($query);
    }else{
      if($user->type == 'district'){
        $users = DB::table('users')->where('district',$user->dept_id)->orderby('id','desc')->get();
      }elseif($user->type == 'province'){
        $users = DB::table('users')->where('province',$user->dept_id)->orderby('id','desc')->get();
      }else{
        $users = DB::table('users')->orderby('id','desc')->get();
      }
    }
    // dd('sdaf');
    return view('admin.district.users-list',compact('users','cities'));
  }

  function death_claim_list(){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user){
      $record = DB::table('death_claims')->where(['dept_id'=>$user->dept_id,'type'=>$user->type])->get();
      return view('admin.district.death-claim-list' , compact('record'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  function death_claim(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $users = DB::table('users')->where(['district'=>$user->dept_id,'status'=>'approved'])->get();
    $users_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    if($user->type != "district"){

      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->isMethod('post')){
      $this->validate($request, [
          'user_name' => 'required|max:100',
          'death_date' => 'required|max:100',
          'death_place' => 'required|max:100',
          'death_reason' => 'required|max:1000',
      ]);
      $data['death_place'] = request('death_place');
      $data['death_reason'] = request('death_reason');
      $data['death_date'] = implode('-', array_reverse(explode('/', request('death_date'))));
      $array = ['Death Claim request is created by ('.$username.') on '.date('d/m/Y h:i:s A')];
      if(request()->has('add')){
        $data['request_panel'] = GetProvinceId($user->dept_id);
        $data['dept_id'] = $user->dept_id;
        $data['type'] = $user->type;
        $data['user_id'] = request('user_name');
        $data['status'] = 'pending';
        $data['history'] = json_encode($array);
        // dd($data);
        $id = DB::table('death_claims')->insertGetId($data);
        $sms_setting = DB::table('sms_setting')->first();
        // $email_setting = DB::table('email_setting')->first();
        if($sms_setting->deth_req == 'on'){
          $cnic_info = DB::table('users')->where('id',$data['user_id'])->first();
          $no = generate_mbl($cnic_info->contact);
          $msg = send_sms_shortCode($sms_setting->death_req,$cnic_info->name,$cnic_info->cnic,'','');
          sendSMS($no,$msg);
        }
        return redirect(route('death-claim').'?id='.$id)->with('success','Claim request send successfully');
      }elseif(request()->has('update')){
        DB::table('death_claims')->where('id',request('id'))->update($data);
        return back()->with('success','Record updated successfully');
      }
    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('death_claims')->where('id',request('id'))->first();
      return view('admin.district.death-claim',compact('get_data','users','users_info'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
      $check = DB::table('death_claims')->where([
        'type' => $user->type,
        'dept_id' => $user->dept_id,
        'status' => 'pending',
        'id' => request('del')
      ])->first();
      if($check){
        DB::table('death_claims')->where('id',$check->id)->delete();
        return back()->with('success','Death Claim request is deleted successfully');
      }else{
        return back()->with('success','Death Claim request cannot be deleted');        
      }
    }
    return view('admin.district.death-claim',compact('users','users_info'));
  }
  function death_requests(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user->type != "province"){

      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->isMethod('post') and request()->has('action') and request('action') == 'payment'){
      $id = request('id');
      $data = DB::table('death_claims')->where('id',$id)->first();
      return view('admin.province.layouts.death-claim-approval' , compact('data'));
    }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'reject'){
      $id = request('id');
      $reason = request('reason');
      $get_record = DB::table('death_claims')->where('id',$id)->where('status','pending')->first();
      // if($get_record){
        $history = json_decode($get_record->history,true);
        $array = ['change_status' => 'Requset is rejected by ('.Auth::user()->username.') due to '.$reason];
        $_history = array_merge($history,$array);
        $data = ['status'=>'reject','history'=>json_encode($_history)];
        DB::table('death_claims')->where('id',$id)->update($data);
        $sms_setting = DB::table('sms_setting')->first();
        if($sms_setting->death_rej == 'on'){
          $cnic_info = DB::table('users')->where('id',$get_record->user_id)->first();
          $no = generate_mbl($cnic_info->contact);
          $msg = send_sms_shortCode($sms_setting->death_rejection,$cnic_info->name,$cnic_info->cnic,'','',$reason);
          sendSMS($no,$msg);
        }
        return json_encode('success');
      // }else{
      //   return json_encode('Budget Request is not found or Request status is already changed. Please refresh page and try agian.');
      // }
    }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'view'){
      $id = request('id');
      $data = DB::table('death_claims')->where('id',$id)->first();
      return view('admin.province.layouts.death-claim-detail' , compact('data'));
    }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'approve'){
      $record = DB::table('death_claims')->where('id',request('id'))->first();
      $id = request('id');
      $reason = request('reason');
      $get_record = DB::table('death_claims')->where('id',$id)->first();
      if($get_record){
        if($get_record->status == 'pending'){
          $history = json_decode($get_record->history,true);
          $array = ['change_status' => 'Requset is approved by ('.Auth::user()->username.') on '.date('d/m/Y h:i:s A').' with amount '.$reason];
          $_history = array_merge($history,$array);
          $data = ['amount'=>$reason,'status'=>'approved','history'=>json_encode($_history)];
          DB::table('death_claims')->where('id',$id)->update($data);
          $sms_setting = DB::table('sms_setting')->first();
          if($sms_setting->death_apr == 'on'){
            $cnic_info = DB::table('users')->where('id',$get_record->user_id)->first();
            $no = generate_mbl($cnic_info->contact);
            $msg = send_sms_shortCode($sms_setting->death_aproval,$cnic_info->name,$cnic_info->cnic,'','');
            sendSMS($no,$msg);
          }
          return json_encode('success');
        }else{
          return json_encode('This Death Claim request is already proceed. Please refresh page.');
        }
      }else{
        return json_encode('Budget Request is not found or Request status is already changed. Please refresh page and try agian.');
      }
    }elseif(request()->isMethod('post') and request()->has('status') and request('status') == 'check'){
      $validation = Validator::make($request->all(), [
        'cheque_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);
      if($validation->passes()){
        $fileName = time().'.'.$request->file('cheque_image')->extension();
        $request->file('cheque_image')->move('images/cheque', $fileName);
        $time = date('d/m/Y H:i:s:a');
        $data = [
          'This payment has been submitted through Cheque on '.$time,
          'title' => request('title'),
          'bank' => request('bank'),
          'no' => request('no'),
          'date' => request('date'),
          'img' => $fileName
        ];
        DB::table('death_claims')->where('id',request('hidden_id'))->update([
          'history'=>json_encode($data),
          'status'=>'delivered'
        ]);
        return json_encode('success');
      }else{
        return response()->json([
          'cheque_image' => $validation->errors()->get('cheque_image')
        ]);
      }
    }elseif(request()->isMethod('post') and request()->has('status') and request('status') == 'cash'){
      $validation = Validator::make($request->all(), [
        'cash_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);
      if($validation->passes()){
        $fileName = time().'.'.$request->file('cash_image')->extension();
        $request->file('cash_image')->move('images/cheque', $fileName);
        $time = date('d/m/Y H:i:s:a');
        $data = [
          'This payment has been submitted through Cash on '.$time,
          'title' => request('title'),
          'bank' => request('bank'),
          'no' => request('no'),
          'date' => request('date'),
          'img' => $fileName
        ];
        // dd($data);
        DB::table('death_claims')->where('id',request('hidden_id'))->update([
          'history'=>json_encode($data),
          'status'=>'delivered'
        ]);
        return json_encode('success');
      }else{
        return response()->json([
          'cash_image' => $validation->errors()->get('cash_image')
        ]);
      }
    }elseif(request()->isMethod('post') and request()->has('status') and request('status') == 'bank'){
      $validation = Validator::make($request->all(), [
        'trans_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);
      if($validation->passes()){
        $fileName = time().'.'.$request->file('trans_img')->extension();
        $request->file('trans_img')->move('images/cheque', $fileName);
        $time = date('d/m/Y H:i:s:a');
        $data = [
          'This payment has been submitted through Bank Transfer on '.$time,
          'trans_to_name' => request('trans_to_name'),
          'trans_to_ac' => request('trans_to_ac'),
          'trans_to_bank' => request('trans_to_bank'),
          'trans_from_name' => request('trans_from_name'),
          'trans_from_ac' => request('trans_from_ac'),
          'trans_from_bank' => request('trans_from_bank'),
          'trans_date' => request('trans_date'),
          'trans_id' => request('trans_id'),
          'img' => $fileName
        ];
        DB::table('death_claims')->where('id',request('hidden_id'))->update([
          'history'=>json_encode($data),
          'status'=>'delivered'
        ]);
        return json_encode('success');
      }else{
        return response()->json([
          'trans_img' => $validation->errors()->get('trans_img')
        ]);
      }
    }else{
      $record = DB::table('death_claims')->where('request_panel',$user->dept_id)->get();
      return view('admin.province.death-claim',compact('record'));
    }
  }

  function jobsmeta(){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has("submit")){

      $schema= request('schema');
      $type= request('type');
      $schm = array();
      if (!empty($type)) {
        for($a = 0; $a < count($type); $a++){
          if ($type[$a] !="") {
               $schm[]= array(
                  "schema" => $schema[$a],
                  "type" => $type[$a]
              );  
           }     
        }
      }else{
        $schm = array();
      }
      $schema= (json_encode($schm));
      $jobsmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
      );
      if($user->type == 'district'){
        DB::table("cities")->where('id', $user->dept_id)->update([
           'jobs_meta' => json_encode($jobsmeta),
        ]);
        return back()->with('flash_message', 'District Jobs Meta Record  updated successfully');
      }elseif($user->type == 'province'){
        DB::table("province")->where('id', $user->dept_id)->update([
           'jobs_meta' => json_encode($jobsmeta),
        ]);
        return back()->with('flash_message', 'Province Jobs Meta Record  updated successfully');

      }elseif($user->type == 'national'){
        return redirect(route('base_url')."/404");
        DB::table("national")->where('id', $user->dept_id)->update([
           'jobs_meta' => json_encode($jobsmeta),
        ]);
        return back()->with('flash_message', 'National Jobs Meta Record  updated successfully');

      }else{
        return redirect(route('base_url').'/404');
      }
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id' , $user->dept_id)->first();
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id' , $user->dept_id)->first();

    }elseif($user->type == 'national'){
        return redirect(route('base_url')."/404");
      $data = DB::table('national')->where('id' , $user->dept_id)->first();

    }else{
        return redirect(route('base_url').'/404');      
    }
    return view('admin.district.meta.jobs-meta' , compact('data'));
  }
  function notificationMeta(){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has("submit")){

      $schema= request('schema');
      $type= request('type');
      $schm = array();
      for($a = 0; $a < count($type); $a++){
          if ($type[$a] !="") {
               $schm[]= array(
                  "schema" => $schema[$a],
                  "type" => $type[$a]
              );  
           }     
      }  
      $schema= (json_encode($schm));
      $notificationmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
      );
      if($user->type == 'district'){
        DB::table("cities")->where('id', $user->dept_id)->update([
           'notification_meta' => json_encode($notificationmeta),
        ]);
        return back()->with('flash_message', 'District Notification Meta Record  updated successfully');
      }elseif($user->type == 'province'){
        DB::table("province")->where('id', $user->dept_id)->update([
           'notification_meta' => json_encode($notificationmeta),
        ]);
        return back()->with('flash_message', 'Province Notification Meta Record  updated successfully');

      }elseif($user->type == 'national'){
        DB::table("national")->where('id', $user->dept_id)->update([
           'notification_meta' => json_encode($notificationmeta),
        ]);
        return back()->with('flash_message', 'National Notification Meta Record  updated successfully');

      }else{
        return redirect(route('base_url').'/404');
      }
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id' , $user->dept_id)->first();
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id' , $user->dept_id)->first();

    }elseif($user->type == 'national'){
      $data = DB::table('national')->where('id' , $user->dept_id)->first();

    }else{
        return redirect(route('base_url').'/404');      
    }
    return view('admin.district.meta.notification-meta' , compact('data'));
  }
  function eventsmeta(Request $request){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has("submit")){
        $this->validate($request, [
            'meta_title' => 'required',
        ]);
        $schema= request('schema');
        $type= request('type');
        $schm = array();
        for($a = 0; $a < count($type); $a++){
          if ($type[$a] !="") {
            $schm[]= array(
              "schema" => $schema[$a],
              "type" => $type[$a]
            );  
          }
        }  
        $schema= json_encode($schm);
        $eventsmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
        );
        if($user->type == 'district'){
          DB::table("cities")->where('id', $user->dept_id)->update([
             'events_meta' => json_encode($eventsmeta),
          ]);
          return back()->with('flash_message', 'District Events Meta Record  updated successfully');
        }elseif($user->type == 'province'){
          DB::table("province")->where('id', $user->dept_id)->update([
             'events_meta' => json_encode($eventsmeta),
          ]);
          return back()->with('flash_message', 'Province Events Meta Record  updated successfully');

        }elseif($user->type == 'national'){
          DB::table("national")->where('id', $user->dept_id)->update([
             'events_meta' => json_encode($eventsmeta),
          ]);
          return back()->with('flash_message', 'National Events Meta Record  updated successfully');

        }else{
          return redirect(route('base_url').'/404');      
        }
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id' , $user->dept_id)->first();
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id' , $user->dept_id)->first();

    }elseif($user->type == 'national'){
      $data = DB::table('national')->where('id' , $user->dept_id)->first();

    }else{
        return redirect(route('base_url').'/404');      
    }
    // dd($data);
    return view('admin.district.meta.events-meta' , compact('data'));
  }
  function newsmeta(){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has("submit")){

        $schema= request('schema');
        $type= request('type');
        $schm = array();
        if(!empty($type)){
          for($a = 0; $a < count($type); $a++){
            if ($type[$a] !="") {
              $schm[]= array(
                "schema" => $schema[$a],
                "type" => $type[$a]
              );  
            }     
          }  
        }else{
          $schm = array();
        }
        $schema= (json_encode($schm));
        $newsmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
        );
        if($user->type == 'district'){
          DB::table("cities")->where('id', $user->dept_id)->update([
             'news_meta' => json_encode($newsmeta),
          ]);
          return back()->with('flash_message', 'District News Meta Record  updated successfully');
        }elseif($user->type == 'province'){
          DB::table("province")->where('id', $user->dept_id)->update([
             'news_meta' => json_encode($newsmeta),
          ]);
          return back()->with('flash_message', 'Province News Meta Record  updated successfully');

        }elseif($user->type == 'national'){
          DB::table("national")->where('id', $user->dept_id)->update([
             'news_meta' => json_encode($newsmeta),
          ]);
          return back()->with('flash_message', 'National News Meta Record  updated successfully');

        }else{
          return redirect(route('base_url').'/404');      
        }
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id' , $user->dept_id)->first();
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id' , $user->dept_id)->first();

    }elseif($user->type == 'national'){
      $data = DB::table('national')->where('id' , $user->dept_id)->first();

    }else{
        return redirect(route('base_url').'/404');      
    }
    return view('admin.district.meta.news-meta' , compact('data'));
  }
  function membersmeta(Request $request){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has("submit")){
      $this->validate($request, [
          'meta_title' => 'required|min:3|max:200',
          'meta_description' => 'nullable|min:3|max:255',
      ]);
      $schema= request('schema');
      $type= request('type');
      $schm = array();
      if (!empty($type)) {
        for($a = 0; $a < count($type); $a++){
            if ($type[$a] !="") {
              $schm[]= array(
                  "schema" => $schema[$a],
                  "type" => $type[$a]
              );  
            }
        }  
      }else{
        $schm = array();
      }
      $schema= (json_encode($schm));
      $membersmeta = array(
            'meta_title' => request('meta_title'),
            'meta_description' => request('meta_description'),
            'meta_tags' => request('meta_tags'),
            'schema' => $schema
      );
        DB::table("cities")->where('id', $user->dept_id)->update([
               'members_meta' => json_encode($membersmeta),
            ]);
        return back()->with('flash_message', ' Record updated successfully');
    }
    $data = DB::table('cities')->where('id' , $user->dept_id)->first();
    return view('admin.district.meta.members-meta' , compact('data'));
  }
  function tahsil_list(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post') and request()->has('add')){
      $this->validate($request, [
          'name' => 'required|max:30|min:3|unique:tehsil,name',
      ]);
      $id = DB::table('tehsil')->insertGetId(['name'=>request('name'),'dept_id'=>$user->dept_id,'sort'=>0,'created_at'=>date('Y-m-d H:i:s')]);
      return back()->with('success','Tehsil name added successfully');
    }elseif(request()->isMethod('post') and request()->has('id')){
      $get_data = DB::table('tehsil')->where('id',request('id'))->first();
      if($get_data){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $check = DB::table('tehsil')->where('id','!=',request('id'))->where('name',request('name'))->first();
        if($check){
          return back()->with('error',request('name').' Name is already exist.');
        }
        DB::table('tehsil')->where('id',$get_data->id)->update(['name'=>request('name')]);
        return back()->with('success','Tehsil Name updated successfully');  
      }
      return back()->with('error','Tehsil id cannot not exist');
    }elseif(request()->has('id') and is_numeric(request('id')) and request('id') > 0){
      $get_data = DB::table('tehsil')->where(['id'=>request('id'),'dept_id'=>$user->dept_id])->first();
      $record = DB::table('tehsil')->where('dept_id',$user->dept_id)->orderby('sort','asc')->get();
      return view('admin.district.tehsil-list' , compact('record','get_data'));
    }elseif(request()->has('del') and is_numeric(request('del')) and request('del') > 0){
      $get_data = DB::table('tehsil')->where(['id'=>request('del'),'dept_id'=>$user->dept_id])->delete();
      return redirect(route('tehsil'))->with('success','Tehsil deleted successfully');
    }
    $record = DB::table('tehsil')->where('dept_id',$user->dept_id)->orderby('sort','asc')->get();
    return view('admin.district.tehsil-list' , compact('record'));
  }
  function cabinet_content(Request $request){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post')){
        $this->validate($request, [
            'message_heading' => 'nullable|max:100',
            'description' => 'required|min:3|max:10000',
        ]);
      if($user->type == 'district'){
        $record = DB::table('cities')->where('id',$user->dept_id)->first();
      }elseif($user->type == 'province'){
        $record = DB::table('province')->where('id',$user->dept_id)->first();
      }else{
        $record = DB::table('national')->where('id',$user->dept_id)->first();
      }
      if(!empty($record)){
        $cabinet_json = (!empty($record->cabinet))?json_decode($record->cabinet,true):array();
      }else{
        $cabinet_json = array();
      }
      $data['message_heading'] = request('message_heading');
      $data['message_body'] = request('message_body');
      $data['description'] = request('description');
      // dd($cabinet_json);
      $sd = array_merge($cabinet_json,$data);

      if($user->type == 'district'){
        DB::table('cities')->where('id',$user->dept_id)->update(['cabinet_team'=>json_encode($sd)]);
        return back()->with('success','Record updated successfully');
      }elseif($user->type == 'province'){
        DB::table('province')->where('id',$user->dept_id)->update(['cabinet_team'=>json_encode($sd)]);
        return back()->with('success','Record updated successfully');
      }else{
        DB::table('national')->update(['cabinet_team'=>json_encode($sd)]);
        return back()->with('success','Record updated successfully');
      }
    }
    if($user->type == 'district'){
      $get_data = DB::table('cities')->where('id',$user->dept_id)->first();
      return view('admin.district.cabinet-content' , compact('get_data'));

    }elseif($user->type == 'province'){
      $get_data = DB::table('province')->where('id',$user->dept_id)->first();
      return view('admin.district.cabinet-content' , compact('get_data'));

    }elseif($user->type == 'national'){
      $get_data = DB::table('national')->first();
      return view('admin.district.cabinet-content' , compact('get_data'));

    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  function  about_cabinet_meta (Request $request)
  {
    $username = Auth::user()->username;
    $user = Db::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post')){
      $this->validate($request, [
          'meta_title' => 'required|max:200|min:3',
          'meta_description' => 'nullable|max:255|min:3',
      ]);
      $schema= request('schema');
      $type= request('type');
      $schm = array();
      for($a = 0; $a < count($type); $a++){
          if ($type[$a] !="") {
               $schm[]= array(
                  "schema" => $schema[$a],
                  "type" => $type[$a]
              );  
           }     
      }  
      $schema= (json_encode($schm));
      $cabinetmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
      );

      if($user->type == 'district'){
        DB::table('cities')->where('id',$user->dept_id)->update(['cabinet_meta'=>json_encode($cabinetmeta)]); 
        // dd($data);
        return back()->with('success', 'Meta setting updated successfully');
      }elseif($user->type == 'province'){
        DB::table('province')->where('id',$user->dept_id)->update(['cabinet_meta'=>json_encode($cabinetmeta)]); 
        return back()->with('success', 'Meta setting updated successfully');
      }elseif($user->type == 'national'){
        DB::table('national')->update(['cabinet_meta'=>json_encode($cabinetmeta)]);
        // dd($data); 
        return back()->with('success', 'Meta setting updated successfully');
      }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
      }
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id',$user->dept_id)->first();
      return view('admin.district.meta.about-cabinet' , compact('data'));
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id',$user->dept_id)->first(); 
      return view('admin.district.meta.about-cabinet' , compact('data'));
    }elseif($user->type == 'national'){
      $data = DB::table('national')->first();
      // dd($data); 
      return view('admin.district.meta.about-cabinet' , compact('data'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  function  cabinet_team_meta(Request $request)
  {
    $username = Auth::user()->username;
    $user = Db::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post')){
        $this->validate($request, [
            'meta_description' => 'nullable|min:3|max:255',
            'meta_title' => 'required|min:3|max:200',
        ]);

      $schema= request('schema');
      $type= request('type');
      $schm = array();
      if(!empty($schema)){
        for($a = 0; $a < count($schema); $a++){
          if ($type[$a] !="") {
             $schm[]= array(
                "schema" => $schema[$a],
                "type" => $type[$a]
            );  
          }     
        }  
      }else{
        $schm = array();
      }
      $schema= (json_encode($schm));
      $cabinetmeta = array(
          'meta_title' => request('meta_title'),
          'meta_description' => request('meta_description'),
          'meta_tags' => request('meta_tags'),
          'schema' => $schema
      );
      if($user->type == 'province'){
        DB::table("province")->where('id',$user->dept_id)->update([
           'cabinet_team_meta' => json_encode($cabinetmeta),
        ]);
        

      }elseif($user->type == 'district'){
        DB::table("cities")->where('id',$user->dept_id)->update([
           'cabinet_team_meta' => json_encode($cabinetmeta),
        ]);
      }elseif($user->type == 'national'){
        DB::table("national")->update([
           'cabinet_team_meta' => json_encode($cabinetmeta),
        ]);

      }
      return back()->with('success', 'Meta setting updated successfully');
    }
    if($user->type == 'district'){
      $data = DB::table('cities')->where('id',$user->dept_id)->first(); 
      // dd($data);
      return view('admin.district.meta.cabinet-team' , compact('data'));
    }elseif($user->type == 'province'){
      $data = DB::table('province')->where('id',$user->dept_id)->first(); 
      // dd($data);
      return view('admin.district.meta.cabinet-team' , compact('data'));
    }elseif($user->type == 'national'){
      $data = DB::table('national')->where('id',$user->dept_id)->first(); 
      return view('admin.district.meta.cabinet-team' , compact('data'));
    }else{
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }

  function fund_request(Request $request)
  {
    $type = Auth::user()->type;
    if($type != "province"){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->isMethod('post') and request()->has('action') and request('action') == 'reject'){
        $id = request('id');
        $reason = request('reason');
        $get_record = DB::table('district_ledger')->where(['id'=>$id,'province'=>auth()->user()->dept_id])->where('status','Deliver')->first();
        if($get_record){
          $history = json_decode($get_record->history,true);
          if(!is_array($history)){
            $history = [];
          }
          $array = ['change_status' => 'Requset is rejected by ('.Auth::user()->username.') on ('.date('d/m/Y h:i:s a').') due to '.$reason];
          $_history = array_merge($history,$array);
          $data = ['status'=>'Reject','history'=>json_encode($_history)];
          DB::table('district_ledger')->where(['id'=>$id,'province'=>auth()->user()->dept_id])->update($data);
          return json_encode('success');
        }else{
          return json_encode('Fund Request is not found or Request status is already changed. Please refresh page and try agian.');
        }
    }elseif(request()->has('approve') and is_numeric(request('approve')) and request('approve') > 0){
      $check = DB::table('district_ledger')->where(['id'=>request('approve'),'province'=>auth('admin')->user()->dept_id])->first();
      if($check){
        if($check->status == 'Deliver'){
          $history = json_decode($check->history,true);
          if(!is_array($history)){
            $history = [];
          }
          $array = ['change_status' => 'Fund received by ('.Auth::user()->username.') on ('.date('d/m/Y h:i:s a').')'];
          $_history = array_merge($history,$array);
          DB::table('district_ledger')->where(['id'=>request('approve'),'province'=>auth('admin')->user()->dept_id])->update(['status'=>'Delivered','history'=>json_encode($_history)]);
          return back()->with('success','Fund request accepted successfully');
        }elseif($check->status == 'Reject'){
          return back()->with('error','Request already submit against this fund');
        }elseif($check->status == 'Delivered'){
          return back()->with('error','Request already submit against this fund');
        }else{
          return back();
        }
      }else{
        return back()->with('error','Fund request cant exist.');
      }
      return view('admin.district.add-funds' , compact('get_data','remaining'));
    }
    $record = DB::table('district_ledger')->where(['province'=>auth('admin')->user()->dept_id,'ledger'=>'-'])->get();
    return view('admin.district.fund-request',compact('record')); 
  }

  function fcledger_report(Request $request)
  {
    if(request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
      $collector = request('collector');
      $date_from = request('date_from');
      $date_to = request('date_to');
      $query = "SELECT * FROM ledger WHERE dept_id = '".auth('admin')->user()->dept_id."' ";
      if(!empty($collector)){
        $query .= "AND collector_id = '$collector'";
      }
      if (!empty($date_from) or !empty($date_to)) {
        
        $_from = implode('-', array_reverse(explode('/',$date_from)));
        $_to = implode('-', array_reverse(explode('/',$date_to)));
        $from = (validate_date($date_from))?$_from:"";
        $to = (validate_date($date_to))?$_to:"";
        if(!empty($from)){
          $query .= "AND date >= '$from'";
        }if(!empty($to)){
          $query .= "AND date <= '$to'";
        }
      }
      $query .= " ORDER BY id DESC";
      $record = DB::select($query);
    }else{
      $record = DB::table('ledger')->where('dept_id',auth('admin')->user()->dept_id)->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where('district',auth('admin')->user()->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',auth('admin')->user()->dept_id)->get();
    return view('admin.district.reports.ledger' , compact('record','users','user_info'));
  }
  function fcledger_pdf(Request $request)
  {
      $file = 'FC Ledger of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_fcledger_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
  }
  function view_fcledger_pdf()
  {
    if(request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
      $collector = request('collector');
      $date_from = request('date_from');
      $date_to = request('date_to');
      $query = "SELECT * FROM ledger WHERE dept_id = '".auth('admin')->user()->dept_id."' ";
      if(!empty($collector)){
        $query .= "AND collector_id = '$collector'";
      }
      if (!empty($date_from) or !empty($date_to)) {
        
        $_from = implode('-', array_reverse(explode('/',$date_from)));
        $_to = implode('-', array_reverse(explode('/',$date_to)));
        $from = (validate_date($date_from))?$_from:"";
        $to = (validate_date($date_to))?$_to:"";
        if(!empty($from)){
          $query .= "AND date >= '$from'";
        }if(!empty($to)){
          $query .= "AND date <= '$to'";
        }
      }
      $query .= " ORDER BY id DESC";
      $record = DB::select($query);
    }else{
      $record = DB::table('ledger')->where('dept_id',auth('admin')->user()->dept_id)->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where('district',auth('admin')->user()->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',auth('admin')->user()->dept_id)->get();
    return view('admin.district.reports.ledger-pdf' , compact('record','users','user_info'));
  }
  function dcledger_report(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user->type != "district"){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->has('user') or request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
        $district_user = request('user');
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $query = "SELECT * FROM district_ledger WHERE district = '".$user->dept_id."' ";
        if(!empty($district_user)){
          $query .= "AND user_id = '$district_user'";
        }
        if(!empty($collector)){
          $query .= "AND collector = '$collector'";
        }
        if (!empty($date_from) or !empty($date_to)) {          
          $_from = implode('-', array_reverse(explode('/',$date_from)));
          $_to = implode('-', array_reverse(explode('/',$date_to)));
          $from = (validate_date($date_from))?$_from:"";
          $to = (validate_date($date_to))?$_to:"";
          if(!empty($from)){
            $query .= "AND date >= '$from'";
          }if(!empty($to)){
            $query .= "AND date <= '$to'";
          }
        }
        $query .= " ORDER BY id DESC";
        $record = DB::select($query);
    }else{
      $record = DB::table('district_ledger')->where(['district' => $user->dept_id])->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where(['district'=>$user->dept_id,'status'=>'approved'])->get();
    $user_info = DB::table('user_info')->where(['district'=>$user->dept_id,'collector'=>'yes'])->get();
    $district_users = DB::table('admin')->where(['type'=>'district','dept_id'=>$user->dept_id])->get();
    $provinces = DB::table('province')->get();
    return view('admin.district.reports.dcledger',compact('record','users','user_info','district_users','provinces'));
  }
  function dcledger_pdf(Request $request)
  {
      $file = 'District Ledger of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_districtledger_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
  }
  function view_districtledger_pdf()
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if($user->type != "district"){
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if(request()->has('user') or request()->has('collector') or request()->has('date_from') or request()->has('date_to')){
        $district_user = request('user');
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $query = "SELECT * FROM district_ledger WHERE district = '".$user->dept_id."' ";
        if(!empty($district_user)){
          $query .= "AND user_id = '$district_user'";
        }
        if(!empty($collector)){
          $query .= "AND collector = '$collector'";
        }
        if (!empty($date_from) or !empty($date_to)) {
          $_from = implode('-', array_reverse(explode('/',$date_from)));
          $_to = implode('-', array_reverse(explode('/',$date_to)));
          $from = (validate_date($date_from))?$_from:"";
          $to = (validate_date($date_to))?$_to:"";
          if(!empty($from)){
            $query .= "AND date >= '$from'";
          }if(!empty($to)){
            $query .= "AND date <= '$to'";
          }
        }
        $query .= " ORDER BY id DESC";
        $record = DB::select($query);
    }else{
      $record = DB::table('district_ledger')->where(['district' => $user->dept_id])->orderby('id','desc')->get();
    }
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    $district_users = DB::table('admin')->where(['type'=>'district','dept_id'=>$user->dept_id])->get();
    $provinces = DB::table('province')->get();
    return view('admin.district.reports.dcledger-pdf',compact('record','users','user_info','district_users','provinces'));
  }
  function fund_report(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    if(request()->has('del') and is_numeric(request('del'))){
      return back()->with('error','Fund cant be deleted');
    }elseif(request()->has('collector') or request()->has('date_from') or request()->has('date_to') or request()->has('search')){
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $search = request('search');
        if(!empty($collector) || !empty($date_from) || !empty($date_to) || !empty($search)){
          $query = "SELECT * FROM funds WHERE dept_id = '".$user->dept_id."' ";
          if(!empty($collector)){
            $query .= " AND deposited_to = '$collector'";
          }
          if(!empty($search)){
            $query .= " AND user_id = '$search'";
          }
          if (!empty($date_from) or !empty($date_to)) {
            
            $_from = implode('-', array_reverse(explode('/',$date_from)));
            $_to = implode('-', array_reverse(explode('/',$date_to)));
            $from = (validate_date($date_from))?$_from:"";
            $to = (validate_date($date_to))?$_to:"";
            if(!empty($from)){
              $query .= " AND deposited_on >= '$from'";
            }if(!empty($to)){
              $query .= " AND deposited_on <= '$to'";
            }
          }
          $query .= " ORDER BY id DESC";
          // dd($query);
          $record = DB::select($query);
          // dd($searchRecord);
        }else{
          $record = array();
        }
        if(empty($collector) && empty($date_from) && empty($date_to) && empty($search)){
          $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();  
        }
    }else{
      $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();
    }
    return view('admin.district.reports.fund',compact('record','users','user_info'));
  }
  function fund_pdf(Request $request)
  {
      $file = 'Fund History of '.get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type).'.pdf';
      pdf_generate($this->view_fundhistory_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
  }
  function view_fundhistory_pdf()
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    $users = DB::table('users')->where('district',$user->dept_id)->get();
    $user_info = DB::table('user_info')->where('district',$user->dept_id)->get();
    if(request()->has('del') and is_numeric(request('del'))){
      return back()->with('error','Fund cant be deleted');
    }elseif(request()->has('collector') or request()->has('date_from') or request()->has('date_to') or request()->has('search')){
        $collector = request('collector');
        $date_from = request('date_from');
        $date_to = request('date_to');
        $search = request('search');
        if(!empty($collector) || !empty($date_from) || !empty($date_to) || !empty($search)){
          $query = "SELECT * FROM funds WHERE dept_id = '".$user->dept_id."' ";
          if(!empty($collector)){
            $query .= " AND deposited_to = '$collector'";
          }
          if(!empty($search)){
            $query .= " AND user_id = '$search'";
          }
          if (!empty($date_from) or !empty($date_to)) {
            
            $_from = implode('-', array_reverse(explode('/',$date_from)));
            $_to = implode('-', array_reverse(explode('/',$date_to)));
            $from = (validate_date($date_from))?$_from:"";
            $to = (validate_date($date_to))?$_to:"";
            if(!empty($from)){
              $query .= " AND deposited_on >= '$from'";
            }if(!empty($to)){
              $query .= " AND deposited_on <= '$to'";
            }
          }
          $query .= " ORDER BY id DESC";
          // dd($query);
          $record = DB::select($query);
          // dd($searchRecord);
        }else{
          $record = array();
        }
        if(empty($collector) && empty($date_from) && empty($date_to) && empty($search)){
          $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();  
        }
    }else{
      $record = DB::table('funds')->where('dept_id',$user->dept_id)->orderby('id','desc')->get();
    }
    return view('admin.district.reports.fund-pdf',compact('record','users','user_info'));
  }
}