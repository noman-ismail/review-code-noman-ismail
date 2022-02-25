<?php

	function get_user_detail($id='0')
	{
		if($id > 0){
			$record = DB::table('users')->where('id',$id)->first();
			return json_decode(json_encode($record) , true);
		}else{
			return array();
		}
	}
	function get_userinfo_detail($id='0')
	{
		if($id > 0){
			$record = DB::table('user_info')->where('user_id',$id)->first();
			return json_decode(json_encode($record) , true);
		}else{
			return array();
		}
	}
	function get_user_designation($id='')
	{
		if($id == ''){
			return "";
		}else{
			$record = DB::table('society_dsg')->where('id',$id)->first();
			return $record ? $record->name : "";
		}
	}
	function get_user_off_dsg($id='')
	{
		if($id == ''){
			return "";
		}else{
			$record = DB::table('official_dsg')->where('id',$id)->first();
			return $record ? $record->name : "";
		}
	}
	function get_user_cityName($id='')
	{
		if($id == ''){
			return "";
		}else{
			$record = DB::table('cities')->where('id',$id)->first();
			return $record ? $record->name : "";
		}
	}
	function isJson($string) {
		$result = json_decode($string);
		// switch and check possible JSON errors
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				$error = ''; // JSON is valid // No error has occurred
				break;
			case JSON_ERROR_DEPTH:
				$error = 'The maximum stack depth has been exceeded.';
				break;
			case JSON_ERROR_STATE_MISMATCH:
				$error = 'Invalid or malformed JSON.';
				break;
			case JSON_ERROR_CTRL_CHAR:
				$error = 'Control character error, possibly incorrectly encoded.';
				break;
			case JSON_ERROR_SYNTAX:
				$error = 'Syntax error, malformed JSON.';
				break;
			// PHP >= 5.3.3
			case JSON_ERROR_UTF8:
				$error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_RECURSION:
				$error = 'One or more recursive references in the value to be encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_INF_OR_NAN:
				$error = 'One or more NAN or INF values in the value to be encoded.';
				break;
			case JSON_ERROR_UNSUPPORTED_TYPE:
				$error = 'A value of a type that cannot be encoded was given.';
				break;
			default:
				$error = 'Unknown JSON error occured.';
				break;
		}
		if ($error !== '') {
		// throw the Exception or exit // or whatever :)
			return false;
		}
		// everything is OK
		return true;
	}

	function user_fund_history($dept_id="" , $id='')
	{
		$record = DB::table('funds')->where(['dept_id'=>$dept_id,'user_id'=>$id])->get();
		$amount = 0;
		$date = '';
		if (count($record) > 0) {
			foreach ($record as $value) {
				$amount += $value->amount;
				$date = date('d/m/y' , strtotime($value->deposited_on));
			}
		}
		$array = ['amount'=>$amount , 'date' => $date];
		return $array;
	}

	function fund_dashboard_user($dept_id="" , $id='')
	{
        $total_collection = 0;
        $total_remaining = 0;
        $tatal_transfered = 0;
        $collected_date = $transfer_date = '';
        $record = DB::table('funds')->where(['dept_id'=>$dept_id,'deposited_to'=>$id])->get();  
        if(count($record) > 0){
          foreach($record as $value){
            $total_collection = $total_collection + $value->amount;
            $collected_date = date('d/m/y',strtotime($value->deposited_on));
          }
        }
        $record2 = DB::table('ledger')->where([
            'dept_id'=>$dept_id,
            'ledger'=>'-',
            'collector_id' => $id
        ])->get();
        if(count($record2) > 0){
          foreach($record2 as $value){
            $tatal_transfered = $tatal_transfered + $value->amount;
            $transfer_date = date('d M, Y',strtotime($value->date));
          }
        }
        $total_remaining = $total_collection - $tatal_transfered;
        $array = [
        	'collection' => $total_collection,
        	'collected_date' => $collected_date,
        	'remaining' => $total_remaining,
        	'remaining_date' => $transfer_date,
        ];
        return $array;
	}

	function get_city_ID($prov_ID='0')
	{
		$reccord = DB::table('cities')->where(['province'=>$prov_ID])->orderby('id','desc')->first();
		$get_id = ($reccord) ? $reccord->city_id : 0;
		return ++$get_id;
	}
	function date_compare($a, $b)
	{
	    $t1 = strtotime($a['created_at']);
	    $t2 = strtotime($b['created_at']);
	    return $t1 - $t2;
	}