@include('front.layout.header')
  <style>
    .loader-section{
          height:500px;
          background:white url('compress/preloader.gif') no-repeat center center;
      }
    .map-image-col .map-column{
      width:100%;
      height:400px;
      margin-top:30px;
    }
    .isLoading{
        min-height:100vh;
        margin-bottom:80px;
        height:100%;
        width:100%;
      }
      .isLoading>div{
        display: none;
      }
  </style>
    <!--Load different Section on scroll-->
    <script>
          window.addEventListener("load", (event) => {["sectionTwo","sectionThree","sectionFour","sectionFive","sectionSix"].forEach(name =>{
              handleEachCategory(name);
            });
          }, false);

          function handleEachCategory(category) {
            let target = document.getElementById(category);
            let observer;
            let isVis;
            createObserver();

          function createObserver() {
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.25
            }
            observer = new IntersectionObserver(handleIntersect, options);
            observer.observe(target);
          }  

          function handleIntersect(entries, observer) {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                  entry.target.classList.remove('isLoading');
              }
          });
        }
      }
    </script>
<link rel="stylesheet" href="{{asset('assets/style/all.index.css') }}">
</head>
<body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>''])
  <header class="main-header" id="sectionOne">
    <div class="container-fluid  padding-0 sectionChild">
      <div class="top-map">
        <div class="container">
          <div class="row">
            <div class="col-md-5 col-lg-4">
              <h3>We Have The Largest Network In Pakistan</h3>
              <ul>
                <li class="pak"> <a href="{{ route('base_url')."/pakistan" }}"><span>Pakistan</span></a> </li>
                @if (count($province) > 0)
                  @foreach ($province as $element)
                    <li> <a href="{{ $element->slug }}"><span>{{ $element->name }}</span></a> </li>
                    {{-- expr --}}
                  @endforeach
                  {{-- expr --}}
                @endif
              </ul>
            </div>
            <div class="col-md-7 col-lg-8 map-image-col" id="country-map">
              <div class="map-column">
                @include('front.layout.new-map')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  @php
    $res = isset($data->text_sec1 )? json_decode($data->text_sec1 , true) : array();
    $ts_img1 = (isset($res["ts_img1"])) ? '<img src='.is_image($res["ts_img1"]).' class="img-fluid" alt="about-img">': "";
    $ts_details1 = (isset($res["ts_details1"])) ? $res["ts_details1"]: "";
  @endphp
  <div class="isLoading" id="sectionTwo">
    @if ($ts_details1 !="" and $ts_img1 !="")
    <div class="container about-intro">
      <div class="row show-section align-items-center sectionChild">
        <div class="col-lg-8 col-xl-7 about-col intro-col-one">
          {!! $ts_details1 !!}
        </div>
        <div class="col-lg-4 col-xl-5 about-col">
          @isset ($res["ts_img1"])
                <img class="img-fluid" src="{{ is_image($res["ts_img1"]) }}" alt="{{ get_alt($res["ts_img1"]) }}">
            @endisset
        </div>
      </div>
    </div>
    @endif
  </div>
  
  <!-- Our Grants -->
  @php
    $grant  = ($data->grants  !="" )? json_decode($data->grants , true) : array();
    $grants = isset($grant["grants"]) ? $grant["grants"] : array() ;
    $count = (count($grants) > 3) ? "owl-carousel grant-carousel" : "row";
    $item = (count($grants) > 3) ? "item" : "col-md-4";
    $heading = (isset($grant["m_heading"]))? $grant["m_heading"] :"";
  @endphp
  <div class="isLoading" id="sectionThree">
      @if (count($grants) > 0)   
      <div class="grants-section grCarousel-section">
      <div class="show-section sectionChild">
        <div class="grant-overlay"></div>
        <div class="container grant-container">

          @if ($heading !="")
            <h3 class="main-head text-center">{{ $heading }}</h3>
          @endif
          
          <div class="row">
            <div class="col-md-11 mx-auto">
              <div class="{{ $count }}">
                @foreach ($grants as $k => $v)
                @php
                  $title = (isset($v["title"])) ? $v["title"]: "";
                  $anchor_url = (isset($v["anchor_url"])) ? $v["anchor_url"]: "";
                  $anchor_text  = (isset($v["anchor_text"])) ? $v["anchor_text"]: "";
                  $description  = (isset($v["description"])) ? $v["description"]: "";
              @endphp
               <div class="{{ $item }}">
                <div class="grant-column hvr-overline-from-left" style="width:100%;min-height:324px;max-height:324px;">
                  <div class="grant-icon"> 
                    @isset ($v["img"])
                        <img class="img-fluid" src="{{ is_image($v["img"]) }}" alt="{{ get_alt($v["img"]) }}">
                    @endisset
                  </div>
                  <div class="grant-text">
                    <h3>{{ $title }}</h3>
                    <p>{{ $description }}</p>
                    <a href="{{ $anchor_url }}">{{ $anchor_text }}&nbsp;<i class="icon-arrow-right2"></i></a> </div>
                </div>
              </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>     
    </div> @endif
  </div>
</div>
<!-- What We Offer -->
  <div class="isLoading" id="sectionFour">
    <div class="offer-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <div class="offer-column">
              <h3 class="main-head text-center">Latest News</h3>
              <div class="row dashboxes">
                <div class="col-lg-12">
                  @foreach ($news as $k => $v)
                  @php
                     $title = unslash( $v->title );
                      $content = trim(trim_words( html_entity_decode($v->content), 150 ));
                      $content = clean_short_code(html_entity_decode($content));
                      $url = route('base_url')."/".$v->slug."-5".$v->id;
                      if($v->category == "green"){
                        $class = "dash-success";
                        $color = "bg-grdgreen";
                        $icon  =  "<i class='icon-check_circle_outline'></i>";
                      }elseif($v->category == "orange"){
                        $class = "dash-warn";
                        $color = "bg-grdorange";
                        $icon  =  "<i class='icon-info'></i>";
                      }elseif($v->category == "blue"){
                        $class = "dash-info";
                        $color = "bg-info";
                        $icon  =  "<i class='icon-info'></i>";
                      }elseif($v->category == "red"){
                        $class = "dash-error";
                        $color = "bg-grdred";
                        $icon  =  "<i class='icon-cancel-circle'></i>";
                      }else{
                        $class = "";
                        $color = "";
                        $icon = "";
                      }
                  @endphp
                    <div class="dash-box {{ $class }}">
                      <div class="dash-flex">
                        <div class="dash-icon {{ $color }}"> {!! $icon !!} </div>
                        <div class="dash-date">
                          @if ($v->date)
                          @php
                          $date = date("d", strtotime($v->date) );
                          $month = date("M", strtotime($v->date) );
                          @endphp
                          <h4>{{ $date }} <span>{{ $month }}</span></h4>
                          @endif
                        </div>
                        <div class="dash-detail">
                          <h3><a href="{{$url}}">{{ $title }}</a></h3>
                          <p>{{ $content }}</p>
                        </div>
                        
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-6">
            @php
                $rec   = ($data->interest  !="" )? json_decode($data->interest , true) : array();
                $heading = isset($rec["m_heading"])? $rec["m_heading"] :"";
                $result = isset($rec["interest"])? $rec["interest"] :"";
                $heading = (isset($heading)) ? "<h3 class='main-head text-center'>".$heading."</h3>" : "";
                @endphp
            {!! $heading !!}
            @if ($result > 0)
            <div class="success-row">
                @foreach ($result as $k => $v)
                @php
                  $icon = (isset($v["icon"])) ? $v["icon"]: "";
                  $name = (isset($v["name"])) ? "<h3 class='text-center'>".$v["name"]."</h3>" : "";
                  $count = (isset($v["count"])) ? "<span>".$v["count"]."</span>" : "";

                  if(empty($count) && $v["name"] == 'Provinces'){
                    $c_count = DB::table('users')->where('status','approved')->distinct()->count('province');
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Districts'){
                    $c_count = DB::table('users')->where('status','approved')->distinct()->count('district');
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Members'){
                    $c_count = DB::table('users')->where('status','approved')->count();       
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Events'){
                    $c_count = DB::table('event')->count(); 
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Grants'){
                    $c_count = DB::table('death_claims')->where('status','delivered')->count();
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Pension Calculations'){
                    $c_count = 0;
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Pension Paper'){
                    $c_count = 0;
                    $count = "<span>".$c_count."</span>";
                  }elseif(empty($count) && $v["name"] == 'Notifications'){
                    $c_count = DB::table('downloads')->where(['type'=>'govt-notification'])->count();
                    $count = "<span>".$c_count."</span>";
                  }
                @endphp
                <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                  <div class="success-icon dash-flex"> {!! $icon !!} {!! $count !!} </div>
                  {!! $name !!}
                </div>
                @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Our Grants -->
  <div class="isLoading" id="sectionFive">
  @php
    $ini  = ($data->initiatives  !="" )? json_decode($data->initiatives , true) : array();
    $initiatives = isset($ini["initiatives"]) ? $ini["initiatives"] : array();
    $count = (count($initiatives) > 3) ? "owl-carousel grant-carousel" : "row";
    $item = (count($initiatives) > 3) ? "item" : "col-md-4";
    $heading = isset($ini["m_heading"]) ? $ini["m_heading"] : "";
    $heading = (isset($heading)) ? "<h3 class='main-head text-center'>".$heading."</h3>" : "";
  @endphp
  @if ( count($initiatives) > 0)
    <div class="initiative-section grants-section">
      <div class="grant-overlay"></div>
      <div class="container grant-container">
        {!! $heading !!}
        <div class="row">
          <div class="col-md-11 mx-auto">
              <div class="{{ $count }}">
                  @foreach ($initiatives as $k => $v)
                    @php
                      $title = (isset($v["title"])) ? $v["title"]: "";
                      $anchor_url = (isset($v["anchor_url"])) ? $v["anchor_url"]: "";
                      $anchor_text  = (isset($v["anchor_text"])) ? $v["anchor_text"]: "";
                      $description  = (isset($v["description"])) ? $v["description"]: "";
                    @endphp
                     <div class="{{ $item }}">
                      <div class="grant-column hvr-outline-corner">
                        <span class="border-tl"></span>
                        <span class="border-tr"></span>
                        <div class="grant-icon"> 
                          @isset ($v["img"])
                            <img src="{{ is_image($v["img"]) }}" alt="{{ get_alt($v["img"]) }}">
                        @endisset
                        </div>
                        <div class="grant-text">
                          <h3>{{ $title }}</h3>
                          <p>{{ $description }}</p>
                          <a href="{{ $anchor_url }}">{{ $anchor_text }}&nbsp;<i class="icon-arrow-right2"></i></a> 
                        </div>
                        <span class="border-rb"></span>
                        <span class="border-lb"></span>
                      </div>
                    </div>
                  @endforeach
              </div>
          </div>
        </div>
      </div>
    </div>
     @endif
  </div>
  <div class="isLoading" id="sectionSix">
    @if (count($blogs) > 0)
      <div class="blog-section">
        <div class="container">
          <h3 class="main-head text-center">Our Latest Posts</h3>
          <div class="row">
            @foreach ($blogs as $k => $v)
              @php
                $title = unslash( $v->title );
                $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
                $content = trim(trim_words( html_entity_decode($v->content), 12 ));
                $content = clean_short_code(html_entity_decode($content));
                $image = $v->cover;
                $url = route('base_url')."/".$v->slug."-3".$v->id;
              @endphp
              <div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
                <div class="blog-column">
                  <div class="blog-image">
                    <a href="{{ $url }}">
                      <img src="{{ get_post_mid($image) }}" width="100%" height="555" class="img-fluid" srcset="{{ get_post_mid($image) }} 400w,{{ get_post_mid($image) }} 992w,{{ get_post_mid($image) }} 1920w" sizes="100vw" alt="{{ $short_title }}">
                      <div class="img-hvr"></div>
                      @if ($v->date)
                        @php
                          $date = date("d", strtotime($v->date) );
                          $month = date("M", strtotime($v->date) );
                        @endphp
                        <div class="blog-date">
                          <span class="date">{{ $date }}</span>
                          <span class="month">{{ $month }}</span>
                        </div>
                      @endif
                    </a>
                  </div>
                  <div class="blog-bottom">
                    <ul class="blog-feat">
                      <li><i class="icon-user"></i><a href="#">Admin</a></li>
                      @isset ($v->category)
                        @php
                          $cat =  explode(",", $v->category);
                          $cat_name = get_cat_name($cat[0]);
                        @endphp  
                        <li>
                          <i class="icon-price-tags"></i><a href="#">{{ $cat_name }}</a>
                        </li> 
                      @endisset
                    </ul>
                    <h3>
                    <a href="{{ $url }}">{{ $short_title }}</a>
                    </h3>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      {{-- expr --}}
    @endif
  </div>
  @php
    $br = DB::table('brands')->get();
  @endphp
  @if (count($br) > 0)
  <div>
    <div class="partner-section">
      <div class="container">
        <div class="client-box row">
          {{-- {{ dd($br) }} --}}
          @foreach ($br as $k => $v)
            <div class="col-4 col-sm-3 col-md-2 client-item">
              <a href="{{ $v->url }}"> <img src="{{ is_image($v->image) }}" class="img-fluid" alt="{{ get_alt($v->image) }}"></a> 
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif
@include('front.layout.footer')
</div>
@php
    $row = \App\Models\Homedata::select('views')->first();
    refresh_views($row['views'] , 0 , 0 , get_postid('full'));
@endphp
<!--  Owl Carousel --> 
<script src="{{asset('assets/js/owl.js') }}"></script> 
      <script type="text/javascript">
          $('.blog-bottom > h3').css('overflow','hidden');
          $(".grant-carousel").owlCarousel({
              loop:true,
              margin:15,
              nav:true,
              dots:true,
              autoplay:true,
              autoplayTimeout:3000,
              autoplayHoverPause:true,
              navText : ['<i class="icon-arrow-left2"></i>','<i class="icon-arrow-right2"></i>'],
              responsive:{
                  0:{
                      items:1
                  },
                  576:{
                      items:1
                  },
                  768:{
                      items:2
                  },
                  992:{
                      items:3
                  },
                  1200:{
                      items:3
                  }
              }
          });
          $("svg #punjab-map path,svg #text32,#isl-map path").hover(function(){
               $("#isl-map path").css({"fill":"#ccc"});
               $("svg #punjab-map path").css({"fill":"#ccc"});
            },function(){
               $("#isl-map path").css({"fill":"#C6E7F8"});
               $("svg #punjab-map path").css({"fill":"#C6E7F8"});
          });
          $("svg #sindh-map path,svg #text30").hover(function(){
               $("svg #sindh-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #sindh-map path").css({"fill":"#F2EC8A"});
          });
          $("svg #balochistan-map path,svg #text28").hover(function(){
               $("svg #balochistan-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #balochistan-map path").css({"fill":"#FEEAC9"});
          });
          $("svg #fata-map path,svg #text34").hover(function(){
               $("svg #fata-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #fata-map path").css({"fill":"#d5c2db"});
          });
          $("svg #kpk-map path,svg #text36").hover(function(){
               $("svg #kpk-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #kpk-map path").css({"fill":"#E9DCCB"});
          });
          $("svg #gilgit-map path,svg #text38").hover(function(){
               $("svg #gilgit-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #gilgit-map path").css({"fill":"#D9E6D2"});
          });
          $("svg #kashmir-map path").hover(function(){
               $(this).css({"fill":"#ccc"});
            },function(){
               $(this).css({"fill":"#ffffd0"});
          });
      </script>
</body>
</html>
