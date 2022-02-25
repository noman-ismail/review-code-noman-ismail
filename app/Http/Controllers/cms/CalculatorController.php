<?php

namespace App\Http\Controllers\cms;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Hash;
use DB;
use Auth;
use SoapClient;

class CalculatorController extends Controller
{
	function meta_pension_paper(Request $request)
	{
        if(request()->isMethod('post')){
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
	      $membersmeta = array(
	            'meta_title' => request('meta_title'),
	            'meta_description' => request('meta_description'),
	            'meta_tags' => request('meta_tags'),
                'og_image'=>request('og_image'),
	            'microdata' => $schema
	      );
	        DB::table("meta")->where('page_name', 'pension-paper')->update($membersmeta);
	        return back()->with('flash_message', 'Meta Record updated successfully');
        }
        $data = DB::table('meta')->where('page_name','pension-paper')->first();
        return view('admin.calculators.meta.pension-paper',compact('data'));		
	}
	function meta_pension_calculator(Request $request)
	{
        if(request()->isMethod('post')){
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
	      $membersmeta = array(
	            'meta_title' => request('meta_title'),
	            'meta_description' => request('meta_description'),
	            'meta_tags' => request('meta_tags'),
                'og_image'=>request('og_image'),
	            'microdata' => $schema
	      );
	        DB::table("meta")->where('page_name', 'pension-calculator')->update($membersmeta);
	        return back()->with('flash_message', 'Meta Record updated successfully');
        }
        $data = DB::table('meta')->where('page_name','pension-calculator')->first();
        return view('admin.calculators.meta.pension-calculator',compact('data'));		
	}
	function meta_gp_fund(Request $request)
	{
        if(request()->isMethod('post')){
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
	      $membersmeta = array(
            'meta_title' => request('meta_title'),
            'meta_description' => request('meta_description'),
            'meta_tags' => request('meta_tags'),
            'og_image'=>request('og_image'),
            'microdata' => $schema
	      );
	        DB::table("meta")->where('page_name', 'gp-fund')->update($membersmeta);
	        return back()->with('flash_message', 'Meta Record updated successfully');
        }
        $data = DB::table('meta')->where('page_name','gp-fund')->first();
        return view('admin.calculators.meta.gp-fund',compact('data'));		
	}
	function pension_paper(Request $request)
	{
		if(request()->isMethod('post')){
	        DB::table("meta")->where('page_name', 'pension-paper')->update(['content'=>request('description')]);
	        return back()->with('success','Record updated successfully');
		}
        $data = DB::table('meta')->where('page_name','pension-paper')->first();
        return view('admin.calculators.pension-paper',compact('data'));	
	}
	function pension_calculator(Request $request)
	{
		if(request()->isMethod('post')){
	        DB::table("meta")->where('page_name', 'pension-calculator')->update(['content'=>request('description')]);
	        return back()->with('success','Record updated successfully');
		}
        $data = DB::table('meta')->where('page_name','pension-calculator')->first();
        return view('admin.calculators.pension-calculator',compact('data'));	
	}
	function gp_fund(Request $request)
	{
		if(request()->isMethod('post')){
	        DB::table("meta")->where('page_name', 'gp-fund')->update(['content'=>request('description')]);
	        return back()->with('success','Record updated successfully');
		}
        $data = DB::table('meta')->where('page_name','gp-fund')->first();
        return view('admin.calculators.gp-fund',compact('data'));	
	}

}