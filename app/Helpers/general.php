<?php
    require dirname(dirname(dirname(__FILE__)))."/dompdf/vendor/autoload.php";
    use Dompdf\Dompdf;
    use Dompdf\Options;
    function pdf_generate($html, $file="", $is_view = false, $is_download = false,$page_size ="legal",$orientation="portrait"){
        $options = new Options();
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($page_size, $orientation);
        if($is_download){
            $dompdf->render();
            $dompdf->stream($file, array("Attachment" => true));
            exit(0);
        }
        if($is_view){
            $dompdf->render();
            $output = $dompdf->output();
            if(file_exists(base_path("images/$file"))){
                unlink(base_path("images/$file"));
            }
            file_put_contents(base_path("images/$file"), $output);
        }else{
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents(base_path("images/$file"), $output);
        }

    }
    function s_img_values(){
        $imgs = get_security_img();
        foreach ($imgs as $value) {
            $img_aray[$value['title']] = $value['value'];
        }
        return $img_aray;
    }
    function get_security_img(){
        $s_img = [
            ['title'=>'Pencil','i'=>'icon-pencil','value'=>'SDF4N343L2'],
            ['title'=>'Bell','i'=>'icon-bell','value'=>'8D83H4JJ5N'],
            ['title'=>'Alarm','i'=>'icon-alarm','value'=>'Y2U3N4M5L3'],
            ['title'=>'Calculator','i'=>'icon-calculator','value'=>'C73HK29D7W'],
            ['title'=>'Camera','i'=>'icon-camera','value'=>'0WK3N4M27D'],
            ['title'=>'Book','i'=>'icon-book','value'=>'U2HD7S64N3'],
            ['title'=>'Car','i'=>'icon-car','value'=>'W3UM4N43M3'],
            ['title'=>'Heart','i'=>'icon-heart','value'=>'7R6E5W7C6F'],
            ['title'=>'Headphone','i'=>'icon-headphones','value'=>'3MNTIR93K4'],
            ['title'=>'Bicycle','i'=>'icon-bicycle','value'=>'7W6D4HSIW0'],
            ['title'=>'Keyboard','i'=>'icon-keyboard','value'=>'0QMIRYC738'],
            ['title'=>'Home','i'=>'icon-home','value'=>'7FME82KR74'],
            ['title'=>'Truck','i'=>'icon-truck','value'=>'26YDNEM762'],
            ['title'=>'Star','i'=>'icon-star-full','value'=>'7RU4KF74HJ'],
            ['title'=>'Aeroplane','i'=>'icon-airplane','value'=>'UMFY64HRY3']
        ];
        return $s_img;
    }
    function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%&(){}<>?[]';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomUsername($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomPath($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomImg() {
        $all_imgs = get_security_img();
        shuffle($all_imgs);
        return $all_imgs[5];
    }
    function sendSMS($to, $message){ // send sms to given number and given message
        // dd([$to,$message]);
        ini_set("soap.wsdl_cache_enabled", 0);
        $url = 'http://cbs.zong.com.pk/ReachCWSv2/CorporateSMS.svc?wsdl';
        $client = new SoapClient($url, array("trace" => 1, "exception" => 0));
        $resultBulkSMS = $client->QuickSMS( array('obj_QuickSMS' =>
        array(
            'loginId'=> '923186705868', //here type your account name
            'loginPassword'=>'Zong@123', //here type your password
            'Mask'=>'APJEA', //here set allowed mask against your account or you will get invalid mask
            'Message'=>$message,//Your Messge Text
            'UniCode'=>'0', //If sms is unicode place 1 otherwise 0
            'ShortCodePrefered'=>'n',
            'Destination'=>'92'.$to //Destination Mobile No
            // 'Destination'=>'923056427357' //Destination Mobile No
            ))
        );
        // dd([$resultBulkSMS,'92'.$to,$message]);
    }
    function sendSmsToNumber()
    {
        sendSMS('3067342393','SMS Testing');   
    }
    function generate_mbl($no){ // change mbl format 0300-1234567 to 3001234567
        $ra = explode('-', $no);
        if(count($ra) == 2){
            $ar = str_split($ra[0]);
            $ar2 = str_split($ra[1]);
        }else{
            return '3039168261';
        }
        for ($i = 0; $i < count($ar) ; $i++) {
            if($i != 0){
                $fr[] = $ar[$i];
            }
        }
        $mbl = implode('', $fr);
        for ($j = 0; $j < count($ar2) ; $j++) {
                $fr2[] = $ar2[$j];
        }
        $mbl .= implode('', $fr2);
        return $mbl;
    }
    function get_dept_name($id='',$type="")
    {
        if($type == ""){
            return "";
        }else{
            if($type == "province"){
                $record = DB::table('province')->where('id',$id)->first();
            }elseif($type == 'district'){
                $record = DB::table('cities')->where('id',$id)->first();
            }else{
                $record = "";
            }
            if(!empty($record)){
                return $record->name;
            }else{
                return "";
            }
        }
    }
    function get_province_name($id){
        $data = DB::table('province')->where('id',$id)->first();
        if($data){
            return $data->name;
        }else{
            return "";
        }
    }
    function user_cityName(){
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        if($user->type == "district"){
            $dpId = $user->dept_id;
            $dist = DB::table('cities')->where('id',$dpId)->first();
            $city = ($dist) ? $dist->name : "";
        }elseif($user->type == 'province'){
            $dpId = $user->dept_id;
            $dist = DB::table('province')->where('id',$dpId)->first();
            $city = ($dist) ? $dist->name : "";
        }else{
            $city = 'Pakistan';
        }
        return $city;

    }
    function user_ProvinceName()
    {
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        if($user->type == 'district'){
            $district = DB::table('cities')->where('id',$user->dept_id)->first();
            if($district){
                $province = DB::table('province')->where('id',$district->province)->first();
                if($province){
                    return $province->name;
                }else{
                    return "";
                }
            }else{
                return "";
            }
        }elseif($user->type == 'province'){
            $province = DB::table('province')->where('id',$user->dept_id)->first();
            if($province){
                return $province->name;
            }else{
                return "";
            }
        }else{
            return "Pakistan";
        }
    }
    function get_DeptName($id='' , $name='')
    {
        if($id == '' || $name == ''){
            return "";
        }else{
            if($name == 'district'){
                $get_data = DB::table('cities')->where('id',$id)->first();
                if($get_data){
                    return $get_data->name;
                }else{
                    return "";
                }
            }elseif($name == 'province'){
                $get_data = DB::table('province')->where('id',$id)->first();
                if($get_data){
                    return $get_data->name;
                }else{
                    return "";
                }
            }elseif($name == 'national'){
                $get_data = DB::table('national')->where('id',$id)->first();
                if($get_data){
                    return $get_data->name;
                }else{
                    return "";
                }
            }else{
                return "";
            }
        }
    }
    
    function _user_data()
    {
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        if($user->type == 'district'){
            $district = DB::table('cities')->where('id',$user->dept_id)->first();
            if($district){
                $province = DB::table('province')->where('id',$district->province)->first();
                if($province){
                    $data = [
                        'type' => 'district',
                        'district' => $district->id , 
                        'province' => $province->id ,
                        'natonal' => "" ,
                        'admin' => "" ,
                        'city' => $district->name ,
                    ];
                    return $data;
                }else{
                    return "";
                }
            }else{
                return "";
            }
        }elseif($user->type == 'province'){
            $province = DB::table('province')->where('id',$user->dept_id)->first();
            if($province){
                    $data = [
                        'type' => 'province',
                        'district' => '', 
                        'province' => $province->id ,
                        'natonal' => "" ,
                        'admin' => "" ,
                        'city' => $province->name ,
                    ];
                    return $data;
            }else{
                return "";
            }
        }elseif($user->type=='national'){
            $data = [
                'type' => 'national',
                'district' => '', 
                'province' => '' ,
                'natonal' => "1" ,
                'admin' => "" ,
                'city' => "Pakistan" ,
            ];
            return $data;
        }else{
            $data = [
                'type' => 'admin',
                'district' => '', 
                'province' => '' ,
                'natonal' => "" ,
                'admin' => "" ,
                'city' => "" ,
            ];
            return $data;
        }
    }

    function find_bdg_stat($dept_id = '', $name = '', $type = '')
    {
        // dd($type);
        if($dept_id == '' || $name == '' || $type == ''){
            return 0;
        }else{
            $get_record = DB::table('budget_list')->where([
                'type' => $type,
                'reqst_from' => $dept_id,
                'budget_type' => 'request'
            ])->get();
            // dd($type);
            if($name == 'consumed'){
                $total_used = 0;
                if(count($get_record) > 0){
                    foreach ($get_record as $value) {
                        if($value->status == 'delivered'){
                            $total_used = $total_used + $value->amount;
                        }
                    }
                }
                return $total_used;
            }elseif($name == 'pipline'){
                $pipline = 0;
                if(count($get_record) > 0){
                    foreach ($get_record as $value) {
                        if($value->status == 'pending' || $value->status == 'approved'){
                            $pipline = $pipline + $value->amount;
                        }
                    }
                }
                // dd($type);
                return $pipline;
            }else{
                return 0;
            }
        }
    }
    function find_remaining_bdg_old()
    {
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $_userDetail = _user_data();
        if($user){
            $type = $user->type;
            $dept_id = $user->dept_id;
            if($type == 'district' || $type == 'province'){
                $get_record = DB::table('budget_list')->where(['type'=>$type,'reqst_from'=>$dept_id])->where('status','!=','reject')->get();
                $new_type = ($type == 'district')?"city":$type;
                $get_bdg = DB::table('budget_allocation')->where('type',$new_type)->where('allowcate_to',$dept_id)->first();
                $total_used = 0;
                if(count($get_record) > 0){
                    foreach ($get_record as $value) {
                        $total_used = $total_used + $value->amount;
                    }
                }
                $remaining = (!empty($get_bdg))?$get_bdg->total - $total_used:"0";
                return $remaining;
            }elseif($type == 'national'){
                return 0;
            }else{
                return '0';
            }
        }else{
            return '0';
        }
    }
    function find_remaining_bdg()
    {
        $username = auth('admin')->user()->username;
        $type = auth('admin')->user()->type;
        $dept_id = auth('admin')->user()->dept_id;
        if(Auth::check()){
            $collected_fund = get_collected_fund($dept_id);
            if($type != 'admin'){
                $get_record = DB::table('budget_list')->where([
                    'reqst_from' => $dept_id,
                    'year' => date('Y'),
                    'budget_type' => 'allocate',
                ])->get();
                // dd($get_record);
                $allocated = 0;
                $total_used = $total_pending = $total_remaining = 0;
                if(count($get_record) > 0){
                    foreach ($get_record as $value) {
                        $allocated += $value->amount;
                    }
                }
                $r = $collected_fund - $allocated  ;
                return (int)$r;
            }else{
                $allocated = DB::table('budget_list')->where([
                    'year' => date('Y'),
                    'budget_type' => 'allocate',
                ])->sum('amount');
                $total_used = $total_pending = $total_remaining = 0;
                $r = $collected_fund - $allocated  ;
                return (int)$r;
            }
        }else{
            return '0';
        }
    }
    function find_consumed_bdg()
    {
        $username = auth('admin')->user()->username;
        $type = auth('admin')->user()->type;
        $dept_id = auth('admin')->user()->dept_id;
        if(Auth::check()){
            if($type != 'admin'){
                $count = DB::table('budget_list')->where([
                    'reqst_to' => $dept_id,
                    'year' => date('Y'),
                    'budget_type' => 'request',
                    'status' => 'delivered'
                ])->sum('amount');
                return (int)$count;
            }else{
                $count = DB::table('budget_list')->where([
                    'year' => date('Y'),
                    'budget_type' => 'request',
                    'status' => 'delivered'
                ])->sum('amount');
                return (int)$count;
            }
        }else{
            return '0';
        }
    }
    function find_pending_bdg()
    {
        $username = auth('admin')->user()->username;
        $type = auth('admin')->user()->type;
        $dept_id = auth('admin')->user()->dept_id;
        if(Auth::check()){
            if($type != 'admin'){
                $get_record = DB::table('budget_list')->where([
                    'reqst_to' => $dept_id,
                    'year' => date('Y'),
                    'budget_type' => 'request',
                ])->where('status','!=','delivered')->get();
                $count = 0;
                if(count($get_record) > 0){
                    foreach ($get_record as $value) {
                        $count += $value->amount;
                    }
                }
                return $count;
            }else{
                return '0';
            }
        }else{
            return '0';
        }
    }

    function getCurrentRemaingBdg($dept_id = "", $type = "" , $id = "")
    {
        $dept_id = empty($dept_id) ? auth('admin')->user()->dept_id : $dept_id;
        $type = empty($type) ? auth('admin')->user()->type : $type;
        $id = empty($id) ? request('id') : $id;
        $consume = DB::table('budget_list')->where([
            'type'=> $type , 
            'reqst_from'=> $dept_id , 
            'budget_type' => 'request',
        ])->get();
        if(!empty($id)){
            $current = DB::table('budget_list')->where([
                'id'=> $id ,
            ])->whereNotNull('status')->first();
        }
        $allocate = DB::table('budget_list')->where([
            'type'=> $type , 
            'reqst_to'=> $dept_id , 
            'budget_type' => 'allocate',
        ])->whereNull('status')->get();
        // dd([$allocate,$consume]);
        $remaining = $allocated = $consumed = $reject = 0;
        if(count($allocate) > 0){
            foreach ($allocate as $value) {
                $allocated = $allocated + $value->amount;
            }
        }
        if(count($consume) > 0){
            foreach ($consume as $value) {
                if ($value->status != 'reject') {
                    $consumed = $consumed + $value->amount;
                }else{
                    $reject = $reject + $value->amount;
                }
            }
        }

        $remaining = ($allocated ) - $consumed;
        if(empty($id)){
            return $remaining;
        }else{
            $current_remaining = ($current) ? $current->amount : 0; 
            // dd($consumed);
            if (!empty($current) and $current->status != "reject") {
                $remaining =  $remaining + $current_remaining;                
            }else{
                $remaining =  $remaining ;
            }
            return $remaining;            
        }
    }
    function GetProvinceId($city_id = 0)
    {
        if($city_id > 0){
            $record = DB::table('cities')->where('id',$city_id)->first();
            if($record){
                return $record->province;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }

    function ArrangeCity($record = array() , $sortby = "" , $table = '')
    {
        if(empty($record) || $sortby == ""){
            return $record;
        }else{
            if(count($record) > 0 and count($record) < 2){
                return $record;
            }else{
                $city_array = [];
                foreach ($record as $value) {
                    $city_array[$value->dept_id] = get_dept_name($value->dept_id,$table);
                }
                if(count($city_array) > 0){   
                    ($sortby == 'asc')?asort($city_array):arsort($city_array);
                    foreach ($city_array as $key => $value) {
                        $custom_order[] = $key;
                    }
                    $new_record = $record->sort(function ($a, $b) use ($custom_order) {
                      $pos_a = array_search($a->dept_id, $custom_order);
                      $pos_b = array_search($b->dept_id, $custom_order);
                      return $pos_a - $pos_b;
                    });
                }else{
                    $new_record = $record;
                }
                return $new_record;
            }
        }
    }

    function get_fund_detail($user_id='')
    {
        if($user_id != ""){
            $dept_id = Auth::user()->dept_id;
            $data = get_user_fund_detail($dept_id,$user_id);
            return $data;
        }else{
            return array();
        }
    }
    function get_user_fund_detail($dept_id , $id ){
        $total_collection = 0;
        $grand_total_collection = 0;
        $tatal_transfered = 0;
        $grand_tatal_transfered = 0;
        $record = DB::table('funds')->where(['dept_id'=>$dept_id])->get();  
        if(count($record) > 0){
          foreach($record as $value){
            if($value->deposited_to == $id){
                $total_collection = $total_collection + $value->amount;
            }
            $grand_total_collection = $grand_total_collection + $value->amount;
          }
        }
        $record2 = DB::table('ledger')->where([
            'dept_id'=>$dept_id,
            'ledger'=>'-'
        ])->get();
        if(count($record2) > 0){
          foreach($record2 as $value){
            if($value->collector_id == $id){
                $tatal_transfered = $tatal_transfered + $value->amount;
            }
            $grand_tatal_transfered = $grand_tatal_transfered + $value->amount;
          }
        }
        $data['total_collection'] = $total_collection;
        $data['tatal_transfered'] = $tatal_transfered;
        $data['balance'] = $total_collection - $tatal_transfered;
        $data['grand_balance'] = $grand_total_collection - $grand_tatal_transfered;
        return $data;
    }
    function get_district_fund_detail($dept_id){
        $total_collection = 0;
        $grand_total_collection = 0;
        $tatal_transfered = 0;
        $grand_tatal_transfered = 0;
        $record = DB::table('district_ledger')->where(['district'=>$dept_id])->get();
        if(count($record) > 0){
          foreach($record as $value){
            if($value->ledger == "+"){
                $total_collection = $total_collection + $value->amount;
            }elseif($value->ledger == "-"){
                $tatal_transfered = $tatal_transfered + $value->amount;
            }
          }
        }
        // dd($record);
        $data['total_collection'] = $total_collection;
        $data['tatal_transfered'] = $tatal_transfered;
        $data['balance'] = $total_collection - $tatal_transfered;
        return $data;
    }
    function GetUserName($id = ''){
        if($id != ""){
            $user_detail = DB::table('admin')->where('id',$id)->first();
            return ($user_detail)?$user_detail->name:"";
        }else{
            return "";
        }
    }
    function GetLoginUserName($id = ''){
        if($id != ""){
            $user_detail = DB::table('users')->where('id',$id)->first();
            return ($user_detail)?$user_detail->name:"";
        }else{
            return "";
        }
    }
    function GetDistrictRemainingFund($id = "")
    {
        if(!empty($id)){
            $remaining = DB::table('ledger')->where('dept_id',$id)->whereNull('user_id')->sum('amount');
            $transfer = DB::table('district_ledger')->where('district',$id)->sum('amount');
            return floor($remaining) - $transfer;
        }
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $remaining = DB::table('ledger')->where('dept_id',$user->dept_id)->whereNull('user_id')->sum('amount');
        $transfer = DB::table('district_ledger')->where('district',$user->dept_id)->sum('amount');
        return floor($remaining) - $transfer;
    }
    function province_r_email($id = ""){
        if(!empty($id)){
            $admin = DB::table('contact_us')->where('user_type','admin')->first();
            $data = DB::table('contact_us')->where('province',$id)->first();
            if(!empty($data) and !empty($data->r_email)){
                return $data ? $data->r_email : "";
            }else{
                return $admin ? $admin->r_email : "";
            }
        }else{
            return "";
        }
    }
    function calculate_year($date='')
    {
        if(!empty($date)){
            $today = date('Y-m-d');
            $diff = abs(strtotime($today)-strtotime($date));
            $years = floor($diff / (365*60*60*24));
            return (int)$years;
        }else{
            return "";
        }
    }
    function validate_date($value='')
    {
        if($value != ""){
            $explode = explode('/', $value);
            if (is_array($explode) and count($explode) == 3) {
                if(checkdate($explode[1],$explode[0],$explode[2])){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
    function get_city_allocation($id='')
    {
        $year = date("Y");
        $record = DB::table('budget_allocation')->where(['type'=>'city','allowcate_to'=>$id,'year'=>$year])->first();
        return $record;
    }
    function get_collected_fund($id='')
    {
        $date = date('Y');
        if ($id == '') {
            $record = DB::table('district_ledger')->where(['year'=>$date,'ledger'=>'-','status'=>'delivered'])->sum('amount');
        }else{
            $record = DB::table('district_ledger')->where(['province'=>$id,'year'=>$date,'ledger'=>'-','status'=>'delivered'])->sum('amount');
        }
        $r = round($record);
        return $r;
    }

    function send_sms_shortCode($content,$name='', $cnic='', $city='',$password='',$reason='',$receipt = ''){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
        $matches = (isset($matches[1])) ? $matches[1] : array();
        foreach($matches as $k=>$v){
            if($v == 'name'){
                $r = $name;
            }elseif($v == 'cnic'){
                $r = $cnic;
            }elseif($v == 'fund-period'){
                $r = $reason;
            }elseif($v == 'collector'){
                $r = $city;
            }elseif($v == 'amount'){
                $r = $password;
            }elseif($v == 'receipt-no'){
                $r = $receipt;
            }elseif($v == 'city'){
                $rrrr =  DB::table('cities')->where('id',$city)->first();
                $r = $rrrr->name;
            }elseif($v == 'password' || $v == 'security_img'){
                $r = $password;
                if($v == 'password'){
                    $r = $password;
                }else{
                    $dsf = base64_decode($reason);
                    $simg = s_img_values();
                    $s_img = array_search($dsf, $simg);
                    $r = $s_img;
                }
            }elseif($v == 'reason'){
                $r = $reason;
            }
            if($r !=""){
                $content = str_replace("[[$v]]", $r, $content);
            }
        }
        return $content;
    }