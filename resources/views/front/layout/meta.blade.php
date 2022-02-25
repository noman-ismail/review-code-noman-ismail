@php
    $segment = request()->segment(1);
    $segment2 = request()->segment(2);
    $route = $segment;
    $page_name = get_postid("full");
    $page_id = get_postid("page_id");
    $post_id = get_postid("post_id");
    $setting = \App\Models\generalsetting::first();
    $favicon =  (isset($setting->favicon)) ? $setting->favicon : "";
    $google_analytics =  (isset($setting->google_analytics)) ? $setting->google_analytics : "";
    $web_master =  (isset($setting->web_master)) ? $setting->web_master : "";
    $bing_master =  (isset($setting->bing_master)) ? $setting->bing_master : "";
    $og_image = (isset($setting->og)) ? $setting->og: "" ;
    $og_image =  $setting->og ;
    $schema = array();
    $meta_title = "No Meta Title ";
    $meta_description = "No Meta Description";
    $meta_tags = "No Meta Tags";
    if($page_name == ""){
        $data = \App\Models\Homedata::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $data   = ($data['home_meta']  !="" )? json_decode($data['home_meta']  , true) : array();
        $meta_title = (isset($data["meta_title"]) and $data["meta_title"] !="") ? $data["meta_title"] : "";
        $meta_description = (isset($data["meta_description"]) and  $data["meta_description"]!="") ? $data["meta_description"] : "";
        $meta_tags = (isset($data["meta_tags"]) and $data["meta_tags"] !="") ? $data["meta_tags"] : "";
        $og_image = (isset($data["og_image"])) ? $data["og_image"] : $setting->og ;
    }elseif($page_name == "about-us"){
        $data = \App\Models\AboutUs::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $about_og = isset($data['og_image']) ? $data['og_image'] : "";
        $data = isset($data['about_meta']) ? json_decode($data['about_meta'] , true) : array();
        $meta_title = ($data["meta_title"] !="") ? $data["meta_title"] : "";
        $meta_description = ($data["meta_description"] !="") ? $data["meta_description"] : "";
        $meta_tags = ($data["meta_tags"] !="") ? $data["meta_tags"] : "";
        $og_image = ($about_og!="") ? $about_og :$setting->og;
    }elseif($page_name == "welfare-benefits"){
        $data = DB::table("welfare_benefits")->first();
        $schema   = ($data->microdata  !="" )? json_decode($data->microdata  , true) : array();
        $about_og = isset($data->og_image) ? $data->og_image : "";
        $meta_title = ($data->meta_title !="") ? $data->meta_title : "";
        $meta_description = ($data->meta_description !="") ? $data->meta_description : "";
        $meta_tags = ($data->meta_tags !="") ? $data->meta_tags : "";
        $og_image = ($about_og!="") ? $about_og :$setting->og;
    }elseif($page_name == "blogs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "documents"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "notifications"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "events"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "jobs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "news"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "careers"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$setting->og;
    }elseif($page_name == "faqs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = $r->og_image?$r->meta_tags:$setting->og;
    }elseif($page_name == "district"){
        $data = DB::table('generalsettings')->first();
        $r = (!empty($data)) ? json_decode($data->district_cabinet) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = $setting->og;
    }elseif($page_name == "contact-us"){
        $data = \App\Models\ContactUs::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->meta_tags:$setting->og;
    }elseif($page_name == "privacy-policy"){
        $data = \App\Models\Privacy::first();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "terms-conditions"){
        $data = \App\Models\TermsCondition::first();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "404"){
        $meta_title = "Page Not Found";
        $meta_description = "Page Not Found";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "search"){
        $meta_title = "Search";
        $meta_description = "Search Result";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "register"){
        $meta_title = "APJEA Registeration";
        $meta_description = "Regsiteration form for APJEA Members";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "forgot-password"){
        $meta_title = "APJEA Forgot Password";
        $meta_description = "Forgot Password APJEA";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($page_name == "pension-calculator"){
        $data = DB::table('meta')->where(['page_name'=>'pension-calculator'])->first();
        $meta_title = (!empty($data) and !empty($data->meta_title)) ? $data->meta_title : "Pension Calculator | APJEA";
        $meta_description = (!empty($data) and !empty($data->meta_description)) ? $data->meta_description : "Pension Calculator APJEA";
        $meta_tags = (!empty($data) and !empty($data->meta_tags)) ? $data->meta_tags : "Pension Calculator APJEA";
        $og_image = (!empty($data) and !empty($data->og_image)) ? $data->og_image :$setting->og;
    }elseif($page_name == "login" and empty($segment2)){
        $meta_title = "APJEA Login";
        $meta_description = "User Panel Login";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'dashboard'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Dashboard '.$current_uu_name.' - APJEA';
        $meta_description = 'Dashboard - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'personal-information'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Personal Information - '.$current_uu_name.' - APJEA';
        $meta_description = 'Personal Information - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'nominee-information'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Nominee Information - '.$current_uu_name.' - APJEA';
        $meta_description = 'Nominee Information - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'family-information'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Family Information - '.$current_uu_name.' - APJEA';
        $meta_description = 'Family Information - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'amount-history'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Amount History - '.$current_uu_name.' - APJEA';
        $meta_description = 'Amount History - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'add-funds'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Add Fund - '.$current_uu_name.' - APJEA';
        $meta_description = 'Add Fund - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'funds-history'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Fund History - '.$current_uu_name.' - APJEA';
        $meta_description = 'Fund History - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }elseif($segment == 'login' and $segment2 == 'account-setting'){
        $current_uu_name = auth('login')->user()->name;
        $meta_title = 'Account Setting - '.$current_uu_name.' - APJEA';
        $meta_description = 'Account Setting - APJEA';
        $meta_tags = '';
        $og_image = isset($data->og_image)?$data->og_image:$setting->og;
    }else{
        if(empty($segment2)){
            if($page_name != 'pakistan'){
                $check = DB::table('province')->where('slug',$page_name)->first();
                if(empty($check)){
                    $check = DB::table('cities')->where('slug',$page_name)->first();
                    if(empty($check)){
                        switch ($page_id) {
                            case 1:
                                $r = \App\Models\Jobs::find($post_id);
                                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                                    $og_image = isset($r->og_image)?$r->og_image:"";
                                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                                    break;
                            case 2:
                                $r = \App\Models\Event::find($post_id);
                                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                                    $og_image = isset($r->og_image)?$r->og_image:"";
                                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                                    break;
                            case 3:
                                $r = \App\Models\Blogs::find($post_id);
                                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                                    $og_image = isset($r->og_image)?$r->og_image:"";
                                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                                    break;
                            case 4:
                                    $r = \App\Models\blogcats::find($post_id);
                                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                                    $og_image = isset($r->og_image)?$r->og_image:$setting->og;
                                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                                    break;
                            case 5:
                                    $r = \App\Models\News::find($post_id);
                                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                                    $og_image = isset($r->og_image)?$r->og_image:$setting->og;
                                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                                    break;
                            default:
                                $meta_title = $meta_title;
                                $meta_description =$meta_description;
                                $meta_tags = $meta_tags;
                                $og_image = $setting->og;
                        }
                    }else{
                        $fff = (!empty($check->cabinet_meta))? json_decode($check->cabinet_meta ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                        if(!empty($fff)){
                            $meta_title = $fff->meta_title;
                            $meta_description = $fff->meta_description;
                            $meta_tags = $fff->meta_tags;
                            $og_image = $setting->og;
                        }else{
                            $meta_title = $meta_title;
                            $meta_description = $meta_description;
                            $meta_tags = $meta_tags;
                            $og_image = $setting->og;                        
                        }
                    }
                }else{
                    $fff = (!empty($check->cabinet_meta))? json_decode($check->cabinet_meta ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    if(!empty($fff)){
                        $meta_title = $fff->meta_title;
                        $meta_description = $fff->meta_description;
                        $meta_tags = $fff->meta_tags;
                        $og_image = $setting->og;
                    }else{
                        $meta_title = $meta_title;
                        $meta_description = $meta_description;
                        $meta_tags = $meta_tags;
                        $og_image = $setting->og;                        
                    }
                }
            }else{
                $fff = (!empty($check->cabinet_meta))? json_decode($check->cabinet_meta ) : array();
                $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                if(!empty($fff)){
                    $meta_title = $fff->meta_title;
                    $meta_description = $fff->meta_description;
                    $meta_tags = $fff->meta_tags;
                    $og_image = $setting->og;
                }else{
                    $meta_title = $meta_title;
                    $meta_description = $meta_description;
                    $meta_tags = $meta_tags;
                    $og_image = $setting->og;                        
                }
            }
        }else{
            $fff = array();
            if($segment2 == 'team'){
                $__table = 'cabinet_team_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $check = DB::table('cities')->where('slug',$page_name)->first();
                        if(!empty($check)){
                            $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                            $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                        }else{
                            $fff = $schema = array();
                        }
                    }else{
                        $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    }
                }else{
                    $check = DB::table('national')->first();
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }
            }elseif($segment2 == 'apjea-members'){
                $__table = 'members_meta';
                $check = DB::table('cities')->where('slug',$page_name)->first();
                if(!empty($check)){
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }else{
                    $fff = $schema = array();
                }
            }elseif($segment2 == 'news-updates'){
                $__table = 'news_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $check = DB::table('cities')->where('slug',$page_name)->first();
                        if(!empty($check)){
                            $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                            $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                        }else{
                            $fff = $schema = array();
                        }
                    }else{
                        $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    }
                }else{
                    $check = DB::table('national')->first();
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }
            }elseif($segment2 == 'events'){
                $__table = 'events_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $check = DB::table('cities')->where('slug',$page_name)->first();
                        if(!empty($check)){
                            $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                            $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                        }else{
                            $fff = $schema = array();
                        }
                    }else{
                        $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    }
                }else{
                    $check = DB::table('national')->first();
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }
            }elseif($segment2 == 'jobs'){
                $__table = 'jobs_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $check = DB::table('cities')->where('slug',$page_name)->first();
                        if(!empty($check)){
                            $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                            $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                        }else{
                            $fff = $schema = array();
                        }
                    }else{
                        $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    }
                }else{
                    $check = DB::table('national')->first();
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }
            }elseif($segment2 == 'contact-us'){
                $__table = 'cabinet_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $check = DB::table('cities')->where('slug',$page_name)->first();
                        if(!empty($check)){
                            $panel = 'district';
                            $__rr = DB::table('contact_us')->where('user_type',$panel)->where($panel,$check->id)->first();
                            if($__rr){
                                $fff = json_decode(json_encode(['meta_title'=>$__rr->meta_title,'meta_description'=>$__rr->meta_description,'meta_tags'=>$__rr->meta_tags]));
                                $schema = (!empty($fff->microdata)) ? json_decode($fff->microdata , true) : array();
                            }else{
                                $fff = $schema = array();
                            }
                        }else{
                            $fff = $schema = array();
                        }
                    }else{
                        $panel = 'province';
                        $__rr = DB::table('contact_us')->where('user_type',$panel)->where($panel,$check->id)->first();
                        if($__rr){
                            $fff = json_decode(json_encode(['meta_title'=>$__rr->meta_title,'meta_description'=>$__rr->meta_description,'meta_tags'=>$__rr->meta_tags]));
                            $schema = (!empty($fff->microdata)) ? json_decode($fff->microdata , true) : array();
                        }else{
                            $fff = $schema = array();
                        }
                    }
                }else{
                    $check = DB::table('national')->first();
                    $__rr = DB::table('contact_us')->where('user_type','national')->first();
                    if($__rr){
                        $fff = json_decode(json_encode(['meta_title'=>$__rr->meta_title,'meta_description'=>$__rr->meta_description,'meta_tags'=>$__rr->meta_tags]));
                        $schema = (!empty($fff->microdata)) ? json_decode($fff->microdata , true) : array();
                    }else{
                        $fff = $schema = array();
                    }
                }
            }elseif($segment2 == 'notifications'){
                $__table = 'notification_meta';
                if($page_name != 'pakistan'){
                    $check = DB::table('province')->where('slug',$page_name)->first();
                    if(empty($check)){
                        $fff = $schema = array();
                    }else{
                        $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                        $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                    }
                }else{
                    $check = DB::table('national')->first();
                    $fff = (!empty($check->$__table))? json_decode($check->$__table ) : array();
                    $schema   = (!empty($fff))? json_decode($fff->schema  , true) : array();
                }
            }
            if(empty($fff)){
                $meta_title = $meta_title;
                $meta_description = $meta_description;
                $meta_tags = $meta_tags;
                $og_image = $setting->og; 
            }else{
                $meta_title = $fff->meta_title;
                $meta_description = $fff->meta_description;
                $meta_tags = $fff->meta_tags;
                $og_image = $setting->og;
            }
        }
        $og_image;
}
@endphp
		<meta charset="utf-8">
		<title>{{$meta_title}}</title>
		<meta http-equiv="Content-Security-Policy" content="base-uri 'self'">
		<meta name="theme-color" content="#257c17"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{$favicon}}" rel="shortcut icon" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{$favicon}}">
        <link rel="canonical" href="{{ url('/'.$page_name) }}" />
		<meta name="title" content="{{$meta_title}}">
		<meta name="description" content="{{$meta_description}}">
		<meta name="keywords" content="{{ $meta_tags }}">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:url" content="{{ url('/'.$page_name) }}">
		<meta name="twitter:title" content="{{$meta_title}}">
		<meta name="twitter:description" content="{{$meta_description}}">
		<meta name="twitter:image" content="{{$og_image}}">
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{ url('/'.$page_name) }}">
		<meta property="og:title" content="{{$meta_title}}">
		<meta property="og:description" content="{{$meta_description}}">
		<meta property="og:image" content="{{$og_image}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	@foreach ($schema as $element) @if (strpos($element['schema'], "script") !==false)
		{!! $element['schema'] !!} 
	@endif
	@endforeach
		<script>
			var page_id = {{ get_postid("page_id") }};
		</script>
		{!! $web_master !!}
		{!! $google_analytics !!}
		{!! $bing_master !!}