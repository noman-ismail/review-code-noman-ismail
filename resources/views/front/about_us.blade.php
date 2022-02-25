@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.about.css') }}">
</head><body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'about'])
  <header class="title-header contact-header">
    <div class="container">
      <div class="header-text">
        <h1 class="header-title">About Us</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><a href="{{ route('base_url') }}/about-us">About Us</a></li>
        </ul>
      </div>
    </div>
  </header>
  <main class="main-content"> 
    <!-- About Us Intro -->
    <div class="container-fluid bg-silver">
    @php
      $res = isset($data->text_sec1 )? json_decode($data->text_sec1 , true) : array();
      $ts_details1 = (isset($res["ts_details1"])) ? $res["ts_details1"]: "";
     @endphp
      <div class="container about-intro">
        <div class="row align-items-center">
          <div class="col-lg-4 col-xl-5 about-col"> 
            @isset ($res["ts_img1"])
                <img class="img-fluid" src="{{ is_image($res["ts_img1"]) }}" alt="{{ get_alt($res["ts_img1"]) }}">
            @endisset
        </div>
          <div class="col-lg-8 col-xl-7 about-col intro-col-one">
            {!! $ts_details1 !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Our Experience -->
    <div class="container-fluid experience-section">
      <div class="container">
        <div class="row expr-flex">
              @php
                $res = isset($data->text_sec2 )? json_decode($data->text_sec2 , true) : array();
                $ts_img2 = (isset($res["ts_img2"])) ? '<img src='.is_image($res["ts_img2"]).' class="img-fluid" alt="about single person">': "";
                $ts_details2 = (isset($res["ts_details2"])) ? $res["ts_details2"]: "";
              @endphp
          <div class="col-lg-7 expr-col-7 dark-col">
            <div class="container">
             {!! $ts_details2 !!}
            </div>
          </div>
          <div class="col-lg-5 expr-col-5 light-col">
            <div class="figure"> 
              @isset ($res["ts_img2"])
                <img class="img-fluid" src="{{ is_image($res["ts_img2"]) }}" alt="{{ get_alt($res["ts_img2"]) }}">
            @endisset 
          </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Client Reviews -->
     @php
      $res   = ($data->reviews  !="" )? json_decode($data->reviews , true) : array();
     @endphp
     @isset ($res['reviews'])
    <div class="container-fluid review-section" id="review-section">
      @isset ($res["m_heading"])
        <h3 class="main-head">{{ $res["m_heading"] }}</h3> 
      @endisset
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="owl-carousel review-slider">
              @foreach ($res['reviews'] as $k => $v)
              @php
                $name = (isset($v["name"])) ? $v["name"]: "";
                $designation = (isset($v["designation"])) ? $v["designation"]: "";
                $review = (isset($v["review"])) ? $v["review"]: "";
              @endphp
              <div class="item">
                <div class="review-item">
                  <div class="review-text">
                    <p>{{ $review }}</p>
                  </div>
                  <div class="review-detail row">
                    <div class="review-image col-3"> 
                    @isset ($v["img"])
                      <img class="img-fluid" src="{{ is_image($v["img"]) }}" alt="{{ get_alt($v["img"]) }}">
                    @endisset
                    </div>
                    <div class="review-info col-9">
                      <h4 class="review-title">{{ $name }}</h4>
                      <p>{{ $designation }}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endisset
@php
$res   = ($data->attorneys  !="" )? json_decode($data->attorneys , true) : array();
@endphp
@if( count($res['attorneys']) > 0 )
<div class="container-fluid team-section">
  @isset ($res["m_heading"])
  <h3 class="main-head">{{ $res["m_heading"] }}</h3>
  @endisset
  
  <div class="container">
    <div class="owl-carousel team-slider">
      @foreach ($res['attorneys'] as $k => $v)
      @php
      $name = (isset($v["name"])) ? "<h4>".$v["name"]."</h4>": "";
      $designation = (isset($v["designation"])) ? "<p>".$v["designation"]."</p>": "";
      $details = (isset($v["details"])) ? $v["details"]: "";
      @endphp
      <div class="item">
        <div class="team-column">
          <div class="team-image"> 
            @isset ($v['img'])
                <img src="{{ is_image($v['img']) }}" alt="{{ get_alt($v['img']) }}">
            @endisset
            <div class="team-overlay"></div>
            <ul class="team-nav">
              @isset ($v["fb_url"])
              <li><a href="{{$v["fb_url"]}}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i></a> </li>
              @endisset
              @isset ($v["twitter_url"])
              <li><a href="{{ $v["twitter_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i></a> </li>
              @endisset
              @isset ($v["instagram_url"])
              <li><a href="{{ $v["instagram_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i></a> </li>
              @endisset
              @isset ($v["linkedin_url"])
              <li><a href="{{ $v["linkedin_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i></a> </li>
              @endisset
            </ul>
          </div>
          <div class="team-bottom">
            {!! $designation !!}
            {!! $name !!}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif
    <!-- About Intro Bottom -->
      @php
        $res = isset($data->text_sec3 )? json_decode($data->text_sec3 , true) : array();
        $ts_details3 = (isset($res["ts_details3"])) ? $res["ts_details3"]: "";
      @endphp
      @if ($ts_details3 !="")
    <div class="container-fluid bottom-section bg-silver">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 about-col">
            <figure class="main-figure"> 
              @isset ($res["ts_img3"])
                <img class="img-fluid" src="{{ is_image($res["ts_img3"]) }}" alt="{{ get_alt($res["ts_img3"]) }}">
            @endisset
            </figure>
          </div>
          <div class="col-lg-7 about-col intro-col-two">
            {!! $ts_details3 !!}
          </div>
        </div>
      </div>
    </div>
     @endif
    <!-- video popup -->
    <div class="popup" id="myPopup">
      <div class="popup-content">
        <div class="closebar">
          <button class="btnClose" type="button"><i class="fa fa-times"></i></button>
        </div>
        <span class="close">Close &times;</span> </div>
    </div>
  </main>
  @php
    $row = \App\Models\AboutUs::select('views')->first();
    refresh_views($row['views'] , 0 , 0 , get_postid('full'));
@endphp
  @include('front.layout.footer') 
  <script src="{{asset('assets/js/owl.js') }}"></script> 
  <script>
	$(window).on("load scroll",function(){
	if($(window).scrollTop() > 300){
		startCarousel();
	}
	else{
		setTimeout(function(){startCarousel();},2000);      
	}
	});
	$(".team-column").hover(function(){
		$(this).find(".team-nav").addClass("fade");
		},function(){
	$(".team-column").find(".team-nav").removeClass("fade");
	});

    function startCarousel(){
    $(".review-slider").owlCarousel({
            loop:true,
              margin:20,
              nav:false,
              autoplay:true,
              autoplayTimeout:4000,
              autoplayHoverPause:true,
              dots:true,
              responsive:{
                  0:{
                      items:1
                  },
                  576:{
                      items:1
                  },
                  992:{
                      items:2
                  },
                  1200:{
                      items:3
                  }
              }
          });

    $(".team-slider").owlCarousel({
            loop:true,
              margin:20,
              nav:false,
              dots:true,
              autoplay:false,
              autoplayTimeout:3000,
              autoplayHoverPause:true,
              responsive:{
              0:{
                    items:1
                },
                400:{
                    items:1
                },
                576:{
                    items:2
                },
                1200:{
                    items:3
                },
                        1440:{
                    items:4
                }
              }
          });
                 }
    </script> 
  <script>
      // https://www.youtube.com/watch?v=x3ptP78JOnM
      var popup  =  document.getElementById("myPopup");
      var button =  document.getElementById("btn-popup");
      var span   =  document.getElementsByClassName("close")[0];
      var close  =  document.getElementsByClassName("btnClose")[0];

      if (button != null) {
        button.onclick = function(e){
          e.preventDefault();
          popup.style.display = "block";
          var iframe = document.createElement("iframe");
          iframe.classList.add("ifr-video");
          iframe.src = "//www.youtube.com/embed/7e90gBu4pas?autoplay=1";
          document.getElementsByClassName("popup-content")[0].appendChild(iframe);
        }
      }
      span.onclick = function(){
        popup.style.display = "none";
        var iframe = document.getElementsByClassName('ifr-video')[0];
        iframe.parentNode.removeChild(iframe);
      }

      close.onclick = function(){
        popup.style.display = "none";
        var iframe = document.getElementsByClassName('ifr-video')[0];
        iframe.parentNode.removeChild(iframe);
      }

      window.onclick = function(event){
        if (event.target == popup) {
          popup.style.display = "none";
          var iframe = document.getElementsByClassName('ifr-video')[0];
            iframe.parentNode.removeChild(iframe);
          }
      }
      // src="https://www.youtube.com/embed/TOYA0RopPts" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
    </script> 
</div>
</body>
</html>