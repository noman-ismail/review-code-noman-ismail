  @include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.event.css') }}">
</head>
<body>
  <div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'events'])
    <header class="title-header main-header">
      <div class="container">
        <div class="header-text">
          <h1 class="header-title">Events</h1>
          <ul class="breadcrumb">
            <li><a href="{{ route('base_url') }}">Home</a></li>
            <li><a href="{{ route('base_url') }}/events">Events</a></li>
          </ul>
        </div>
      </div>
    </header>
    <div class="container-fluid container-first event-section">
      <div class="container">
        <h3 class="main-head">Our Recent Events</h3>
        <div class="row recent-row append-row">
          @foreach ($data as $k => $v)
          @php
            $title = unslash( $v->title );
            $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
            $image = $v->cover_image;
            $url = route('base_url')."/".$v->slug."-2".$v->id;
          @endphp
           <div class="col-md-6 col-lg-4 outer-column">
            <div class="event-column">
              <a class="event-image" href="{{ $url }}">
                <img src="{{ get_post_mid($image) }}" class="img-fluid" alt="{{ $title }}">
                <div class="event-overlay"></div>
                @if ($v->date)
                @php
                  $date = date("d", strtotime($v->date) );
                  $month = date("M", strtotime($v->date) );
                @endphp
                <div class="event-date"> <span class="date">{{ $date }}</span> <span class="month">{{ $month }}</span> </div>
                @endif
                @php
                  $lk   = ($v->social_links  !="" )? json_decode($v->social_links , true) : array();
                @endphp
                <ul class="social-list">
                  @isset ($lk["fb_link"])
                     <li><a href="{{$lk["fb_link"]}}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i></a> </li> 
                  @endisset
                  @isset ($lk["twitter_link"])
                     <li><a href="{{ $lk["twitter_link"] }}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i></a> </li> 
                  @endisset
                  @isset ($lk["instagram_link"])
                      <li><a href="{{ $lk["instagram_link"] }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i></a> </li>
                  @endisset
                  @isset ($lk["linkedin_link"])
                      <li><a href="{{ $lk["linkedin_link"] }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i></a> </li>
                  @endisset
                </ul>
              </a>
              <div class="event-bottom">
                @isset ($v->address)
                  <p>{{ $v->address }}</p>  
                @endisset
                <h4><a href="{{ $url }}">{{ $title }}</a></h4>
              </div>
            </div>
          </div>
          @endforeach
          @isset ($v->id)
          <div class="col-md-12 button-column">
            <div class="button-bottom mx-auto">
              <button class="btn-load" id="btn-load" type="button" data-id="{{ isset($v->id)? $v->id : 0 }}">Load More</button>
            </div>
          </div>    
          @endisset
        </div>
      </div>
    </div>
    
    <!-- Most Popular Events -->
    <div class="main-content event-section">
      <div class="container-fluid event-container">
        <h3 class="main-head">Popular Events</h3>
        <div class="container">
          <div class="owl-carousel event-slider">
            @foreach ($popular as $k => $v)
            @php
              $title = unslash( $v->title );
              $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
              $image = $v->cover_image;
              $url = route('base_url')."/".$v->slug."-2".$v->id;
            @endphp
              <div class="item">
                <div class="event-column">
                        <a class="event-image" href="{{ $url }}">
                          <img src="{{ is_image($image) }}" class="img-fluid" alt="{{ $title }}">
                          <div class="event-overlay"></div>
                          
                          @if ($v->date)
                          @php
                            $date = date("d", strtotime($v->date) );
                            $month = date("M", strtotime($v->date) );
                          @endphp
                          <div class="event-date"> <span class="date">{{ $date }}</span> <span class="month">{{ $month }}</span> </div>
                          @endif
                          @php
                            $lk   = ($v->social_links  !="" )? json_decode($v->social_links , true) : array();
                          @endphp
                          </a>
                          <ul class="social-list">
                            @isset ($lk["fb_link"])
                               <li><a href="{{$lk["fb_link"]}}" rel="nofollow noopener" target="_blank" ><i class="icon-facebook"></i></a> </li> 
                            @endisset
                            @isset ($lk["twitter_link"])
                               <li><a href="{{ $lk["twitter_link"] }}" rel="nofollow noopener" target="_blank" ><i class="icon-twitter"></i></a> </li> 
                            @endisset
                            @isset ($lk["instagram_link"])
                                <li><a href="{{ $lk["instagram_link"] }}" rel="nofollow noopener" target="_blank" ><i class="icon-linkedin2"></i></a> </li>
                            @endisset
                            @isset ($lk["linkedin_link"])
                                <li><a href="{{ $lk["linkedin_link"] }}" rel="nofollow noopener" target="_blank" ><i class="icon-instagram"></i></a> </li>
                            @endisset
                          </ul>
                        
                        <div class="event-bottom">
                          @isset ($v->address)
                           <p>{{ $v->address }}</p>    
                          @endisset
                         
                          <h4><a href="{{ $url }}">{{ $title }}</a></h4>
                        </div>
                      </div>
              </div>
              @endforeach
          </div>
        </div>
      </div>
    </div>  
     @php
      $res = DB::table("meta")->select("views")->where("page_name" , "events")->first();
      $views = $res->views;
      refresh_views($views , 0 , 0 , "events" );
     @endphp
    @include('front.layout.footer')
    <script src="{{asset('assets/js/owl.js') }}"></script> 
    <script>
      $(".event-slider").owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        dots:true,
        // autoplay:true,
        // autoplayTimeout:3000,
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
          }
        }
      });

      $(".hide-column").hide();
      $(document).on("click", '#btn-load',function(){
        var id = $(this).data('id');
        $("#btn-load").text("");
        $("#btn-load").css({"background":"white url(compress/loader.gif) no-repeat center","background-size":"contain","padding":"20px 10px"});
          $.ajax({
           url : '{{ url("more-event") }}',
           method : "POST",
           data : {id:id, _token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
              if(data != '') 
              {
                  $('.button-column').remove();
                  $('.append-row').append(data);
              }
              else
              {
                  $('.append-row').append("No Data");
              }
           }
          });
      });
      function showEvents(){
        $(".hide-column").fadeIn("slow");
        $(".btn-load").closest(".button-column").remove();
      }
    </script>
  </div>