<?php
namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;
use Mail;
use App\Models\ContactUser;
use App\Models\ContactUs;
use Validator;
class AjaxController extends Controller {

	function contactform(Request $request)
	{
      $this->validate($request, [
        'name' => 'required|min:3|max:35',
        'email' => 'required|email',
        'contact' => 'required|min:12',
        'subject' => 'required|min:5|max:100',
        'message' => 'required|min:10|max:5000',
      ],[
        'email.email' => "Email format is invalid."
      ]);
      $r_email = "";
      $admin_detail = DB::table('contact_us')->where('user_type','admin')->first();
      if(request('r_type') == 'district'){
        $detail = DB::table('contact_us')->where('district',request('city'))->first();
        if(!empty($detail)){
          $r_email = $detail ? $detail->r_email : "";
        }
      }else{
        $r_email = request('r_email');
      }
      $get_city = DB::table('cities')->where('id',request('city'))->first();
      $city_name = ($get_city)?$get_city->name:"";
      if(!empty($admin_detail)){
        if(empty($r_email)){
          $r_email = $admin_detail->r_email;
        }
        if (request('r_type') == 'national') {
          $from = array("email"=>'pakistan@apjea.com', "label"=>request("name"));
        }else{
          $from = array("email"=>request("email"), "label"=>request("name"));
        }
        $data['reply_to'] = request("email");
        $data['name'] = request('name');
        $data['email'] = request('email');
        $data['contact'] = request('contact');
        $data['city'] = $city_name;
        $data['body'] = request('message');
        $data['subject'] = request('subject');
        $data['from'] = $from;
        $data['to'] = array("email"=>$r_email, "label"=>"APJEA Contact-Us");
        $Mail = new Mail;
        sendEmail($Mail, "email-template.contact", $data);
      }else{
        $data = array(
          "name" => request("name"),
          "email" => request("email"),
          "contact" => request("contact"),
          "city" => $city_name,
          "body" => request('message'),
          "subject" => request("subject"),
          "from" => array("email"=>request("email"), "label"=>request("name")),
          "to" => array("email"=>'kamran30kwl@gmail.com', "label"=>"APJEA Contact-Us")
        );
        // dd($data);
        $Mail = new Mail;
        sendEmail($Mail, "email-template.contact", $data);
      }
	}
  public function faqsform() {
      request()->validate([
        'name' => ['required', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ ]+$/'],
        'email' => ['required', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
        'question' => ['required', 'string'],
      ]);
      $email = ContactUser::where('email', '=', request('email'))->first();
      $from = request('email');
      $data = ContactUs::select("r_email")->first();
      $emails = explode("," , $data['r_email']);
      $subject = request('subject');
      $mail_content = 'name :' . request('name') . PHP_EOL . 'email: ' . request('email') . PHP_EOL . request('subject') . PHP_EOL . request('question');     
      foreach ($emails as $k =>$v) {
        $data = array(
            "name" => request("name"),
            "email" => request("email"),
            "phone" => request("phone"),
            "content" => request('question'),
            "subject" => "FAQs - APJEA",
            "from" => array("email"=>"$from", "label"=>request("name")),
            "to" => array("email"=>$v, "label"=>"Engr Abbas")
        );
        $Mail = new Mail;
        sendEmail($Mail, "email-template.faqs", $data); 
      }
  }
  public function ajax(Request $request)
  {
    if(request()->has('action') and request('action') == 'get-national'){
      $id = request('id');
      $type = Auth::user()->type;
      $allocate = DB::table('budget_list')->where([
          'type'=> $type , 
          'reqst_to'=> $id , 
          'budget_type' => 'allocate',
      ])->whereNull('status')->get();
      // dd([$id,$type]);
      $remaining = 0;
      if(count($allocate) > 0){
          foreach ($allocate as $value) {
              $remaining = $value->amount;
          }
      }
      return json_encode($remaining);
    }elseif(request()->has('action') and request('action') == 'national-amount'){
      $id = request('id');
      $type = Auth::user()->type;
      $get_record = DB::table('budget_list')->where('type',$type)->where('reqst_to',$id)->get();
      $get_bdg = DB::table('national_allocation')->where('allowcate_from',$id)->first();
      $total_used = 0;
      if(count($get_record) > 0){
          foreach ($get_record as $value) {
              $total_used = $total_used + $value->amount;
          }
      }
      $remaining = (!empty($get_bdg))?$get_bdg->total - $total_used:"0";
      return json_encode($remaining);
    }elseif(request()->has('action') and request('action') == 'get-districts'){
      $id = request('id');
      $data = DB::table('cities')->where('province',$id)->orderby('province','asc')->orderby('name','asc')->get();
      $rslt = array();
      if(count($data) > 0){
        foreach ($data as $value) {
          $rslt[$value->id] = $value->name;
        }
      }
      return json_encode($rslt);
    }elseif(request()->has('action') and request('action') == 'dc-users'){
      $title = request('title');
      $record = DB::table('admin')->where('type','district')->get();
      $collection = collect($record);
      $record2 = DB::table('cities')
              ->whereRaw("MATCH(name) AGAINST('$title')")
              ->orderBy('id','desc')
              ->get();
      $find = $find2 = array();

      $dds[] = collect($collection)->filter(function ($item) use ($title) {
          if(false !== stristr($item->name, $title)){
            return false !== stristr($item->name, $title);
          }elseif(false !== stristr($item->username, $title)){
            return false !== stristr($item->username, $title);
          }
      });
      foreach ($dds as $value) {
        if(!empty($value)){
          $find[] = $value;
        }
      }
      if(count($record2)){
        foreach ($record2 as $value) {
          if (count($collection->where('dept_id',$value->id)) > 0) {
            $find2[] = $collection->where('dept_id',$value->id);
          }
          if (count($collection->where('city',$value->id)) > 0) {
            $find2[] = $collection->where('city',$value->id);
          }
        }
      }
      $find = json_decode(json_encode($find),true);
      $find2 = json_decode(json_encode($find2),true);
      $abc = array_merge($find[0],$find2[0]);
      $abc = array_map("unserialize", array_unique(array_map("serialize", $abc)));
      return json_encode($abc);
    }elseif(request()->has('action') and request('action') == 'search-expense'){
      $title = request('title');
      $from = explode('/', request('date_from'));
      $to = explode('/', request('date_to'));
      if(count($from) == 3){
        $date_from = implode('-', array_reverse($from));
      }else{
        $date_from = '';
      }
      if(count($to) == 3){
        $date_to = implode('-', array_reverse($to));
      }else{
        $date_to = '';
      }
      DB::enableQueryLog();
      if(!empty(trim($title))){
        if(!empty($date_to) and !empty($date_from)){
          // echo '1';
          $record = DB::table('expense')
            ->whereRaw("MATCH(title) AGAINST('$title')")
            ->whereDate('entry_date' ,"<=" , $date_to)
            ->whereDate('entry_date' ,">=", $date_from)
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }elseif(!empty($date_to) and empty($date_from)){
          // echo '2';
          $record = DB::table('expense')
            ->whereRaw("MATCH(title) AGAINST('$title')")
            ->whereDate('entry_date' ,"<=" , $date_to)
            ->where('type' , 'govt-notification')                   
            ->orderBy('id','desc')
            ->get();

        }elseif(empty($date_to) and !empty($date_from)){
          // echo '3';
          $record = DB::table('expense')
            ->whereRaw("MATCH(title) AGAINST('$title')")
            ->whereDate('entry_date' ,">=", $date_from)
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }else{
          // echo '4';
          $record = DB::table('expense')
            ->whereRaw("MATCH(title) AGAINST('$title')")
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }
      }else{
        if(!empty($date_to) and !empty($date_from)){
          // echo '1';
          $record = DB::table('expense')
            ->whereDate('entry_date' ,"<=" , $date_to)
            ->whereDate('entry_date' ,">=", $date_from)
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }elseif(!empty($date_to) and empty($date_from)){
          // echo '2';
          $record = DB::table('expense')
            ->whereDate('entry_date' ,"<=" , $date_to)
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }elseif(empty($date_to) and !empty($date_from)){
          // echo '3';
          $record = DB::table('expense')
            ->where('entry_date' ,">=", $date_from)
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }else{
          // echo '4';
          $record = DB::table('expense')
            ->where('dept_id' , auth()->user()->dept_id)
            ->where('type' , 'district')
            ->orderBy('id','desc')
            ->get();
        }
      }
      return view('admin.layout.expense',compact('record'));
    }elseif(request()->has('action') and request('action') == 'user_ledger'){
      $id = request('id');
      $record = DB::table('ledger')->where(['id'=>$id,'dept_id'=>auth()->user()->dept_id])->first();
      // dd($record);
      $users = DB::table('users')->where(['district'=>auth()->user()->dept_id])->get();
      $admin = DB::table('admin')->where(['type'=>auth('admin')->user()->type,'dept_id'=>auth('admin')->user()->dept_id])->get();
      return view('admin.district.layouts.ledger-detail',compact('record','users','admin'));
    }elseif(request()->has('action') and request('action') == 'find-province'){
      $province = request('province');
      $province_record = DB::table('contact_us')->where('province',$province)->first();
      return view('front.temp.contact',compact('province_record'));
    }elseif(request()->has('action') and request('action') == 'find-tehsil'){
      $city = request('cityID');
      $tehsil = DB::table('tehsil')->where('dept_id',$city)->get();
      return json_decode(json_encode($tehsil),true);
    }elseif(request()->has('action') and request('action') == 'getting-users'){
      $id = request('id');
      $type = request('type');
      $rec = array();
      if ($type == 'national') {
        $record = DB::table('users')->orderby('id','asc')->get();
        $rec = json_decode(json_encode($record),true);  
      }elseif($type == 'province'){
        $record = DB::table('users')->where('province',$id)->orderby('id','asc')->get();
        $rec = json_decode(json_encode($record),true);  
      }elseif($type == 'district'){
        $record = DB::table('users')->where('district',$id)->orderby('id','asc')->get();
        $rec = json_decode(json_encode($record),true);  
      }
      $dsg = DB::table('official_dsg')->get();
      $user_info = DB::table('user_info')->get();
      $f_array = array();
      if (!empty($rec)) {
        foreach ($rec as $value) {
          $dsg_detail = $dsg->where('id',$value['designation'])->first();
          $dsg_name = (!empty($dsg_detail)) ? " - ".$dsg_detail->name : "";
          $user_info_detail = $user_info->where('user_id',$value['id'])->first();
          $user_info_name = (!empty($user_info_detail) and !empty($user_info_detail->personnel_no)) ? $user_info_detail->personnel_no." - " : "";
          $f_name = $user_info_name.$value['name'].$dsg_name;
          $f_array[] = array('id'=>$value['id'],'name'=>$f_name);
        }
      }
      return $f_array;
    }else{
      return abort(404);
    }
  }

  function update_user(Request $request)
  {
    $req_user = DB::table('users')->where('id',request('user_id'))->first();
    $user_id = request('user_id');
    if(request()->isMethod('post') and request()->has('personnal_number')){
      $validation = Validator::make($request->all(), [
          'CNIC_number' => 'nullable|regex:/^\d{5}-\d{7}-\d{1}$/|unique:users,cnic,'.$user_id,
          'dob' => 'nullable|date_format:d/m/Y|before:-18years',
          'father_name' => 'nullable',
          'full_name' => 'nullable|regex:/^[a-zA-Z ]+$/u|min:3|max:30',
          'email' => 'nullable|email',
          'appointment_date' => 'nullable|date_format:d/m/Y|after_or_equal:dob',
      ],[
        'CNIC_number.unique' => 'The CNIC number has already been taken.'
      ]);
      if($validation->passes()){
        $_his = (!empty($req_user->history)) ? json_decode($req_user->history , true) : array();
        $new_his = [auth()->user()->username.' is updated his record (Personal Information) on date: '.date('d/m/Y h:i:s A')];
        $history = array_merge($_his , $new_his);
        $dob1 = (!empty(request('dob'))) ? implode('-',array_reverse(explode('/', request('dob')))) : NULL ;
        $app1 = (!empty(request('appointment_date'))) ? implode('-',array_reverse(explode('/', request('appointment_date')))) : NULL ;
        $data_2['name'] = request('full_name');
        $data_2['cnic'] = request('CNIC_number');
        $data_2['email'] = request('email');
        $data_2['contact'] = request('phone_no');
        $data_2['history'] = json_encode($history);
        $data_2['designation'] = request('official_designation');
        DB::table('users')->where('id',request('user_id'))->update($data_2);

        $data['father_name'] = request('father_name');
        $data['personnel_no'] = request('personnal_number');
        $data['dob'] = $dob1;
        $data['appointment'] = $app1;
        $data['whatsapp_no'] = request('whatsappp_no');
        $data['blood_group'] = request('blood_group');
        $data['address'] = request('address');

        $check = DB::table('user_info')->where(['user_id'=>request('user_id'),'district'=>auth()->user()->dept_id])->first();
        if(!empty($check)){
          DB::table('user_info')->where('id',$check->id)->update($data);
        }else{
          $data['user_id'] = request('user_id');
          $data['district'] = auth()->user()->dept_id;
          DB::table('user_info')->insert($data);        
        }
        return json_encode("success");
      }else{
        return response()->json([
          'CNIC_number' => $validation->errors()->get('CNIC_number'),
          'dob' => $validation->errors()->get('dob'),
          'full_name' => $validation->errors()->get('full_name'),
          'email' => $validation->errors()->get('email'),
          'appointment_date' => $validation->errors()->get('appointment_date'),
        ]);        
      }
    }elseif(request()->isMethod('post') and request()->has('nominee_name')){
      $_his = (!empty($req_user->history)) ? json_decode($req_user->history , true) : array();
      $new_his = [auth()->user()->username.' is updated his record (Nominee Information) on date: '.date('d/m/Y h:i:s A')];
      $history = array_merge($_his , $new_his);
      $hist__['history'] = json_encode($history);
      DB::table('users')->where('id',$req_user->id)->update($hist__);
      $data['full_name'] = request('nominee_name');
      $data['relation'] = request('noinee_relation');
      $data['father_name'] = request('guardian_name');
      $data['cnic'] = request('nominee_cnic');
      $data['cell_no'] = request('nominee_phone_no');
      $data['email'] = request('nominee_email');
      $check = DB::table('nominee_information')->where(['user_id'=>request('user_id')])->first();
      if(!empty($check)){
        DB::table('nominee_information')->where('id',$check->id)->update($data);
      }else{
        $data['user_id'] = request('user_id');
        DB::table('nominee_information')->insert($data);        
      }
      return json_encode("success");
    }elseif(request()->isMethod('post') and request()->has('relation') ){
      $_his = (!empty($req_user->history)) ? json_decode($req_user->history , true) : array();
      $new_his = [auth()->user()->username.' is updated his record (Family Information) on date: '.date('d/m/Y h:i:s A')];
      $history = array_merge($_his , $new_his);
      $hist__['history'] = json_encode($history);
      DB::table('users')->where('id',$req_user->id)->update($hist__);
      $names = request('name');
      $relations = request('relation');
      $age = request('age');
      $status = request('status');
      $final_array = array();
      $check_array = 0;
      if(count($names) > 0){
        for ($i = 0; $i < count($names); $i++) {
          if (!empty($names[$i]) || !empty($relations[$i]) || !empty($age[$i]) || !empty($status[$i])) {
              $final_array[] = [
                'name' => $names[$i],
                'relation' => $relations[$i],
                'age' => $age[$i],
                'status' => $status[$i],
              ];   
          }else{
            $check_array++;
          }   
        }
      }
      if ($check_array > 0) {
        return json_encode('error');
      }
      $check = DB::table('user_info')->where(['user_id'=>request('user_id'),'district'=>auth()->user()->dept_id])->first();
      if(!empty($check)){
        DB::table('user_info')->where(['user_id'=>request('user_id'),'district'=>auth()->user()->dept_id])->update(['family_info'=>json_encode($final_array)]);
      }else{
        DB::table('user_info')->insert([
          'family_info'=>json_encode($final_array),
          'user_id' => request('user_id'),
          'district' => auth()->user()->dept_id,
        ]);
      }
      return json_encode('success');
    }elseif(request()->isMethod('post') and request()->has('profile_image')){
      $validation = Validator::make($request->all(), [
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
      ]);
      if($validation->passes()){
        $_his = (!empty($req_user->history)) ? json_decode($req_user->history , true) : array();
        $new_his = [auth()->user()->username.' is updated his Profile Photo on date: '.date('d/m/Y h:i:s A')];
        $history = array_merge($_his , $new_his);
        $hist__['history'] = json_encode($history);
        DB::table('users')->where('id',$req_user->id)->update($hist__);
        $fileName = time().'.'.$request->file('profile_image')->extension();
        $request->file('profile_image')->move('images', $fileName);
        $check = DB::table('user_info')->where(['user_id'=>request('user_id'),'district'=>auth()->user()->dept_id])->first();
        if(!empty($check)){
          DB::table('user_info')->where('id',$check->id)->update(['img'=>$fileName]);
        }else{
          $data['user_id'] = request('user_id');
          $data['district'] = auth()->user()->dept_id;
          $data['img'] = $fileName;
          DB::table('user_info')->insert([$data]);        
        }
        return json_encode("success");
      }else{
        return response()->json([
          'profile_image' => $validation->errors()->get('cheque_image')
        ]);
      }
      return json_encode("success");
    }else{
      return json_encode('Please choose an image');
    }
  }
} 