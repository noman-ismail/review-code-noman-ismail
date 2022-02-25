<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Auth;
use SoapClient;

class CommonController extends Controller
{
	function expense_sheet(Request $request)
	{
		$username = Auth::user()->username;
		$user = DB::table('admin')->where('username',$username)->first();
		if(request()->isMethod('post')){
			
		}
		$record = DB::table('expense')->where(['dept_id'=>$user->dept_id,'type'=>$user->type])->orderby('id','desc')->get();
		return view('admin.expense-sheet' , compact('record'));
	}
	function add_expense(Request $request)
	{
		$username = Auth::user()->username;
		$user = DB::table('admin')->where('username',$username)->first();
		if(request()->isMethod('post')){
			$this->validate($request, [
				'title' => 'required|max:100',
				'amount' => 'required|numeric|max:100000000',
				'entry_date' => 'required',
				'description' => 'nullable|max:5000',
			]);
			$time = date('Y-m-d H:i:s');
			$data['title'] = request('title');
			$data['amount'] = (int)request('amount');
			$data['description'] = request('description');
			if(request()->has('id')){
				$data['entry_date'] = implode('-', array_reverse(explode('/', request('entry_date'))));
				// dd(request()->all());
				DB::table('expense')->where('id',request('id'))->update($data);
				return back()->with('success','Expense updated successfully');
			}else{
				$data['entry_date'] = date('Y-m-d');
				$data['dept_id'] = $user->dept_id;
				$data['type'] = $user->type;
				$data['created_at'] = $time;
				$id = DB::table('expense')->InsertGetId($data);
				return redirect(route('add-expense').'?id='.$id)->with('success','Expense added successfully');
			}
		}elseif(request()->has('id')){
			$get_data = DB::table('expense')->where('id',request('id'))->first();
			return view('admin.add-expense',compact('get_data'));
		}elseif(request()->has('del')){
				// DB::enableQueryLog();
			$get_data = DB::table('expense')->where([
				'dept_id' => $user->dept_id,
				'id' => request('del')
			])->delete();
			return back()->with('success','Your expense deleted successfully');
		}
		return view('admin.add-expense');
	}
}