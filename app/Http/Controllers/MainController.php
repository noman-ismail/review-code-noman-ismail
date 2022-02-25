<?php
namespace App\Http\Controllers;
use App\Models\ContactUs;
use App\Models\Faqs;
use App\Models\Privacy;
use App\Models\blogcats;
use App\Models\Blogs;
use App\Models\TermsCondition;
use DB;
use Auth;
use Illuminate\Http\Request;
use Mail;
class MainController extends Controller {

	public function home(){
		$data = DB::table('homedata')->first();
		$blogs = DB::table('blogs')->where('status' , 'publish')->limit(4)->orderBy('views' , 'desc')->get();
		$news = DB::table('news')->where('status' , 'publish')->limit(4)->orderBy('views' , 'desc')->get();
		$province = DB::table('province')->get();
		return view('front.home' , compact('data' , 'blogs' ,'news','province'));
	}
	public function jobs(){
		$r = DB::table('meta')->where( 'page_name', 'jobs' )->select("pagination")->first(); 
		$limit = ($r->pagination !=Null) ? $r->pagination : 10;
		if (request()->has("search")) {
		    $where = request()->get('search');
		    $city = request()->get('city');
		    if( $city !=NULL and $where !=""){
		    	$data = DB::table('jobs')
				->where('status' , 'publish')
				->whereRaw("MATCH(title) AGAINST('$where')")
				->where('district' , '=' , $city)
				->orderBy('id','desc')
				->paginate($limit);
		    }elseif($city !=NULL and $where =="" ){
		    	$data = DB::table('jobs')
				->where('status' , 'publish')
				->where('district' , '=' , $city)
				->orderBy('id','desc')
				->paginate($limit);
		    }elseif($city ==NULL and $where !="" ){
		    	$data = DB::table('jobs')
				->where('status' , 'publish')				
				->whereRaw("MATCH(title) AGAINST('$where') OR MATCH(meta_tags) AGAINST('$where')")
				->orderBy('id','desc')
				->paginate($limit);
		    }
		    else{
		    	$data = DB::table('jobs')
				->orderBy('id','desc')
				->paginate($limit);
		    }
			$where = $where;
			return view( 'front.jobs', compact( 'data' , 'where') );
		}
		$data = DB::table('jobs')->where('status' , 'publish')->orderBy('id', 'desc')->paginate($limit);
		return view('front.jobs' , compact('data'));
	}
	public function news(){
		$data = DB::table('news')->where('status' , 'publish')->orderBy('id', 'desc')->limit(8)->get();
		return view('front.news' , compact('data'));
	}
	public function single() {
	    if ( get_postid( 'page_id' ) == 2 ) {
	      $page_id = get_postid( 'page_id' );
	      $post_id = get_postid( 'post_id' );
	      //checks if category id not numeric
	      if ( !is_numeric( $post_id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }
	      //checks if category does not exists 
	      $res = DB::table('event')->where( 'id', $post_id )->first();
	      if ( !isset( $res->id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }

	      $slug = get_postid( "slug" );
	      $c_slug = $res->slug;
	      if ( $slug != $c_slug ) {
	        return redirect( route( "base_url" ) . "/" . $res->slug . "-2" . $res->id );
	      }
	      $data = DB::table('event')->where('district' , $res->district)->orderBy('id','desc')->limit(4)->get();
	      return view( 'front.event_detail', compact( 'res' , 'data') );
	    }elseif ( get_postid( 'page_id' ) == 1 ) {
	      $page_id = get_postid( 'page_id' );
	      $post_id = get_postid( 'post_id' );
	      //checks if category id not numeric
	      if ( !is_numeric( $post_id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }
	      //checks if category does not exists 
	      $res = DB::table('jobs')->where([ ['id' , '=' , $post_id] , ['status' , '=' , 'publish']  ])->first();
	      if ( !isset( $res->id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }

	      $slug = get_postid( "slug" );
	      $c_slug = $res->slug;
	      if ( $slug != $c_slug ) {
	        return redirect( route( "base_url" ) . "/" . $res->slug . "-1" . $res->id );
	      }
	      $data = DB::table('jobs')->where('id' , "!=" , $post_id)->orderBy('id', 'desc')->limit(4)->get();
	      return view( 'front.jobs-detail', compact( 'res' , 'data') );
	    }elseif ( get_postid( 'page_id' ) == 3 ) {
	      $page_id = get_postid( 'page_id' );
	      $post_id = get_postid( 'post_id' );
	      //checks if category id not numeric
	      if ( !is_numeric( $post_id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }
	      //checks if category does not exists 
	      $res = DB::table('blogs')->where([ ['id' , '=' , $post_id] , ['status' , '=' , 'publish']  ])->first();
	      if ( !isset( $res->id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }

	      $slug = get_postid( "slug" );
	      $c_slug = $res->slug;
	      if ( $slug != $c_slug ) {
	        return redirect( route( "base_url" ) . "/" . $res->slug . "-3" . $res->id );
	      }
	      //$data = DB::table('jobs')->orderBy('id', 'desc')->limit(4)->get();
	      return view( 'front.blogs-detail', compact( 'res') );
	    }elseif ( get_postid( 'page_id' ) == 4 ) {
	      $page_id = get_postid( 'page_id' );
	      $post_id = get_postid( 'post_id' );
	      //checks if category id not numeric
	      if ( !is_numeric( $post_id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }
	      //checks if category does not exists 
	      $cats = blogcats::where( 'id', $post_id )->first();
	      if ( !isset( $cats->id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }

	      $slug = get_postid( "slug" );
	      $c_slug = $cats->slug;
	      if ( $slug != $c_slug ) {
	        return redirect( route( "base_url" ) . "/" . $cats->slug . "-1" . $cats->id );
	      }
	      $data = Blogs::where('status' , 'publish')->whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->orderBy('views', 'desc')->get()->take(4);
	   //   dd($res);
	      return view( 'front.blogs', compact( 'cats', 'data' ) );
	    }elseif ( get_postid( 'page_id' ) == 5 ) {
	      $page_id = get_postid( 'page_id' );
	      $post_id = get_postid( 'post_id' );
	      //checks if category id not numeric
	      if ( !is_numeric( $post_id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }
	      //checks if category does not exists 
	      $res = DB::table('news')->where([ ['id' , '=' , $post_id] , ['status' , '=' , 'publish']  ])->first();
	      if ( !isset( $res->id ) ) {
	        return redirect( route( "base_url" ) . "/404" );
	      }

	      $slug = get_postid( "slug" );
	      $c_slug = $res->slug;
	      if ( $slug != $c_slug ) {
	        return redirect( route( "base_url" ) . "/" . $res->slug . "-5" . $res->id );
	      }
	      //$data = DB::table('jobs')->orderBy('id', 'desc')->limit(4)->get();
	      return view( 'front.news-detail', compact( 'res') );
	    }
	} 
	function about_cabinet($url = "")
	{
		$check = DB::table('province')->where('slug',$url)->first();
		if(empty($check)){
			$check = DB::table('cities')->where('slug',$url)->first();
			if(empty($check)){
                session(['back_url' => url()->previous()]);
				return redirect(route('404'));
			}else{
				$about = $check->cabinet;
				$panel = 'cities';
				return view('front.cabinets.about-cabinets' , compact('about','panel','check'));
			}
		}else{
			$about = $check->cabinet;
			$panel = 'province';
			return view('front.cabinets.about-cabinets' , compact('about','panel','check'));
		}
	}
	public function aboutUs(){
		$data = DB::table('about_us')->first();
		return view('front.about_us' , compact('data'));
	}
	public function wellfareBenefits(){
		$data = DB::table('welfare_benefits')->first();
		return view('front.welfare_benefits' , compact('data'));
	}	
	public function events(){
		$r = DB::table('meta')->where( 'page_name', 'events' )->select("before_limit")->first(); 
		$limit = $r->before_limit;
		$data = DB::table('event')->orderBy('id','DESC')->limit($limit)->get();
		$popular = DB::table('event')->orderBy('views','DESC')->limit(4)->get();
		// dd($popular);
		return view('front.event' , compact('data' , 'popular'));
	}
	public function more_events(Request $request){
		$r = DB::table('meta')->where( 'page_name', 'events' )->select("after_limit")->first(); 
		$limit = $r->after_limit;
		$output = '';
        $id = $request->id;
        $posts = DB::table('event')->where('id','<',$id)->orderBy('id','DESC')->limit($limit)->get();
        
        if(!$posts->isEmpty())
        {
            foreach($posts as $post => $v)
            {
				$title = unslash( $v->title );
				$short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
				$image = is_image($v->cover_image);
				$url = route('base_url')."/".$v->slug."-2".$v->id;
				$date = (!empty($v->date)) ? date("d", strtotime($v->date) ) : "";
				$address = (!empty($v->address)) ? $v->address  : "";
				$month = (!empty($v->date)) ? date("M", strtotime($v->date) ) : "";  
				$lk   = ($v->social_links  !="" )? json_decode($v->social_links , true) : array();
				$fb = ""; $twitter=""; $instagram=""; $linkedin ="";
				if(isset($lk["fb_link"])){
					$fb ='<li><a href="'.$lk["fb_link"] .'" target="_blank"><i class="icon-facebook"></i></a> </li> ';
				}
				if(isset($lk["twitter_link"])){
					$twitter ='<li><a href="'.$lk["twitter_link"] .'" target="_blank"><i class="icon-twitter"></i></a> </li> ';
				}
				if(isset($lk["instagram_link"])){
					$instagram ='<li><a href="'.$lk["instagram_link"] .'" target="_blank"><i class="icon-linkedin2"></i></a> </li> ';
				}
				if(isset($lk["linkedin_link"])){
					$linkedin ='<li><a href="'.$lk["linkedin_link"] .'" target="_blank"><i class="icon-instagram"></i></a> </li>';
				}           
                $output .= '<div class="col-md-6 col-lg-4 outer-column">
				            <div class="event-column">
				              <a class="event-image" href="'.$url .'">
				                <img src="'.get_post_mid($image) .'" class="img-fluid" alt="'.$title .'">
				                <div class="event-overlay"></div>
				                <div class="event-date"> <span class="date">'.$date .'</span> <span class="month">'.$month .'</span> </div>
				                <ul class="social-list">
				                 '.$fb.$twitter.$instagram.$linkedin.'
				                </ul>
				              </a>
				              <div class="event-bottom">
				                <p>'.$address.'</p>
				                <h4><a href="'.$url .'">'. $title .'</a></h4>
				              </div>
				            </div>
				          </div>';
            }
            
            $output .= '<div class="col-md-12 button-column">
			            <div class="button-bottom mx-auto">
			              <button class="btn-load" id="btn-load" type="button" data-id="'.$v->id.'">Load More</button>
			            </div>
			          </div>';
            
            echo $output;
        }else{
        	$output .= '<div class="col-md-12 button-column">
			            <div class="button-bottom mx-auto">
			              <button class="btn-load" >No More Available </button>
			            </div>
			          </div>';
            
            echo $output;
        }
	}
	public function blogs(){
		if (request()->has("search")) {
		    $where = request()->get('search');
		    if( $where !=""){
		    	$data = DB::table('blogs')
		    	->where('status' , 'publish')
				->whereRaw("MATCH(title) AGAINST('$where')")
				->orderBy('id','desc')
				->paginate(10);
		    }
		    else{
		    	$data = DB::table('blogs')
		    	->where('status' , 'publish')
				->orderBy('id','desc')
				->paginate(10);
		    }
			$where = $where;
			return view( 'front.blogs', compact( 'data' , 'where') );
		}
		$data = DB::table('blogs')->where('status' , 'publish')->orderBy('id','desc')->limit(8)->get();
		return view('front.blogs' , compact('data'));
	}
	public function national()
	{
		$check = DB::table('national')->first();
		$about = $check->cabinet;
		$panel = 'national';
		return view('front.cabinets.about-cabinets' , compact('about','panel','check'));
	}
	public function district()
	{
		$record = DB::table('cities')->orderby('name','asc')->get();
		$data = DB::table('generalsettings')->select('district_cabinet')->first();
		return view('front.cabinets.district-list' , compact('record','data'));
	}
	public function contact_us()
	{
		$national = DB::table('admin')->where('type','national')->first();
		$admin = DB::table('admin')->where('type','admin')->first();
		$province = DB::table('province')->orderby('name','asc')->get();
		$cities = DB::table('cities')->orderby('id','asc')->get();
		$admin_contact = DB::table('contact_us')->where('user_type','admin')->first();
		$national_contact = DB::table('contact_us')->where('user_type','national')->first();
		$province_contact = DB::table('contact_us')->where('user_type','province')->get();
		return view('front.contact-us' ,compact('admin','national','province','cities','admin_contact','national_contact','province_contact'));
	}
	public function govt_notification()
	{
		$r = DB::table('meta')->where( 'page_name', 'notifications' )->select("pagination")->first(); 
		$limit = ($r->pagination != Null) ? $r->pagination : 10;
		if(request()->has('search')){
			$where = request()->get('search');
			$province = request()->get('province');
			$user_type = (is_numeric($province)) ? 'province' : '';
			// DB::enableQueryLog();
			// select count(*) as aggregate from `downloads` where MATCH(title) AGAINST('fasd f asd f') and date(`date`) <= ? and date(`date`) >= ? and `type` = ? or `province` = ? 
			$query = "select * from `downloads` where type = 'govt-notification'";
			if (!empty($province)) {
				if (is_numeric($province)) {
					$query .= " AND province = ".$province;
				}else{
					$query .= " AND user_type = 'national'";
				}
			}
			if(!empty($where)){
				$query .= " AND title LIKE '%".$where."%'";
				$query .= " or description LIKE '%".$where."%'";
			}
			if (!empty(request('date_from'))) {
				$arrr = explode('/', request('date_from'));
				if(is_array($arrr) and count($arrr) == 3){
					$date_from = implode('-', array_reverse($arrr));
					$query .= " AND date >= '".$date_from."'";
				}
			}
			if (!empty(request('date_to'))) {
				$arrr = explode('/', request('date_to'));
				if(is_array($arrr) and count($arrr) == 3){
					$date_to = implode('-', array_reverse($arrr));
					$query .= " AND date <= '".$date_to."'";
				}
			}
			$record = DB::select($query);
			return view('front.notifications',compact('record'));
		}
		$record = DB::table('downloads')->where('type' , 'govt-notification')->paginate($limit);
		return view('front.notifications',compact('record'));
	}
	public function imp_document()
	{
		$r = DB::table('meta')->where( 'page_name', 'documents' )->select("pagination")->first(); 
		$limit = ($r->pagination !=Null) ? $r->pagination : 10;
		if(request()->has('search')){
			$where = request()->get('search');
			$province = request()->get('province');
			$user_type = (is_numeric($province)) ? 'province' : '';
			// DB::enableQueryLog();
			// select count(*) as aggregate from `downloads` where MATCH(title) AGAINST('fasd f asd f') and date(`date`) <= ? and date(`date`) >= ? and `type` = ? or `province` = ? 
			$query = "select * from `downloads` where type = 'imp-docs'";
			if (!empty($province)) {
				if (is_numeric($province)) {
					$query .= " AND province = ".$province;
				}else{
					$query .= " AND user_type = 'national'";
				}
			}
			if(!empty($where)){
				$query .= " AND MATCH(title) AGAINST('".$where."')";
			}
			if (!empty(request('date_from'))) {
				$arrr = explode('/', request('date_from'));
				if(is_array($arrr) and count($arrr) == 3){
					$date_from = implode('-', array_reverse($arrr));
					$query .= " AND date >= '".$date_from."'";
				}
			}
			if (!empty(request('date_to'))) {
				$arrr = explode('/', request('date_to'));
				if(is_array($arrr) and count($arrr) == 3){
					$date_to = implode('-', array_reverse($arrr));
					$query .= " AND date <= '".$date_to."'";
				}
			}
			$record = DB::select($query);
			return view('front.imp-document',compact('record'));
		}
		$record = DB::table('downloads')->where('type' , 'imp-docs')->paginate($limit);
		return view('front.imp-document',compact('record'));
	}
	public function cabinet_pages($segment1 = "" , $segment2 = "")
	{
		if($segment1 != 'pakistan'){
			$check = DB::table('province')->where('slug',$segment1)->first();
			if(empty($check)){
				$check = DB::table('cities')->where('slug',$segment1)->first();
				if(empty($check)){
                    session(['back_url' => url()->previous()]);
					return redirect(route('404'));
				}else{
					$panel = 'cities';
					if($segment2 == 'team'){
						$team = DB::table('cabinets')->where(['dept_id'=>$check->id,'district'=>'yes'])->whereNull('tehsil')->orderby('sort','asc')->get();
						$tehsil_team = DB::table('cabinets')->where(['dept_id'=>$check->id,'district'=>'yes'])->whereNotNull('tehsil')->orderby('sort','asc')->get();
						return view('front.cabinets.cabinet-team',compact('team','tehsil_team','check','panel'));
					}elseif($segment2 == 'apjea-members'){
						$ddd = DB::table('users')->where(['status'=>'approved','district'=>$check->id])->get();
						$detail = DB::table('user_info')->where('district',$check->id)->get()->toArray();
						if (count($ddd) > 0) {
							foreach ($ddd as $value) {
								$value->designation = get_user_off_dsg($value->designation);
							}
							$record = $ddd;
						}else{
							$record = array();
						}
						if(request()->has('search')){
							$where = request('search');
							$detail = DB::table('user_info')->where('district',$check->id)->where('blood_group','like',$where."%")->get()->toArray();
							$collect_record = collect(json_decode(json_encode($record),true));
							$new = $new_array = array();
							$collect_detail = collect(json_decode(json_encode($detail)));
							$search_array = collect($collect_record)->filter(function ($item) use ($where) {
							    if(false !== stristr($item['name'], $where)){
							    	return false !== stristr($item['name'], $where);
							    }elseif(false !== stristr($item['designation'], $where)){
							    	return false !== stristr($item['designation'], $where);
							    }
							});
							if (count($detail) > 0) {
								foreach ($detail as $value) {
									$s = $search_array->where('id',$value->user_id)->toArray();
									if(empty($s)){
										$new[] = $value;
									}
								}
							}
							if(count($new) > 0){
								foreach ($new as $value) {
									$_uid = $value->user_id;
									$new_array = collect($collect_record)->filter(function ($item) use ($_uid) {
								    	return false !== stristr($item['id'], $_uid);
									});
								}
							}
							if(count($new_array) > 0){
								foreach ($new_array as $value) {
									$value = json_decode(json_encode($value));
									$dfad2[] = $value;
								}
								$record2 = json_decode(json_encode($dfad2));
							}else{
								$record2 = array();
							}
							if(count($search_array) > 0){
								foreach ($search_array as $value) {
									$value = json_decode(json_encode($value));
									$dfad[] = $value;
								}
								$record = json_decode(json_encode($dfad));
							}else{
								$record = array();
							}
							if(count($record) > 0){
								if(count($record2) > 0){
									// dd();
									$final_array = collect(array_merge($record,$record2));
									// dd($final_array);
								}else{
									$final_array = collect($record);
								}
							}else{
								$final_array = collect($record2);
							}
							$record = array();
							$record = $final_array;
						}
						// dd($record);
						$detail = DB::table('user_info')->where('district',$check->id)->get()->toArray();
						return view('front.cabinets.apjea-members',compact('check','panel','record','detail'));
					}elseif($segment2 == 'news-updates'){
						$record = DB::table('news')->where(['user_type'=>'district','status'=>'publish','district'=>$check->id])->get();
						return view('front.cabinets.news-cabinets',compact('record','check','panel'));
					}elseif($segment2 == 'events'){
						$record = DB::table('event')->where(['user_type'=>'district','district'=>$check->id])->get();
						return view('front.cabinets.event-cabinets',compact('record','check','panel'));
					}elseif($segment2 == 'jobs'){
						$record = DB::table('jobs')->where(['user_type'=>'district','status'=>'publish','district'=>$check->id])->get();
						return view('front.cabinets.jobs-cabinets',compact('record','check','panel'));
					}elseif($segment2 == 'contact-us'){
						$r_email = "";
						$admin_email = DB::table('contact_us')->where('user_type','admin')->first();
						$rec_email = DB::table('contact_us')->where(['user_type'=>'district','district'=>$check->id])->first();
						$ad_email = ($admin_email) ? $admin_email->r_email : "";
						$r_email = ($rec_email) ? $rec_email->r_email : $ad_email;
						$record = DB::table('contact_us')->where(['user_type'=>'district','district'=>$check->id])->first();
						$cities = DB::table('cities')->orderby('name','asc')->get();
						return view('front.cabinets.contact-cabinets',compact('record','cities','check','panel','r_email'));
					}else{
	                    session(['back_url' => url()->previous()]);
						return redirect(route('404'));
					}
				}
			}else{
				$panel = 'province';
				if($segment2 == 'team'){
					$team = DB::table('cabinets')->where(['dept_id'=>$check->id,'province'=>'yes'])->orderby('sort','asc')->get();
					return view('front.cabinets.cabinet-team',compact('team','check','panel'));
				}elseif($segment2 == 'apjea-members'){
					$record = DB::table('users')->where('status','approved')->get();
					$data = DB::table('user_info')->get();
					$detail = json_decode(json_encode($data),true);
					return view('front.cabinets.apjea-members',compact('check','panel','record','detail'));
				}elseif($segment2 == 'news-updates'){
					$record = DB::table('news')->where(['user_type'=>'province','status'=>'publish','province'=>$check->id])->get();
					return view('front.cabinets.news-cabinets',compact('record','check','panel'));
				}elseif($segment2 == 'events'){
					$record = DB::table('event')->where(['user_type'=>'province','province'=>$check->id])->get();
					return view('front.cabinets.event-cabinets',compact('record','check','panel'));
				}elseif($segment2 == 'jobs'){
					$record = DB::table('jobs')->where(['user_type'=>'province','status'=>'publish','province'=>$check->id])->get();
					return view('front.cabinets.jobs-cabinets',compact('record','check','panel'));
				}elseif($segment2 == 'notifications'){
					if(request()->has('search')){
						$where = request()->get('search');
						$query = "select * from `downloads` where type = 'govt-notification' and province = ".$check->id;
						if(!empty($where)){
							$query .= " AND title LIKE '%".$where."%'";
							$query .= " OR description LIKE '%".$where."%'";
						}
						if (!empty(request('date_from'))) {
							$arrr = explode('/', request('date_from'));
							if(is_array($arrr) and count($arrr) == 3){
								$date_from = implode('-', array_reverse($arrr));
								$query .= " AND date >= '".$date_from."'";
							}
						}
						if (!empty(request('date_to'))) {
							$arrr = explode('/', request('date_to'));
							if(is_array($arrr) and count($arrr) == 3){
								$date_to = implode('-', array_reverse($arrr));
								$query .= " AND date <= '".$date_to."'";
							}
						}
						$record = DB::select($query);
					}else{
						$record = DB::table('downloads')->where(['type'=>'govt-notification','user_type'=>'province','province'=>$check->id])->get();
					}
					return view('front.cabinets.notification-cabinets',compact('record','check','panel'));
				}elseif($segment2 == 'contact-us'){
					$r_email = "";
					$admin_email = DB::table('contact_us')->where('user_type','admin')->orWhere('province',$check->id)->first();
					$r_email = $admin_email ? $admin_email->r_email : "";
					$record = DB::table('contact_us')->where(['user_type'=>'province','province'=>$check->id])->first();
					$cities = DB::table('cities')->orderby('name','asc')->get();
					return view('front.cabinets.contact-cabinets',compact('record','cities','check','panel','r_email'));
				}else{
                    session(['back_url' => url()->previous()]);
					return redirect(route('404'));
				}
			}
		}else{
			$panel = 'national';
			$check = DB::table('national')->first();
			if($segment2 == 'team'){
				$team = DB::table('cabinets')->where(['dept_id'=>$check->id,'district'=>'yes'])->orderby('sort','asc')->get();
				return view('front.cabinets.cabinet-team',compact('team','check','panel'));
			}elseif($segment2 == 'apjea-members'){
				$record = DB::table('users')->where('status','approved')->get();
				$data = DB::table('user_info')->get();
				$detail = json_decode(json_encode($data),true);
				return view('front.cabinets.apjea-members',compact('check','panel','record','detail'));
			}elseif($segment2 == 'news-updates'){
				$record = DB::table('news')->where(['user_type'=>'national','status'=>'publish'])->get();
				return view('front.cabinets.news-cabinets',compact('record','check','panel'));
			}elseif($segment2 == 'events'){
				$record = DB::table('event')->where(['user_type'=>'national'])->get();
				return view('front.cabinets.event-cabinets',compact('record','check','panel'));
			}elseif($segment2 == 'jobs'){
				$record = DB::table('jobs')->where(['user_type'=>'national','status'=>'publish'])->get();
				return view('front.cabinets.jobs-cabinets',compact('record','check','panel'));
			}elseif($segment2 == 'notifications'){
				if(request()->has('search')){
					$where = request()->get('search');
						DB::enableQueryLog();
						$query = "select * from `downloads` where type = 'govt-notification' and province = ".$check->id;
						if(!empty($where)){
							$query .= " AND title LIKE '%".$where."%'";
							$query .= " OR description LIKE '%".$where."%'";
						}
						if (!empty(request('date_from'))) {
							$arrr = explode('/', request('date_from'));
							if(is_array($arrr) and count($arrr) == 3){
								$date_from = implode('-', array_reverse($arrr));
								$query .= " AND date >= '".$date_from."'";
							}
						}
						if (!empty(request('date_to'))) {
							$arrr = explode('/', request('date_to'));
							if(is_array($arrr) and count($arrr) == 3){
								$date_to = implode('-', array_reverse($arrr));
								$query .= " AND date <= '".$date_to."'";
							}
						}
						// dd($query);
						$record = DB::select($query);
					}else{
						$record = DB::table('downloads')->where(['user_type'=>'national'])->get();
					}
				return view('front.cabinets.notification-cabinets',compact('record','check','panel'));
			}elseif($segment2 == 'contact-us'){
				$r_email = "";
				$admin_email = DB::table('contact_us')->where('user_type','admin')->orWhere('national',$check->id)->first();
				$r_email = $admin_email ? $admin_email->r_email : "";
				$record = DB::table('contact_us')->where(['user_type'=>'national'])->first();
				$cities = DB::table('cities')->orderby('name','asc')->get();
				return view('front.cabinets.contact-cabinets',compact('record','cities','check','panel','r_email'));
			}else{
                session(['back_url' => url()->previous()]);
				return redirect(route('404'));
			}		
		}
	}
	function forgot_password(Request $request)
	{
		if(request()->isMethod('post')){
			if(request()->has('reset_by')){
				if(request('reset_by') == 'email-tab'){
					if(request()->has('cnic1') and !empty(request('cnic1'))){
						$cnic = request('cnic1');
						$cnic_info = DB::table('users')->where('cnic',$cnic)->first();
						if($cnic_info){
							if($cnic_info->email == request('email')){
								$data = $cnic_info->contact;
								$reset_pass = generateRandomString(8);
							    $email_setting = DB::table('email_setting')->first();
								DB::table('users')->where('id',$cnic_info->id)->update(['reset_pass'=>$reset_pass]);
								$msg = send_sms_shortCode($email_setting->forgot_password,$cnic_info->name,'','',$reset_pass,$cnic_info->s_img);
						        $data = array(
						          "name" => $cnic_info->name,
						          "email" => $cnic_info->email,
						          "body" => $msg,
						          "subject" => 'Your password is reset',
						          "from" => array("email"=>'admin@apjea.com', "label"=>"APJEA"),
						          "to" => array("email"=>$cnic_info->email, "label"=>"APJEA")
						        );
						        $Mail = new Mail;
						        sendEmail($Mail, "email-template.forgot-password", $data);
						        return back()->with('success','New password has been emailed.');
						    }else{
								return back()->with([
									'reset_by'=>request('reset_by'),
									'cnic1'=>request('cnic1'),
									'cnic2'=>request('cnic2'),
									'email'=>request('email'),
									'phone'=>request('phone_no'),
									'error'=>'CNIC / Email does not match with our record.'
								]);
						    }
						}else{
							return back()->with([
								'reset_by'=>request('reset_by'),
								'cnic1'=>request('cnic1'),
								'cnic2'=>request('cnic2'),
								'email'=>request('email'),
								'phone'=>request('phone_no'),
								'error'=>'Your CNIC No. is not register'
							]);
						}
					}else{
						return back()->with([
							'reset_by'=>request('reset_by'),
							'cnic1'=>request('cnic1'),
							'cnic2'=>request('cnic2'),
							'email'=>request('email'),
							'phone'=>request('phone_no'),
							'error'=>'Please enter your correct CNIC No.'
						]);
					}
				}elseif(request('reset_by') == 'contact-tab'){
					if(request()->has('cnic2') and !empty(request('cnic2'))){
						$cnic = request('cnic2');
						$cnic_info = DB::table('users')->where('cnic',$cnic)->first();
					    $sms_setting = DB::table('sms_setting')->first();
						if($cnic_info){
							if($cnic_info->contact == request('phone_no')){
								$data = $cnic_info->contact;
								$reset_pass = generateRandomString(8);
								$encrypted_pass = bcrypt($reset_pass);
								DB::table('users')->where('id',$cnic_info->id)->update(['reset_pass'=>$encrypted_pass,'tries'=>'0']);
					            $no = generate_mbl($data);
								$msg = send_sms_shortCode($sms_setting->forgot_password,$cnic_info->name,'','',$reset_pass,$cnic_info->s_img);
								sendSMS($no,$msg);
					            return back()->with('success','New password has been sent on your mobile number.');
					        }else{
								return back()->with([
									'reset_by'=>request('reset_by'),
									'cnic1'=>request('cnic1'),
									'cnic2'=>request('cnic2'),
									'email'=>request('email'),
									'phone'=>request('phone_no'),
									'error'=>'CNIC / Phone No. does not match with our record.'
								]);
						    }
						}else{
							return back()->with([
								'reset_by'=>request('reset_by'),
								'cnic1'=>request('cnic1'),
								'cnic2'=>request('cnic2'),
								'email'=>request('email'),
								'phone'=>request('phone_no'),
								'error'=>'Your CNIC No. is not register'
							]);
						}
					}else{
						return back()->with([
							'reset_by'=>request('reset_by'),
							'cnic1'=>request('cnic1'),
							'cnic2'=>request('cnic2'),
							'email'=>request('email'),
							'phone'=>request('phone_no'),
							'error'=>'Please enter your correct CNIC No.'
						]);
					}

				}else{
					return redirect(route('base_url')."/404");
				}
			}else{
				return back()->with([
					'reset_by'=>request('reset_by'),
					'cnic1'=>request('cnic1'),
					'cnic2'=>request('cnic2'),
					'email'=>request('email'),
					'phone'=>request('phone_no'),
					'error'=>'Please choose an option for reset password'
				]);
			}
		}
		return view('front.forgot-password');
	}
	public function privacy() {
		$data = Privacy::first();
		return view( 'front.privacy', compact( 'data' ) );
	}
	public function _faqs(){
		$data = Faqs::orderBy('tb_order', 'desc')->get();
		return view('front.faqs' , compact('data')); 
	}
	public function terms() {
		$data = TermsCondition::first();
		return view( 'front.terms', compact( 'data' ) );
	}
	 public function notFound() {
	 	return abort( '404');
	 }
}
