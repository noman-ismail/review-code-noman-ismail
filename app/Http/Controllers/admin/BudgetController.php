<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;
use Validator;
use Response;

class BudgetController extends Controller
{
  function add_budget(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if (request()->isMethod('post') and request()->has('add')) {
      $this->validate($request, [
          'province' => 'required',
          'title' => 'required|max:250',
          'amount' => 'required|numeric|min:1',
          'due_date' => 'required',
          'reason' => 'required',
      ]);
      $time = date('d/m/Y h:i:s A');
      $history = ['Request is created by ('.$username.') on '.$time];
      if(!empty(request('due_date'))){
        $due_date = implode('-', array_reverse(explode('/', request('due_date'))));
      }else{
        $due_date = null;
      }
      $data['reqst_from'] = $user->dept_id;
      $data['title'] = request('title');
      $data['reqst_to'] = request('province');
      $data['amount'] = request('amount');
      $data['reason'] = request('reason');
      $data['budget_type'] = 'request';
      $data['history'] = json_encode($history);
      $data['due_date'] = $due_date;
      $data['status'] = 'pending';
      $data['year'] = date('Y');
      $data['type'] = $user->type;
      $data['created_at'] = date('Y-m-d');
      $id = DB::table('budget_list')->insertGetId($data);
      return redirect(route('add-budget')."?id=".$id)->with('success','Budget Request send successfully');
    }elseif(request()->isMethod('post') and request()->has('id') and is_numeric(request('id'))){
      $get_data = DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('id')])->first();
      $this->validate($request, [
          'province' => 'required',
          'title' => 'required|max:250',
          'amount' => 'required|numeric|min:1',
          'due_date' => 'required',
          'reason' => 'required',
      ]);
      if(!empty(request('due_date'))){
        $due_date = implode('-', array_reverse(explode('/', request('due_date'))));
      }else{
        $due_date = null;
      }
      $_his = (!empty($get_data->history)) ? json_decode($get_data->history , true) : array();
      $new_his = ['Budget request record updated by ('.auth('admin')->user()->username.') on '.date('d/m/Y h:i:s a')];
      $history = array_merge($_his,$new_his);
      $data['reqst_from'] = $user->dept_id;
      $data['title'] = request('title');
      $data['reqst_to'] = request('province');
      $data['amount'] = request('amount');
      $data['reason'] = request('reason');
      $data['budget_type'] = 'request';
      $data['due_date'] = $due_date;
      $data['status'] = 'pending';
      $data['history'] = json_encode($history);
      DB::table('budget_list')->where('id',request('id'))->update($data);
      return back()->with('success','Budget Request send successfully');

    }elseif(request()->has('id') and is_numeric(request('id'))){
      $get_data = DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('id')])->where('status','!=','delivered')->where('status','!=','approved')->first();
      if($get_data){
        return view('admin.district.budget',compact('get_data'));
      }else{
        return redirect(route('add-budget'));
      }
    }elseif(request()->has('del') and is_numeric(request('del'))){
      $record = DB::table('budget_list')->where(['id'=>request('del'),'status'=>'pending'])->first();
      if($record){
        if($user->type == 'district'){
          if ($user->dept_id == $record->reqst_from and $user->type == $record->type) {
            DB::table('budget_list')->where(['id'=>$record->id])->delete();     
            return back()->with('success','Budget deleted successfully');       
          }else{
            return redirect(route('budget-list'))->with('error','Budget does not exist.');
          }
        }elseif($user->type == 'province'){
          if ($user->dept_id == $record->reqst_to and $user->type == $record->type) {
            DB::table('budget_list')->where(['id'=>$record->id])->delete();    
            return back()->with('success','Budget deleted successfully');        
          }else{
            return redirect(route('budget-list'))->with('error','Budget does not exist.');
          }
        }elseif($user->type == 'national'){
          if ($user->dept_id == $record->reqst_from and $user->type == $record->type) {
            DB::table('budget_list')->where(['id'=>$record->id])->delete();
            return back()->with('success','Budget deleted successfully');            
          }else{
            return redirect(route('budget-list'))->with('error','Budget does not exist.');
          }
        }else{
            return redirect(route('budget-list'))->with('error','Budget does not exist.');          
        }
      }else{
        return redirect(route('budget-list'))->with('error','Budget cannot be deleted.');
      }
    }else{
      return view('admin.district.budget');
    }
  }
  function budget_list(Request $request)
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has('del') and is_numeric(request('del'))){
      return back()->with('success','How to delete budget discuss pending');
    }elseif(request()->has('search') or request()->has('panel') or request()->has('date_from') or request()->has('date_to') or request()->has('pending') or request()->has('approved') or request()->has('rejected') or request()->has('delivered')){
      $title = request('search');
      $panel = request('panel');
      $date_from = request('date_from');
      $date_to = request('date_to');
      $approved = request('approved');
      $pending = request('pending');
      $rejected = request('rejected');
      $delivered = request('delivered');
      $_from = implode('-', array_reverse(explode('/',$date_from)));
      $_to = implode('-', array_reverse(explode('/',$date_to)));
      $from = (validate_date($date_from))?$_from:"";
      $to = (validate_date($date_to))?$_to:"";
      if($user->type == 'national'){
        $dept_id = '1';
      }else{
        $dept_id = $user->dept_id;
      }
      $query = "SELECT * FROM budget_list WHERE type = '".Auth::user()->type."' AND budget_type = 'request' AND reqst_from = $dept_id ";
      if(!empty($approved)){
        $query .= "AND status = 'approved'";
      }if(!empty($delivered)){
        $query .= "AND status = 'delivered'";
      }if(!empty($pending)){
        $query .= "AND status = 'pending'";
      }if(!empty($rejected)){
        $query .= "AND status = 'rejected'";
      }if(!empty($title)){
        $query .= "AND title LIKE '%$title%'";
      }if(!empty($panel)){
        $query .= "AND reqst_to LIKE '%$panel%'";
      }if(!empty($from)){
        $query .= "AND created_at > '$from'";
      }if(!empty($to)){
        $query .= "AND created_at < '$to'";
      }
      $record = DB::select($query);
    }else{
      $record = DB::table('budget_list')->where(['budget_type'=>'request','type'=>$user->type,'reqst_from'=>$user->dept_id])->get();
    }
    $province = DB::table('province')->get();
    return view('admin.district.budget-list',compact('record','province'));
  }
  function budget_stat(Request $request)
  {
  	$username = Auth::user()->username;
  	$user = DB::table('admin')->where('username',$username)->first();
    if($user->type == 'province'){
      return view('admin.district.budget-stat');
    }else{
      
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  function budget_dis(Request $request)
  {
  	$username = Auth::user()->username;
  	$user = DB::table('admin')->where('username',$username)->first();
    $date = date('Y');
    if($user->type == 'province'){
      if(request()->isMethod('post') and request()->has('action') and request('action') == 'update'){
        $district = request('district');
        $province = request('province');
        $national = request('national');
        if(!empty($district) and count($district) > 0){
          foreach ($district as $key => $value) {
            $data['annual'] = $value[1][0];
            $data['supplementary'] = $value[2][0];
            $data['revised'] = $value[3][0];
            $data['total'] = $value[4][0];
            $data['type'] = 'city';
            $data['allowcate_from'] = $user->dept_id;
            $data['allowcate_to'] = $value[0][0];
            $data['year'] = $date;
            $check1 = DB::table('budget_allocation')->where([
              'year'=>$date,
              'allowcate_from'=>$data['allowcate_from'],
              'allowcate_to'=>$data['allowcate_to'],
              'type' => 'city'
            ])->first();
            if($check1){
              DB::table('budget_allocation')->where('id',$check1->id)->update($data);
            }else{
              DB::table('budget_allocation')->insert($data);
            }
          }
        }
        $data22['annual'] = $province[0]; 
        $data22['supplementary'] = $province[1]; 
        $data22['revised'] = $province[2]; 
        $data22['total'] = $province[3]; 
        $data22['allowcate_from'] = $user->dept_id;
        $data22['allowcate_to'] = $user->dept_id;
        $data22['type'] = 'province';
        $data22['year'] = $date;
          $check2 = DB::table('budget_allocation')->where([
            'year'=>$date,
            'allowcate_from'=>$data22['allowcate_from'],
            'allowcate_to'=>$data22['allowcate_to'],
            'type' => 'province'
          ])->first();
          if($check2){
            DB::table('budget_allocation')->where('id',$check2->id)->update($data22);
          }else{
            DB::table('budget_allocation')->insert($data22);
          }
        $_data['annual'] = $national[0]; 
        $_data['supplementary'] = $national[1]; 
        $_data['revised'] = $national[2]; 
        $_data['total'] = $national[3]; 
        $_data['allowcate_from'] = $user->dept_id; 
        $_data['year'] = $date; 
          $check3 = DB::table('national_allocation')->where([
            'year'=>$date,
            'allowcate_from'=>$_data['allowcate_from']
          ])->first();
          if($check3){
            DB::table('national_allocation')->where('id',$check3->id)->update($_data);
          }else{
            DB::table('national_allocation')->insert($_data);
          }
        return json_encode('success');
      }
      // $record = DB::table('budget_distribution')->get();
      return view('admin.district.budget-distribution');
    }else{
      
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }
  function budget_distribution(Request $request)
  {
    $date = date('Y');
    if(auth('admin')->user()->type != 'province'){
      
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
    if (request()->isMethod('post') and request()->has('action') and request('action') == 'view') {
      $record = DB::table('budget_list')->where(['budget_type'=>'allocate','id'=>request('id')])->first();
      return view('admin.district.layouts.allocate',compact('record'));
    }
    $record = DB::table('budget_list')->where(['budget_type'=>'allocate','reqst_from'=>auth('admin')->user()->dept_id])->get();
    return view('admin.district.budget-distribution', compact('record'));
  }
  function budget_allocation(Request $request)
  {
    $date = date('Y');
    if (request()->isMethod('post')) {
        $this->validate($request, [
            'allowcate_to' => 'required',
            'remaining' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:1|max:999999999',
            'reason' => 'required',
            'title' => 'required',
        ]);
        $arr = explode('-', request('allowcate_to'));
        $type = $request_to = "";
        if(array_key_exists(1, $arr)){
          if($arr[1] == 'n'){
            $type = 'national';
            $request_to = $arr[0];
          }elseif($arr[1] == 'p'){
            $type = 'province';
            $request_to = $arr[0];
          }elseif($arr[1] == 'd'){
            $type = 'district';
            $request_to = $arr[0];
          }
        }
        $data['title'] = request('title');
        $data['reqst_from'] = auth('admin')->user()->dept_id;
        $data['budget_type'] = 'allocate';
        $data['type'] = $type;
        $data['reqst_to'] = $request_to;
        $data['amount'] = request('amount');
        $data['year'] = $date;
        $data['reason'] = request('reason');
        if(request()->has('add')){
          $history = ['Fund allocate on ('.date('d/m/Y h:i:s a').') by '.auth('admin')->user()->name];
          $data['history'] = json_encode($history);
          $data['created_at'] = date('Y-m-d H:i:s');
          DB::table('budget_list')->insert($data);
          return back()->with('success','Budget allocated successfully.');
        }else{
          $record = DB::table('budget_list')->where('id',request('id'))->first();
          if($record){
            $history = ['Fund allowcation is updated on ('.date('d/m/Y h:i:s a').') by '.auth('admin')->user()->name];
            $data['history'] = json_encode($history);
            $_history = json_decode($record->history , true);
            $__his = array_merge($_history,$history);
            $data['history'] = json_encode($__his);
            DB::table('budget_list')->where('id',$record->id)->update($data);
            return back()->with('success','Budget allocated successfully.');
          }else{
            
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
          }
        }
     }
     return view('admin.district.budget-allocate'); 
  }
  function budget_request(Request $request){
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->isMethod('post') and request()->has('action') and request('action') == 'view'){
      $id = request('id');
      $data = DB::table('budget_list')->where(['budget_type'=>'request','id'=>$id])->first();
      return view('admin.layout.budget-detail' , compact('data'));
    }
    if($user->type == 'province'){
      if(request()->isMethod('post') and request()->has('action') and request('action') == 'payment'){
        $id = request('id');
        $data = DB::table('budget_list')->where(['budget_type'=>'request','id'=>$id])->first();
        return view('admin.layout.budget-approval' , compact('data'));
      }elseif(request()->isMethod('post') and request()->has('action') and request('action') == 'reject'){
        $id = request('id');
        $reason = request('reason');
        $get_record = DB::table('budget_list')->where(['budget_type'=>'request','id'=>$id])->where('status','pending')->first();
        if($get_record){
          $history = json_decode($get_record->history,true);
          $array = ['Requset is rejected by ('.Auth::user()->username.') due to '.$reason];
          $_history = array_merge($history,$array);
          $data = ['status'=>'reject','history'=>json_encode($_history)];
          DB::table('budget_list')->where(['budget_type'=>'request','id'=>$id])->update($data);
          return json_encode('success');
        }else{
          return json_encode('Budget Request is not found or Request status is already changed. Please refresh page and try agian.');
        }
      }elseif(request()->has('approve') and is_numeric(request('approve')) and request('approve') > 0){
        $id = request('approve');
        $check = DB::table('budget_list')->where(['budget_type'=>'request','id'=>$id])->first();
        if($check){
          $history = json_decode($check->history,true);
          $array = ['Requset is approved by ('.Auth::user()->username.') on '.date('d/m/Y h:i:s a')];
          $_history = array_merge($history,$array);
          $data = ['status'=>'approved','history'=>json_encode($_history)];
          DB::table('budget_list')->where(['budget_type'=>'request','id'=>$check->id])->update($data);
          return back()->with('success','Budget approved successfully');
        }else{
          return back()->with('error','Record not found. Please refresh a page and try again');
        }
      }elseif(request()->isMethod('post') and request()->has('status') and request('status') == 'check'){
        $validation = Validator::make($request->all(), [
          'cheque_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        if($validation->passes()){
          $fileName = time().'.'.$request->file('cheque_image')->extension();
          $request->file('cheque_image')->move('images/cheque', $fileName);
          $time = date('d/m/Y H:i:s:a');
          $check = DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->first();
          if($check){
            $_his = (!empty($check->history)) ? json_decode($check->history , true) : array();
          }else{
            return response()->json([
              'trans_img' => 'This budget request may be already submit or deleted. Refresh page and try again.'
            ]);
          }
          $data = [
            'This payment has been submitted through Cheque on'.$time,
            'title' => request('title'),
            'bank' => request('bank'),
            'no' => request('no'),
            'date' => request('date'),
            'img' => $fileName
          ];
          $f_history = array_merge($_his,$data);
          DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->update([
            'history'=>json_encode($f_history),
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
          'cash_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        if($validation->passes()){
          $fileName = time().'.'.$request->file('cash_image')->extension();
          $request->file('cash_image')->move('images/cheque', $fileName);
          $time = date('d/m/Y H:i:s:a');
          $check = DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->first();
          if($check){
            $_his = (!empty($check->history)) ? json_decode($check->history , true) : array();
          }else{
            return response()->json([
              'trans_img' => 'This budget request may be already submit or deleted. Refresh page and try again.'
            ]);
          }
          $data = [
            'This payment has been submitted through Cash on'.$time,
            'title' => request('title'),
            'bank' => request('bank'),
            'no' => request('cash_no'),
            'date' => request('cash_date'),
            'trans_id' => request('transaction_id'),
            'img' => $fileName
          ];
          $f_history = array_merge($_his,$data);
          DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->update([
            'history'=>json_encode($f_history),
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
          'trans_img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        if($validation->passes()){
          $fileName = time().'.'.$request->file('trans_img')->extension();
          $request->file('trans_img')->move('images/cheque', $fileName);
          $time = date('d/m/Y H:i:s:a');
          $check = DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->first();
          if($check){
            $_his = (!empty($check->history)) ? json_decode($check->history , true) : array();
          }else{
            return response()->json([
              'trans_img' => 'This budget request may be already submit or deleted. Refresh page and try again.'
            ]);
          }
          $data = [
            'This payment has been submitted through Bank Transfer on'.$time,
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
          $f_history = array_merge($_his,$data);
          DB::table('budget_list')->where(['budget_type'=>'request','id'=>request('hidden_id')])->update([
            'history'=>json_encode($f_history),
            'status'=>'delivered'
          ]);
          return json_encode('success');
        }else{
          return response()->json([
            'trans_img' => $validation->errors()->get('trans_img')
          ]);
        }
      }
      // if()
      $record = DB::table('budget_list')->where([
        'reqst_to' => $user->dept_id,'budget_type'=>'request',
      ])->get();
      return view('admin.district.budget-request',compact('record'));
    }else{
      
      session(['back_url'=>url()->previous()]);
      return redirect(route('404'));
    }
  }

  function budget_pdf(Request $request)
  {
      $file = 'Budget List Report'.'.pdf';
      pdf_generate($this->view_budget_pdf(),$file,true,false,'legal');
      $fileurl = base_path("images/".$file);
      return Response::download($fileurl, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($fileurl)))->deleteFileAfterSend(true);
  }
  function view_budget_pdf()
  {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    if(request()->has('del') and is_numeric(request('del'))){
      return back()->with('success','How to delete budget discuss pending');
    }elseif(request()->has('search') or request()->has('panel') or request()->has('date_from') or request()->has('date_to') or request()->has('pending') or request()->has('approved') or request()->has('rejected') or request()->has('delivered')){
      $title = request('search');
      $panel = request('panel');
      $date_from = request('date_from');
      $date_to = request('date_to');
      $approved = request('approved');
      $pending = request('pending');
      $rejected = request('rejected');
      $delivered = request('delivered');
      $_from = implode('-', array_reverse(explode('/',$date_from)));
      $_to = implode('-', array_reverse(explode('/',$date_to)));
      $from = (validate_date($date_from))?$_from:"";
      $to = (validate_date($date_to))?$_to:"";
      if($user->type == 'national'){
        $dept_id = '1';
      }else{
        $dept_id = $user->dept_id;
      }
      $query = "SELECT * FROM budget_list WHERE type = '".Auth::user()->type."' AND budget_type = 'request' AND reqst_from = $dept_id ";
      if(!empty($approved)){
        $query .= "AND status = 'approved'";
      }if(!empty($delivered)){
        $query .= "AND status = 'delivered'";
      }if(!empty($pending)){
        $query .= "AND status = 'pending'";
      }if(!empty($rejected)){
        $query .= "AND status = 'rejected'";
      }if(!empty($title)){
        $query .= "AND title LIKE '%$title%'";
      }if(!empty($panel)){
        $query .= "AND reqst_to LIKE '%$panel%'";
      }if(!empty($from)){
        $query .= "AND created_at > '$from'";
      }if(!empty($to)){
        $query .= "AND created_at < '$to'";
      }
      $record = DB::select($query);
    }else{
      $record = DB::table('budget_list')->where(['budget_type'=>'request','type'=>$user->type,'reqst_from'=>$user->dept_id])->get();
    }
    $province = DB::table('province')->get();
    return view('admin.district.reports.budget-list',compact('record','province'));
  }
}