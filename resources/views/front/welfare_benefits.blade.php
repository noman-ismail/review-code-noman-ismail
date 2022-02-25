@include('front.layout.header')
  <link rel="stylesheet" href="{{asset('assets/style/all.cabinet.css') }}">
</head>
<body>
  <div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'welfare'])
    <header class="title-header contact-header">
      <div class="container">
        <div class="header-text">
          <h1 class="header-title">Welfare Benefits</h1>
          <ul class="breadcrumb">
            <li><a href="{{ route('base_url') }}">Home</a></li>
            <li><span>Welfare Benefits</span></li>
          </ul>
        </div>
      </div>
    </header>
    
    <div class="main-content cabinet-content">
      <div class="container">
        <div class="row welfare-cabinet">
          <main class="col-lg-8 col-xl-9 cabinet-main">
            <div id="overview" class="cabinet-column cabinet-custom">
              @isset ($data->title)
                <h3 class="rounded-top">{{ $data->title }}</h3>  
              @endisset
              @php
                $content = welfare_shortcode($data->content);
              @endphp
              {!! $content !!}
              </div> 
              <!-- overview end -->
              <!-- <hr class="hr-green"/> -->
            </main>
              @include('front.sidebar.common')
          </div>
        </div>
      </div>
      @php
    $row = DB::table("welfare_benefits")->select('views')->first();
    refresh_views($row->views , 0 , 0 , get_postid('full'));
@endphp
   @include('front.layout.footer')
    <script>  
      $(document).ready(function(){
        $(".cabinet-main blockquote").addClass("green-note");
        $(".cabinet-main blockquote cite").addClass("text-green");
        });
      $(window).on("scroll",function(){
        if($(window).scrollTop() >600){
          $(".cabinet-content .inner-column").addClass("fixed-column");
        }
        else{
          $(".cabinet-content .inner-column").removeClass("fixed-column");
        }
        if($(window).scrollTop() > $(".cabinet-content").height()){
          $(".cabinet-content .inner-column").removeClass("fixed-column");
        }
      });
    </script>
  </div>
</body>
</html>