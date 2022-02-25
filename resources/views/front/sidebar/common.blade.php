<aside class="col-lg-4 col-xl-3 aside-col">
     @php
   $page_id = get_postid("page_id");
  $slug = get_postid("full");
  if($slug == "privacy-policy"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "terms-conditions"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "district"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "welfare-benefits"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($page_id == 3){
    $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "blog")->get();
  }elseif($page_id == 5){
    $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "news")->get();
  }
  $order = array();
  if (isset($r[0]->data_order)){
    $order = explode(",",$r[0]->data_order);
  }
    $ads =  DB::table("ads")->get();
    if (count($ads) > 0) {
      $ads = json_decode($ads[0]->ads, true);
    }
    $r  = DB::table("ads")->get();
    if(isset($r[0]->id) !=""){
      $id = (isset($r[0]->id)!='')?$r[0]->id: '' ;
      $add = (isset($r[0]->ads))? $r[0]->ads: "";
      $add = ($ads !="" )? json_decode($add , true) : array();
      $add_ids = array_column($add , 'ads_id');
    }
   if (!empty($order)) {

    foreach ($order as $value) {
       $end = (!next( $order)) ? "true" : "false" ;
       if($value == 1) {
       @endphp 
        @include( "front.sidebar.trending")
       @php
      }elseif($value == 2) { 
        @endphp
         @include( "front.sidebar.blogcats")
         @php
      }else{
        if(isset($r[0]->id) !=""){
          if ($value !="") {
            if ($value >= 3 and $value <= 100) {
              $ads_id = $value - 3;
              $ad = $ads[$ads_id];
              $ad['end'] = $end;
              if (isset($ad)) {
              @endphp
              @include( "front.sidebar.ads" , $ad)
              @php }
            }
          }
        }
      }   
   }
  }
 @endphp
</aside>
